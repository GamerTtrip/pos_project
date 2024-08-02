<?php
session_start();
include("connection.php");

$query_transactions = "SELECT `transactionid`, `customer_email`, `customer_snumber`, `items`, `total_price`, `customer_money`, `change`, `receipt`, `status`, `date` FROM `transactions`";
$result_transactions = mysqli_query($con, $query_transactions);

if (!$result_transactions) {
    die("Error fetching data: " . mysqli_error($con));
}
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
                <h2>Old Transactions</h2>
            </div>
            <table class="table table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Customer Email</th>
                        <th>Student #</th>
                        <th>Items</th>
                        <th>Total Price</th>
                        <th>Customer Money</th>
                        <th>Change</th>
                        <th>Receipt</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result_transactions)) {
                        echo "
                        <tr>
                            <td>" . $row['transactionid'] . "</td>
                            <td>" . $row['customer_email'] . "</td>
                            <td>" . $row['customer_snumber'] . "</td>
                            <td>
                                <button class='btn btn-info' data-toggle='modal' data-target='#itemsModal' data-items='" . $row['items'] . "'>
                                    View
                                </button>
                            </td>
                            <td>" . $row['total_price'] . "</td>
                            <td>" . $row['customer_money'] . "</td>
                            <td>" . $row['change'] . "</td>
                            <td><a href='view_receipt.php?id=" . $row['transactionid'] . "' target='_blank'>View Receipt</a></td>
                            <td>" . $row['status'] . "</td>
                            <td>" . $row['date'] . "</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
        <!-- End Main -->

    </div>

    <!-- Modal for Items Information -->
    <div class="modal fade" id="itemsModal" tabindex="-1" aria-labelledby="itemsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemsModalLabel">Items Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><span id="modalItems"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        $('#itemsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var items = button.data('items'); // Extract info from data-* attributes

            var modal = $(this);
            modal.find('#modalItems').text(items); // Update the modal's content.
        });
    </script>
    <script src="admin_file/js/scripts.js"></script>
</body>
</html>
