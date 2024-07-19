<?php include "header.php"; ?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
                <h4 class="font-weight-bold text-dark">Hi, welcome back!</h4>
                <p class="font-weight-normal mb-2 text-muted">APRIL 1, 2019</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-6 mb-4"> <!-- Use col-sm-6 to make each card occupy half of the row on all screen sizes -->
                <a href="products.php" class="text-decoration-none"> <!-- Make card a link -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Products</h4>
                            <p>23% increase in conversion</p>
                            <h4 class="text-dark font-weight-bold mb-2">43,981</h4>
                            <canvas id="customers"></canvas>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 mb-4"> <!-- Use col-sm-6 to make each card occupy half of the row on all screen sizes -->
                <a href="adminmaker.php" class="text-decoration-none"> <!-- Make card a link -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Admin Maker</h4>
                            <p>6% decrease in earnings</p>
                            <h4 class="text-dark font-weight-bold mb-2">55,543</h4>
                            <canvas id="orders"></canvas>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 mb-4"> <!-- Use col-sm-6 to make each card occupy half of the row on all screen sizes -->
                <a href="productcatalogue.php" class="text-decoration-none"> <!-- Make card a link -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product Catalogue</h4>
                            <p>6% decrease in earnings</p>
                            <h4 class="text-dark font-weight-bold mb-2">55,543</h4>
                            <canvas id="orders"></canvas>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 mb-4"> <!-- Use col-sm-6 to make each card occupy half of the row on all screen sizes -->
                <a href="customerorders.php" class="text-decoration-none"> <!-- Make card a link -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Customer Orders</h4>
                            <p>6% decrease in earnings</p>
                            <h4 class="text-dark font-weight-bold mb-2">55,543</h4>
                            <canvas id="orders"></canvas>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <?php include "footer.php"; ?>
