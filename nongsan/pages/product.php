<?php
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$p = $result->fetch_assoc();

if(!$p){
    echo "<h3>❌ Không tìm thấy sản phẩm</h3>";
    exit;
}
?>
<div class="row">

  <!-- 🖼️ ẢNH BÊN TRÁI -->
  <div class="col-md-5">
    <div style="width:100%; height:400px; overflow:hidden;">
      <img src="uploads/<?= $p['image'] ?>" 
           style="width:100%; height:100%; object-fit:cover;"
           class="rounded shadow"
           onerror="this.src='https://via.placeholder.com/400'">
    </div>
  </div>

  <!-- 📄 THÔNG TIN BÊN PHẢI -->
  <div class="col-md-7">

    <h2 class="fw-bold"><?= $p['name'] ?></h2>

    <p class="text-muted">
      Xuất xứ: <?= $p['origin'] ?? '' ?>
    </p>

    <p class="text-muted">
      Quy cách: <?= $p['weight'] ?? '' ?>
    </p>

    <h3 class="text-danger fw-bold">
      <?= number_format($p['price']) ?> đ
    </h3>

    <p>
      <?= $p['description'] ?? '' ?>
    </p>

    <!-- SỐ LƯỢNG -->
    <form method="GET">
      <input type="hidden" name="page" value="cart">
      <input type="hidden" name="add" value="<?= $p['id'] ?>">

      <div class="d-flex align-items-center mb-3">
        <button type="button" onclick="this.nextElementSibling.stepDown()" class="btn btn-light">-</button>
        <input type="number" name="qty" value="1" min="1" class="form-control text-center" style="width:60px;">
        <button type="button" onclick="this.previousElementSibling.stepUp()" class="btn btn-light">+</button>
      </div>

      <button class="btn btn-warning me-2">🛒 Thêm vào giỏ</button>
      <a href="?page=checkout" class="btn btn-danger">ĐẶT HÀNG</a>
    </form>

    <!-- HOTLINE -->
    <div class="mt-4 p-3 bg-success text-white text-center rounded">
      <h5>📞 GỌI HOTLINE</h5>
      <h4>0931 117 381</h4>
    </div>

  </div>

</div>