<?php
include "header.php";

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id > 0) {
    // Check if the product exists
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $product_name = mysqli_real_escape_string($link, $product['product_name']);
        $product_price = mysqli_real_escape_string($link, $product['product_price']);
        $product_image = mysqli_real_escape_string($link, $product['product_image']);
        $description = mysqli_real_escape_string($link, $product['description']);

        // Add product to the cart
        $query = "INSERT INTO cart (customer_id, product_id, quantity, product_image, product_name, product_price, description) 
                  VALUES ('$customer_id', '$product_id', 1, '$product_image', '$product_name', '$product_price', '$description')";
        if (mysqli_query($link, $query)) {
            header("Location: cart.php");
            exit();
        } else {
            echo "Error adding to cart: " . mysqli_error($link);
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid product ID.";
}

include "footer.php";
?>
