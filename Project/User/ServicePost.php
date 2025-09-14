<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

if (isset($_POST['btn_submit'])) {
    $type = $_POST['sel_type'];
    $content = $_POST['txt_content'];
    $duration = $_POST['txt_duration'];
    $amount = $_POST['txt_amount'];
    
    $insQry = "INSERT INTO tbl_servicepost(servicepost_content, servicepost_date, servicepost_duration, servicepost_amount, user_id, servicetype_id)
               VALUES('$content', CURDATE(), '$duration', '$amount', '" . $_SESSION["uid"] . "', '$type')";
    if ($Con->query($insQry)) {
        ?>
        <script>
            alert("Service Posted");
            window.location = "ServicePost.php";
        </script>
        <?php
    }
}

if (isset($_GET['did'])) {
    $delQry = "DELETE FROM tbl_servicepost WHERE servicepost_id='" . $_GET['did'] . "' AND user_id='" . $_SESSION['uid'] . "'";
    if ($Con->query($delQry)) {
        ?>
        <script>
            alert("Service Post Deleted");
            window.location = "ServicePost.php";
        </script>
        <?php
    }
}
?>

<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <!-- Service Post Form -->
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Post a Service</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="sel_type">Service Type</label>
                                <select name="sel_type" id="sel_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <?php
                                    $selQry = "SELECT * FROM tbl_servicetype";
                                    $res = $Con->query($selQry);
                                    while ($data = $res->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $data['servicetype_id']; ?>">
                                            <?php echo $data['servicetype_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txt_content">Content</label>
                                <textarea name="txt_content" id="txt_content" class="form-control" rows="3" placeholder="Enter service details..."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="txt_duration">Duration</label>
                                <input type="text" name="txt_duration" id="txt_duration" class="form-control" placeholder="Enter duration..." />
                            </div>
                            <div class="form-group">
                                <label for="txt_amount">Amount (Ready to Pay)</label>
                                <input type="text" name="txt_amount" id="txt_amount" class="form-control" placeholder="Enter amount..." />
                            </div>
                            <div class="text-center">
                                <button type="submit" name="btn_submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Service Posts List -->
            <div class="col-md-10 col-md-offset-1 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title text-center">My Service Posts</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Type</th>
                                    <th>Content</th>
                                    <th>Date</th>
                                    <th>Duration</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $sel = "SELECT * FROM tbl_servicepost p 
                                        INNER JOIN tbl_servicetype d ON p.servicetype_id = d.servicetype_id 
                                        WHERE p.user_id='" . $_SESSION['uid'] . "'";
                                $res = $Con->query($sel);
                                if ($res->num_rows > 0) {
                                    while ($data = $res->fetch_assoc()) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $data['servicetype_name']; ?></td>
                                            <td><?php echo $data['servicepost_content']; ?></td>
                                            <td><?php echo $data['servicepost_date']; ?></td>
                                            <td><?php echo $data['servicepost_duration']; ?></td>
                                            <td><?php echo $data['servicepost_amount']; ?></td>
                                            <td>
                                                <a href="ServicePost.php?did=<?php echo $data['servicepost_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No service posts found.</td>
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