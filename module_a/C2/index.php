<?php

$host = "skill17-mysql";
$user = "root";
$pass = "root";
$dbname = "a_c2";

$mysqli = new mysqli($host, $user, $pass, $dbname);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    $task_date = $_POST['task_date'] ?? '';
    $is_recurring = isset($_POST['is_recurring']) && $_POST['is_recurring'] === '1' ? 1 : 0;

    $type = $_POST['type'] ?? null;
    $cycle = !empty($_POST['cycle']) ? (int)$_POST['cycle'] : null;
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;

    if (!$is_recurring) {
        $type = null;
        $cycle = null;
        $end_date = null;
    }

    $stmt = $mysqli->prepare("INSERT INTO schedules (title, task_date, is_recurring, type, cycle, end_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisis", $title, $task_date, $is_recurring, $type, $cycle, $end_date);
    $stmt->execute();
    $stmt->close();

    $redirectYear = $_GET['year'] ?? date('Y');
    $redirectMonth = $_GET['month'] ?? date('n');
    header("Location: index.php?year=$redirectYear&month=$redirectMonth");
    exit;
}

$year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('n');

$firstDayOfMonth = new DateTime("$year-$month-01");
$startDayOfWeek = $firstDayOfMonth->format('w'); // 0 (Sun) to 6 (Sat)

$viewStartDate = clone $firstDayOfMonth;
if ($startDayOfWeek > 0) {
    $viewStartDate->modify("-$startDayOfWeek days");
}

$viewEndDate = clone $viewStartDate;
$viewEndDate->modify("+41 days");

function getOccurrences($schedule, $viewStartDate, $viewEndDate) {
    $occurrences = [];
    $baseDate = new DateTime($schedule['task_date']);
    $endDate = $schedule['end_date'] ? new DateTime($schedule['end_date']) : null;
    $originalDay = $baseDate->format('d');

    $i = 0;
    while (true) {
        $currentDate = clone $baseDate;

        if ($schedule['is_recurring']) {
            if ($schedule['type'] === 'Day' || $schedule['type'] === 'Week') {
                $modifier = $i * $schedule['cycle'];
                $currentDate->modify("+$modifier {$schedule['type']}");
            } else { // Month or Year
                $monthsToAdd = ($schedule['type'] === 'Month') ? ($i * $schedule['cycle']) : ($i * $schedule['cycle'] * 12);
                if ($monthsToAdd > 0) {
                    $currentDate->modify("+$monthsToAdd months");
                }

                $targetYear = $currentDate->format('Y');
                $targetMonth = $currentDate->format('m');
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $targetMonth, $targetYear);

                // Snap to the end of the month if necessary (e.g. Jan 31 -> Feb 28)
                $finalDay = ($originalDay > $daysInMonth) ? $daysInMonth : $originalDay;
                $currentDate->setDate($targetYear, $targetMonth, $finalDay);
            }
        }

        if ($endDate && $currentDate > $endDate) break;
        if ($currentDate > $viewEndDate) break;

        if ($currentDate >= $viewStartDate && $currentDate >= clone $baseDate) {
            $occurrences[] = [
                'date' => $currentDate->format('Y-m-d'),
                'title' => $schedule['title']
            ];
        }

        if (!$schedule['is_recurring']) break;

        $i++;
        if ($i > 1000) break;
    }

    return $occurrences;
}

$calendarData = [];
$result = $mysqli->query("SELECT * FROM schedules");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $occs = getOccurrences($row, $viewStartDate, $viewEndDate);
        foreach ($occs as $occ) {
            $calendarData[$occ['date']][] = $occ;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C2 - Recurring Calendar</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .top-controls { text-align: center; margin-bottom: 20px; }

        .calendar-table { width: 100%; border-collapse: collapse; table-layout: fixed; margin-bottom: 20px; }
        .calendar-table th, .calendar-table td { border: 1px solid #ccc; padding: 8px; vertical-align: top; }
        .calendar-table th { background: #fff; text-align: left; font-weight: normal; }
        .calendar-table td { height: 100px; }
        .out-of-month { background-color: #e9ecef; }

        .day-number { color: #555; }
        .event-chip {
            background-color: #3b5bdb;
            color: white;
            padding: 4px 8px;
            margin-top: 4px;
            font-size: 14px;
            word-wrap: break-word;
        }

        .form-row { margin-bottom: 10px; }
        .required { color: red; }
        #recurring_options { display: none; margin-top: 10px; padding-left: 20px; border-left: 2px solid #ccc; }
    </style>
</head>
<body>

<div class="top-controls">
    <form method="GET" action="index.php">
        <label>Year: <input type="number" name="year" value="<?= $year ?>" required style="width: 80px;"></label>
        <label>Month: <input type="number" name="month" value="<?= $month ?>" min="1" max="12" required style="width: 60px;"></label>
        <button type="submit">change</button>
    </form>
</div>

<table class="calendar-table">
    <thead>
    <tr>
        <th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $currentGridDate = clone $viewStartDate;

    for ($i = 0; $i < 42; $i++) {
        if ($i % 7 === 0) echo "<tr>\n";

        $isCurrentMonth = ($currentGridDate->format('n') == $month);
        $cellClass = $isCurrentMonth ? '' : 'out-of-month';

        echo "<td class='{$cellClass}'>";
        echo "<div class='day-number'>" . $currentGridDate->format('j') . "</div>";

        $dateString = $currentGridDate->format('Y-m-d');
        if (!empty($calendarData[$dateString])) {
            foreach ($calendarData[$dateString] as $event) {
                echo "<div class='event-chip'>" . htmlspecialchars($event['title']) . "</div>";
            }
        }

        echo "</td>\n";
        $currentGridDate->modify('+1 day');
        if ($i % 7 === 6) echo "</tr>\n";
    }
    ?>
    </tbody>
</table>

<form method="POST" action="index.php?year=<?= $year ?>&month=<?= $month ?>">
    <input type="hidden" name="action" value="add">

    <div class="form-row">
        <span class="required">*</span>Title
        <input type="text" name="title" required>

        <span class="required" style="margin-left: 15px;">*</span>Task date
        <input type="date" name="task_date" required>
    </div>

    <div class="form-row">
        <label>
            <input type="radio" name="is_recurring" value="0" checked onchange="toggleRecurring(false)"> One day task
        </label>
        <label style="margin-left: 15px;">
            <input type="radio" name="is_recurring" value="1" onchange="toggleRecurring(true)"> Recurring task
        </label>
    </div>

    <div id="recurring_options">
        <div class="form-row">
            <span class="required">*</span>Type
            <select name="type" id="type_select">
                <option value="Day">Day</option>
                <option value="Week">Week</option>
                <option value="Month">Month</option>
                <option value="Year">Year</option>
            </select>

            <span class="required" style="margin-left: 15px;">*</span>Cycle
            <input type="number" name="cycle" id="cycle_input" min="1" style="width: 60px;">

            <span style="margin-left: 15px;">End date (optional)</span>
            <input type="date" name="end_date">
        </div>
    </div>

    <button type="submit" style="margin-top: 10px;">Create</button>
</form>

<script>
    function toggleRecurring(show) {
        const container = document.getElementById('recurring_options');
        const typeSelect = document.getElementById('type_select');
        const cycleInput = document.getElementById('cycle_input');

        if (show) {
            container.style.display = 'block';
            typeSelect.required = true;
            cycleInput.required = true;
        } else {
            container.style.display = 'none';
            typeSelect.required = false;
            cycleInput.required = false;
        }
    }
</script>
</body>
</html>