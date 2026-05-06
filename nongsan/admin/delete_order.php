<?php
include("C:/xampp/htdocs/nongsan/config/database.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id > 0){

    // xóa chi tiết đơn trước
    $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // xóa đơn hàng
    $stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: ?page=admin_orders");
exit;
?>