<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

if (isset($_GET['delid'])) {
    $delQry = "DELETE FROM tbl_feedback WHERE feedback_id='" . $_GET['delid'] . "'";
    if ($Con->query($delQry)) {
        echo "<script>alert('Feedback deleted successfully');window.location='ManageFeedback.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Feedback</title>
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

<div class="table-container card p-4 shadow-sm">
  <h4 class="mb-3"><i class="fas fa-comment-dots"></i> User Feedback</h4>
  <table class="table table-bordered table-striped">
    <tr>
      <th>Sl No</th>
      <th>User Details</th>
      <th>Content</th>
      <th>Action</th>
    </tr>
    <?php
    $i = 0;
    $selQry = "SELECT f.*, u.user_name, u.user_email FROM tbl_feedback f LEFT JOIN tbl_user u ON f.user_id = u.user_id ORDER BY f.feedback_id DESC";
    $result = $Con->query($selQry);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $i++;
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td>
                <?php echo $row['user_name']; ?><br>
                <small class="text-muted"><?php echo $row['user_email']; ?></small>
              </td>
              <td class="text-start"><?php echo $row['feedback_content']; ?></td>
              <td>
                <a href="ManageFeedback.php?delid=<?php echo $row['feedback_id']; ?>" 
                   class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this feedback?')">
                   <i class="fa fa-trash"></i>Delete</a>
              </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
          <td colspan="4" class="text-muted">No feedback found.</td>
        </tr>
        <?php
    }
    ?>
  </table>
</div>

</body>
</html>

<?php include("Foot.php") ?>