<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id <= 0){
    echo "<h3>❌ ID không hợp lệ</h3>";
    exit;
}

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
      <img src="uploads/<?= htmlspecialchars(basename($p['image'])) ?>" 
           style="width:100%; height:100%; object-fit:cover;"
           class="rounded shadow"
           onerror="this.src='https://via.placeholder.com/400'">
    </div>
  </div>

  <!-- 📄 THÔNG TIN BÊN PHẢI -->
  <div class="col-md-7">

    <h2 class="fw-bold"><?= htmlspecialchars($p['name']) ?></h2>

    <p class="text-muted">
      Xuất xứ: <?= htmlspecialchars($p['origin'] ?? '') ?>

    </p>

    <p class="text-muted">
      Quy cách: <?= htmlspecialchars($p['weight'] ?? '') ?>
    </p>

    <h3 class="text-danger fw-bold">
      <?= number_format($p['price'] ?? 0) ?> đ
    </h3>

<p>
  <?= nl2br(htmlspecialchars($p['description'] ?? 'Chưa có mô tả')) ?>
</p>

    <!-- SỐ LƯỢNG -->
    <!-- <form method="GET"> -->
      <form method="POST" action="?page=cart">
      <input type="hidden" name="add" value="<?= $p['id'] ?>">
      <!-- <input type="hidden" name="qty" id="qty-hidden">

      <div class="d-flex align-items-center mb-3"> -->
        <!-- <button type="button" onclick="this.nextElementSibling.stepDown()" class="btn btn-light">-</button>
        <input type="number" name="qty" value="1" min="1" class="form-control text-center" style="width:60px;">
        <button type="button" onclick="this.previousElementSibling.stepUp()" class="btn btn-light">+</button> -->
      <!-- <button type="button" onclick="this.parentNode.querySelector('input').stepDown()" class="btn btn-light">-</button>

<input type="number" name="qty" value="1" min="1" class="form-control text-center" style="width:60px;">

<button type="button" onclick="this.parentNode.querySelector('input').stepUp()" class="btn btn-light">+</button>
      </div> -->
    <div class="d-flex align-items-center mb-3">
        <button type="button"
                onclick="this.parentNode.querySelector('input').stepDown()"
                class="btn btn-light">-</button>

        <input type="number"
               name="qty"
               value="1"
               min="1"
               class="form-control text-center"
               style="width:60px;">

        <button type="button"
                onclick="this.parentNode.querySelector('input').stepUp()"
                class="btn btn-light">+</button>
    </div>
      <!-- <button class="btn btn-warning me-2">🛒 Thêm vào giỏ</button>
        -->
      <button type="submit" class="btn btn-warning me-2">
    🛒 Thêm vào giỏ
</button>
      <!-- <a href="?page=checkout" class="btn btn-danger">ĐẶT HÀNG</a> -->
    <button type="submit" name="buy_now" value="1" class="btn btn-danger">
        ĐẶT HÀNG
    </button>
    </form>

    <!-- HOTLINE -->
    <div class="mt-4 p-3 bg-success text-white text-center rounded">
      <h5>📞 GỌI HOTLINE</h5>
      <h4>0931 117 381</h4>
    </div>

  </div>

</div>