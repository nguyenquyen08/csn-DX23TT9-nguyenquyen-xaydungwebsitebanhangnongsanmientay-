<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../config/database.php");

// CHECK ADMIN
if(
    !isset($_SESSION['user']) || 
    $_SESSION['user']['role'] !== 'admin'
){
    exit("❌ Không có quyền");
}

// CHỈ NHẬN POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit("❌ Sai phương thức");
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if($id <= 0){
    exit("❌ ID không hợp lệ");
}

// KHÔNG CHO XÓA CHÍNH MÌNH
if($id == $_SESSION['user']['id']){
    exit("❌ Không thể tự xóa tài khoản của mình");
}

// KIỂM TRA ROLE
$stmt = $conn->prepare("SELECT role FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if(!$user){
    exit("❌ User không tồn tại");
}

// ❌ KHÔNG CHO XÓA ADMIN
if($user['role'] === 'admin'){
    exit("❌ Không thể xóa tài khoản admin");
}

// XÓA USER
$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: ?page=users");
    exit;
}else{
    echo "❌ Lỗi: " . $conn->error;
}