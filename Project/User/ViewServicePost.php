<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

$district_id = isset($_GET['district_id']) ? $_GET['district_id'] : '';
$place_id = isset($_GET['place_id']) ? $_GET['place_id'] : '';
?>

<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Available Service Posts</h2>
                <!-- Location Filter -->
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form method="get">
                                    <div class="form-group">
                                        <label for="district_id">District</label>
                                        <select name="district_id" id="district_id" class="form-control" onchange="loadPlaces(this.value)">
                                            <option value="">Select District</option>
                                            <?php
                                            $selDistrict = "SELECT * FROM tbl_district";
                                            $resDistrict = $Con->query($selDistrict);
                                            while ($dataDistrict = $resDistrict->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo $dataDistrict['district_id']; ?>" <?php if ($district_id == $dataDistrict['district_id']) echo 'selected'; ?>>
                                                    <?php echo $dataDistrict['district_name']; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="place_id">Place</label>
                                        <select name="place_id" id="place_id" class="form-control">
                                            <option value="">Select Place</option>
                                            <?php
                                            if ($district_id != '') {
                                                $selPlace = "SELECT * FROM tbl_place WHERE district_id='$district_id'";
                                                $resPlace = $Con->query($selPlace);
                                                while ($dataPlace = $resPlace->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?php echo $dataPlace['place_id']; ?>" <?php if ($place_id == $dataPlace['place_id']) echo 'selected'; ?>>
                                                        <?php echo $dataPlace['place_name']; ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="ViewServicePost.php" class="btn btn-default">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Service Posts -->
                <div class="row">
                    <?php
                    $i = 0;
                    $sel = "SELECT * FROM tbl_servicepost p 
                            INNER JOIN tbl_servicetype d ON p.servicetype_id = d.servicetype_id 
                            INNER JOIN tbl_user u ON p.user_id = u.user_id 
                            INNER JOIN tbl_place pl ON u.place_id = pl.place_id 
                            INNER JOIN tbl_district di ON pl.district_id = di.district_id 
                            WHERE p.user_id != '" . $_SESSION['uid'] . "'";
                    if ($place_id != '') {
                        $sel .= " AND u.place_id = '$place_id'";
                    } elseif ($district_id != '') {
                        $sel .= " AND pl.district_id = '$district_id'";
                    }
                    $res = $Con->query($sel);
                    if ($res->num_rows > 0) {
                        while ($data = $res->fetch_assoc()) {
                            $i++;
                            ?>
                            <div class="col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h4 class="text-center"><?php echo $data['servicetype_name']; ?></h4>
                                        <p class="text-center"><strong>Content:</strong> <?php echo $data['servicepost_content']; ?></p>
                                        <p class="text-center"><strong>Posted By:</strong> <?php echo $data['user_name']; ?></p>
                                        <p class="text-center"><strong>Location:</strong> <?php echo $data['place_name'] . ", " . $data['district_name']; ?></p>
                                        <p class="text-center"><strong>Date:</strong> <?php echo date('d-m-Y', strtotime($data['servicepost_date'])); ?></p>
                                        <p class="text-center"><strong>Duration:</strong> <?php echo $data['servicepost_duration']; ?></p>
                                        <p class="text-center"><strong>Amount:</strong> ₹<?php echo $data['servicepost_amount']; ?></p>
                                        <div class="text-center">
                                            <a href="Request.php?spid=<?php echo $data['servicepost_id']; ?>" 
                                               class="btn btn-primary btn-sm">Request</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    No service posts found.
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../Assets/JQ/jQuery.js"></script>
<script>
function loadPlaces(district_id) {
    $.ajax({
        url: "../Assets/AjaxPages/AjaxPlace.php?district_id=" + district_id,
        success: function(data) {
            $("#place_id").html('<option value="">Select Place</option>' + data);
        }
    });
}
</script>

<?php include("Foot.php"); ?>