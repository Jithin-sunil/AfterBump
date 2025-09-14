<?php
include("Head.php");
include("../Assets/Connection/Connection.php");
?>

<!-- Page Content -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Available Products</h2>
                <div class="row">
                    <?php
                    $i = 0;
                    $SelQry = "SELECT * FROM tbl_product p 
                               INNER JOIN tbl_brand b ON p.brand_id = b.brand_id 
                               INNER JOIN tbl_category c ON c.category_id = p.category_id";
                    $res = $Con->query($SelQry);
                    if ($res->num_rows > 0) {
                        while ($data = $res->fetch_assoc()) {
                            $i++;

                            // Stock check
                            $selstock = "SELECT SUM(stock_qty) AS stock FROM tbl_stock WHERE product_id='" . $data["product_id"] . "'";
                            $selstock1 = "SELECT SUM(cart_qty) AS cart_qty FROM tbl_cart WHERE product_id='" . $data["product_id"] . "' AND cart_status > 0";
                            $stockRes = $Con->query($selstock)->fetch_assoc();
                            $cartRes = $Con->query($selstock1)->fetch_assoc();

                            $totalStock = $stockRes['stock'] ?? 0;
                            $totalCart = $cartRes['cart_qty'] ?? 0;
                            $remaining = $totalStock - $totalCart;

                            // Rating
                            $average_rating = 0;
                            $total_review = 0;
                            $query = "SELECT AVG(rating_data) AS avg_rate, COUNT(rating_id) AS count_rate 
                                      FROM tbl_rating WHERE product_id = '" . $data["product_id"] . "'";
                            $result = $Con->query($query)->fetch_assoc();
                            if ($result['count_rate'] > 0) {
                                $average_rating = $result['avg_rate'];
                                $total_review = $result['count_rate'];
                            }
                            ?>
                            <div class="col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <img src="../Assets/Files/Seller/<?php echo $data['product_photo']; ?>" class="img-responsive center-block" style="height: 150px; width: auto;" alt="<?php echo $data['product_name']; ?>">
                                        <h4 class="text-center"><?php echo $data['product_name']; ?></h4>
                                        <p class="text-center"><strong>Price:</strong> ₹<?php echo $data['product_price']; ?></p>
                                        <p class="text-center"><strong>Category:</strong> <?php echo $data['category_name']; ?></p>
                                        <p class="text-center"><strong>Brand:</strong> <?php echo $data['brand_name']; ?></p>
                                        <p class="text-center">
                                            <strong>Rating:</strong>
                                            <?php
                                            $full_stars = floor($average_rating);
                                            $decimal_part = $average_rating - $full_stars;
                                            for ($s = 1; $s <= 5; $s++) {
                                                if ($s <= $full_stars) {
                                                    echo '★';
                                                } else if ($s == $full_stars + 1 && $decimal_part >= 0.25) {
                                                    echo '½';
                                                } else {
                                                    echo '☆';
                                                }
                                            }
                                            ?>
                                            <small>(<?php echo number_format($average_rating, 1) . " (" . $total_review . " reviews)"; ?>)</small>
                                        </p>
                                        <div class="text-center">
                                            <?php if ($remaining > 0) { ?>
                                                <button class="btn btn-primary btn-sm" onclick="AddtoCart(<?php echo $data['product_id']; ?>)">
                                                    Add to Cart
                                                </button>
                                            <?php } else { ?>
                                                <span class="label label-danger">Out of Stock</span>
                                            <?php } ?>
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
                                    No products found.
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
function AddtoCart(pid) {
    $.ajax({
        url: "../Assets/AjaxPages/AjaxAddCart.php?pid=" + pid,
        success: function(result) {
            alert(result);
        }
    });
}
</script>

<?php include("Foot.php"); ?>