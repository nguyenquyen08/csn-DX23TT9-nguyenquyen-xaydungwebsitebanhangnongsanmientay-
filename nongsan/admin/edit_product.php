<?php
include("../config/database.php");
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!='admin'){
    exit("❌ Không có quyền");
}

$id = $_GET['id'] ?? 0;

// LẤY SẢN PHẨM
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();

if(!$p){
    exit("❌ Không tìm thấy sản phẩm");
}

// CẬP NHẬT
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $origin = $_POST['origin'];
    $weight = $_POST['weight'];

    $stmt = $conn->prepare("
        UPDATE products 
        SET name=?, price=?, description=?, origin=?, weight=? 
        WHERE id=?
    ");
    $stmt->bind_param("sisssi",$name,$price,$desc,$origin,$weight,$id);
    $stmt->execute();

    // upload ảnh
    if(!empty($_FILES['image']['name'])){
        $img = time()."_".$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$img);

        $stmt = $conn->prepare("UPDATE products SET image=? WHERE id=?");
        $stmt->bind_param("si",$img,$id);
        $stmt->execute();
    }

    echo "<div class='alert alert-success'>✔ Cập nhật thành công</div>";
}
?>

<h3>✏️ Chỉnh sửa sản phẩm</h3>

<a href="?page=products" class="btn btn-secondary mb-3">← Quay lại</a>

<form method="POST" enctype="multipart/form-data">

<label>Tên sản phẩm</label>
<input name="name" value="<?= $p['name'] ?>" class="form-control mb-2">

<label>Giá</label>
<input name="price" value="<?= $p['price'] ?>" class="form-control mb-2">

<label>Xuất xứ</label>
<input name="origin" value="<?= $p['origin'] ?>" class="form-control mb-2">

<label>Quy cách</label>
<input name="weight" value="<?= $p['weight'] ?>" class="form-control mb-2">

<label>Mô tả</label>
<textarea name="description" class="form-control mb-2"><?= $p['description'] ?></textarea>

<label>Ảnh hiện tại</label><br>
<!-- <img src="../uploads/<?= $p['image'] ?>" width="120" class="mb-2"><br> -->
<img src="../uploads/<?= $p['image'] ?>" width="120" class="mb-2"><br>
<label>Đổi ảnh</label>
<input type="file" name="image" class="form-control mb-3">

<button name="update" class="btn btn-success">
    💾 Lưu thay đổi
</button>

</form>