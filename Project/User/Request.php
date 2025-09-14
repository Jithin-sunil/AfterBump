<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

if (isset($_POST['btn_submit'])) {
    $content = $_POST['txt_content'];
    $insQry = "INSERT INTO tbl_request(request_content, request_date, user_id, servicepost_id)
               VALUES('" . $content . "', CURDATE(), '" . $_SESSION["uid"] . "', '" . $_GET['spid'] . "')";
    if ($Con->query($insQry)) {
        ?>
        <script>
            alert("Request Sent.");
            window.location = "MyRequest.php";
        </script>
        <?php
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
                        <h3 class="panel-title text-center">Send Your Request</h3>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="txt_content">Request Content</label>
                                <textarea name="txt_content" id="txt_content" class="form-control" rows="5" placeholder="Write your request here..." required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="btn_submit" class="btn btn-primary btn-block">Send Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("Foot.php"); ?>