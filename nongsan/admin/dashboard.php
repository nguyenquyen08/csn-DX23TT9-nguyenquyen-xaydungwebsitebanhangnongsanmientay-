<?php
if($_SESSION['user']['role']!='admin'){ exit("Không có quyền"); }

$totalProducts = $conn->query("SELECT COUNT(*) as t FROM products")->fetch_assoc()['t'];
$totalUsers = $conn->query("SELECT COUNT(*) as t FROM users")->fetch_assoc()['t'];
?>

<h2>👑 Dashboard</h2>

<div class="row">

<div class="col-md-3">
<div class="card bg-success text-white p-3">
<h4>Sản phẩm</h4>
<h2><?= $totalProducts ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card bg-primary text-white p-3">
<h4>Người dùng</h4>
<h2><?= $totalUsers ?></h2>
</div>
</div>

</div>

<hr>

<a href="?page=products" class="btn btn-warning">Quản lý sản phẩm</a>
<a href="?page=orders" class="btn btn-info">Đơn hàng</a>
<a href="?page=users" class="btn btn-secondary">Người dùng</a>