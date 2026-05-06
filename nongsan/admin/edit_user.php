<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// include("../config/database.php");
include($_SERVER['DOCUMENT_ROOT'] . "/nongsan/config/database.php");

// CHECK ADMIN
if(
    !isset($_SESSION['user']) || 
    $_SESSION['user']['role'] !== 'admin'
){
    exit("❌ Không có quyền");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// LẤY USER
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$u = $result->fetch_assoc();

if(!$u){
    exit("❌ Không tìm thấy user");
}

// XỬ LÝ UPDATE
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $role = $_POST['role'] ?? 'user';
    $password = $_POST['password'] ?? '';

    // KHÔNG CHO HẠ ADMIN CUỐI CÙNG (optional nâng cao)
    if($u['role'] == 'admin' && $role != 'admin'){
        // bạn có thể kiểm tra số admin ở đây nếu muốn
    }

    // UPDATE ROLE
    if(!empty($password)){
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET role=?, password=? WHERE id=?");
        $stmt->bind_param("ssi", $role, $hash, $id);
    }else{
        $stmt = $conn->prepare("UPDATE users SET role=? WHERE id=?");
        $stmt->bind_param("si", $role, $id);
    }

    if($stmt->execute()){
        echo "<script>alert('✅ Cập nhật thành công'); location.href='?page=users';</script>";
        exit;
    }else{
        echo "❌ Lỗi: " . $conn->error;
    }
}
?>

<h3>✏️ Sửa user</h3>

<form method="POST">

    <div class="mb-3">
        <label>Tên</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($u['name']) ?>" disabled>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($u['email']) ?>" disabled>
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="user" <?= $u['role']=='user'?'selected':'' ?>>User</option>
            <option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>Admin</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Mật khẩu mới (để trống nếu không đổi)</label>
        <input type="password" name="password" class="form-control">
    </div>

    <button class="btn btn-primary">💾 Lưu</button>
    <a href="?page=users" class="btn btn-secondary">Quay lại</a>

</form>