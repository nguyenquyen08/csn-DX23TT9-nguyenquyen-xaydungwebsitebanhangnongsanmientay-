<?php
include("config/database.php");

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if($name == '' || $email == '' || $_POST['password'] == ''){
        die("❌ Không được để trống");
    }

    // check email trùng
    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if($check->num_rows > 0){
        die("❌ Email đã tồn tại");
    }

    // insert user
    $sql = "
        INSERT INTO users(name, email, password, role)
        VALUES('$name', '$email', '$password', 'user')
    ";

    if(!$conn->query($sql)){
        die("❌ SQL ERROR: " . $conn->error);
    }

    echo "✅ Đăng ký thành công!";
}
?>

<form method="POST">
    <input name="name" placeholder="Họ tên" class="form-control mb-2" required>
    <input name="email" placeholder="Email" class="form-control mb-2" required>
    <input name="password" type="password" placeholder="Password" class="form-control mb-2" required>

    <button name="register" class="btn btn-success">
        Đăng ký
    </button>
</form>