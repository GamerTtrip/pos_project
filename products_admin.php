<?php
include("connection.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
            <th>Action</th>
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
        $result_products = mysqli_query($con, $sql);
        if ($result_products->num_rows > 0) {
            while($row = $result_products->fetch_assoc()) {
                echo "<tr>";
                    echo "<td>" . $row["product_id"] . "</td>";
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td>" . $row["category_name"] . "</td>";
                    echo "<td>";
                    if (!empty($row["product_image"])) {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row["product_image"]) . '" alt="Product Image" class="img-thumbnail" style="width: 100px; cursor: pointer;" data-toggle="modal" data-target="#imageModal" data-image="data:image/jpeg;base64,' . base64_encode($row["product_image"]) . '"><br>';
                    }
                    echo "</td>";                      
                    echo "<td>
                        <button class='btn btn-success' type='button'>View</button>
                    </td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No products found</td></tr>";
        }
    ?>
    </tbody>
</table>
</main>
        <!-- End Main -->

    </div>

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

</body>
</html>
