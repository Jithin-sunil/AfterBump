<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$dis_name = "";
$dis_id = "";

if (isset($_POST['btn_submit'])) {
    $category = $_POST['txt_category'];
    $hid = $_POST['txt_hidden'];

    // Added duplicate check
    $dupQry = "SELECT * FROM tbl_category WHERE category_name='" . $category . "' AND category_id!='". $hid ."'";
    $dupRes = $Con->query($dupQry);
    
    if($dupRes->num_rows > 0) {
        echo "<script>alert('Category already exists');window.location='Category.php';</script>";
    } else {
        if ($hid == "") {
            $insQry = "INSERT INTO tbl_category(category_name) VALUES('" . $category . "')";
            if ($Con->query($insQry)) {
                echo "<script>alert('Inserted');window.location='Category.php';</script>";
            }
        } else {
            $upQry = "UPDATE tbl_category SET category_name='" . $category . "' WHERE category_id='" . $hid . "'";
            if ($Con->query($upQry)) {
                echo "<script>alert('Updated');window.location='Category.php';</script>";
            }
        }
    }
}

if (isset($_GET['did'])) {
    // Check if category is referenced in tbl_product before delete
    $checkQry = "SELECT COUNT(*) as cnt FROM tbl_product WHERE category_id='" . $_GET['did'] . "'";
    $checkRes = $Con->query($checkQry);
    $checkData = $checkRes->fetch_assoc();
    
    if($checkData['cnt'] > 0) {
        echo "<script>alert('Cannot delete category as it is referenced in products.');window.location='Category.php';</script>";
    } else {
        $delQry = "DELETE FROM tbl_category WHERE category_id='" . $_GET['did'] . "'";
        if ($Con->query($delQry)) {
            echo "<script>alert('Deleted');window.location='Category.php';</script>";
        }
    }
}

if (isset($_GET['eid'])) {
    $selQry = "SELECT * FROM tbl_category WHERE category_id='" . $_GET['eid'] . "'";
    $row = $Con->query($selQry);
    $data = $row->fetch_assoc();
    $dis_name = $data['category_name'];
    $dis_id = $data['category_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Category Management</title>
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
  <h4 class="mb-3"><i class="fas fa-list-ul"></i> Manage Category</h4>
  <form method="post" action="">
    <div class="mb-3">
      <label for="txt_category" class="form-label">Category Name</label>
      <input type="hidden" name="txt_hidden" value="<?php echo $dis_id; ?>" />
      <input type="text" name="txt_category" id="txt_category" class="form-control" placeholder="Enter Category" value="<?php echo $dis_name; ?>" required />
    </div>
    <div class="text-center">
      <input type="submit" name="btn_submit" id="btn_submit" 
             class="btn btn-success" 
             value="<?php echo ($dis_id != '') ? 'Update' : 'Submit'; ?>" />
      <input type="reset" name="btn_reset" id="btn_reset" class="btn btn-secondary" value="Reset" />
    </div>
  </form>
</div>

<div class="table-container card p-4 shadow-sm">
  <h4 class="mb-3"><i class="fas fa-list"></i> Available Categories</h4>
  <table class="table table-bordered table-striped">
    <tr>
      <th>SI No</th>
      <th>Category Name</th>
      <th>Action</th>
    </tr>
    <?php
    $i = 0;
    $selQry = "SELECT * FROM tbl_category ORDER BY category_name";
    $result = $Con->query($selQry);
    while ($row = $result->fetch_assoc()) {
        $i++;
    ?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $row['category_name']; ?></td>
      <td>
        <a href="Category.php?eid=<?php echo $row['category_id']; ?>" 
           class="btn btn-edit"><i class="fa fa-edit"></i>Edit</a>
        <a href="Category.php?did=<?php echo $row['category_id']; ?>" 
           class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this category?')">
           <i class="fa fa-trash"></i>Delete</a>
      </td>
    </tr>
    <?php
    }
    ?>
  </table>
  <?php if ($i == 0) { ?>
    <div class="alert alert-warning text-center">No categories found.</div>
  <?php } ?>
</div>

</body>
</html>

<?php include("Foot.php") ?>