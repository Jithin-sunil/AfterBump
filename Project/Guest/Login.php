<?php
include("../Assets/Connection/Connection.php");
session_start();

if (isset($_POST['btn_submit'])) {
    $email=$_POST['txt_email'];
    $password=$_POST['txt_pwd'];
    
    $seluser="select * from tbl_user where user_email='".$email."' and user_password='".$password."'";
    $rowuser=$Con->query($seluser);
    
    $seladmin="select * from tbl_admin where admin_email='".$email."' and admin_password='".$password."'";
    $rowadmin=$Con->query($seladmin);
    
    $selseller="select * from tbl_seller where seller_email='".$email."' and seller_password='".$password."'";
    $rowseller=$Con->query($selseller);
    
    $seldel="select * from tbl_delivery d inner join tbl_place p on d.place_id = p.place_id 
            where delivery_email='".$email."' and delivery_password='".$password."'";
    $rowdel=$Con->query($seldel);
    
    if($datauser=$rowuser->fetch_assoc()) {
        $_SESSION['uid']=$datauser['user_id'];
        header("location:../User/Homepage.php");
    }
    else if($dataadmin=$rowadmin->fetch_assoc()) {
        $_SESSION['aid']=$dataadmin['admin_id'];
        header("location:../Admin/Dashboard.php");
    }
    else if($dataseller=$rowseller->fetch_assoc()) {
        $_SESSION['sid']=$dataseller['seller_id'];
        header("location:../Seller/Homepage.php");
    }
    else if($datadel=$rowdel->fetch_assoc()) {
        $_SESSION['did']=$datadel['delivery_id'];
        $_SESSION['district'] = $datadel['district_id'];
        header("location:../DeliveryAgent/Homepage.php");
    }
    else {
        echo "<script>alert('Invalid Login'); window.location='Login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AfterBump :: Login</title>
  
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Lottie -->
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <style>
    body {
      background: linear-gradient(135deg, #f9a8d4 0%, #c084fc 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      max-width: 900px;
      width: 100%;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      overflow: hidden;
    }
    .login-left {
      padding: 40px;
    }
    .login-right {
      background: #fdf2f8;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
    }
    .form-control {
      border-radius: 10px;
    }
    .btn-login {
      border-radius: 25px;
      font-weight: 600;
      background: #c084fc;
      border: none;
    }
    .btn-login:hover {
      background: #a855f7;
    }
    .register-links a {
      text-decoration: none;
      font-weight: 500;
      color: #c026d3;
    }
    .register-links a:hover {
      text-decoration: underline;
    }
    .password-wrapper {
      position: relative;
    }
    .password-wrapper i {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #666;
    }
  </style>
</head>

<body>
<div class="login-card row">
  <!-- Left Side (Form) -->
  <div class="col-md-6 login-left">
    <h3 class="text-center mb-4 fw-bold text-purple">AfterBump Login</h3>
    <form method="post">
      <div class="mb-3">
        <label for="txt_email" class="form-label">Email</label>
        <input type="email" class="form-control" name="txt_email" id="txt_email" placeholder="Enter Email" required>
      </div>
      <div class="mb-3 password-wrapper">
        <label for="txt_pwd" class="form-label">Password</label>
        <input type="password" class="form-control" name="txt_pwd" id="txt_pwd" placeholder="Enter Password" required>
        <i class="fa fa-eye" id="togglePassword"></i>
      </div>
      <div class="d-grid">
        <button type="submit" name="btn_submit" class="btn btn-login btn-lg">Login</button>
      </div>
    </form>
    <hr>
    <p class="text-center register-links">
      <a href="UserRegistration.php">New User?</a> | 
      <a href="Seller.php">Become a Seller</a> | 
      <a href="DeliveryAgent.php">Join as Delivery Agent</a>
    </p>
  </div>

  <!-- Right Side (Animation) -->
  <div class="col-md-6 login-right">
    <lottie-player 
      src="https://assets9.lottiefiles.com/packages/lf20_wd1udlcz.json"
      background="transparent"  
      speed="1"  
      style="width: 100%; height: 100%;"  
      loop autoplay>
    </lottie-player>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Show/Hide Password -->
<script>
document.getElementById("togglePassword").addEventListener("click", function() {
  let pwd = document.getElementById("txt_pwd");
  if (pwd.type === "password") {
    pwd.type = "text";
    this.classList.remove("fa-eye");
    this.classList.add("fa-eye-slash");
  } else {
    pwd.type = "password";
    this.classList.remove("fa-eye-slash");
    this.classList.add("fa-eye");
  }
});
</script>

</body>
</html>
