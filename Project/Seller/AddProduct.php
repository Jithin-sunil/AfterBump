<?php
include("Head.php");
include("../Assets/Connection/Connection.php");

if (isset($_POST['btn_submit'])) {
    $name = $_POST['txt_name'];
    $details = $_POST['txt_details'];
    $photo = $_FILES['file_photo']['name'];
    $path = $_FILES['file_photo']['tmp_name'];
    move_uploaded_file($path, "../Assets/Files/Seller/" . $photo);
    $brand = $_POST['txt_brand'];
    $category = $_POST['txt_category'];
    $price = $_POST['txt_price'];
    
    $insQry = "INSERT INTO tbl_product(product_name, product_details, product_photo, brand_id, category_id, product_price, seller_id)
               VALUES('$name', '$details', '$photo', '$brand', '$category', '$price', '" . $_SESSION['sid'] . "')";
    if ($Con->query($insQry)) {
        ?>
        <script>
            alert("Inserted");
            window.location = "AddProduct.php";
        </script>
        <?php
    }
}

if (isset($_GET['did'])) {
    $delQry = "DELETE FROM tbl_product WHERE product_id='" . $_GET['did'] . "' AND seller_id='" . $_SESSION['sid'] . "'";
    if ($Con->query($delQry)) {
        ?>
        <script>
            alert("Deleted");
            window.location = "AddProduct.php";
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
    <title>Add Product</title>
</head>
<body>
<section>
    <div class="container">
        <!-- Add Product Form -->
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Add New Product</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="txt_name">Name</label>
                                <input type="text" name="txt_name" id="txt_name" class="form-control" placeholder="Enter Name" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_details">Details</label>
                                <input type="text" name="txt_details" id="txt_details" class="form-control" placeholder="Enter Details" required>
                            </div>
                            <div class="form-group">
                                <label for="file_photo">Photo</label>
                                <input type="file" name="file_photo" id="file_photo" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="txt_brand">Brand</label>
                                <select name="txt_brand" id="txt_brand" class="form-control">
                                    <option value="">Select Brand</option>
                                    <?php
                                    $selQry = "SELECT * FROM tbl_brand";
                                    $res = $Con->query($selQry);
                                    while ($data = $res->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $data['brand_id']; ?>"><?php echo $data['brand_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txt_category">Category</label>
                                <select name="txt_category" id="txt_category" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php
                                    $selQry = "SELECT * FROM tbl_category";
                                    $res = $Con->query($selQry);
                                    while ($data = $res->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $data['category_id']; ?>"><?php echo $data['category_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txt_price">Price</label>
                                <input type="text" name="txt_price" id="txt_price" class="form-control" placeholder="Enter Price" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="btn_submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product List -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">My Products</h3>
                <div class="row">
                    <?php
                    $i = 0;
                    $selQry = "SELECT * FROM tbl_product p 
                               INNER JOIN tbl_brand b ON b.brand_id = p.brand_id 
                               INNER JOIN tbl_category c ON c.category_id = p.category_id 
                               INNER JOIN tbl_seller s ON s.seller_id = p.seller_id 
                               WHERE s.seller_id = '" . $_SESSION['sid'] . "'";
                    $res = $Con->query($selQry);
                    if ($res->num_rows > 0) {
                        while ($data = $res->fetch_assoc()) {
                            $i++;
                            ?>
                            <div class="col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <img src="../Assets/Files/Seller/<?php echo $data['product_photo']; ?>" 
                                             class="img-responsive center-block" 
                                             style="height: 150px; width: auto;" 
                                             alt="<?php echo $data['product_name']; ?>">
                                        <h4 class="text-center"><?php echo $data['product_name']; ?></h4>
                                        <p class="text-center"><strong>Details:</strong> <?php echo $data['product_details']; ?></p>
                                        <p class="text-center"><strong>Brand:</strong> <?php echo $data['brand_name']; ?></p>
                                        <p class="text-center"><strong>Category:</strong> <?php echo $data['category_name']; ?></p>
                                        <p class="text-center"><strong>Price:</strong> ₹<?php echo $data['product_price']; ?></p>
                                        <div class="text-center">
                                            <a href="AddProduct.php?did=<?php echo $data['product_id']; ?>" 
                                               class="btn btn-danger btn-sm">Delete</a>
                                            <a href="AddStock.php?pid=<?php echo $data['product_id']; ?>" 
                                               class="btn btn-primary btn-sm">Add Stock</a>
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
<?php include("Foot.php"); ?>
</body>
</html>