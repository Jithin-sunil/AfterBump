<?php 
include("Head.php");
include("../Assets/Connection/Connection.php");

$adminId = "";
$adminName = "";
$adminEmail = "";
$adminPassword = "";

if (isset($_GET['did'])) {
    $delQry = "DELETE FROM tbl_admin WHERE admin_id='".$_GET['did']."'";
    if ($Con->query($delQry)) {
        echo "<script>alert('Record Deleted');window.location = 'AdminRegistration.php';</script>";
        exit();
    }
}

if (isset($_GET['eid'])) {
    $selQry = "SELECT * FROM tbl_admin WHERE admin_id='".$_GET['eid']."'";
    $row = $Con->query($selQry);
    if ($data = $row->fetch_assoc()) {
        $adminId = $data['admin_id'];
        $adminName = $data['admin_name'];
        $adminEmail = $data['admin_email'];
        $adminPassword = $data['admin_password'];
    }
}

if (isset($_POST['btn_submit'])) {
    $adminName = $_POST['txt_name'];
    $adminEmail = $_POST['txt_email'];
    $adminPassword = $_POST['txt_password'];
    $hiddenId = $_POST['txt_hidden'];

    // Added duplicate email check
    $dupQry = "SELECT * FROM tbl_admin WHERE admin_email='".$adminEmail."' AND admin_id!='".$hiddenId."'";
    $dupRes = $Con->query($dupQry);
    
    if($dupRes->num_rows > 0) {
        echo "<script>alert('Email already exists');window.location = 'AdminRegistration.php';</script>";
    } else {
        if ($hiddenId != "") {
            $updQry = "UPDATE tbl_admin SET admin_name='".$adminName."', admin_email='".$adminEmail."', admin_password='".$adminPassword."' WHERE admin_id='".$hiddenId."'";
            if ($Con->query($updQry)) {
                echo "<script>alert('Registration Updated Successfully');window.location = 'AdminRegistration.php';</script>";
            }
        } else {
            $inQry = "INSERT INTO tbl_admin(admin_name, admin_email, admin_password) VALUES ('".$adminName."','".$adminEmail."','".$adminPassword."')";
            if ($Con->query($inQry)) {
                echo "<script>alert('Registration Inserted Successfully');window.location = 'AdminRegistration.php';</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Registration</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  .form-container, .table-container {
      width: 70%;
      margin: 20px auto;
  }
  table {
      width: 100%;
      text-align: center;
      border-collapse: collapse;
  }
  table th, table td {
      padding: 12px;
      border: 1px solid #ddd;
  }
  table th {
      background: #f5f5f5;
  }
  .btn {
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      color: #fff;
      font-size: 14px;
      margin: 2px;
  }
  .btn-edit {
      background-color: #007bff;
  }
  .btn-delete {
      background-color: #dc3545;
  }
  .btn-success {
      background-color: #28a745;
  }
  .btn-secondary {
      background-color: #6c757d;
  }
  .btn i {
      margin-right: 5px;
  }
  .card {
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      border: 1px solid rgba(0, 0, 0, 0.125);
      border-radius: 0.375rem;
  }
  .p-4 {
      padding: 1.5rem;
  }
  .mb-3 {
      margin-bottom: 1rem;
  }
  .form-label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: bold;
  }
  .form-control {
      width: 100%;
      padding: 0.375rem 0.75rem;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
  }
  .text-center {
      text-align: center;
  }
  .table {
      margin-bottom: 0;
  }
  .table-bordered th,
  .table-bordered td {
      border: 1px solid #dee2e6;
  }
  .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(0, 0, 0, 0.05);
  }
</style>
</head>

<body>

<div class="form-container card p-4 shadow-sm">
  <h4 class="mb-3"><i class="fas fa-user-shield"></i> Admin Registration</h4>
  <form method="post" action="">
    <div class="mb-3">
      <label for="txt_name" class="form-label">Admin Name</label>
      <input type="hidden" name="txt_hidden" value="<?php echo $adminId; ?>" />
      <input type="text" name="txt_name" id="txt_name" class="form-control" value="<?php echo $adminName; ?>" placeholder="Enter Name" required />
    </div>
    <div class="mb-3">
      <label for="txt_email" class="form-label">Email</label>
      <input type="email" name="txt_email" id="txt_email" class="form-control" value="<?php echo $adminEmail; ?>" placeholder="Enter Email" required />
    </div>
    <div class="mb-3">
      <label for="txt_password" class="form-label">Password</label>
      <input type="password" name="txt_password" id="txt_password" class="form-control" value="<?php echo $adminPassword; ?>" placeholder="Enter Password" required />
    </div>
    <div class="text-center">
      <input type="submit" name="btn_submit" id="btn_submit" class="btn btn-success" value="<?php echo ($adminId != "") ? 'Update' : 'Submit'; ?>" />
      <input type="reset" name="btn_reset" id="btn_reset" class="btn btn-secondary" value="Reset" />
    </div>
  </form>
</div>

<div class="table-container card p-4 shadow-sm">
  <h4 class="mb-3"><i class="fas fa-list"></i> Registered Admins</h4>
  <table class="table table-bordered table-striped">
    <tr>
      <th>SI.no</th>
      <th>Admin Name</th>
      <th>Email ID</th>
      <th>Action</th>
    </tr>
    <?php
    $selQry = "SELECT * FROM tbl_admin ORDER BY admin_name";
    $i = 0;
    $row = $Con->query($selQry);
    while ($data = $row->fetch_assoc()) {
        $i++;
    ?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $data['admin_name']; ?></td>
      <td><?php echo $data['admin_email']; ?></td>
      <td>
        <a href="AdminRegistration.php?did=<?php echo $data['admin_id']; ?>" 
           class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this record?')">
           <i class="fa fa-trash"></i>Delete</a>
        <a href="AdminRegistration.php?eid=<?php echo $data['admin_id']; ?>" 
           class="btn btn-edit"><i class="fa fa-edit"></i>Edit</a>
      </td>
    </tr>
    <?php
    }
    ?>
  </table>
</div>

</body>
</html>
<?php include("Foot.php") ?>