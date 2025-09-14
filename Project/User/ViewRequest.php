<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$user_id = $_SESSION['uid'];

// Process Accept/Reject if parameters exist
if (isset($_GET['rid']) && isset($_GET['action'])) {
    $request_id = $_GET['rid'];
    $action = $_GET['action'];

    if ($action == 'accept') {
        $status = 1;
    } elseif ($action == 'reject') {
        $status = 2;
    } else {
        $status = 0;
    }

    $updQry = "UPDATE tbl_request SET request_status='$status' WHERE request_id='$request_id'";
    $Con->query($updQry);
    echo "<script>alert('Request updated successfully'); window.location='ViewRequestPoster.php';</script>";
    exit;
}
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Requests for My Service Posts</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered" cellpadding="10">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Service Post</th>
                                    <th>Post Details</th>
                                    <th>Requested By</th>
                                    <th>User Details</th>
                                    <th>Request Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selQry = "SELECT r.*, sp.*, u.user_name, u.user_email, u.user_contact, u.user_address, pl.place_name, di.district_name
                                           FROM tbl_request r
                                           INNER JOIN tbl_servicepost sp ON r.servicepost_id = sp.servicepost_id
                                           INNER JOIN tbl_user u ON r.user_id = u.user_id
                                           INNER JOIN tbl_place pl ON u.place_id = pl.place_id
                                           INNER JOIN tbl_district di ON pl.district_id = di.district_id
                                           WHERE sp.user_id = '$user_id'
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
                                        <strong>Content:</strong> <?php echo $row['servicepost_content']; ?><br>
                                        <strong>Duration:</strong> <?php echo $row['servicepost_duration']; ?><br>
                                        <strong>Amount:</strong> ₹<?php echo $row['servicepost_amount']; ?><br>
                                        <strong>Date:</strong> <?php echo date('d-m-Y', strtotime($row['servicepost_date'])); ?>
                                    </td>
                                    <td><?php echo $row['user_name']; ?></td>
                                    <td>
                                        <strong>Email:</strong> <?php echo $row['user_email']; ?><br>
                                        <strong>Contact:</strong> <?php echo $row['user_contact']; ?><br>
                                        <strong>Address:</strong> <?php echo $row['user_address']; ?><br>
                                        <strong>Location:</strong> <?php echo $row['place_name'] . ", " . $row['district_name']; ?>
                                    </td>
                                    <td><?php echo date('d-m-Y', strtotime($row['request_date'])); ?></td>
                                    <td><span class="label <?php echo $badge_class; ?>"><?php echo $status; ?></span></td>
                                    <td>
                                        <?php if ($row['request_status'] == 0) { ?>
                                            <a href="?rid=<?php echo $row['request_id']; ?>&action=accept" class="btn btn-success btn-sm">Accept</a>
                                            <a href="?rid=<?php echo $row['request_id']; ?>&action=reject" class="btn btn-danger btn-sm">Reject</a>
                                        <?php } else { ?>
                                            <span class="text-muted">Action Done</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center">No requests found.</td>
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
