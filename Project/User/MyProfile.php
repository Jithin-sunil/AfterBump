<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$sel = "SELECT * FROM tbl_user u 
        INNER JOIN tbl_place p ON p.place_id=u.place_id 
        INNER JOIN tbl_district d ON d.district_id=p.district_id 
        WHERE user_id='" . $_SESSION['uid'] . "'";
$row = $Con->query($sel);
$data = $row->fetch_assoc();
?>

<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">My Profile</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4"><strong>Name:</strong></div>
                            <div class="col-md-8"><?php echo $data['user_name']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Email:</strong></div>
                            <div class="col-md-8"><?php echo $data['user_email']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Address:</strong></div>
                            <div class="col-md-8"><?php echo $data['user_address']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Contact:</strong></div>
                            <div class="col-md-8"><?php echo $data['user_contact']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>District:</strong></div>
                            <div class="col-md-8"><?php echo $data['district_name']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Place:</strong></div>
                            <div class="col-md-8"><?php echo $data['place_name']; ?></div>
                        </div>
                    </div>
                    <div class="panel-footer text-center">
                        <a href="EditProfile.php" class="btn btn-primary btn-sm">Edit Profile</a>
                        <a href="ChangePassword.php" class="btn btn-default btn-sm">Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("Foot.php"); ?>