<?php
include("C:/xampp/htdocs/nongsan/config/database.php");
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// if(isset($_GET['add'])){
//     $id = (int)$_GET['add'];
//     $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

//     if(isset($_SESSION['cart'][$id])){
//         $_SESSION['cart'][$id] += $qty;
//     } else {
//         $_SESSION['cart'][$id] = $qty;
//     }

//     header("Location: index.php?page=cart");
//     exit;
// }


// // XOÁ SẢN PHẨM
// if(isset($_GET['remove'])){
//     $id = (int)$_GET['remove'];
//     unset($_SESSION['cart'][$id]);
// }

// // CẬP NHẬT SỐ LƯỢNG
// if(isset($_POST['update']) && isset($_POST['qty']) && is_array($_POST['qty'])){
//     foreach($_POST['qty'] as $id => $qty){
//         $qty = (int)$qty;

//         if($qty > 0){
//             $_SESSION['cart'][$id] = $qty;
//         } else {
//             unset($_SESSION['cart'][$id]);
//         }
//     }
// }
/* =========================
   THÊM VÀO GIỎ
========================= */
if(isset($_POST['add'])){

    $id = (int)$_POST['add'];
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

    if($qty < 1){
        $qty = 1;
    }

    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }

    // nếu bấm đặt hàng
    if(isset($_POST['buy_now'])){
        header("Location: index.php?page=checkout");
    } else {
        header("Location: index.php?page=cart");
    }

    exit;
}

/* =========================
   XOÁ
========================= */
if(isset($_GET['remove'])){
    $id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$id]);

    header("Location: index.php?page=cart");
    exit;
}

/* =========================
   UPDATE
========================= */
if(isset($_POST['update']) && isset($_POST['qty'])){

    foreach($_POST['qty'] as $id => $qty){

        $id = (int)$id;
        $qty = (int)$qty;

        if($qty > 0){
            $_SESSION['cart'][$id] = $qty;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }

    header("Location: index.php?page=cart");
    exit;
}
// ?>



<h3>🛒 Giỏ hàng của bạn</h3>

<form method="POST">
<table class="table table-bordered text-center align-middle">
<tr class="table-success">
    <th>Tên sản phẩm</th>
    <th>Số lượng</th>
    <th>Giá</th>
    <th>Thành tiền</th>
    <th>Xóa</th>
</tr>

<?php
$total = 0;

if(!empty($_SESSION['cart'])):
foreach($_SESSION['cart'] as $id => $qty):

    $result = $conn->query("SELECT * FROM products WHERE id=$id");

    if(!$result || $result->num_rows == 0){
        continue;
    }

    $p = $result->fetch_assoc();

    $subtotal = $p['price'] * $qty;
    $total += $subtotal;
?>

<tr>
    <td><?= $p['name'] ?></td>

    <td style="width:120px;">
        <input type="number" name="qty[<?= $id ?>]" value="<?= $qty ?>" min="1" class="form-control">
    </td>

    <td class="text-danger"><?= number_format($p['price']) ?> đ</td>

    <td class="fw-bold"><?= number_format($subtotal) ?> đ</td>

    <td>
        <a href="?page=cart&remove=<?= $id ?>" class="btn btn-danger btn-sm">X</a>
    </td>
</tr>

<?php endforeach; ?>

<tr>
    <td colspan="3" class="text-end fw-bold">Tổng tiền:</td>
    <td colspan="2" class="text-danger fs-5 fw-bold">
        <?= number_format($total) ?> đ
    </td>
</tr>

<?php else: ?>

<tr>
    <td colspan="5">Giỏ hàng trống</td>
</tr>

<?php endif; ?>

</table>

<button name="update" class="btn btn-primary">Cập nhật giỏ hàng</button>
<a href="?" class="btn btn-success">Tiếp tục mua</a>

<a href="?page=checkout" class="btn btn-danger">💳 Thanh toán</a>
</form>