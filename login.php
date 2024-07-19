<?php
include_once "connection.php";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $role = $_POST["role"];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM customers WHERE email = ? AND password = ? AND role = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "sss", $email, $pass, $role);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        if ($role == "admin") {
            $_SESSION["da_admin_email"] = $email;
            header("location: admin/index.php");
            exit();
        } elseif ($role == "customer") {
            $_SESSION["user_email"] = $email;
            header("Location: customer/index.php");
            exit();
        }
    } else {
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Danger!</strong> EMAIL OR PASSWORD INCORRECT.
            </div>';
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="login-box">
    <h2>Login</h2>
    <form method="post">
        <div class="user-box">
            <input type="text" name="email" required>
            <label>Email</label>
        </div>
        <div class="user-box">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>
        <div class="user-box">
            <label for="role">Role:</label>
            <br><br>
            <select name="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="customer">Customer</option>
            </select>
        </div>
        <br>
        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
        
    </form>
    <br>
    <p>Dont have account signup <a href="signup.php"><b>Sign Up</b></a></p>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
