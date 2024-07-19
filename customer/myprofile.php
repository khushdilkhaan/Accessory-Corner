<?php
include "header.php";

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Fetch the customer data based on user_email
$query = "SELECT * FROM customers WHERE email = '$user_email'";
$result = mysqli_query($link, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Customer not found.";
    exit();
}

$customer = mysqli_fetch_assoc($result);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_name = mysqli_real_escape_string($link, $_POST['customer_name']);
    $customer_contact = mysqli_real_escape_string($link, $_POST['customer_contact']);
    $customer_address = mysqli_real_escape_string($link, $_POST['customer_address']);
    $customer_id = $customer['id'];
    
    // Handle profile image upload
    $profile_image = $customer['profile_image']; // existing profile image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_name = basename($_FILES['profile_image']['name']);
        $image_dir = '../profile_images/';
        $image_path = $image_dir . $image_name;

        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $profile_image = $image_name;
        } else {
            echo "Error uploading image.";
            exit();
        }
    }

    // Update customer data in the database
    $query = "UPDATE customers SET username = '$customer_name', contact = '$customer_contact', address = '$customer_address', profile_image = '$profile_image' WHERE id = '$customer_id'";

    if (mysqli_query($link, $query)) {
        $update_success = true;
        // Refresh customer data
        $result = mysqli_query($link, "SELECT * FROM customers WHERE email = '$user_email'");
        $customer = mysqli_fetch_assoc($result);
    } else {
        $update_error = "Error updating profile: " . mysqli_error($link);
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
              <h4 class="card-title">My Profile</h4>
              <?php if (isset($update_success) && $update_success): ?>
                  <div class="alert alert-success">Profile updated successfully!</div>
              <?php elseif (isset($update_error)): ?>
                  <div class="alert alert-danger"><?php echo htmlspecialchars($update_error); ?></div>
              <?php endif; ?>
              <form action="myprofile.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="customer_name">Name</label>
                  <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($customer['username']); ?>" required>
                </div>
                <div class="form-group">
                  <label for="customer_contact">Contact Number</label>
                  <input type="text" class="form-control" id="customer_contact" name="customer_contact" value="<?php echo htmlspecialchars($customer['contact']); ?>" required>
                </div>
                <div class="form-group">
                  <label for="customer_address">Address</label>
                  <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required><?php echo htmlspecialchars($customer['address']); ?></textarea>
                </div>
                <div class="form-group">
                  <label for="profile_image">Profile Image</label>
                  <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                  <?php if ($customer['profile_image']): ?>
                      <img src="../profile_images/<?php echo htmlspecialchars($customer['profile_image']); ?>" alt="Profile Image" style="width: 100px; height: auto; margin-top: 10px;">
                  <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
<?php include "footer.php"; ?>
