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

// Fetch cart items for the logged-in customer by joining cart and products table
$query = "
    SELECT 
        cart.cart_id, 
        products.product_id, 
        products.product_image, 
        products.product_name, 
        products.description, 
        products.product_price, 
        cart.quantity 
    FROM cart 
    JOIN products ON cart.product_id = products.product_id 
    WHERE cart.customer_id = ?
";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, 'i', $customer_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Shopping Cart</h4>
              <?php if (mysqli_num_rows($result) > 0): ?>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Product Image</th>
                      <th>Product Name</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $total_price = 0;
                    while ($item = mysqli_fetch_assoc($result)) {
                        $item_total = $item['product_price'] * $item['quantity'];
                        $total_price += $item_total;
                        echo "<tr>";
                        echo "<td><img src='../admin/product_images/" . htmlspecialchars($item['product_image']) . "' alt='Product Image' style='width: 50px; height: auto;'></td>";
                        echo "<td>" . htmlspecialchars($item['product_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['description']) . "</td>";
                        echo "<td>PKR " . htmlspecialchars($item['product_price']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
                        echo "<td>PKR " . htmlspecialchars($item_total) . "</td>";
                        echo "<td>
                        <a href='remove_from_cart.php?cart_id=" . htmlspecialchars($item['cart_id']) . "' class='btn btn-danger'>Remove</a>
                                <a href='order.php?id=" . htmlspecialchars($item['product_id']) . "' class='btn btn-primary'>Checkout</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <h4>Total Price: PKR <?php echo $total_price; ?></h4>
              <?php else: ?>
              <p>Your cart is empty.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
<?php include "footer.php"; ?>
