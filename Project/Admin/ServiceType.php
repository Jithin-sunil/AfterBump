<?php include("Head.php"); ?>
<?php include("../Assets/Connection/Connection.php");

$type_name = "";
$type_id = "";

if (isset($_POST['btn_submit'])) {
    $district = $_POST['txt_type'];
    $hid = $_POST['txt_hidden'];

    // Added duplicate check
    $dupQry = "SELECT * FROM tbl_servicetype WHERE servicetype_name='" . $district . "' AND servicetype_id!='". $hid ."'";
    $dupRes = $Con->query($dupQry);
    
    if($dupRes->num_rows > 0) {
        echo "<script>alert('Service type already exists'); window.location='ServiceType.php';</script>";
    } else {
        if ($hid == "") {
            $insQry = "INSERT INTO tbl_servicetype(servicetype_name) VALUES('" . $district . "')";
            if ($Con->query($insQry)) {
                echo "<script>alert('Inserted'); window.location='ServiceType.php';</script>";
            }
        } else {
            $upQry = "UPDATE tbl_servicetype SET servicetype_name='" . $district . "' WHERE servicetype_id='" . $hid . "'";
            if ($Con->query($upQry)) {
                echo "<script>alert('Updated'); window.location='ServiceType.php';</script>";
            }
        }
    }
}

if (isset($_GET['did'])) {
    // Check if referenced in tbl_servicepost before delete
    $checkQry = "SELECT COUNT(*) as cnt FROM tbl_servicepost WHERE servicetype_id='" . $_GET['did'] . "'";
    $checkRes = $Con->query($checkQry);
    $checkData = $checkRes->fetch_assoc();
    
    if($checkData['cnt'] > 0) {
        echo "<script>alert('Cannot delete service type as it is referenced in service posts.'); window.location='ServiceType.php';</script>";
    } else {
        $delQry = "DELETE FROM tbl_servicetype WHERE servicetype_id='" . $_GET['did'] . "'";
        if ($Con->query($delQry)) {
            echo "<script>alert('Deleted'); window.location='ServiceType.php';</script>";
        }
    }
}

if (isset($_GET['eid'])) {
    $selQry = "SELECT * FROM tbl_servicetype WHERE servicetype_id='" . $_GET['eid'] . "'";
    $row = $Con->query($selQry);
    $data = $row->fetch_assoc();

    $type_name = $data['servicetype_name'];
    $type_id = $data['servicetype_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Service Type Management</title>
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
  <h4 class="mb-3"><i class="fas fa-cogs"></i> Manage Service Type</h4>
  <form method="post" action="">
    <div class="mb-3">
      <label for="txt_type" class="form-label">Service Type</label>
      <input type="hidden" name="txt_hidden" value="<?php echo $type_id; ?>" />
      <input type="text" name="txt_type" id="txt_type" class="form-control" placeholder="Enter Service Type" value="<?php echo $type_name; ?>" required />
    </div>
    <div class="text-center">
      <input type="submit" name="btn_submit" id="btn_submit" 
             class="btn btn-success" 
             value="<?php echo ($type_id != '') ? 'Update' : 'Submit'; ?>" />
      <input type="reset" name="btn_reset" id="btn_reset" class="btn btn-secondary" value="Reset" />
    </div>
  </form>
</div>

<div class="table-container card p-4 shadow-sm">
  <h4 class="mb-3"><i class="fas fa-list"></i> Available Service Types</h4>
  <table class="table table-bordered table-striped">
    <tr>
      <th>SI No</th>
      <th>Service Type</th>
      <th>Action</th>
    </tr>
    <?php
    $i = 0;
    $selQry = "SELECT * FROM tbl_servicetype ORDER BY servicetype_name";
    $result = $Con->query($selQry);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $i++;
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row['servicetype_name']; ?></td>
              <td>
                <a href="ServiceType.php?eid=<?php echo $row['servicetype_id']; ?>" 
                   class="btn btn-edit"><i class="fa fa-edit"></i>Edit</a>
                <a href="ServiceType.php?did=<?php echo $row['servicetype_id']; ?>" 
                   class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this service type?')">
                   <i class="fa fa-trash"></i>Delete</a>
              </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
          <td colspan="3" class="text-muted">No service types found.</td>
        </tr>
        <?php
    }
    ?>
  </table>
</div>

</body>
</html>

<?php include("Foot.php"); ?>