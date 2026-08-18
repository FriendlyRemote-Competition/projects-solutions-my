<?php
$file = "table.json";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $action = $_POST['action'] ?? '';
    $postData = $_POST['data'] ?? [];

    $currentData = json_decode(file_get_contents($file), true);
    if (!is_array($currentData)) {
        $currentData = [];
    }

    if ($action === 'add') {
        $currentData[] = [
                "first name" => "",
                "last name"  => "",
                "age"        => "",
                "country"    => "",
                "gender"     => ""
        ];
        file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT));

    } elseif (strpos($action, 'delete_') === 0) {
        $index = (int) str_replace('delete_', '', $action);

        if (isset($currentData[$index])) {
            array_splice($currentData, $index, 1);
            file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT));
        }

    } elseif ($action === 'save') {
        $newData = [];
        foreach ($postData as $row) {
            $newData[] = [
                    "first name" => $row['first name'] ?? '',
                    "last name"  => $row['last name'] ?? '',
                    "age"        => $row['age'] !== '' ? (int)$row['age'] : '',
                    "country"    => $row['country'] ?? '',
                    "gender"     => $row['gender'] ?? ''
            ];
        }
        file_put_contents($file, json_encode($newData, JSON_PRETTY_PRINT));
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$content = json_decode(file_get_contents($file));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>C3</title>
</head>
<body>
<div class="container mt-4">
    <form method="POST" action="">
        <table class="table table-striped">
            <thead class="table-dark">
            <tr>
                <th>first name</th>
                <th>last name</th>
                <th>age</th>
                <th>country</th>
                <th>gender</th>
                <th>== Delete ==</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($content)): ?>
                <?php foreach ($content as $index => $c): ?>
                    <tr>
                        <td><input type="text" class="form-control" name="data[<?= $index ?>][first name]" value="<?= htmlspecialchars($c->{"first name"} ?? '') ?>"></td>
                        <td><input type="text" class="form-control" name="data[<?= $index ?>][last name]" value="<?= htmlspecialchars($c->{"last name"} ?? '') ?>"></td>
                        <td><input type="number" class="form-control" name="data[<?= $index ?>][age]" value="<?= htmlspecialchars($c->{"age"} ?? '') ?>"></td>
                        <td><input type="text" class="form-control" name="data[<?= $index ?>][country]" value="<?= htmlspecialchars($c->{"country"} ?? '') ?>"></td>
                        <td><input type="text" class="form-control" name="data[<?= $index ?>][gender]" value="<?= htmlspecialchars($c->{"gender"} ?? '') ?>"></td>

                        <td><button type="submit" name="action" value="delete_<?= $index ?>" class="btn btn-danger">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No data found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" name="action" value="add" class="btn btn-secondary">Add row</button>
            <button type="submit" name="action" value="save" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
</body>
</html>