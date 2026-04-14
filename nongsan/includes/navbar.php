<nav class="navbar navbar-expand-lg navbar-dark bg-success">
<div class="container">

<a class="navbar-brand" href="?">🌾 Miền Tây</a>

<form class="d-flex" method="GET">
  <input type="hidden" name="page" value="home">
  <input class="form-control me-2" name="keyword">
  <button class="btn btn-warning">Tìm</button>
</form>

<style>
.btn-custom {
  min-width: 100px;
  height: 40px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
</style>

<div class="d-flex align-items-center">

  <!-- 🛒 GIỎ HÀNG LUÔN HIỂN THỊ -->
  <a href="?page=cart" class="btn btn-warning position-relative me-3">
    🛒 Giỏ hàng

    <?php 
    $count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    if($count > 0):
    ?>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        <?= $count ?>
      </span>
    <?php endif; ?>
  </a>

<?php if(isset($_SESSION['user'])): ?>

  <span class="me-2 text-white">
    Xin chào <?= htmlspecialchars($_SESSION['user']['name']) ?>
  </span>

  <?php if($_SESSION['user']['role']=='admin'): ?>
    <a href="?page=admin" class="btn btn-danger btn-custom">👑 Admin</a>
    <a href="?page=products" class="btn btn-warning btn-custom">📦 Sản phẩm</a>
  <?php endif; ?>

  <a href="?page=logout" class="btn btn-light btn-custom">Logout</a>

<?php else: ?>

  <!-- ✅ THÊM ĐOẠN NÀY -->
  <a href="?page=login" class="btn btn-light btn-custom me-2">🔑 Đăng nhập</a>
  <a href="?page=register" class="btn btn-warning btn-custom">📝 Đăng ký</a>

<?php endif; ?>

</div>

</div>
</nav>

<div class="container mt-3">