<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$sel = "SELECT * FROM tbl_seller WHERE seller_id='" . $_SESSION['sid'] . "'";
$row = $Con->query($sel);
$data = $row->fetch_assoc();
$dbpwd = $data['seller_password'];

if (isset($_POST['btn_submit'])) {
    $opwd = $_POST['txt_oldpwd'];
    $npwd = $_POST['txt_newpwd'];
    $rpwd = $_POST['txt_repwd'];
    
    if ($opwd == $dbpwd) {
        if ($npwd == $rpwd) {
            $upQry = "UPDATE tbl_seller SET seller_password='$npwd' WHERE seller_id='" . $_SESSION['sid'] . "'";
            if ($Con->query($upQry)) {
                ?>
                <script>
                    alert("Password Updated Successfully");
                    window.location = "MyProfile.php";
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                alert("New Password and Re-typed Password Do Not Match");
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("Old Password is Incorrect");
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
<section>
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Change Password</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="txt_oldpwd">Old Password</label>
                                <input type="password" name="txt_oldpwd" id="txt_oldpwd" class="form-control" 
                                       placeholder="Enter Old Password" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_newpwd">New Password</label>
                                <input type="password" name="txt_newpwd" id="txt_newpwd" class="form-control" 
                                       placeholder="Enter New Password" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_repwd">Re-enter New Password</label>
                                <input type="password" name="txt_repwd" id="txt_repwd" class="form-control" 
                                       placeholder="Re-enter New Password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="btn_submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include("Foot.php"); ?>
</body>
</html>