<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

// Handle complaint submission
if (isset($_POST['btn_submit'])) {
    $title = $_POST['txt_title'];
    $content = $_POST['txt_content'];

    // Basic validation
    if ($title == "") {
        echo "<script>alert('Title is required.');</script>";
    } else if ($content == "") {
        echo "<script>alert('Content is required.');</script>";
    } else {
        // Insert complaint into tbl_complaint
        $insQry = "INSERT INTO tbl_complaint (complaint_title, complaint_content, complaint_date, user_id) 
                   VALUES ('$title', '$content', CURDATE(), '" . $_SESSION['uid'] . "')";
        if ($Con->query($insQry)) {
            echo "<script>alert('Complaint submitted successfully.'); window.location='Complaint.php';</script>";
        } else {
            echo "<script>alert('Failed to submit complaint.');</script>";
        }
    }
}
?>

<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <!-- Complaint Form -->
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Submit a Complaint</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="txt_title">Title</label>
                                <input type="text" name="txt_title" id="txt_title" class="form-control" placeholder="Enter Title" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_content">Content</label>
                                <textarea name="txt_content" id="txt_content" class="form-control" placeholder="Enter Complaint Content" rows="3" required></textarea>
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
            <!-- Complaint List Table -->
            <div class="col-md-10 col-md-offset-1 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title text-center">Your Complaints</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Date</th>
                                    <th>Reply</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch complaints for the logged-in user
                                $selComplaints = "SELECT * FROM tbl_complaint WHERE user_id='" . $_SESSION['uid'] . "'";
                                $result = $Con->query($selComplaints);
                                $slno = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $slno++;
                                    ?>
                                    <tr>
                                        <td><?php echo $slno; ?></td>
                                        <td><?php echo $row['complaint_title']; ?></td>
                                        <td><?php echo $row['complaint_content']; ?></td>
                                        <td><?php echo $row['complaint_date']; ?></td>
                                        <td><?php echo $row['complaint_reply'] ? $row['complaint_reply'] : 'No Reply'; ?></td>
                                        <td>
                                            <?php if ($row['complaint_status'] == 0) { ?>
                                                <a href="delete_complaint.php?id=<?php echo $row['complaint_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                            <?php } else { ?>
                                                <span>Replied</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if ($slno == 0) {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No Complaints Found</td>
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