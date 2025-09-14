<?php
include("Head.php");
include("../Assets/Connection/Connection.php");
?>

<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">My Bookings</h2>
                <?php
                $selBookings = "SELECT * FROM tbl_booking WHERE user_id = '" . $_SESSION['uid'] . "' AND booking_status > 0 ORDER BY booking_id DESC";
                $bookingResult = $Con->query($selBookings);

                if ($bookingResult->num_rows > 0) {
                    while ($bookingData = $bookingResult->fetch_assoc()) {
                ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Booking ID: #<?php echo $bookingData['booking_id']; ?> | Date: <?php echo $bookingData['booking_date']; ?>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SlNo</th>
                                        <th>Product</th>
                                        <th>Photo</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Item Total</th>
                                        <th>Seller</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $selCartItems = "SELECT * FROM tbl_cart c 
                                                    INNER JOIN tbl_product p ON p.product_id = c.product_id 
                                                    INNER JOIN tbl_seller s ON s.seller_id = p.seller_id 
                                                    WHERE c.booking_id = '" . $bookingData['booking_id'] . "'";
                                    $cartResult = $Con->query($selCartItems);
                                    $i = 0;
                                    while ($cartData = $cartResult->fetch_assoc()) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $cartData['product_name']; ?></td>
                                            <td><img src="../Assets/Files/Seller/<?php echo $cartData['product_photo']; ?>" width="60" height="60" /></td>
                                            <td><?php echo $cartData['product_price']; ?> ₹</td>
                                            <td><?php echo $cartData['cart_qty']; ?></td>
                                            <td><?php echo $cartData['product_price'] * $cartData['cart_qty']; ?> ₹</td>
                                            <td><?php echo $cartData['seller_name'] . "<br>" . $cartData['seller_email']; ?></td>
                                            <td>
                                                <?php
                                                if ($bookingData['booking_status'] == 7) {
                                                    echo '<a href="Rating.php?pid=' . $cartData['product_id'] . '" class="btn btn-primary btn-sm">Rate Product</a>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="7" class="text-right"><strong>Grand Total:</strong></td>
                                        <td><?php echo $bookingData['booking_amount']; ?> ₹</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">
                                            <strong>Order Status:</strong>
                                            <?php
                                            if ($bookingData['booking_status'] == 1) {
                                                echo "Payment Pending";
                                            } else if ($bookingData['booking_status'] == 2) {
                                                echo "Payment Completed";
                                            } else if ($bookingData['booking_status'] == 3) {
                                                echo "Product Packed";
                                            } else if ($bookingData['booking_status'] == 4) {
                                                echo "Product Shipped";
                                            } else if ($bookingData['booking_status'] == 5) {
                                                echo "Collected by Delivery Agent";
                                            } else if ($bookingData['booking_status'] == 6) {
                                                echo "Out For Delivery";
                                            } else if ($bookingData['booking_status'] == 7) {
                                                echo "Order Completed";
                                            } else {
                                                echo "Unknown Status";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            No bookings found.
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php include("Foot.php"); ?>