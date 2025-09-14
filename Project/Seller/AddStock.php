<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

if (isset($_POST["btnsave"])) {
    $quantity = $_POST["txtqty"];
    $productId = $_GET["pid"];
    // Verify product belongs to the seller
    $selProduct = "SELECT seller_id FROM tbl_product WHERE product_id='$productId' AND seller_id='" . $_SESSION['sid'] . "'";
    $resProduct = $Con->query($selProduct);
    if ($resProduct->num_rows > 0) {
        $insQry = "INSERT INTO tbl_stock(stock_date, stock_qty, product_id) VALUES (CURDATE(), '$quantity', '$productId')";
        if ($Con->query($insQry)) {
            ?>
            <script>
                alert('Stock Added Successfully');
                window.location = 'AddStock.php?pid=<?php echo $productId; ?>';
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert('Unauthorized product');
            window.location = 'AddProduct.php';
        </script>
        <?php
    }
}

if (isset($_GET["did"])) {
    $id = $_GET["did"];
    $productId = $_GET["pid"];
    // Verify stock entry belongs to the seller's product
    $delQry = "DELETE FROM tbl_stock s 
               INNER JOIN tbl_product p ON s.product_id = p.product_id 
               WHERE s.stock_id='$id' AND p.seller_id='" . $_SESSION['sid'] . "'";
    if ($Con->query($delQry)) {
        ?>
        <script>
            alert('Stock Entry Deleted');
            window.location = 'AddStock.php?pid=<?php echo $productId; ?>';
        </script>
        <?php
    }
}

$productId = $_GET["pid"];

// Verify product belongs to the seller before displaying
$selProduct = "SELECT seller_id FROM tbl_product WHERE product_id='$productId' AND seller_id='" . $_SESSION['sid'] . "'";
$resProduct = $Con->query($selProduct);
if ($resProduct->num_rows == 0) {
    ?>
    <script>
        alert('Unauthorized product');
        window.location = 'AddProduct.php';
    </script>
    <?php
    exit;
}

$selTotalStock = "SELECT SUM(stock_qty) AS total_stock FROM tbl_stock WHERE product_id='$productId'";
$resTotalStock = $Con->query($selTotalStock);
$dataTotalStock = $resTotalStock->fetch_assoc();
$totalStockAdded = $dataTotalStock['total_stock'] ? $dataTotalStock['total_stock'] : 0;

$selTotalSold = "SELECT SUM(cart_qty) AS total_sold FROM tbl_cart WHERE product_id='$productId' AND cart_status > 0";
$resTotalSold = $Con->query($selTotalSold);
$dataTotalSold = $resTotalSold->fetch_assoc();
$totalStockSold = $dataTotalSold['total_sold'] ? $dataTotalSold['total_sold'] : 0;

$remainingStock = $totalStockAdded - $totalStockSold;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Stock</title>
</head>
<body>
<section>
    <div class="container">
        <!-- Add Stock Form -->
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Add Stock</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="txtqty">Quantity</label>
                                <input type="number" name="txtqty" id="txtqty" class="form-control" placeholder="Enter Quantity" required autocomplete="off">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="btnsave" class="btn btn-primary btn-block">Add Stock</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stock Summary -->
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Stock Summary</h3>
                    </div>
                    <div class="panel-body">
                        <p class="text-center"><strong>Total Stock Added:</strong> <?php echo $totalStockAdded; ?></p>
                        <p class="text-center"><strong>Total Stock Sold:</strong> <?php echo $totalStockSold; ?></p>
                        <p class="text-center"><strong>Remaining Stock:</strong> <?php echo $remainingStock; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stock History -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Stock History</h3>
                <div class="row">
                    <?php
                    $i = 0;
                    $selQry = "SELECT * FROM tbl_stock WHERE product_id='$productId' ORDER BY stock_date DESC";
                    $res = $Con->query($selQry);
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            $i++;
                            ?>
                            <div class="col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <p class="text-center"><strong>Entry #<?php echo $i; ?></strong></p>
                                        <p class="text-center"><strong>Date:</strong> <?php echo date('d-m-Y', strtotime($row['stock_date'])); ?></p>
                                        <p class="text-center"><strong>Quantity:</strong> <?php echo $row['stock_qty']; ?></p>
                                        <div class="text-center">
                                            <a href="AddStock.php?did=<?php echo $row['stock_id']; ?>&pid=<?php echo $productId; ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Are you sure you want to delete this stock entry?');">Delete</a>
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
                                    No stock history found.
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
<?php include("Foot.php"); ?>
</body>
</html>