<?php
include "header.php";

// Handle form submission for adding a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addProduct'])) {
    // Get the form data
    $productName = mysqli_real_escape_string($link, $_POST['productName']);
    $productDescription = mysqli_real_escape_string($link, $_POST['productDescription']);
    $productQuantity = mysqli_real_escape_string($link, $_POST['productQuantity']);
    $productPrice = mysqli_real_escape_string($link, $_POST['productPrice']);
    
    // Handle file upload
    $targetDir = "product_images/";
    $productImage = basename($_FILES["productImage"]["name"]);
    $targetFilePath = $targetDir . $productImage;

    if (!empty($productImage)) {
        // Check if the directory exists, if not, create it
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Upload file to server
        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFilePath)) {
            // Insert product data into the database
            $insertQuery = "INSERT INTO products (product_name, description, product_image, product_quantity, product_price) VALUES ('$productName', '$productDescription', '$productImage', '$productQuantity', '$productPrice')";
            if (mysqli_query($link, $insertQuery)) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Congrats !</strong> Product added successfuly.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            } else {
                echo "Error: " . mysqli_error($link);
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Please select an image to upload.";
    }
}
?>

<div class="col-8 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add New Product</h4>
            <p class="card-description">
                Fill in the details below to add a new product.
            </p>
            <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" class="form-control" id="productName" name="productName" placeholder="Product Name" required>
                </div>
                <div class="form-group">
                    <label for="productDescription">Product Description</label>
                    <textarea class="form-control" id="productDescription" name="productDescription" rows="4" placeholder="Product Description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="productQuantity">Quantity</label>
                    <input type="number" class="form-control" id="productQuantity" name="productQuantity" placeholder="Quantity" required>
                </div>
                <div class="form-group">
                    <label for="productPrice">Price</label>
                    <input type="number" step="0.01" class="form-control" id="productPrice" name="productPrice" placeholder="Price" required>
                </div>
                <div class="form-group">
                    <label>Product Image</label>
                    <input type="file" name="productImage" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mr-2" name="addProduct">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
