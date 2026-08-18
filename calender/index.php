<?php
$year = $_GET['year'] ?? date("Y");
$month = $_GET['month'] ?? date("m");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Calender</title>
    <style>
        *{

        }
        body{
            background-color: #bababa;
        }
        table,th,td{
            padding:10p
        }
    </style>
</head>
<body>
<?php //= $year ?>
<?php //= $month ?>
<?php
$startOfMonth = new DateTime("$year-$month-01");
$startWeekNum = $startOfMonth->format('w');
var_dump($startWeekNum);
$currentDate = clone $startOfMonth;
$currentDate->modify("-{$startWeekNum} days");
?>
    <table>
        <thead>
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i = 0; $i < 42; $i++){
                    if($i % 7 == 0) echo "<tr>";

                    if($currentDate->format('m') == $month){
                        echo "<td>".$currentDate->format('d')."</td>";
                    }else{
                        echo "<td style='opacity:0.2'>".$currentDate->format('d')."</td>";
                    }

                    if($i % 7 == 6) echo "</tr>";
                    $currentDate->modify("+1 day");
                }
            ?>
        </tbody>
    </table>
</body>
</html>