<?php require "header.php" ?>
<?php

// Query to fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($link, $query);

// Check if the query was successful
if (!$result) {
    echo "Error: " . mysqli_error($link);
    exit();
}
?>

<!-- product section -->
<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Our <span>products</span>
            </h2>
        </div>
        <div class="row">
            <?php while ($product = mysqli_fetch_assoc($result)) { ?>
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="box">
                        <div class="option_container">
                            <div class="options">
                                <a href="product_details.php?id=<?php echo $product['product_id']; ?>" class="option1">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </a>
                                <a href="cart.php?action=add&id=<?php echo $product['product_id']; ?>" class="option2">
                                    Buy Now
                                </a>
                            </div>
                        </div>
                        <div class="img-box">
                            <img src="admin/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                <?php echo htmlspecialchars($product['product_name']); ?>
                            </h5>
                            <h6>
                                PKR <?php echo htmlspecialchars($product['product_price']); ?>
                            </h6>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="btn-box">
            <a href="products.php">
                View All products
            </a>
        </div>
    </div>
</section>
<!-- end product section -->

     
      <?php require "footer.php" ?>