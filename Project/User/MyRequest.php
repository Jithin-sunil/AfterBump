<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$user_id = $_SESSION['uid'];
?>

<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">My Service Requests</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered" cellpadding="10">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Service Name</th>
                                    <th>Posted By</th>
                                    <th>Service Details</th>
                                    <th>Request Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch all requests made by the logged-in user
                                $selQry = "SELECT r.*, sp.*, u.user_name, u.user_email, u.user_contact, pl.place_name, di.district_name
                                           FROM tbl_request r
                                           INNER JOIN tbl_servicepost sp ON r.servicepost_id = sp.servicepost_id
                                           INNER JOIN tbl_user u ON sp.user_id = u.user_id
                                           INNER JOIN tbl_place pl ON u.place_id = pl.place_id
                                           INNER JOIN tbl_district di ON pl.district_id = di.district_id
                                           WHERE r.user_id = '$user_id'
                                           ORDER BY r.request_date DESC";

                                $result = $Con->query($selQry);
                                if ($result->num_rows > 0) {
                                    $i = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        $i++;
                                        if ($row['request_status'] == 0) {
                                            $status = 'Pending';
                                            $badge_class = 'label-warning';
                                        } elseif ($row['request_status'] == 1) {
                                            $status = 'Accepted';
                                            $badge_class = 'label-success';
                                        } else {
                                            $status = 'Rejected';
                                            $badge_class = 'label-danger';
                                        }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['servicetype_name'] ?? ''; ?></td>
                                    <td>
                                        <?php echo $row['user_name']; ?><br>
                                        <small><?php echo $row['user_email']; ?></small><br>
                                        <small><?php echo $row['user_contact']; ?></small><br>
                                        <small><?php echo $row['place_name'] . ", " . $row['district_name']; ?></small>
                                    </td>
                                    <td>
                                        <strong>Content:</strong> <?php echo $row['servicepost_content']; ?><br>
                                        <strong>Duration:</strong> <?php echo $row['servicepost_duration']; ?><br>
                                        <strong>Amount:</strong> ₹<?php echo $row['servicepost_amount']; ?><br>
                                        <strong>Date:</strong> <?php echo date('d-m-Y', strtotime($row['servicepost_date'])); ?>
                                    </td>
                                    <td><?php echo date('d-m-Y', strtotime($row['request_date'])); ?></td>
                                    <td><span class="label <?php echo $badge_class; ?>"><?php echo $status; ?></span></td>
                                </tr>
                                <?php
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center">No requests found.</td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("Foot.php"); ?>
