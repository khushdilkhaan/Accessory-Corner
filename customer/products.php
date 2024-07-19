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

// Handle adding to cart
if (isset($_GET['add_to_cart'])) {
  $product_id = (int)$_GET['id'];
  $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
  $query = "SELECT * FROM products WHERE product_id = ?";
  $stmt = mysqli_prepare($link, $query);
  mysqli_stmt_bind_param($stmt, 'i', $product_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) > 0) {
      $product = mysqli_fetch_assoc($result);
      $product_name = mysqli_real_escape_string($link, $product['product_name']);
      $product_price = mysqli_real_escape_string($link, $product['product_price']);
      $product_image = mysqli_real_escape_string($link, $product['product_image']);
      $description = mysqli_real_escape_string($link, $product['description']);

      // Add product to the cart
      $query = "INSERT INTO cart (customer_id, product_id, quantity, product_image, product_name, product_price, description) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($link, $query);
      mysqli_stmt_bind_param($stmt, 'iiissss', $customer_id, $product_id, $quantity, $product_image, $product_name, $product_price, $description);

      if (!mysqli_stmt_execute($stmt)) {
          echo "Error adding to cart: " . mysqli_error($link);
      } else {
          header("Location: cart.php");
          exit();
      }
  } else {
      echo "Product not found.";
  }
}

?>

<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Product List</h4>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Product ID</th>
                      <th>Product Name</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Image</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Query to fetch products from the database
                    $query = "SELECT * FROM products";
                    $result = mysqli_query($link, $query);

                    // Check if the query was successful
                    if (!$result) {
                      echo "Error: " . mysqli_error($link);
                      exit();
                    }

                    // Fetch and display each product
                    while ($product = mysqli_fetch_assoc($result)) {
                      $product_id = htmlspecialchars($product['product_id']);
                      $product_name = htmlspecialchars($product['product_name']);
                      $description = htmlspecialchars($product['description']);
                      $product_quantity = htmlspecialchars($product['product_quantity']);
                      $product_price = htmlspecialchars($product['product_price']);
                      $product_image = htmlspecialchars($product['product_image']);
                      
                      echo "<tr>";
                      echo "<td>$product_id</td>";
                      echo "<td>$product_name</td>";
                      echo "<td>$description</td>";
                      echo "<td>";
                      echo "<form method='get' action='products.php' id='add-to-cart-form-$product_id'>";
                      echo "<input type='hidden' name='id' value='$product_id'>";
                      echo "<input type='hidden' name='add_to_cart' value='1'>";
                      echo "<div class='input-group'>";
                      echo "<button type='button' class='btn btn-secondary btn-sm' onclick='changeQuantity($product_id, -1)'>-</button>";
                      echo "<input type='number' id='quantity-input-$product_id' name='quantity' class='form-control' value='1' min='1' max='$product_quantity' style='width: 60px;'>";
                      echo "<button type='button' class='btn btn-secondary btn-sm' onclick='changeQuantity($product_id, 1)'>+</button>";
                      echo "</div>";
                      echo "</form>";
                      echo "</td>";
                      echo "<td>PKR $product_price</td>";
                      echo "<td><img src='../admin/product_images/$product_image' alt='Product Image' style='width: 50px; height: auto;'></td>";
                      echo "<td><a href='order.php?id=$product_id' class='btn btn-primary'>Order</a></td>";
                      echo "<td><a href='#' onclick='addToCart($product_id)' class='btn btn-secondary'>Add to Cart</a></td>";
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
<?php include "footer.php"; ?>

<script>
function changeQuantity(productId, change) {
  var input = document.getElementById('quantity-input-' + productId);
  var newValue = parseInt(input.value) + change;
  var maxValue = parseInt(input.max);
  
  // Ensure the new value is within the allowed range
  if (newValue >= 1 && newValue <= maxValue) {
    input.value = newValue;
  }
}

function addToCart(productId) {
  var quantity = document.getElementById('quantity-input-' + productId).value;
  
  // Redirect to the URL with the proper quantity
  window.location.href = 'products.php?add_to_cart=1&id=' + productId + '&quantity=' + quantity;
}
</script>
