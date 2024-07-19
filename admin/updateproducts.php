<?php
include "header.php";

// Check if product ID is provided and handle form submission for updating a product
if ((isset($_GET['productId']) && !empty($_GET['productId'])) || (isset($_POST['updateProduct']) && isset($_POST['productId']) && !empty($_POST['productId']))) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateProduct'])) {
        // Get the form data
        $productId = mysqli_real_escape_string($link, $_POST['productId']);
        $productName = mysqli_real_escape_string($link, $_POST['productName']);
        $productDescription = mysqli_real_escape_string($link, $_POST['productDescription']);
        $productQuantity = mysqli_real_escape_string($link, $_POST['productQuantity']);
        $productPrice = mysqli_real_escape_string($link, $_POST['productPrice']);
        $productImage = '';

        // Handle file upload if a new image is provided
        if (!empty($_FILES["productImage"]["name"])) {
            $targetDir = "product_images/";
            $productImage = basename($_FILES["productImage"]["name"]);
            $targetFilePath = $targetDir . $productImage;

            // Check if the directory exists, if not, create it
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Upload file to server
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFilePath)) {
                // Update product data with new image
                $updateQuery = "UPDATE products SET product_name='$productName', description='$productDescription', product_image='$productImage', product_quantity='$productQuantity', product_price='$productPrice' WHERE product_id='$productId'";
                if (mysqli_query($link, $updateQuery)) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Product updated successfully.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                    // Redirect to productcatalogue.php after successful update
                    header("Location: productcatalogue.php");
                    exit();
                } else {
                    echo "Error updating product: " . mysqli_error($link);
                }
            } else {
                echo "Error uploading file.";
                exit();
            }
        } else {
            // Update product data without changing the image
            $updateQuery = "UPDATE products SET product_name='$productName', description='$productDescription', product_quantity='$productQuantity', product_price='$productPrice' WHERE product_id='$productId'";
            if (mysqli_query($link, $updateQuery)) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Product updated successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
                // Redirect to productcatalogue.php after successful update
                header("Location: productcatalogue.php");
                exit();
            } else {
                echo "Error updating product: " . mysqli_error($link);
            }
        }
    } else {
        $productId = mysqli_real_escape_string($link, $_GET['productId']);
    }

    // Fetch product details
    $query = "SELECT * FROM products WHERE product_id = '$productId'";
    $result = mysqli_query($link, $query);
    $product = mysqli_fetch_assoc($result);
    if ($product) {
        // Display product details in a form for updating
        ?>
        <div class="container col-9">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-4">Update Product</h2>
                    <form class="forms-sample" method="post" action="updateproducts.php" enctype="multipart/form-data">
                        <input type="hidden" name="productId" value="<?php echo $product['product_id']; ?>">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="productDescription">Product Description</label>
                            <textarea class="form-control" id="productDescription" name="productDescription" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productQuantity">Quantity</label>
                            <input type="number" class="form-control" id="productQuantity" name="productQuantity" value="<?php echo htmlspecialchars($product['product_quantity']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Price</label>
                            <input type="number" step="0.01" class="form-control" id="productPrice" name="productPrice" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="productImage">Product Image</label>
                            <div>
                                <img src="product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Current Image" style="height: 200px; object-fit: cover;">
                            </div>
                            <input type="file" name="productImage" class="form-control mt-2">
                        </div>
                       <button type="submit" class="btn btn-primary mr-2" name="updateProduct">Update</button>
                        <a href="productcatalogue.php" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>No product selected for updating.</p>";
}

include "footer.php";
?>
