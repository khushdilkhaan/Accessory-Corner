<?php include_once "../connection.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags --> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Regal Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css"/>
  <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="vendors/jquery-bar-rating/fontawesome-stars-o.css">
  <link rel="stylesheet" href="vendors/jquery-bar-rating/fontawesome-stars.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo.svg" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Search Projects.." aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">

          <li class="nav-item dropdown d-flex mr-4 ">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Settings</p>
              <a href="myprofile.php" class="dropdown-item preview-item">               
                  <i class="icon-head"></i> Profile
              </a>
              <a href="logout.php" class="dropdown-item preview-item">
                  <i class="icon-inbox"></i> Logout
              </a>
            </div>
          </li>
        
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <?php


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
?>


    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="user-profile">
                <div class="user-image">
                    <!-- Fetch and display the admin's profile image -->
                    <?php if (!empty($adminData['profile_image'])) { ?>
                        <img src="../profile_images/<?php echo htmlspecialchars($adminData['profile_image']); ?>" alt="Profile Image">
                    <?php } else { ?>
                        <img src="images/faces/face28.png" alt="Default Profile Image">
                    <?php } ?>
                </div>
                <div class="user-name">
                    <!-- Fetch and display the admin's name -->
                    <?php echo !empty($adminData['username']) ? htmlspecialchars($adminData['username']) : 'Admin'; ?>
                </div>
                
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="icon-box menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <i class="icon-disc menu-icon"></i>
                        <span class="menu-title">Products Details</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="products.php">Products</a></li>
                            <li class="nav-item"> <a class="nav-link" href="productcatalogue.php">Product Catalogue</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminmaker.php">
                        <i class="icon-file menu-icon"></i>
                        <span class="menu-title">Admin Maker</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/charts/chartjs.html">
                        <i class="icon-pie-graph menu-icon"></i>
                        <span class="menu-title">Charts</span>
                    </a>
                </li>
            </ul>
        </nav>
  
