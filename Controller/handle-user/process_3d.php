<?php
header('Content-Type: application/json');
include 'Controller/config/config.php'; // file config DB

$sql = "SELECT id, file, name, description FROM cars ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

$cars = [];
if ($result) {
    while($row = mysqli_fetch_assoc($result)) {
        $cars[] = [
            'file' => $row['file'],
            'name' => $row['name'],
            'desc' => $row['description']
        ];
    }
}
echo json_encode($cars);
