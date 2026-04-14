<h3>💳 Thanh toán</h3>

<?php
$total = 0;

if(!empty($_SESSION['cart'])):
foreach($_SESSION['cart'] as $id => $qty):
    $p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
    $subtotal = $p['price'] * $qty;
    $total += $subtotal;
?>

<p><?= $p['name'] ?> x <?= $qty ?> = <?= number_format($subtotal) ?> đ</p>

<?php endforeach; ?>

<hr>
<h4>Tổng tiền: <span class="text-danger"><?= number_format($total) ?> đ</span></h4>

<form method="POST">
  <input name="name" placeholder="Tên khách hàng" class="form-control mb-2" required>
  <input name="phone" placeholder="Số điện thoại" class="form-control mb-2" required>
  <input name="address" placeholder="Địa chỉ" class="form-control mb-2" required>

  <select name="payment" class="form-control mb-3">
    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
    <option value="momo">Thanh toán Momo</option>
  </select>

  <button name="order" class="btn btn-success w-100">
    Đặt hàng
  </button>
</form>

<?php
// XỬ LÝ ĐẶT HÀNG
// if(isset($_POST['order'])){
//     echo "<div class='alert alert-success mt-3'>Đặt hàng thành công!</div>";

//     // Xoá giỏ hàng
//     unset($_SESSION['cart']);
// }
if(isset($_POST['order']) && !empty($_SESSION['cart'])){

    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $payment = $conn->real_escape_string($_POST['payment']);

    $user_id = isset($_SESSION['user']) ? (int)$_SESSION['user']['id'] : 0;

    // 1. Lấy sản phẩm 1 lần
    $ids = array_keys($_SESSION['cart']);
    $idList = implode(',', array_map('intval', $ids));

    $result = $conn->query("SELECT id, price FROM products WHERE id IN ($idList)");

    $products = [];
    while($row = $result->fetch_assoc()){
        $products[$row['id']] = $row;
    }

    // 2. Tính lại tổng (an toàn)
    $total = 0;
    foreach($_SESSION['cart'] as $id => $qty){
        if(isset($products[$id])){
            $qty = max(1, (int)$qty);
            $total += $products[$id]['price'] * $qty;
        }
    }

    // 3. Lưu orders
    $conn->query("
        INSERT INTO orders(user_id, total, status, name, phone, address, payment)
        VALUES($user_id, $total, 'pending', '$name', '$phone', '$address', '$payment')
    ");

    $order_id = $conn->insert_id;

    // 4. Lưu order_items
    foreach($_SESSION['cart'] as $id => $qty){
        if(!isset($products[$id])) continue;

        $price = $products[$id]['price'];
        $qty = max(1, (int)$qty);

        $conn->query("
            INSERT INTO order_items(order_id, product_id, qty, price)
            VALUES($order_id, $id, $qty, $price)
        ");
    }

    // 5. Xoá giỏ
    unset($_SESSION['cart']);

    echo "<div class='alert alert-success mt-3'>✅ Đặt hàng thành công!</div>";
}
 ?>

<?php else: ?>

<p>Giỏ hàng trống</p>

<?php endif; ?>