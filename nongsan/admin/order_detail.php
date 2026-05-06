<?php
include("C:/xampp/htdocs/nongsan/config/database.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM orders WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$order = $stmt->get_result()->fetch_assoc();

if(!$order){
    echo "Không tìm thấy đơn hàng";
    exit;
}
?>

<h3>Chi tiết đơn hàng #<?= $order['id'] ?></h3>

<p>
    Tổng tiền:
    <b class="text-danger">
        <?= number_format($order['total']) ?> đ
    </b>
</p>

<div class="card mb-3">
    <div class="card-header bg-light fw-bold">
        Thông tin khách hàng
    </div>

    <div class="card-body">

        <p>
            <strong>Họ tên:</strong>
            <?= htmlspecialchars($order['name'] ?? '') ?>
        </p>

        <p>
            <strong>Số điện thoại:</strong>
            <?= htmlspecialchars($order['phone'] ?? '') ?>
        </p>

        <p>
            <strong>Địa chỉ:</strong>
            <?= htmlspecialchars($order['address'] ?? '') ?>
        </p>

        <p>
            <strong>Ghi chú:</strong>
            <?= nl2br(htmlspecialchars($order['note'] ?? '')) ?>
        </p>

    </div>
</div>

<hr>

<table class="table table-bordered">
<tr>
    <th>Sản phẩm</th>
    <th>Số lượng</th>
    <th>Giá</th>
</tr>

<?php
$stmt = $conn->prepare("
    SELECT order_items.*, products.name
    FROM order_items
    JOIN products ON order_items.product_id = products.id
    WHERE order_items.order_id=?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_assoc()):
?>

<tr>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= $row['qty'] ?></td>
    <td><?= number_format($row['price']) ?> đ</td>
</tr>

<?php endwhile; ?>
</table>

<a href="?page=orders" class="btn btn-secondary">
    ← Quay lại
</a>