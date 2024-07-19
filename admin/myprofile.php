<?php
include "header.php";

// Check if the admin is logged in
if (!isset($_SESSION["da_admin_email"])) {
    // Redirect to the login page if the admin is not logged in
    header("location: login.php");
    exit();
}

// Fetch admin data from the database based on the logged-in admin's email
$adminEmail = $_SESSION["da_admin_email"];

// Query to fetch admin data from the customers table based on email and role
$query = "SELECT * FROM customers WHERE email = '$adminEmail' AND role = 'admin'";
$result = mysqli_query($link, $query);

// Check if the query was successful
if (!$result) {
    // Handle the error if the query fails
    echo "Error: " . mysqli_error($link);
    exit();
}

// Fetch the admin data as an associative array
$adminData = mysqli_fetch_assoc($result);

// Retrieve current profile image path
$currentProfileImage = $adminData['profile_image'];

// Handle form submission for updating profile
if (isset($_POST["updateProfile"])) {
    // Extract data from the form
    $adminName = mysqli_real_escape_string($link, $_POST["adminName"]);
    $adminEmail = mysqli_real_escape_string($link, $_POST["adminEmail"]);
    $address = mysqli_real_escape_string($link, $_POST["address"]);
    $contact = mysqli_real_escape_string($link, $_POST["contact"]);

    // Check if a new profile image is uploaded
    if ($_FILES["profileImage"]["name"]) {
        // Handle profile image upload
        $targetDir = "../profile_images/";
        $profileImage = basename($_FILES["profileImage"]["name"]);
        $targetPath = $targetDir . $profileImage;

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetPath)) {
            // Update admin data including the profile image path
            $updateQuery = "UPDATE customers SET 
                            username = '$adminName', 
                            email = '$adminEmail',
                            address = '$address', 
                            contact = '$contact', 
                            profile_image = '$profileImage' 
                            WHERE email = '$adminEmail' AND role = 'admin'";

            $updateResult = mysqli_query($link, $updateQuery);

            if ($updateResult) {
                // Update current profile image path
                $currentProfileImage = $profileImage;
                // Redirect to the profile page after successful update
                header("location: myprofile.php");
                exit();
            } else {
                // Handle the error if the update query fails
                echo "Error updating profile: " . mysqli_error($link);
                exit();
            }
        } else {
            // Handle the error if the file move operation fails
            echo "Error uploading profile image.";
            exit();
        }
    } else {
        // Update admin data excluding the profile image
        $updateQuery = "UPDATE customers SET 
                        username = '$adminName', 
                        email = '$adminEmail',
                        address = '$address', 
                        contact = '$contact'
                        WHERE email = '$adminEmail' AND role = 'admin'";

        $updateResult = mysqli_query($link, $updateQuery);

        if ($updateResult) {
            // Redirect to the profile page after successful update
            header("location: myprofile.php");
            exit();
        } else {
            // Handle the error if the update query fails
            echo "Error updating profile: " . mysqli_error($link);
            exit();
        }
    }
}

// Close the database connection
mysqli_close($link);
?>

<div class="col-8 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Update Profile</h4>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="adminName">Username</label>
                    <input type="text" class="form-control" id="adminName" name="adminName" value="<?php echo $adminData['username']; ?>" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="adminEmail">Email</label>
                    <input type="email" class="form-control" id="adminEmail" name="adminEmail" value="<?php echo $adminData['email']; ?>" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $adminData['address']; ?>" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <label for="contact">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $adminData['contact']; ?>" placeholder="Contact" required>
                </div>
                <!-- Display current profile image -->
                <?php if (!empty($currentProfileImage)) { ?>
                    <div class="form-group">
                        <label for="currentProfileImage">Current Profile Image</label><br>
                        <img src="../profile_images/<?php echo $currentProfileImage; ?>" alt="Profile Image" style="max-width: 200px;">
                    </div>
                <?php } ?>

                <!-- Input field for updating profile image -->
                <div class="form-group">
                    <label for="profileImage">Upload New Profile Image</label>
                    <input type="file" class="form-control-file" id="profileImage" name="profileImage">
                </div>
                <div class="form-group">
                    <label for="adminPassword">Password</label>
                    <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="updateProfile">Update Profile</button>
                <a href="myprofile.php" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
