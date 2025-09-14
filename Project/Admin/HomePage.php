<?php
include('Head.php');
include('../Assets/Connection/Connection.php');

// Fetch counts
$userCount     = $Con->query("SELECT COUNT(*) as c FROM tbl_user")->fetch_assoc()['c'];
$sellerCount   = $Con->query("SELECT COUNT(*) as c FROM tbl_seller")->fetch_assoc()['c'];
$bookingCount  = $Con->query("SELECT COUNT(*) as c FROM tbl_booking")->fetch_assoc()['c'];
$totalAmount   = $Con->query("SELECT IFNULL(SUM(CAST(booking_amount AS DECIMAL(10,2))),0) as amt 
                              FROM tbl_booking 
                              WHERE booking_status>1")->fetch_assoc()['amt'];
?>

<div class="row">
  <!-- Users -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-primary text-white rounded-circle p-3 me-3">
          <i class="ti ti-users fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Users</h6>
          <h4 class="fw-bold mb-0"><?php echo $userCount; ?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Sellers -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-success text-white rounded-circle p-3 me-3">
          <i class="ti ti-briefcase fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Sellers</h6>
          <h4 class="fw-bold mb-0"><?php echo $sellerCount; ?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Bookings -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-warning text-white rounded-circle p-3 me-3">
          <i class="ti ti-book fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Bookings</h6>
          <h4 class="fw-bold mb-0"><?php echo $bookingCount; ?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Transactions -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-danger text-white rounded-circle p-3 me-3">
          <i class="ti ti-currency-rupee fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Transactions</h6>
          <h4 class="fw-bold mb-0">₹<?php echo number_format($totalAmount, 2); ?></h4>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Recent Products (Adapted from tbl_product) -->
<div class="col-lg-12">
  <div class="card w-100">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Recent Products</h5>
      <div class="row">
        <?php
        $products = $Con->query("SELECT pr.*, br.brand_name, ca.category_name 
                                 FROM tbl_product pr 
                                 LEFT JOIN tbl_brand br ON pr.brand_id=br.brand_id 
                                 LEFT JOIN tbl_category ca ON pr.category_id=ca.category_id 
                                 ORDER BY pr.product_id DESC LIMIT 4");
        while($row = $products->fetch_assoc()) {
        ?>
        <div class="col-sm-6 col-xl-3">
          <div class="card overflow-hidden rounded-2">
            <div class="position-relative">
              <img src="../Assets/Files/Seller/<?php echo $row['product_photo']; ?>" 
                   class="card-img-top rounded-0" 
                   alt="<?php echo $row['product_name']; ?>"
                   style="height: 200px; object-fit: cover;">
            </div>
            <div class="card-body pt-3 p-4">
              <h6 class="fw-semibold fs-4"><?php echo $row['product_name']; ?></h6>
              <p class="mb-1">Brand: <?php echo $row['brand_name']; ?></p>
              <p class="mb-1">Category: <?php echo $row['category_name']; ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold fs-4 mb-0">₹<?php echo $row['product_price']; ?></h6>
                <span class="badge bg-primary">
                  In Stock
                </span>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Recent Bookings -->
  <div class="col-lg-6">
    <div class="card w-100">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Recent Bookings</h5>
        <div class="table-responsive">
          <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $qry = $Con->query("SELECT bk.*, u.user_name 
                                  FROM tbl_booking bk 
                                  LEFT JOIN tbl_user u ON bk.user_id=u.user_id 
                                  ORDER BY bk.booking_id DESC LIMIT 5");
              while($r = $qry->fetch_assoc()) {
                $status = ($r['booking_status'] == 6) ? 'Completed' : 'Pending';
                $status_color = ($status == 'Completed') ? 'success' : 'warning';
              ?>
              <tr>
                <td><?php echo $r['booking_id']; ?></td>
                <td><?php echo ($r['user_name'] != '') ? $r['user_name'] : 'N/A'; ?></td>
                <td>₹<?php echo $r['booking_amount']; ?></td>
                <td>
                  <span class="badge bg-<?php echo $status_color; ?>">
                    <?php echo $status; ?>
                  </span>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Latest Complaints -->
  <div class="col-lg-6">
    <div class="card w-100">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Latest Complaints</h5>
        <div class="table-responsive">
          <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Title</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $complaints = $Con->query("SELECT c.*, u.user_name 
                                         FROM tbl_complaint c 
                                         LEFT JOIN tbl_user u ON c.user_id=u.user_id 
                                         ORDER BY c.complaint_id DESC LIMIT 5");
              if ($complaints->num_rows > 0) {
                while($c = $complaints->fetch_assoc()) {
                  $status = ($c['complaint_status'] == 1) ? 'Replied' : 'Pending';
                  $status_color = ($status == 'Replied') ? 'success' : 'warning';
                ?>
                <tr>
                  <td><?php echo $c['complaint_id']; ?></td>
                  <td><?php echo ($c['user_name'] != '') ? $c['user_name'] : 'N/A'; ?></td>
                  <td><?php echo $c['complaint_title']; ?></td>
                  <td>
                    <span class="badge bg-<?php echo $status_color; ?>">
                      <?php echo $status; ?>
                    </span>
                  </td>
                </tr>
                <?php 
                }
              } else {
                echo "<tr><td colspan='4' class='text-muted'>No complaints found.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include('Foot.php');
?>