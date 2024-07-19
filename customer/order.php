<?php
include "header.php";

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Fetch the customer_id based on user_email
$query = "SELECT id FROM customers WHERE email = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, 's', $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$customer = mysqli_fetch_assoc($result);
$customer_id = $customer['id'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $product_id = mysqli_real_escape_string($link, $_POST['product_id']);
    $product_name = mysqli_real_escape_string($link, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($link, $_POST['product_price']);
    $customer_name = mysqli_real_escape_string($link, $_POST['customer_name']);
    $customer_contact = mysqli_real_escape_string($link, $_POST['customer_contact']);
    $customer_address = mysqli_real_escape_string($link, $_POST['customer_address']);
    $quantity = (int)$_POST['quantity'];
    $total_price = $product_price * $quantity;
    $status = 'Pending';
    $order_date = date('Y-m-d H:i:s');
    $product_image = mysqli_real_escape_string($link, $_POST['product_image']); // Get the product image

    // Insert order data into the database
    $query = "INSERT INTO orders (customer_id, product_id, product_name, customer_name, customer_contact, customer_address, quantity, total_price, status, order_date, product_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'iissssidsis', $customer_id, $product_id, $product_name, $customer_name, $customer_contact, $customer_address, $quantity, $total_price, $status, $order_date, $product_image);

    if (mysqli_stmt_execute($stmt)) {
        // Update the product quantity in the database
        $update_quantity_query = "UPDATE products SET product_quantity = product_quantity - ? WHERE product_id = ?";
        $update_stmt = mysqli_prepare($link, $update_quantity_query);
        mysqli_stmt_bind_param($update_stmt, 'ii', $quantity, $product_id);

        if (mysqli_stmt_execute($update_stmt)) {
            $order_success = true;
        } else {
            $order_error = "Error updating product quantity: " . mysqli_error($link);
        }
    } else {
        $order_error = "Error: " . mysqli_error($link);
    }
} else {
    // Get the product ID from the URL
    $product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($product_id <= 0) {
        echo "Invalid product ID.";
        exit();
    }

    // Fetch product details from the database
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo "Product not found.";
        exit();
    }

    $product = mysqli_fetch_assoc($result);
}
?>

<div class="container">
    <?php if (isset($order_success) && $order_success): ?>
        <div class="alert alert-success">Order placed successfully!</div>
    <?php elseif (isset($order_error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($order_error); ?></div>
    <?php else: ?>
        <br>
        <div class="row">
            <div class="col-md-6">
                <img src="../admin/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" style="width: 100%; height: auto;">
            </div>
            <div class="col-md-6">
                <h4>Description:</h4>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <h4>Price: PKR <?php echo htmlspecialchars($product['product_price']); ?></h4>
                <form action="order.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                    <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>">
                    <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['product_image']); ?>"> <!-- Include the product image -->
                    <div class="form-group">
                        <label for="customer_name">Your Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_contact">Contact Number</label>
                        <input type="text" class="form-control" id="customer_contact" name="customer_contact" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_address">Shipping Address</label>
                        <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="<?php echo htmlspecialchars($product['product_quantity']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirm Order</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include "footer.php"; ?>