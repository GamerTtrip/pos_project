<?php
include("connection.php");

if (isset($_GET['id'])) {
    $transaction_id = $_GET['id'];

    // Fetch the receipt data from the database
    $query = "SELECT receipt FROM transactions WHERE transactionid = $transaction_id";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $pdf_data = $row['receipt'];

        // Output the PDF
        header('Content-Type: application/pdf');
        echo $pdf_data;
    } else {
        die("Error fetching receipt data: " . mysqli_error($con));
    }
} else {
    die("Invalid request.");
}
?>
