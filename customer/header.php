<?php
include_once "../connection.php";

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kapella Bootstrap Admin Dashboard Template</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
        <nav class="navbar top-navbar col-lg-12 col-12 p-0">
            <div class="container-fluid">
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                    <ul class="navbar-nav navbar-nav-left">
                        <li class="nav-item nav-search d-none d-lg-block ms-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="search">
                                        <i class="mdi mdi-magnify"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" placeholder="search" aria-label="search" aria-describedby="search">
                            </div>
                        </li>
                    </ul>
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo.svg" alt="logo"/></a>
                        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a>
                    </div>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown d-lg-flex d-none">
                            <a class="dropdown-toggle show-dropdown-arrow btn btn-inverse-primary btn-sm" id="nreportDropdown" href="#" data-bs-toggle="dropdown">
                                Reports
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="nreportDropdown">
                                <p class="mb-0 font-weight-medium float-left dropdown-header">Reports</p>
                                <a class="dropdown-item">
                                    <i class="mdi mdi-file-pdf text-primary"></i>
                                    Pdf
                                </a>
                                <a class="dropdown-item">
                                    <i class="mdi mdi-file-excel text-primary"></i>
                                    Exel
                                </a>
                            </div>
                        </li>
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                                <?php if(!empty($customer['username']) && !empty($customer['profile_image'])): ?>
                                    <span class="nav-profile-name"><?php echo htmlspecialchars($customer['username']); ?></span>
                                    <span class="online-status"></span>
                                    <img src="../profile_images/<?php echo htmlspecialchars($customer['profile_image']); ?>" alt="profile"/>
                                <?php endif; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <a href="myprofile.php" class="dropdown-item">
                                    <i class="mdi mdi-settings text-primary"></i>
                                    My Profile
                                </a>
                                <a href="logout.php" class="dropdown-item">
                                    <i class="mdi mdi-logout text-primary"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </div>
        </nav>
        <nav class="bottom-navbar">
            <div class="container">
                <ul class="nav page-navigation">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="mdi mdi-file-document-box menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="mdi mdi-cube-outline menu-icon"></i>
                            <span class="menu-title">INFO</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="submenu">
                            <ul>
                                <li class="nav-item"><a class="nav-link" href="tra">Buttons</a></li>
                                <li class="nav-item"><a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
                            </ul>
                        </div>
                    </li> -->
                    <li class="nav-item">
                        <a href="products.php" class="nav-link">
                            <i class="mdi mdi-chart-areaspline menu-icon"></i>
                            <span class="menu-title">Products</span>
                            <i class="menu-arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="confirmation.php" class="nav-link">
                            <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                            <span class="menu-title">Order confirmation</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
