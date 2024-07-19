<?php
include "header.php";

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Fetch the customer ID based on user_email
$query = "SELECT id FROM customers WHERE email = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, 's', $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$customer = mysqli_fetch_assoc($result);
$customer_id = $customer['id'];

$cart_id = isset($_GET['cart_id']) ? (int)$_GET['cart_id'] : 0;

if ($cart_id > 0) {
    // Remove item from cart
    $query = "DELETE FROM cart WHERE cart_id = ? AND customer_id = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $cart_id, $customer_id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: cart.php");
        exit();
    } else {
        echo "Error removing from cart: " . mysqli_error($link);
    }
} else {
    echo "Invalid cart ID.";
}

include "footer.php";
