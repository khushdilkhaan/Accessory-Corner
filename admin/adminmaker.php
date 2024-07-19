<?php
include "header.php";

// Fetch all users from the database
$query = "SELECT * FROM customers";
$result = mysqli_query($link, $query);

// Handle role change
if (isset($_POST['changeRole'])) {
    $userId = mysqli_real_escape_string($link, $_POST['userId']);
    $currentRole = mysqli_real_escape_string($link, $_POST['currentRole']);
    $newRole = $currentRole == 'admin' ? 'customer' : 'admin';

    $updateQuery = "UPDATE customers SET role = '$newRole' WHERE id = '$userId'";
    if (mysqli_query($link, $updateQuery)) {
        header("Location: adminmaker.php");
        exit();
    } else {
        echo "Error updating role: " . mysqli_error($link);
    }
}
?>

<div class="container mt-4 col-9">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <h2 class="mb-4">Manage User Roles</h2>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['username']; ?></h5>
                            <p class="card-text"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                            <p class="card-text"><strong>Role:</strong> <?php echo ucfirst($row['role']); ?></p>
                            <form method="post" action="adminmaker.php">
                                <input type="hidden" name="userId" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="currentRole" value="<?php echo $row['role']; ?>">
                                <button type="submit" name="changeRole" class="btn btn-primary">
                                    <?php echo $row['role'] == 'admin' ? 'Demote to Customer' : 'Promote to Admin'; ?>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No users found.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
