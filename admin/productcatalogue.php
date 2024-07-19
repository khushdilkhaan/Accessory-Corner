<?php
include "header.php";

// Handle form submission for deleting a product
if (isset($_GET['deleteProduct'])) {
    $productId = mysqli_real_escape_string($link, $_GET['productId']);

    // Delete the product from the database
    $deleteQuery = "DELETE FROM products WHERE product_id = '$productId'";
    if (mysqli_query($link, $deleteQuery)) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Product deleted successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Could not delete the product. ' . mysqli_error($link) . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
}

// Fetch all products
$query = "SELECT * FROM products";
$result = mysqli_query($link, $query);
?>

<div class="container col-9">
    <div class="row">
        <div class="col-12">
            <h2 class="my-4">Product Catalogue</h2>
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <div class="row">
                    <?php while ($product = mysqli_fetch_assoc($result)) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="product_images/<?php echo $product['product_image']; ?>" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                    <p class="card-text">Quantity: <?php echo htmlspecialchars($product['product_quantity']); ?></p>
                                    <p class="card-text">Price: <?php echo htmlspecialchars($product['product_price']); ?></p>
                                    <a href="updateproducts.php?productId=<?php echo $product['product_id']; ?>" class="btn btn-primary mr-2">Update</a>
                                    <a href="productcatalogue.php?deleteProduct=true&productId=<?php echo $product['product_id']; ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p>No products found.</p>
            <?php } ?>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
