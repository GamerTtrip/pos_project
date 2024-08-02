<?php
include("connection.php");

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin_file/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="grid-container">

        <!-- Header -->
        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>
            <div class="header-left">
                <!-- Left Header Content -->
            </div>
            <div class="header-right">
                <span class="material-icons-outlined">notifications</span>
                <span class="material-icons-outlined">email</span>
                <span class="material-icons-outlined">account_circle</span>
            </div>
        </header>
        <!-- End Header -->

        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined">shopping_cart</span> STORE
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <a href="instant_transaction.php" target="_blank">
                        <span class="material-icons-outlined">point_of_sale</span> NEW TRANSACTION
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="oldtransaction.php" target="_blank">
                        <span class="material-icons-outlined">fact_check</span> OLD TRANSACTION
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">inventory_2</span> Products
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">category</span> Categories
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">fact_check</span> Inventory
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">poll</span> Reports
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">settings</span> Settings
                    </a>
                </li>
            </ul>
        </aside>
        <!-- End Sidebar -->

        <!-- Main -->
        <main class="main-container">
            <div class="main-title">
                <h2>Products</h2>
            </div>
            <table class="table table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "
                    SELECT 
                        pc.product_categoryid,
                        pc.category_name,
                        p.product_id,
                        p.product_name,
                        p.product_image
                    FROM 
                        product_category pc
                    INNER JOIN 
                        products p
                    ON 
                        pc.product_categoryid = p.product_categoryid
                ";
                    $query_products = "SELECT * FROM products";
                    $result_products = mysqli_query($con, $query_products);
                    if ($result_products->num_rows > 0) {
                        while($row = $result_products->fetch_assoc()) {
                            echo "<tr>";
                                    echo "<td> name='product_id'  . $row["product_id"] . "'>" . $row["product_id"] . "</td>";
                                    echo "<td> name='product_name'  . $row["product_name"] . "'></td>";
                                    echo "<td>' name='categoryname' . $row["category_name"] . "'></td>";
                                    echo "<td>";
                                    if (!empty($row["product_image"])) {
                                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row["product_image"]) . '" alt="Product Image" class="img-thumbnail" style="width: 100px; cursor: pointer;" data-toggle="modal" data-target="#imageModal" data-image="data:image/jpeg;base64,' . base64_encode($row["product_image"]) . '"><br>';
                                    }
                                    echo "</td>";                      
                                    echo "<td>t class='btn btn-success' type='submit' value='Update'></td>";
                                echo "</form>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No products found</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </main>
        <!-- End Main -->

    </div>

    <!-- Price Modal -->
     
    <!-- <div class="modal fade" id="priceModal" tabindex="-1" aria-labelledby="priceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="priceModalLabel">Product Prices</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="priceForm"> -->

                        <!-- Price form content will be loaded here by JavaScript -->

                    <!-- </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="savePriceChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Stocks Modal -->

    <!-- <div class="modal fade" id="stocksModal" tabindex="-1" aria-labelledby="stocksModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stocksModalLabel">Product Stocks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="stocksForm"> -->

                        <!-- Stocks form content will be loaded here by JavaScript -->

                    <!-- </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveStocksChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" id="modalImage" class="img-fluid" alt="Product Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Image Modal -->
    <script>
        $('#imageModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var image = button.data('image');
            $('#modalImage').attr('src', image);
        });
    </script>

    <!-- Script for Price Modal -->
    <!-- <script>
        $('#priceModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('id');

            $.ajax({
                url: 'get_prices.php',
                method: 'GET',
                data: { product_id: productId },
                success: function(response) {
                    $('#priceForm').html(response);
                }
            });
        });

        $('#savePriceChanges').on('click', function () {
            var formData = $('#priceForm').serialize();

            $.ajax({
                url: 'update_prices.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert(response);
                    $('#priceModal').modal('hide');
                }
            });
        });
    </script> -->

    <!-- Script for Stocks Modal -->
    <!-- <script>
        $('#stocksModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('id');

            $.ajax({
                url: 'get_stocks.php',
                method: 'GET',
                data: { product_id: productId },
                success: function(response) {
                    $('#stocksForm').html(response);
                }
            });
        });

        $('#saveStocksChanges').on('click', function () {
            var formData = $('#stocksForm').serialize();

            $.ajax({
                url: 'update_stocks.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert(response);
                    $('#stocksModal').modal('hide');
                }
            });
        });
    </script> -->
</body>
</html>
