<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$sel = "SELECT *
        FROM tbl_delivery dd 
        INNER JOIN tbl_place p ON dd.place_id = p.place_id 
        INNER JOIN tbl_district d ON p.district_id = d.district_id 
        WHERE dd.delivery_id='" . $_SESSION['did'] . "'";
$row = $Con->query($sel);
if ($row->num_rows > 0) {
    $data = $row->fetch_assoc();
} else {
    ?>
    <script>
        alert("Delivery agent profile not found");
        window.location = "../Guest/Login.php";
    </script>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
</head>
<body>
<section>
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">My Profile</h3>
                    </div>
                    <div class="panel-body">
                        <p class="text-center"><strong>Name:</strong> <?php echo $data['delivery_name']; ?></p>
                        <p class="text-center"><strong>Email:</strong> <?php echo $data['delivery_email']; ?></p>
                        <p class="text-center"><strong>Contact:</strong> <?php echo $data['delivery_contact']; ?></p>
                        <p class="text-center"><strong>Address:</strong> <?php echo $data['delivery_address']; ?></p>
                        <p class="text-center"><strong>District:</strong> <?php echo $data['district_name']; ?></p>
                        <p class="text-center"><strong>Place:</strong> <?php echo $data['place_name']; ?></p>
                        <div class="text-center">
                            <a href="EditProfile.php" class="btn btn-primary btn-sm">Edit Profile</a>
                            <a href="ChangePassword.php" class="btn btn-primary btn-sm">Change Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include("Foot.php"); ?>
</body>
</html>