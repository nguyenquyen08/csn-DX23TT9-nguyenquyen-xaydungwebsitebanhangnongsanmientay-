<h3 class="mb-3">📦 Đơn hàng</h3>

<?php
$orders = $conn->query("SELECT * FROM orders");
?>

<table class="table table-bordered table-hover align-middle text-center">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Tổng tiền</th>
      <th>Trạng thái</th>
      <th>Hành động</th>
    </tr>
  </thead>

  <tbody>
  <?php while($o = $orders->fetch_assoc()): ?>
    <tr>
      <td><?= $o['id'] ?></td>

      <td class="text-danger fw-bold">
        <?= number_format($o['total'], 0, ',', '.') ?> đ
      </td>

      <td>
        <?php
        $status = $o['status'];
        if($status == 'pending'){
          echo '<span class="badge bg-warning">Chờ xử lý</span>';
        } elseif($status == 'done'){
          echo '<span class="badge bg-success">Hoàn thành</span>';
        } else {
          echo '<span class="badge bg-secondary">'.$status.'</span>';
        }
        ?>
      </td>

      <td>
        <a href="?page=order_detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-info">👁 Xem</a>
        <a href="?page=delete_order&id=<?= $o['id'] ?>" 
           class="btn btn-sm btn-danger"
           onclick="return confirm('Xoá đơn này?')">🗑 Xoá</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>