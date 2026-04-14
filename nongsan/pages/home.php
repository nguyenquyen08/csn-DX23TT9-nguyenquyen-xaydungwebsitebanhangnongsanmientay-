<?php
$cats = $conn->query("SELECT * FROM categories");

$cat = $_GET['cat'] ?? '';

if($cat != ''){
  $stmt = $conn->prepare("SELECT * FROM products WHERE category_id=?");
  $stmt->bind_param("i",$cat);
  $stmt->execute();
  $result = $stmt->get_result();
}else{
  $result = $conn->query("SELECT * FROM products");
}
?>

<div class="row">

  <!-- 📂 DANH MỤC BÊN TRÁI -->
  <div class="col-md-3">
    <h5 class="mb-3">📂 Danh mục</h5>

    <ul class="list-group">

      <!-- TẤT CẢ -->
      <li class="list-group-item">
        <a href="?" class="text-decoration-none">Tất cả</a>
      </li>

      <?php while($c = $cats->fetch_assoc()): ?>
      <li class="list-group-item">
        <a href="?cat=<?= $c['id'] ?>" class="text-decoration-none">
          <?= $c['name'] ?>
        </a>
      </li>
      <?php endwhile; ?>

    </ul>
  </div>

  <!-- 🛒 SẢN PHẨM BÊN PHẢI -->
  <div class="col-md-9">
    <div class="row">

      <?php while($p = $result->fetch_assoc()): ?>

      <div class="col-md-4">
        <div class="card mb-4 shadow-sm">

          <a href="?page=product&id=<?= $p['id'] ?>">
            <img src="uploads/<?= $p['image'] ?>" 
                 class="card-img-top"
                 style="height:200px; object-fit:cover;">
          </a>

          <div class="card-body">
            <h6><?= $p['name'] ?></h6>

            <p class="text-danger fw-bold">
              <?= number_format($p['price']) ?> VNĐ
            </p>

            <a href="?page=product&id=<?= $p['id'] ?>" 
               class="btn btn-success btn-sm w-100">
              Xem chi tiết
            </a>
          </div>

        </div>
      </div>

      <?php endwhile; ?>

    </div>
  </div>

</div>