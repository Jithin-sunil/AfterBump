<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$pid = "";
$pname = "";
$disid = "";

if(isset($_POST['btn_submit']))
{
    $place = $_POST['txt_place'];
    $district = $_POST['sel_district'];  // Fixed: sel_disrtict -> sel_district
    $hid = $_POST['txt_hidden'];
    
    // Added duplicate check (place name within district)
    $dupQry = "SELECT * FROM tbl_place WHERE place_name='" . $place . "' AND district_id='" . $district . "' AND place_id!='". $hid ."'";
    $dupRes = $Con->query($dupQry);
    
    if($dupRes->num_rows > 0)
    {
        echo "<script>alert('Place already exists in this district');window.location='Place.php';</script>";
    }
    else
    {
        if($hid == "")
        {
            $insQry = "insert into tbl_place(place_name,district_id) values('".$place."','".$district."')";
            if($Con->query($insQry))
            {
                echo "<script>alert('Inserted');window.location='Place.php';</script>";
            }       
        }
        else
        {
            $upQry = "update tbl_place set place_name='".$place."',district_id='".$district."' where place_id='".$hid."'";
            if($Con->query($upQry))
            {
                echo "<script>alert('Updated');window.location='Place.php';</script>";
            }
        }
    }
}

if(isset($_GET['did']))
{
    // Check if place is referenced (e.g., in sellers, deliveries, users) before delete
    $checkQry = "SELECT COUNT(*) as cnt FROM (SELECT place_id FROM tbl_seller WHERE place_id='".$_GET['did']."' UNION SELECT place_id FROM tbl_delivery WHERE place_id='".$_GET['did']."' UNION SELECT place_id FROM tbl_user WHERE place_id='".$_GET['did']."') as refs";
    $checkRes = $Con->query($checkQry);
    $checkData = $checkRes->fetch_assoc();
    
    if($checkData['cnt'] > 0)
    {
        echo "<script>alert('Cannot delete place as it is referenced in sellers, deliveries, or users.');window.location='Place.php';</script>";
    }
    else
    {
        $delQry = "delete from tbl_place where place_id='".$_GET['did']."'";
        if($Con->query($delQry))
        {
            echo "<script>alert('Deleted');window.location='Place.php';</script>";
        }
    }
}

if(isset($_GET['eid']))
{
    $selQry = "select * from tbl_place where place_id='".$_GET['eid']."'";
    $row = $Con->query($selQry);
    $data = $row->fetch_assoc();
    
    $pname = $data['place_name'];
    $pid = $data['place_id'];    
    $disid = $data['district_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Place Management</title>
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
  <h4 class="mb-3"><i class="fas fa-map-pin"></i> Manage Place</h4>
  <form method="post" action="">
    <div class="mb-3">
      <label for="sel_district" class="form-label">District</label>
      <input type="hidden" name="txt_hidden" value="<?php echo $pid; ?>" />
      <select name="sel_district" id="sel_district" class="form-control" required>
        <option value="">Select District</option>
        <?php
        $selQry = "select * from tbl_district ORDER BY district_name";
        $res = $Con->query($selQry);
        while($data = $res->fetch_assoc())
        {
        ?>
        <option <?php if($disid == $data['district_id']) { echo "selected"; } ?> value="<?php echo $data['district_id']; ?>"><?php echo $data['district_name']; ?></option>
        <?php 
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="txt_place" class="form-label">Place Name</label>
      <input type="text" name="txt_place" id="txt_place" class="form-control" placeholder="Enter Place" value="<?php echo $pname; ?>" required />
    </div>
    <div class="text-center">
      <input type="submit" name="btn_submit" id="btn_submit" 
             class="btn btn-success" 
             value="<?php echo ($pid != '') ? 'Update' : 'Submit'; ?>" />
      <input type="reset" name="btn_reset" id="btn_reset" class="btn btn-secondary" value="Reset" />
    </div>
  </form>
</div>

<div class="table-container card p-4 shadow-sm">
  <h4 class="mb-3"><i class="fas fa-list"></i> Place List</h4>
  <table class="table table-bordered table-striped">
    <tr>
      <th>SI No</th>
      <th>District</th>
      <th>Place</th>
      <th>Action</th>
    </tr>
    <?php
    $i = 0;
    $sel = "select * from tbl_place p inner join tbl_district d on p.district_id=d.district_id ORDER BY d.district_name, p.place_name";
    $res = $Con->query($sel);
    if($res->num_rows > 0)
    {
        while($data = $res->fetch_assoc())
        {
            $i++;
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $data['district_name']; ?></td>
              <td><?php echo $data['place_name']; ?></td>
              <td>
                <a href="Place.php?eid=<?php echo $data['place_id']; ?>" 
                   class="btn btn-edit"><i class="fa fa-edit"></i>Edit</a>
                <a href="Place.php?did=<?php echo $data['place_id']; ?>" 
                   class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this place?')">
                   <i class="fa fa-trash"></i>Delete</a>
              </td>
            </tr>
            <?php
        }
    } 
    else 
    {
        ?>
        <tr>
          <td colspan="4" class="text-muted">No places found.</td>
        </tr>
        <?php
    }
    ?>
  </table>
</div>

</body>
</html>

<?php include("Foot.php") ?>