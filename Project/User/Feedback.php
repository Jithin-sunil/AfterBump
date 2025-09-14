<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

if (isset($_POST['btn_submit'])) {
    $content = $_POST['txt_content'];

    if ($content == "") {
        echo "<script>alert('Feedback content is required.');</script>";
    } else {
        $insQry = "INSERT INTO tbl_feedback (feedback_content, user_id) 
                   VALUES ('$content', '" . $_SESSION['uid'] . "')";
        if ($Con->query($insQry)) {
            echo "<script>alert('Feedback submitted successfully.'); window.location='Feedback.php';</script>";
        } else {
            echo "<script>alert('Failed to submit feedback.');</script>";
        }
    }
}

if (isset($_GET['delete_id'])) {
    $feedback_id = $_GET['delete_id'];
    $delQry = "DELETE FROM tbl_feedback WHERE feedback_id='$feedback_id' AND user_id='" . $_SESSION['uid'] . "'";
    if ($Con->query($delQry)) {
        echo "<script>alert('Feedback deleted successfully.'); window.location='Feedback.php';</script>";
    } else {
        echo "<script>alert('Failed to delete feedback.');</script>";
    }
}
?>

<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <!-- Feedback Form -->
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Submit Feedback</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="txt_content">Your Feedback</label>
                                <textarea class="form-control" name="txt_content" id="txt_content" placeholder="Enter your feedback..." rows="3" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="btn_submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Feedback List -->
            <div class="col-md-10 col-md-offset-1 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title text-center">Previous Feedback</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Content</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selFeedback = "SELECT * FROM tbl_feedback WHERE user_id='" . $_SESSION['uid'] . "'";
                                $result = $Con->query($selFeedback);
                                $slno = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $slno++;
                                    ?>
                                    <tr>
                                        <td><?php echo $slno; ?></td>
                                        <td><?php echo $row['feedback_content']; ?></td>
                                        <td class="text-center">
                                            <a href="Feedback.php?delete_id=<?php echo $row['feedback_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if ($slno == 0) {
                                    ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No Feedback Found</td>
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