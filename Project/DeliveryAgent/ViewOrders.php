<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

// Process Collect Order
if (isset($_GET['booking_id']) && isset($_GET['status'])) {
    $bid = $_GET['booking_id'];
    $newStatus = $_GET['status'];

    $updateQry = "UPDATE tbl_booking SET booking_status = '$newStatus' WHERE booking_id = '$bid'";
    $Con->query($updateQry);
    echo "<script>window.location='ViewBooking.php';</script>";
}
?>

<section>
    <div class="container">
        <h3 class="text-center" style="margin-bottom: 30px;">Received Orders</h3>

        <?php
        $selBookings = "SELECT * FROM tbl_booking b
                        INNER JOIN tbl_user u ON u.user_id = b.user_id
                        INNER JOIN tbl_place pl ON u.place_id = pl.place_id
                        WHERE pl.district_id = '" . $_SESSION['district'] . "' AND b.booking_status = 4
                        ORDER BY b.booking_id DESC";

        $bookingResult = $Con->query($selBookings);

        if ($bookingResult->num_rows > 0) {
            while ($bookingData = $bookingResult->fetch_assoc()) {
        ?>
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#f8f9fa;">
                    <h4>Booking ID: #<?php echo $bookingData['booking_id']; ?></h4>
                    <p>
                        <b>Customer:</b> <?php echo $bookingData['user_name']; ?><br>
                        <b>Email:</b> <?php echo $bookingData['user_email']; ?><br>
                        <b>Date:</b> <?php echo date('d-m-Y', strtotime($bookingData['booking_date'])); ?>
                    </p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Product Name</th>
                                    <th>Photo</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Item Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selCartItems = "SELECT * FROM tbl_cart c 
                                                 INNER JOIN tbl_product p ON p.product_id = c.product_id 
                                                 WHERE c.booking_id = '" . $bookingData['booking_id'] . "' 
                                                 AND p.seller_id = '" . $_SESSION['sid'] . "'";
                                $cartResult = $Con->query($selCartItems);
                                $i = 0;
                                $shopTotal = 0;
                                while ($cartData = $cartResult->fetch_assoc()) {
                                    $i++;
                                    $itemTotal = $cartData['product_price'] * $cartData['cart_qty'];
                                    $shopTotal += $itemTotal;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $cartData['product_name']; ?></td>
                                    <td><img src="../Assets/Files/Seller/<?php echo $cartData['product_photo']; ?>" width="60" height="60" /></td>
                                    <td>₹<?php echo $cartData['product_price']; ?></td>
                                    <td><?php echo $cartData['cart_qty']; ?></td>
                                    <td>₹<?php echo round($itemTotal, 2); ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr class="active">
                                    <td colspan="5" class="text-right"><strong>Your Subtotal:</strong></td>
                                    <td><strong>₹<?php echo round($shopTotal, 2); ?></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <strong>Order Status:</strong>
                                        <?php
                                        $status = $bookingData['booking_status'];
                                        if ($status == 4) {
                                            echo '<a href="ViewBooking.php?booking_id=' . $bookingData['booking_id'] . '&status=5" class="btn btn-success btn-sm">Collect Order</a>';
                                        } else {
                                            echo '<span class="text-muted">Collected</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
            echo '<div class="alert alert-info text-center">No received orders found.</div>';
        }
        ?>
    </div>
</section>

<?php include("Foot.php"); ?>
