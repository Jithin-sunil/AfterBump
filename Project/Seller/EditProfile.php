<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$sel = "SELECT s.*, p.place_id, p.place_name, d.district_id, d.district_name 
        FROM tbl_seller s 
        INNER JOIN tbl_place p ON s.place_id = p.place_id 
        INNER JOIN tbl_district d ON p.district_id = d.district_id 
        WHERE s.seller_id='" . $_SESSION['sid'] . "'";
$row = $Con->query($sel);
$data = $row->fetch_assoc();

if (isset($_POST['btn_submit'])) {
    $name = $_POST['txt_name'];
    $email = $_POST['txt_email'];
    $contact = $_POST['txt_contact'];
    $address = $_POST['txt_address'];
    $place_id = $_POST['txt_place'];
    
    $upQry = "UPDATE tbl_seller 
              SET seller_name='$name', seller_email='$email', seller_contact='$contact', 
                  seller_address='$address', place_id='$place_id' 
              WHERE seller_id='" . $_SESSION['sid'] . "'";
    if ($Con->query($upQry)) {
        ?>
        <script>
            alert("Profile Updated Successfully");
            window.location = "MyProfile.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Profile Update Failed");
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
    <title>My Profile</title>
</head>
<body>
<section>
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Edit Profile</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="txt_name">Name</label>
                                <input type="text" name="txt_name" id="txt_name" class="form-control" 
                                       value="<?php echo $data['seller_name']; ?>" 
                                       placeholder="Enter Name" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_email">Email</label>
                                <input type="email" name="txt_email" id="txt_email" class="form-control" 
                                       value="<?php echo $data['seller_email']; ?>" 
                                       placeholder="Enter Email" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_contact">Contact</label>
                                <input type="text" name="txt_contact" id="txt_contact" class="form-control" 
                                       value="<?php echo $data['seller_contact']; ?>" 
                                       placeholder="Enter Contact" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_address">Address</label>
                                <input type="text" name="txt_address" id="txt_address" class="form-control" 
                                       value="<?php echo $data['seller_address']; ?>" 
                                       placeholder="Enter Address" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_district">District</label>
                                <select name="txt_district" id="txt_district" class="form-control" 
                                        onchange="loadPlaces(this.value)">
                                    <option value="">Select District</option>
                                    <?php
                                    $selDistrict = "SELECT * FROM tbl_district";
                                    $resDistrict = $Con->query($selDistrict);
                                    while ($dataDistrict = $resDistrict->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $dataDistrict['district_id']; ?>" 
                                                <?php if ($data['district_id'] == $dataDistrict['district_id']) echo 'selected'; ?>>
                                            <?php echo $dataDistrict['district_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txt_place">Place</label>
                                <select name="txt_place" id="txt_place" class="form-control" required>
                                    <option value="">Select Place</option>
                                    <?php
                                    $selPlace = "SELECT * FROM tbl_place WHERE district_id='" . $data['district_id'] . "'";
                                    $resPlace = $Con->query($selPlace);
                                    while ($dataPlace = $resPlace->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $dataPlace['place_id']; ?>" 
                                                <?php if ($data['place_id'] == $dataPlace['place_id']) echo 'selected'; ?>>
                                            <?php echo $dataPlace['place_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
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

<script src="../Assets/JQ/jQuery.js"></script>
<script>
function loadPlaces(district_id) {
    $.ajax({
        url: "../Assets/AjaxPages/AjaxPlace.php?did=" + district_id,
        success: function(data) {
            $("#txt_place").html('<option value="">Select Place</option>' + data);
        }
    });
}
</script>

<?php include("Foot.php"); ?>
</body>
</html>