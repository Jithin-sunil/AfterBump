<?php 
include("Head.php");
include("../Assets/Connection/Connection.php");

// Accept
if (isset($_GET['aid'])) {
    $delivery_id = $_GET['aid'];
    $upQry = "UPDATE tbl_delivery SET delivery_status=1 WHERE delivery_id='" . $delivery_id . "'";
    if ($Con->query($upQry)) {
        echo "<script>alert('Delivery boy Verified Successfully'); window.location='DeliveryBoyVerification.php';</script>";
    }
}

// Reject
if (isset($_GET['rid'])) {
    $delivery_id = $_GET['rid'];
    $upQry = "UPDATE tbl_delivery SET delivery_status=2 WHERE delivery_id='" . $delivery_id . "'";
    if ($Con->query($upQry)) {
        echo "<script>alert('Delivery boy Rejected Successfully'); window.location='DeliveryBoyVerification.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Delivery Boy Verification</title>
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
  .btn-accept {
      background-color: #28a745;
  }
  .btn-reject {
      background-color: #dc3545;
  }
  .btn i {
      margin-right: 5px;
  }
  .card {
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      border: 1px solid rgba(0, 0, 0, 0.125);
      border-radius: 0.375rem;
      margin-bottom: 20px;
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
  .img-thumbnail {
      border-radius: 0.25rem;
      border: 1px solid #dee2e6;
  }
</style>
</head>

<body>

<div class="table-container card p-4 shadow-sm">
  <h4 class="mb-3 text-center"><i class="fas fa-bicycle"></i> Delivery Boy Verification</h4>

  <!-- Pending Delivery Boys -->
  <div class="card">
    <div class="card-header" style="background-color: #ffc107; color: #000;">
      <h5 class="mb-0"><i class="fas fa-clock"></i> Pending Delivery Boys</h5>
    </div>
    <div class="p-4">
      <table class="table table-bordered table-striped">
        <tr>
          <th>SNO</th>
          <th>Name</th>
          <th>Email</th>
          <th>Address</th>
          <th>District</th>
          <th>Place</th>
          <th>Proof</th>
          <th>Photo</th>
          <th>Action</th>
        </tr>
        <?php
        $selQry = "SELECT * FROM tbl_delivery s
                   INNER JOIN tbl_place p ON s.place_id=p.place_id 
                   INNER JOIN tbl_district d ON p.district_id=d.district_id 
                   WHERE s.delivery_status=0 ORDER BY s.delivery_id DESC";
        $i = 0;
        $row = $Con->query($selQry);
        if ($row->num_rows > 0) {
            while ($data = $row->fetch_assoc()) {
                $i++;
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $data['delivery_name']; ?></td>
                  <td><?php echo $data['delivery_email']; ?></td>
                  <td><?php echo $data['delivery_address']; ?></td>
                  <td><?php echo $data['district_name']; ?></td>
                  <td><?php echo $data['place_name']; ?></td>
                  <td><img src="../Assets/Files/DeliveryBoy/<?php echo $data['delivery_proof']; ?>" class="img-thumbnail" width="80" /></td>
                  <td><img src="../Assets/Files/DeliveryBoy/<?php echo $data['delivery_photo']; ?>" class="img-thumbnail" width="80" /></td>
                  <td>
                    <a href="DeliveryBoyVerification.php?aid=<?php echo $data['delivery_id']; ?>" 
                       class="btn btn-accept" onclick="return confirm('Are you sure you want to accept this delivery boy?')">
                       <i class="fa fa-check"></i>Accept</a>
                    <a href="DeliveryBoyVerification.php?rid=<?php echo $data['delivery_id']; ?>" 
                       class="btn btn-reject" onclick="return confirm('Are you sure you want to reject this delivery boy?')">
                       <i class="fa fa-times"></i>Reject</a>
                  </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
              <td colspan="9" class="text-muted">No pending delivery boys.</td>
            </tr>
            <?php
        }
        ?>
      </table>
    </div>
  </div>

  <!-- Accepted Delivery Boys -->
  <div class="card">
    <div class="card-header" style="background-color: #28a745; color: #fff;">
      <h5 class="mb-0"><i class="fas fa-check-circle"></i> Accepted Delivery Boys</h5>
    </div>
    <div class="p-4">
      <table class="table table-bordered table-striped">
        <tr>
          <th>SNO</th>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Address</th>
          <th>District</th>
          <th>Place</th>
          <th>Proof</th>
          <th>Photo</th>
          <th>Status</th>
        </tr>
        <?php
        $selQryAccepted = "SELECT * FROM tbl_delivery s
                           INNER JOIN tbl_place p ON s.place_id=p.place_id 
                           INNER JOIN tbl_district d ON p.district_id=d.district_id 
                           WHERE s.delivery_status=1 ORDER BY s.delivery_id DESC";
        $j = 0;
        $rowAccepted = $Con->query($selQryAccepted);
        if ($rowAccepted->num_rows > 0) {
            while ($dataAccepted = $rowAccepted->fetch_assoc()) {
                $j++;
                ?>
                <tr>
                  <td><?php echo $j; ?></td>
                  <td><?php echo $dataAccepted['delivery_id']; ?></td>
                  <td><?php echo $dataAccepted['delivery_name']; ?></td>
                  <td><?php echo $dataAccepted['delivery_email']; ?></td>
                  <td><?php echo $dataAccepted['delivery_password']; ?></td>
                  <td><?php echo $dataAccepted['delivery_address']; ?></td>
                  <td><?php echo $dataAccepted['district_name']; ?></td>
                  <td><?php echo $dataAccepted['place_name']; ?></td>
                  <td><img src="../Assets/Files/DeliveryBoy/<?php echo $dataAccepted['delivery_proof']; ?>" class="img-thumbnail" width="80" /></td>
                  <td><img src="../Assets/Files/DeliveryBoy/<?php echo $dataAccepted['delivery_photo']; ?>" class="img-thumbnail" width="80" /></td>
                  <td><span class="badge bg-success">Accepted</span></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
              <td colspan="11" class="text-muted">No accepted delivery boys.</td>
            </tr>
            <?php
        }
        ?>
      </table>
    </div>
  </div>

  <!-- Rejected Delivery Boys -->
  <div class="card">
    <div class="card-header" style="background-color: #dc3545; color: #fff;">
      <h5 class="mb-0"><i class="fas fa-times-circle"></i> Rejected Delivery Boys</h5>
    </div>
    <div class="p-4">
      <table class="table table-bordered table-striped">
        <tr>
          <th>SNO</th>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Address</th>
          <th>District</th>
          <th>Place</th>
          <th>Proof</th>
          <th>Photo</th>
          <th>Status</th>
        </tr>
        <?php
        $selQryRejected = "SELECT * FROM tbl_delivery b
                           INNER JOIN tbl_place p ON b.place_id=p.place_id 
                           INNER JOIN tbl_district d ON p.district_id=d.district_id 
                           WHERE b.delivery_status=2 ORDER BY b.delivery_id DESC";
        $k = 0;
        $rowRejected = $Con->query($selQryRejected);
        if ($rowRejected->num_rows > 0) {
            while ($dataRejected = $rowRejected->fetch_assoc()) {
                $k++;
                ?>
                <tr>
                  <td><?php echo $k; ?></td>
                  <td><?php echo $dataRejected['delivery_id']; ?></td>
                  <td><?php echo $dataRejected['delivery_name']; ?></td>
                  <td><?php echo $dataRejected['delivery_email']; ?></td>
                  <td><?php echo $dataRejected['delivery_password']; ?></td>
                  <td><?php echo $dataRejected['delivery_address']; ?></td>
                  <td><?php echo $dataRejected['district_name']; ?></td>
                  <td><?php echo $dataRejected['place_name']; ?></td>
                  <td><img src="../Assets/Files/DeliveryBoy/<?php echo $dataRejected['delivery_proof']; ?>" class="img-thumbnail" width="80" /></td>
                  <td><img src="../Assets/Files/DeliveryBoy/<?php echo $dataRejected['delivery_photo']; ?>" class="img-thumbnail" width="80" /></td>
                  <td><span class="badge bg-danger">Rejected</span></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
              <td colspan="11" class="text-muted">No rejected delivery boys.</td>
            </tr>
            <?php
        }
        ?>
      </table>
    </div>
  </div>

</div>

</body>
</html>

<?php include("Foot.php"); ?>