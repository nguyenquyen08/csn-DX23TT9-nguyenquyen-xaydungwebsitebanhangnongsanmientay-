
<?php
if(isset($_POST['login'])){
  $email=$_POST['email'];
  $pass=$_POST['pass'];

  $stmt=$conn->prepare("SELECT * FROM users WHERE email=?");
  $stmt->bind_param("s",$email);
  $stmt->execute();
  $u=$stmt->get_result()->fetch_assoc();

  if($u && password_verify($pass,$u['password'])){
    $_SESSION['user']=$u;

  if($u['role']=='admin'){
    header("Location: ?page=admin");
  } else {
    header("Location: index.php");
  }
  exit;
  } else {
    echo "<div class='alert alert-danger'>Sai tài khoản hoặc mật khẩu</div>";
  }
}
?>
<form method="POST">
<input name="email" class="form-control mb-2">
<input name="pass" type="password" class="form-control mb-2">
<button name="login" class="btn btn-success">Login</button>
</form>