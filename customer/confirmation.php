<?php
include "header.php";

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Fetch the customer_id based on user_email
$query = "SELECT id FROM customers WHERE email = '$user_email'";
$result = mysqli_query($link, $query);
$customer = mysqli_fetch_assoc($result);
$customer_id = $customer['id'];

// Query to fetch orders for the logged-in user
$query = "SELECT * FROM orders WHERE customer_id = '$customer_id'";
$result = mysqli_query($link, $query);

// Check if the query was successful
if (!$result) {
    echo "Error: " . mysqli_error($link);
    exit();
}
?>

<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Your Orders</h4>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Total Price</th>
                      <th>Status</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Fetch and display each order
                    while ($order = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td>" . htmlspecialchars($order['order_id']) . "</td>";
                      echo "<td>" . htmlspecialchars($order['product_name']) . "</td>";
                      echo "<td>" . htmlspecialchars($order['quantity']) . "</td>";
                      echo "<td>PKR " . htmlspecialchars($order['total_price']) . "</td>";
                      echo "<td>" . htmlspecialchars($order['status']) . "</td>";
                      echo "<td>" . htmlspecialchars($order['order_date']) . "</td>";
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
                <?php if (mysqli_num_rows($result) == 0): ?>
                    <p>No orders found.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
<?php include "footer.php"; ?>
