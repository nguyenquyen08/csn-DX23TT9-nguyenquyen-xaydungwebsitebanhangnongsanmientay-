<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("C:/xampp/htdocs/nongsan/config/database.php");

// CHECK ADMIN
if(
    !isset($_SESSION['user']) || 
    !isset($_SESSION['user']['role']) || 
    $_SESSION['user']['role'] !== 'admin'
){
    exit("❌ Không có quyền");
}

// XỬ LÝ FORM
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'] ?? '';
    $price = (int)($_POST['price'] ?? 0);
    $origin = $_POST['origin'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $desc = $_POST['description'] ?? '';

    // UPLOAD ẢNH
    $image = '';
    if(!empty($_FILES['image']['name'])){
        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
    }

    // INSERT DB
    $stmt = $conn->prepare("INSERT INTO products(name, price, image, origin, weight, description) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("sissss", $name, $price, $image, $origin, $weight, $desc);
    $stmt->execute();

    echo "<script>alert('✅ Thêm thành công'); location.href='?page=products';</script>";
}
?>

<h2>➕ Thêm sản phẩm</h2>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Giá</label>
        <input type="number" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Xuất xứ</label>
        <input type="text" name="origin" class="form-control">
    </div>

    <div class="mb-3">
        <label>Quy cách</label>
        <input type="text" name="weight" class="form-control">
    </div>

    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Ảnh</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button class="btn btn-success">💾 Lưu</button>
    <a href="?page=products" class="btn btn-secondary">Quay lại</a>

</form>