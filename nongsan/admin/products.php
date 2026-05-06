<?php
include("C:/xampp/htdocs/nongsan/config/database.php");
if(
    !isset($_SESSION['user']) || 
    !isset($_SESSION['user']['role']) || 
    $_SESSION['user']['role'] !== 'admin'
){
    exit("❌ Không có quyền");
}
// LẤY SẢN PHẨM
// $products = $conn->query("SELECT * FROM products");
$products = $conn->query("SELECT id, name, price, image, description FROM products ORDER BY id DESC LIMIT 50");

if(!$products){
    die("Lỗi SQL: " . $conn->error);
}
?>

<h2>📦 Quản lý sản phẩm</h2>

<a href="?page=admin" class="btn btn-secondary mb-3">← Dashboard</a>
        <a href="?page=add_product" class="btn btn-success mb-3">
    ➕ Thêm sản phẩm
        </a>
<table class="table table-bordered text-center">
<tr>
    <th>ID</th>
    <th>Ảnh</th>
    <th>Tên</th>
    <th>Giá</th>
    <th>mô tả</th>
    <th>Hành động</th>
</tr>

<?php while($p = $products->fetch_assoc()): ?>
<tr>
    <td><?= $p['id'] ?></td>

    <td>
        <!-- <img src="uploads/<?= $p['image'] ?>" width="80">
          -->
        <!-- <img src="../uploads/<?= $p['image'] ?>" width="80"> -->
         <img src="/nongsan/uploads/<?= htmlspecialchars(basename($p['image'])) ?>" width="80">
    </td>

    
    <td><?= htmlspecialchars($p['name']) ?></td>
    <td><?= number_format($p['price']) ?> đ</td>
    <td class="text-start">
    <?= htmlspecialchars(
        mb_substr($p['description'] ?? 'Chưa có mô tả', 0, 50)
    ) ?>
    <?= mb_strlen($p['description'] ?? '') > 50 ? '...' : '' ?>
    </td>
    <td>
        <a href="?page=edit_product&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">
        ✏️ Sửa
        </a>
<!-- 
        <a href="?page=delete_product&id=<?= $p['id'] ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Xóa?')">
           Xóa
        </a> -->
        <form method="POST" action="?page=delete_product" style="display:inline;">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')">
                Xóa
            </button>
        </form>

    </td>

</tr>

<?php endwhile; ?>

</table>