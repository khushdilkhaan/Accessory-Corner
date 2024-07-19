<?php include "header.php"; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h2>Customer Orders</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Customer Contact</th>
                            <th>Customer Address</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Product Image</th>
                            <th>Order Date</th>
                            <th>Order Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch orders from the database
                        $fetchOrdersQuery = "SELECT * FROM orders";
                        $result = mysqli_query($link, $fetchOrdersQuery);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($order = mysqli_fetch_assoc($result)) {
                                // Set the path for the product image
                                $imagePath = "../admin/product_images/" . $order['product_image'];
                        ?>
                                <tr>
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['customer_name']; ?></td>
                                    <td><?php echo $order['customer_contact']; ?></td>
                                    <td><?php echo $order['customer_address']; ?></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo $order['total_price']; ?></td>
                                    <td>
                                        <?php if (file_exists($imagePath)): ?>
                                            <img src="<?php echo $imagePath; ?>" alt="Product Image" class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                        <?php else: ?>
                                            <span>Image not found</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $order['order_date']; ?></td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td>
                                        <form method="post" class="status-form">
                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                            <button type="submit" name="approve" class="btn btn-success">Approve</button>
                                            <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="11">No orders found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// Handle accept or reject actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];

    if (isset($_POST['approve'])) {
        // Update order status to accepted
        $query = "UPDATE orders SET status = 'Accepted' WHERE order_id = '$order_id'";
    } elseif (isset($_POST['reject'])) {
        // Update order status to rejected
        $query = "UPDATE orders SET status = 'Rejected' WHERE order_id = '$order_id'";
    }

    if (mysqli_query($link, $query)) {
        // Redirect to avoid resubmission on refresh
        header("Location: customerorders.php");
        exit();
    } else {
        // Error handling
        echo "Error updating order status: " . mysqli_error($link);
    }
}
?>

<?php include "footer.php"; ?>
