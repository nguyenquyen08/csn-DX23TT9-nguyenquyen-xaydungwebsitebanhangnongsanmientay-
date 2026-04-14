<?php
include("config/database.php");

$page = $_GET['page'] ?? 'home';

include("includes/header.php");
include("includes/navbar.php");

switch($page){

    case 'home': include("pages/home.php"); break;
    case 'product': include("pages/product.php"); break;
    case 'cart': include("pages/cart.php"); break;
    case 'login': include("pages/login.php"); break;
    case 'checkout': include("pages/checkout.php"); break;

    // 👑 ADMIN
    case 'admin': include("admin/dashboard.php"); break;
    case 'products': include("admin/products.php"); break;
    case 'orders': include("admin/orders.php"); break;
    case 'users': include("admin/users.php"); break;
    case 'edit_product': include("admin/edit_product.php"); break;
    case 'delete_product': include("admin/delete_product.php"); break;

    case 'logout':
        session_destroy();
        header("Location: index.php");
        exit;
    break;

    default:
        include("pages/home.php");
}
?>