<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$sel = "SELECT * FROM tbl_user WHERE user_id='" . $_SESSION['uid'] . "'";
$row = $Con->query($sel);
$data = $row->fetch_assoc();
$dbpwd = $data['user_password'];

if (isset($_POST['btn_submit'])) {
    $opwd = $_POST['txt_oldpwd'];
    $npwd = $_POST['txt_newpwd'];
    $rpwd = $_POST['txt_repwd'];

    if ($opwd == "") {
        echo "<script>alert('Old Password is required.');</script>";
    } else if ($npwd == "") {
        echo "<script>alert('New Password is required.');</script>";
    } else if ($rpwd == "") {
        echo "<script>alert('Re-type Password is required.');</script>";
    } else if ($npwd != $rpwd) {
        echo "<script>alert('New Password and Re-type Password do not match.');</script>";
    } else if (strlen($npwd) < 8) {
        echo "<script>alert('New Password must be at least 8 characters long.');</script>";
    } else if ($opwd == $dbpwd) {
        $upQry = "UPDATE tbl_user SET user_password='$npwd' WHERE user_id='" . $_SESSION['uid'] . "'";
        if ($Con->query($upQry)) {
            echo "<script>alert('Password Updated Successfully'); window.location='MyProfile.php';</script>";
        } else {
            echo "<script>alert('Failed to update password.');</script>";
        }
    } else {
        echo "<script>alert('Old Password is incorrect.');</script>";
    }
}
?>

<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Change Password</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="txt_oldpwd">Old Password</label>
                                <input type="password" name="txt_oldpwd" id="txt_oldpwd" class="form-control" placeholder="Enter Old Password" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_newpwd">New Password</label>
                                <input type="password" name="txt_newpwd" id="txt_newpwd" class="form-control" placeholder="Enter New Password" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_repwd">Re-type Password</label>
                                <input type="password" name="txt_repwd" id="txt_repwd" class="form-control" placeholder="Re-enter New Password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="btn_submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("Foot.php"); ?>