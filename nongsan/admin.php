<?php
session_start();
include("config/database.php");

// CHẶN KHÔNG PHẢI ADMIN
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin'){
    echo "❌ Bạn không có quyền truy cập";
    exit;
}

// LẤY SẢN PHẨM
$products = $conn->query("SELECT * FROM products");
?>

<h2>👑 Quản lý sản phẩm</h2>

<a href="add_product.php" class="btn btn-success mb-3">+ Thêm sản phẩm</a>

<table class="table table-bordered text-center">
<tr>
    <th>ID</th>
    <th>Ảnh</th>
    <th>Tên</th>
    <th>Giá</th>
    <th>Hành động</th>
</tr>

<?php while($p = $products->fetch_assoc()): ?>
<tr>
    <td><?= $p['id'] ?></td>

    <td>
        <img src="uploads/<?= $p['image'] ?>" width="80">
    </td>

    <td><?= $p['name'] ?></td>

    <td><?= number_format($p['price']) ?> đ</td>

    <td>
        <a href="?page=edit_product&id=<?= $p['id'] ?>" 
   class="btn btn-warning btn-sm">
   Sửa
</a>
        <a href="delete_product.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Xóa?')">Xóa</a>
    </td>
</tr>
<?php endwhile; ?>

</table>