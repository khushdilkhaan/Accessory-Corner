<?php include_once "connection.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .signup-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .role-container {
            display: flex;
            align-items: center;
        }

        .role-label {
            margin-right: 10px;
        }

        .lock-icon {
            font-size: 20px;
            color: #6c757d;
        }

        /* Custom styles for form */
        #signupForm {
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #555555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 12px 0;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #ff0000;
            font-size: 14px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .signup-container {
                margin: 20px auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="signup-container">
            <h2>Sign Up</h2>
            <form id="signupForm" method="post" enctype="multipart/form-data" action="signup.php">
            <?php

// Initialize variables to store alert information
$alertClass = "";
$alertMessage = "";

if (isset($_POST["Register"])) {
    $name = $_POST["username"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $role = $_POST["role"];
    $image = $_FILES["img"]["name"];
    $profile_image = "profile_images/" . $image;

    // Insert customer data into the database
    $insert_query = "INSERT INTO customers (username, contact, address, email, password, role, profile_image) 
                     VALUES ('$name', '$contact', '$address', '$email', '$pass', '$role', '$profile_image')";

    if (mysqli_query($link, $insert_query)) {
        // Move uploaded image to desired directory
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $profile_image)) {
            $alertClass = "alert-success";
            $alertMessage = "Registration successful! You can now login.";
        } else {
            $alertClass = "alert-danger";
            $alertMessage = "Error uploading profile image.";
        }
    } else {
        $alertClass = "alert-danger";
        $alertMessage = "Error: " . mysqli_error($link);
    }
}


?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" name="address" placeholder="Enter your address" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">Contact:</label>
                            <input type="text" class="form-control" name="contact" placeholder="Enter your contact number" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select class="form-control" name="role" readonly>
                                <option value="customer" selected>Customer</option>
                                <option value="admin" disabled>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="profileImage">Profile Image:</label>
                            <input type="file" class="form-control" name="img" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" name="Register" class="btn btn-primary btn-block">Register</button>
                <div class="text-center mt-3">
                    <p class="text-muted">Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
