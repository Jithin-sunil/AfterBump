<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$sel = "SELECT * FROM tbl_user WHERE user_id='" . $_SESSION['uid'] . "'";
$row = $Con->query($sel);
$data = $row->fetch_assoc();

if (isset($_POST['btn_submit'])) {
    $name = $_POST['txt_name'];
    $email = $_POST['txt_email'];
    $contact = $_POST['txt_contact'];
    $address = $_POST['txt_address'];

    $upQry = "UPDATE tbl_user SET user_name='$name', user_email='$email', user_contact='$contact', user_address='$address' WHERE user_id='" . $_SESSION['uid'] . "'";
    if ($Con->query($upQry)) {
        echo "<script>alert('Profile Updated Successfully'); window.location='MyProfile.php';</script>";
    } else {
        echo "<script>alert('Failed to update profile.');</script>";
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
                        <h3 class="panel-title text-center">Edit Profile</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="txt_name">Name</label>
                                <input type="text" class="form-control" name="txt_name" id="txt_name" value="<?php echo $data['user_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_email">Email</label>
                                <input type="email" class="form-control" name="txt_email" id="txt_email" value="<?php echo $data['user_email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_address">Address</label>
                                <input type="text" class="form-control" name="txt_address" id="txt_address" value="<?php echo $data['user_address']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_contact">Contact</label>
                                <input type="text" class="form-control" name="txt_contact" id="txt_contact" value="<?php echo $data['user_contact']; ?>" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="btn_submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("Foot.php"); ?>