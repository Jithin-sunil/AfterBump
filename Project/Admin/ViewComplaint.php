<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

if (isset($_POST['btn_submit'])) {
    // This page is for listing, not submitting replies
    // Reply logic should be in Reply.php
}

if (isset($_GET['delid'])) {
    $delQry = "DELETE FROM tbl_complaint WHERE complaint_id='" . $_GET['delid'] . "'";
    if ($Con->query($delQry)) {
        echo "<script>alert('Complaint deleted successfully');window.location='ManageComplaints.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Complaints</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  .form-container, .table-container {
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
  .btn-primary {
      background-color: #007bff;
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
  .status-pending {
      color: #ffc107;
      font-weight: bold;
  }
  .status-replied {
      color: #28a745;
      font-weight: bold;
  }
</style>
</head>

<body>

<div class="table-container card p-4 shadow-sm">
  <h4 class="mb-3"><i class="fas fa-exclamation-triangle"></i> User Complaints</h4>
  <table class="table table-bordered table-striped">
    <tr>
      <th>Sl No</th>
      <th>User Details</th>
      <th>Title</th>
      <th>Content</th>
      <th>Date</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
    <?php
    $i = 0;
    $selQry = "SELECT c.*, u.user_name, u.user_email FROM tbl_complaint c LEFT JOIN tbl_user u ON c.user_id = u.user_id ORDER BY c.complaint_date DESC";
    $result = $Con->query($selQry);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $i++;
            $status_class = ($row['complaint_status'] == 1) ? 'status-replied' : 'status-pending';
            $status_text = ($row['complaint_status'] == 1) ? 'Replied' : 'Pending';
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td>
                <?php echo $row['user_name']; ?><br>
                <small class="text-muted"><?php echo $row['user_email']; ?></small>
              </td>
              <td><?php echo $row['complaint_title']; ?></td>
              <td><?php echo $row['complaint_content']; ?></td>
              <td><?php echo $row['complaint_date']; ?></td>
              <td><span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
              <td>
                <?php if ($row['complaint_status'] == 0) { ?>
                  <a href="Reply.php?cid=<?php echo $row['complaint_id']; ?>" 
                     class="btn btn-primary"><i class="fa fa-reply"></i>Reply</a>
                <?php } else { ?>
                  <span class="text-muted">Replied</span>
                <?php } ?>
                <a href="ManageComplaints.php?delid=<?php echo $row['complaint_id']; ?>" 
                   class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this complaint?')">
                   <i class="fa fa-trash"></i>Delete</a>
              </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
          <td colspan="7" class="text-muted">No complaints found.</td>
        </tr>
        <?php
    }
    ?>
  </table>
</div>

</body>
</html>

<?php include("Foot.php") ?>