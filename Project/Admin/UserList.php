<?php 
include("Head.php");
include("../Assets/Connection/Connection.php");

// Remove user (set status=0)
if (isset($_GET['remove'])) {
    $user_id = $_GET['remove'];
    $upQry = "UPDATE tbl_user SET user_status=0 WHERE user_id='" . $user_id . "'";
    if ($Con->query($upQry)) {
        echo "<script>alert('User Removed Successfully'); window.location='UserList.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User List Management</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  .table-container {
      width: 90%;
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
  .btn-remove {
      background-color: #dc3545;
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
  .status-active {
      color: #28a745;
      font-weight: bold;
  }
  .status-removed {
      color: #dc3545;
      font-weight: bold;
  }
</style>
</head>

<body>

<div class="table-container card p-4 shadow-sm">
  <h4 class="mb-3 text-center"><i class="fas fa-users"></i> Registered Users</h4>
  <table class="table table-bordered table-striped">
    <tr>
      <th>Sl.No</th>
      <th>Name</th>
      <th>Address</th>
      <th>Email</th>
      <th>District</th>
      <th>Place</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
    <?php
    $i = 0;
    $selqry = "SELECT u.*, p.place_name, d.district_name FROM tbl_user u 
               INNER JOIN tbl_place p ON u.place_id = p.place_id
               INNER JOIN tbl_district d ON p.district_id = d.district_id 
               ORDER BY u.user_id DESC";
    $result = $Con->query($selqry);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $i++;
            $status_class = ($row['user_status'] == 1) ? 'status-active' : 'status-removed';
            $status_text = ($row['user_status'] == 1) ? 'Active' : 'Removed';
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row['user_name']; ?></td>
              <td><?php echo $row['user_address']; ?></td>
              <td><?php echo $row['user_email']; ?></td>
              <td><?php echo $row['district_name']; ?></td>
              <td><?php echo $row['place_name']; ?></td>
              <td><span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
              <td>
                <a href="UserList.php?remove=<?php echo $row['user_id']; ?>" 
                   class="btn btn-remove" onclick="return confirm('Are you sure you want to remove this user?')">
                   <i class="fa fa-trash"></i>Remove</a>
              </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
          <td colspan="8" class="text-muted">No users found.</td>
        </tr>
        <?php
    }
    ?>
  </table>
</div>

</body>
</html>

<?php include("Foot.php"); ?>