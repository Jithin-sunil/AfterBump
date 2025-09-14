<?php include("Head.php"); ?>  

<?php
include("../Assets/Connection/Connection.php");

if (isset($_GET['aid'])) {
    $seller_id = $_GET['aid'];
    $upQry = "UPDATE tbl_seller SET seller_status=1 WHERE seller_id='" . $seller_id . "'";
    if ($Con->query($upQry)) {
        echo "<script>alert('Seller Verified Successfully'); window.location='SellerVerification.php';</script>";
    }
}

if (isset($_GET['rid'])) {
    $seller_id = $_GET['rid'];
    $upQry = "UPDATE tbl_seller SET seller_status=2 WHERE seller_id='" . $seller_id . "'";
    if ($Con->query($upQry)) {
        echo "<script>alert('Seller Rejected Successfully'); window.location='SellerVerification.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Seller Verification</title>
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
  <h4 class="mb-3 text-center"><i class="fas fa-user-check"></i> Seller Verification</h4>

  <!-- Pending Sellers -->
  <div class="card">
    <div class="card-header" style="background-color: #ffc107; color: #000;">
      <h5 class="mb-0"><i class="fas fa-clock"></i> Pending Sellers</h5>
    </div>
    <div class="p-4">
      <table class="table table-bordered table-striped">
        <tr>
          <th>SI.NO</th>
          <th>Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Address</th>
          <th>District</th>
          <th>Place</th>
          <th>Logo</th>
          <th>Proof</th>
          <th>Action</th>
        </tr>
        <?php
        $selQry = "SELECT * FROM tbl_seller s
                   INNER JOIN tbl_place p ON s.place_id=p.place_id 
                   INNER JOIN tbl_district d ON p.district_id=d.district_id 
                   WHERE s.seller_status=0 ORDER BY s.seller_id DESC";
        $i = 0;
        $row = $Con->query($selQry);
        if ($row->num_rows > 0) {
            while ($data = $row->fetch_assoc()) {
                $i++;
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $data['seller_name']; ?></td>
                  <td><?php echo $data['seller_email']; ?></td>
                  <td><?php echo $data['seller_contact']; ?></td>
                  <td><?php echo $data['seller_address']; ?></td>
                  <td><?php echo $data['district_name']; ?></td>
                  <td><?php echo $data['place_name']; ?></td>
                  <td><img src="../Assets/Files/Seller/<?php echo $data['seller_photo']; ?>" class="img-thumbnail" width="80" /></td>
                  <td><img src="../Assets/Files/Seller/<?php echo $data['seller_proof']; ?>" class="img-thumbnail" width="80" /></td>
                  <td>
                    <a href="SellerVerification.php?aid=<?php echo $data['seller_id']; ?>" 
                       class="btn btn-accept" onclick="return confirm('Are you sure you want to accept this seller?')">
                       <i class="fa fa-check"></i>Accept</a>
                    <a href="SellerVerification.php?rid=<?php echo $data['seller_id']; ?>" 
                       class="btn btn-reject" onclick="return confirm('Are you sure you want to reject this seller?')">
                       <i class="fa fa-times"></i>Reject</a>
                  </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
              <td colspan="10" class="text-muted">No pending sellers.</td>
            </tr>
            <?php
        }
        ?>
      </table>
    </div>
  </div>

  <!-- Accepted Sellers -->
  <div class="card">
    <div class="card-header" style="background-color: #28a745; color: #fff;">
      <h5 class="mb-0"><i class="fas fa-check-circle"></i> Accepted Sellers</h5>
    </div>
    <div class="p-4">
      <table class="table table-bordered table-striped">
        <tr>
          <th>SI.NO</th>
          <th>Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Address</th>
          <th>District</th>
          <th>Place</th>
          <th>Logo</th>
        </tr>
        <?php
        $selQryAccepted = "SELECT * FROM tbl_seller s
                           INNER JOIN tbl_place p ON s.place_id=p.place_id 
                           INNER JOIN tbl_district d ON p.district_id=d.district_id 
                           WHERE s.seller_status=1 ORDER BY s.seller_id DESC";
        $j = 0;
        $rowAccepted = $Con->query($selQryAccepted);
        if ($rowAccepted->num_rows > 0) {
            while ($dataAccepted = $rowAccepted->fetch_assoc()) {
                $j++;
                ?>
                <tr>
                  <td><?php echo $j; ?></td>
                  <td><?php echo $dataAccepted['seller_name']; ?></td>
                  <td><?php echo $dataAccepted['seller_email']; ?></td>
                  <td><?php echo $dataAccepted['seller_contact']; ?></td>
                  <td><?php echo $dataAccepted['seller_address']; ?></td>
                  <td><?php echo $dataAccepted['district_name']; ?></td>
                  <td><?php echo $dataAccepted['place_name']; ?></td>
                  <td><img src="../Assets/Files/Seller/<?php echo $dataAccepted['seller_photo']; ?>" class="img-thumbnail" width="80" /></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
              <td colspan="8" class="text-muted">No accepted sellers.</td>
            </tr>
            <?php
        }
        ?>
      </table>
    </div>
  </div>

  <!-- Rejected Sellers -->
  <div class="card">
    <div class="card-header" style="background-color: #dc3545; color: #fff;">
      <h5 class="mb-0"><i class="fas fa-times-circle"></i> Rejected Sellers</h5>
    </div>
    <div class="p-4">
      <table class="table table-bordered table-striped">
        <tr>
          <th>SI.NO</th>
          <th>Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Address</th>
          <th>District</th>
          <th>Place</th>
          <th>Logo</th>
        </tr>
        <?php
        $selQryRejected = "SELECT * FROM tbl_seller s
                           INNER JOIN tbl_place p ON s.place_id=p.place_id 
                           INNER JOIN tbl_district d ON p.district_id=d.district_id 
                           WHERE s.seller_status=2 ORDER BY s.seller_id DESC";
        $k = 0;
        $rowRejected = $Con->query($selQryRejected);
        if ($rowRejected->num_rows > 0) {
            while ($dataRejected = $rowRejected->fetch_assoc()) {
                $k++;
                ?>
                <tr>
                  <td><?php echo $k; ?></td>
                  <td><?php echo $dataRejected['seller_name']; ?></td>
                  <td><?php echo $dataRejected['seller_email']; ?></td>
                  <td><?php echo $dataRejected['seller_contact']; ?></td>
                  <td><?php echo $dataRejected['seller_address']; ?></td>
                  <td><?php echo $dataRejected['district_name']; ?></td>
                  <td><?php echo $dataRejected['place_name']; ?></td>
                  <td><img src="../Assets/Files/Seller/<?php echo $dataRejected['seller_photo']; ?>" class="img-thumbnail" width="80" /></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
              <td colspan="8" class="text-muted">No rejected sellers.</td>
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