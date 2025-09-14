<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$reply = "";
$complaint_id = 0; // Assume we get this from session or URL

if (isset($_POST['btn_submit'])) {
    $reply = $_POST['txt_reply'];
    
    // Assuming complaint_id is set (e.g., from $_GET['cid'] or session)
    // For demo, let's assume it's passed via hidden field or URL
    if ($complaint_id != 0) {
        $updQry = "UPDATE tbl_complaint SET complaint_reply='" . $reply . "', complaint_status=1 WHERE complaint_id='" . $complaint_id . "'";
        if ($Con->query($updQry)) {
            echo "<script>alert('Reply submitted successfully');window.location='ViewComplaint.php';</script>"; // Redirect to complaints list
        }
    } else {
        echo "<script>alert('Invalid complaint ID');window.location='ViewComplaint.php';</script>";
    }
}

// If editing a specific complaint, fetch details (optional, if pre-filling reply)
if (isset($_GET['cid'])) {
    $complaint_id = $_GET['cid'];
    // Fetch complaint details if needed
    $selQry = "SELECT * FROM tbl_complaint WHERE complaint_id='" . $complaint_id . "'";
    $row = $Con->query($selQry);
    if ($data = $row->fetch_assoc()) {
        // $reply = $data['complaint_reply']; // If pre-filling existing reply
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reply to Complaint</title>
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
</style>
</head>

<body>

<div class="form-container card p-4 shadow-sm">
  <h4 class="mb-3"><i class="fas fa-reply"></i> Reply to Complaint</h4>
  <form method="post" action="">
    <input type="hidden" name="hdn_complaint_id" value="<?php echo $complaint_id; ?>" />
    <div class="mb-3">
      <label for="txt_reply" class="form-label">Reply</label>
      <input type="text" name="txt_reply" id="txt_reply" class="form-control" placeholder="Enter Reply" value="<?php echo $reply; ?>" required />
    </div>
    <div class="text-center">
      <input type="submit" name="btn_submit" id="btn_submit" 
             class="btn btn-success" value="Submit" />
      <a href="ViewComplaint.php" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

<!-- Optional: Display the complaint details above the form -->
<div class="table-container card p-4 shadow-sm" style="margin-top: 20px;">
  <h4 class="mb-3"><i class="fas fa-exclamation-triangle"></i> Complaint Details</h4>
  <table class="table table-bordered">
    <tr>
      <th>Title</th>
      <th>Content</th>
      <th>Date</th>
      <th>Status</th>
    </tr>
    <?php
    if ($complaint_id != 0) {
        $selDetails = "SELECT * FROM tbl_complaint WHERE complaint_id='" . $complaint_id . "'";
        $resDetails = $Con->query($selDetails);
        if ($dataDetails = $resDetails->fetch_assoc()) {
            ?>
            <tr>
              <td><?php echo $dataDetails['complaint_title']; ?></td>
              <td><?php echo $dataDetails['complaint_content']; ?></td>
              <td><?php echo $dataDetails['complaint_date']; ?></td>
              <td><?php echo ($dataDetails['complaint_status'] == 1) ? 'Replied' : 'Pending'; ?></td>
            </tr>
            <?php
        }
    }
    ?>
  </table>
</div>

</body>
</html>

<?php include("Foot.php") ?>