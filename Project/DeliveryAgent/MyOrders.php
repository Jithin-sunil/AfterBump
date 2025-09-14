<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

if (isset($_GET['booking_id']) && isset($_GET['status'])) {
    $bid = $_GET['booking_id'];
    $newStatus = $_GET['status'];

    // Verify booking is assigned to the delivery agent
    $updateQry = "UPDATE tbl_booking 
                  SET booking_status = '$newStatus' 
                  WHERE booking_id = '$bid' AND delivery_id = '" . $_SESSION['did'] . "'";
    
    if ($Con->query($updateQry)) {
        ?>
        <script>
            alert("Status Updated Successfully");
            window.location = "MyOrders.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Status Update Failed");
            window.location = "MyOrders.php";
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
    <title>View Bookings</title>
</head>
<body>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Received Orders</h2>
                <?php
                $selBookings = "SELECT b.*, u.user_name, u.user_email 
                                FROM tbl_booking b 
                                INNER JOIN tbl_cart c ON c.booking_id = b.booking_id 
                                INNER JOIN tbl_product p ON p.product_id = c.product_id 
                                INNER JOIN tbl_user u ON u.user_id = b.user_id 
                                WHERE b.delivery_id = '" . $_SESSION['did'] . "' AND b.booking_status >= 4 
                                GROUP BY b.booking_id 
                                ORDER BY b.booking_date DESC";
                $bookingResult = $Con->query($selBookings);

                if ($bookingResult->num_rows > 0) {
                    while ($bookingData = $bookingResult->fetch_assoc()) {
                        ?>
                        <div class="panel panel-default" style="margin-bottom: 20px;">
                            <div class="panel-heading">
                                <h3 class="panel-title">Booking ID: #<?php echo $bookingData['booking_id']; ?></h3>
                            </div>
                            <div class="panel-body">
                                <p><strong>Customer:</strong> <?php echo $bookingData['user_name']; ?></p>
                                <p><strong>Email:</strong> <?php echo $bookingData['user_email']; ?></p>
                                <p><strong>Date:</strong> <?php echo date('d-m-Y', strtotime($bookingData['booking_date'])); ?></p>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Product Name</th>
                                            <th>Photo</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Item Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $selCartItems = "SELECT c.*, p.product_name, p.product_photo, p.product_price 
                                                         FROM tbl_cart c 
                                                         INNER JOIN tbl_product p ON p.product_id = c.product_id 
                                                         WHERE c.booking_id = '" . $bookingData['booking_id'] . "'";
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
                                                <td><img src="../Assets/Files/Seller/<?php echo $cartData['product_photo']; ?>" 
                                                         class="img-responsive" 
                                                         style="width: 60px; height: 60px;" 
                                                         alt="<?php echo $cartData['product_name']; ?>"></td>
                                                <td>₹<?php echo number_format($cartData['product_price'], 2); ?></td>
                                                <td><?php echo $cartData['cart_qty']; ?></td>
                                                <td>₹<?php echo number_format($itemTotal, 2); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
                                            <td><strong>₹<?php echo number_format($shopTotal, 2); ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><strong>Order Status:</strong> 
                                    <?php
                                    $status = $bookingData['booking_status'];
                                    $statusMap = [
                                        4 => ['label' => 'Order Shipped. Waiting For Delivery Agent To Collect', 'action' => 'Collect Order', 'next_status' => 5],
                                        5 => ['label' => 'Collected By Delivery Agent', 'action' => 'Out For Delivery', 'next_status' => 6],
                                        6 => ['label' => 'Out For Delivery', 'action' => 'Mark As Delivered', 'next_status' => 7],
                                        7 => ['label' => 'Order Completed']
                                    ];
                                    
                                    if (isset($statusMap[$status])) {
                                        echo $statusMap[$status]['label'];
                                        if (isset($statusMap[$status]['action'])) {
                                            ?>
                                            <br>
                                            <a href="MyOrders.php?booking_id=<?php echo $bookingData['booking_id']; ?>&status=<?php echo $statusMap[$status]['next_status']; ?>" 
                                               class="btn btn-success btn-sm"><?php echo $statusMap[$status]['action']; ?></a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </p>
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
</body>
</html>