<?php
session_start();
include("../config/database.php");

// CHECK ADMIN
if(
    !isset($_SESSION['user']) || 
    !isset($_SESSION['user']['role']) || 
    $_SESSION['user']['role'] !== 'admin'
){
    exit("❌ Không có quyền");
}

// CHỈ CHO PHÉP POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit("❌ Sai phương thức");
}

// VALIDATE ID
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if($id <= 0){
    exit("❌ ID không hợp lệ");
}

// LẤY ẢNH TRƯỚC KHI XÓA
$stmt = $conn->prepare("SELECT image FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$p = $result->fetch_assoc();

// XÓA DB
$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){

    // XÓA FILE ẢNH
    if(!empty($p['image'])){
        $file = "../uploads/" . $p['image'];
        if(file_exists($file)){
            unlink($file);
        }
    }

    header("Location: ?page=products");
    exit;
}else{
    echo "❌ Lỗi xóa: " . $conn->error;
}