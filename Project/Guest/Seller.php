<?php
include("../Assets/Connection/Connection.php");

if (isset($_POST['btn_submit'])) {
    $name     = $_POST['txt_name'];
    $email    = $_POST['txt_email'];
    $address  = $_POST['txt_add'];
    $place    = $_POST['sel_place'];
    $password = $_POST['txt_pwd'];
    $contact  = $_POST['txt_contact'];

    $photo = $_FILES['file_photo']['name'];
    $path = $_FILES['file_photo']['tmp_name'];
    move_uploaded_file($path, "../Assets/Files/Seller/" . $photo);

    $proof = $_FILES['file_proof']['name'];
    $path1 = $_FILES['file_proof']['tmp_name'];
    move_uploaded_file($path1, "../Assets/Files/Seller/" . $proof);

    $insQry = "INSERT INTO tbl_seller
        (seller_name, seller_email, seller_address, seller_password, seller_proof, seller_photo, seller_contact, place_id)
        VALUES ('$name','$email','$address','$password','$proof','$photo','$contact','$place')";
    if ($Con->query($insQry)) {
        echo "<script>alert('Seller Registered Successfully'); window.location='Login.php';</script>";
    } else {
        echo "<script>alert('Error in Registration');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AfterBump :: Seller Registration</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<style>
  body {
    background: linear-gradient(135deg, #f9a8d4 0%, #c084fc 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', sans-serif;
    padding: 20px;
  }
  .registration-card {
    max-width: 900px;
    width: 100%;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    overflow: hidden;
    display: flex;
    flex-direction: row;
  }
  .reg-left {
    flex: 1;
    padding: 30px;
  }
  .reg-right {
    flex: 1;
    background: #fdf2f8;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  .form-control, .form-select {
    border-radius: 10px;
    border: 1px solid #c084fc;
    padding: 8px;
    font-size: 14px;
  }
  .form-label {
    font-weight: 500;
    color: #333;
  }
  .btn-primary {
    border-radius: 25px;
    font-weight: 600;
    background: #c084fc;
    border: none;
    padding: 10px;
    transition: background 0.3s;
  }
  .btn-primary:hover {
    background: #a855f7;
  }
  .btn-back {
    background: #6c757d;
    border-radius: 25px;
    padding: 10px;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
  }
  .btn-back:hover {
    background: #5a6268;
  }
  h3 {
    color: #c026d3;
    font-weight: 600;
    text-align: center;
    margin-bottom: 20px;
  }
  .form-group {
    margin-bottom: 12px;
  }
  .d-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
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
  @media (max-width: 768px) {
    .registration-card {
      flex-direction: column;
      max-width: 500px;
    }
    .reg-right {
      padding: 10px;
    }
    .reg-right lottie-player {
      width: 200px !important;
      height: 200px !important;
    }
    .form-control, .form-select {
      font-size: 12px;
    }
    .d-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>

<div class="registration-card">
  <!-- Left Side (Form) -->
  <div class="reg-left">
    <h3><i class="fas fa-heartbeat"></i> Join AfterBump as a Seller</h3>
    <form method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="txt_name" class="form-label">Name</label>
        <input type="text" name="txt_name" id="txt_name" class="form-control" placeholder="Enter Your Name" required>
      </div>

      <div class="form-group">
        <label for="txt_email" class="form-label">Email</label>
        <input type="email" name="txt_email" id="txt_email" class="form-control" placeholder="Enter Your Email" required>
      </div>

      <div class="form-group">
        <label for="txt_add" class="form-label">Address</label>
        <textarea name="txt_add" id="txt_add" class="form-control" rows="2" placeholder="Enter Your Address" required></textarea>
      </div>

      <div class="form-group">
        <label for="file_photo" class="form-label">Upload Photo</label>
        <input type="file" name="file_photo" id="file_photo" class="form-control" accept="image/*" required>
      </div>

      <div class="form-group">
        <label for="file_proof" class="form-label">Upload Proof</label>
        <input type="file" name="file_proof" id="file_proof" class="form-control" accept="image/*,.pdf" required>
      </div>

      <div class="form-group">
        <label for="sel_district" class="form-label">Select District</label>
        <select name="sel_district" id="sel_district" class="form-select" onchange="getplace(this.value)" required>
          <option value="">Select District</option>
          <?php
          $selQry = "SELECT * FROM tbl_district ORDER BY district_name";
          $res = $Con->query($selQry);
          while ($data = $res->fetch_assoc()) {
              echo "<option value='".$data['district_id']."'>".$data['district_name']."</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="sel_place" class="form-label">Select Place</label>
        <select name="sel_place" id="sel_place" class="form-select" required>
          <option value="">Select Place</option>
        </select>
      </div>

      <div class="form-group">
        <label for="txt_contact" class="form-label">Contact</label>
        <input type="text" name="txt_contact" id="txt_contact" class="form-control" 
               placeholder="Enter Contact Number" 
               pattern="[6-9]{1}[0-9]{9}" 
               title="Enter valid 10-digit number starting with 6-9" required>
      </div>

      <div class="form-group password-wrapper">
        <label for="txt_pwd" class="form-label">Password</label>
        <input type="password" name="txt_pwd" id="txt_pwd" class="form-control" 
               placeholder="Enter Password" 
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" 
               title="Must contain at least one number, one uppercase, one lowercase letter, and at least 6 characters" required>
        <i class="fa fa-eye" id="togglePassword"></i>
      </div>

      <div class="d-grid">
        <button type="submit" name="btn_submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Register</button>
        <a href="Home.php" class="btn btn-back"><i class="fas fa-home"></i> Back to Home</a>
      </div>
    </form>
  </div>

  <!-- Right Side (Animation) -->
  <div class="reg-right">
    <lottie-player 
      src="https://assets9.lottiefiles.com/packages/lf20_wd1udlcz.json"
      background="transparent"  
      speed="1"  
      style="width: 300px; height: 300px;"  
      loop 
      autoplay>
    </lottie-player>
  </div>
</div>

<script>
function getplace(did) {
  $.ajax({
    url: "../Assets/Ajaxpages/AjaxPlace.php?did=" + did,
    success: function(html) {
      $("#sel_place").html(html);
    },
    error: function() {
      alert('Error loading places. Please try again.');
    }
  });
}

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