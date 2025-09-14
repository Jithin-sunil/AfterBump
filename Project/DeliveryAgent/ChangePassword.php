<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$sel = "SELECT * FROM tbl_delivery WHERE delivery_id='" . $_SESSION['did'] . "'";
$row = $Con->query($sel);
if ($row->num_rows > 0) {
    $data = $row->fetch_assoc();
    $dbpwd = $data['delivery_password'];
} else {
    ?>
    <script>
        alert("Delivery agent profile not found");
        window.location = "../Guest/Login.php";
    </script>
    <?php
    exit;
}

if (isset($_POST['btn_submit'])) {
    $opwd = $_POST['txt_oldpwd'];
    $npwd = $_POST['txt_newpwd'];
    $rpwd = $_POST['txt_repwd'];

    if ($opwd == $dbpwd) {
        if ($npwd == $rpwd) {
            $upQry = "UPDATE tbl_delivery SET delivery_password='$npwd' WHERE delivery_id='" . $_SESSION['did'] . "'";
            if ($Con->query($upQry)) {
                ?>
                <script>
                    alert("Password Updated Successfully");
                    window.location = "MyProfile.php";
                </script>
                <?php
            } else {
                ?>
                <script>
                    alert("Password Update Failed");
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
                    <div class="panel-heading bg-success text-white">
                        <h3 class="panel-title text-center">Change Password</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="txt_oldpwd">Old Password</label>
                                <input type="password" class="form-control" id="txt_oldpwd" name="txt_oldpwd" 
                                       placeholder="Enter Old Password" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_newpwd">New Password</label>
                                <input type="password" class="form-control" id="txt_newpwd" name="txt_newpwd" 
                                       placeholder="Enter New Password" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_repwd">Re-enter New Password</label>
                                <input type="password" class="form-control" id="txt_repwd" name="txt_repwd" 
                                       placeholder="Re-enter New Password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="btn_submit" class="btn btn-success btn-block">Update</button>
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