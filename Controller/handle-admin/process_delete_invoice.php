<?php
include("../../../Controller/config.php");

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM hoadon WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "fail";
        }
        $stmt->close();
    } else {
        echo "fail";
    }
} else {
    echo "fail";
}
?>
