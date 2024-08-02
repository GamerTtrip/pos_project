<?php
session_start();
include("connection.php");
include_once(__DIR__ . '/TCPDF-main/tcpdf.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $total_price = $_POST['total_price'];
    $customer_money = $_POST['customer_money'];
    $email = $_POST['email'];
    $student_number = $_POST['student_number'];

    // Ensure customer_money is sufficient
    if ($customer_money >= $total_price) {
        $change = $customer_money - $total_price;
        $status = "Success";

        // Set timezone to Asia/Manila
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d H:i:s");

        // Fetch all cart items
        $query_cart = "SELECT product_name, product_price, product_qty, product_size FROM cart";
        $result_cart = mysqli_query($con, $query_cart);

        if (!$result_cart) {
            die("Error fetching cart data: " . mysqli_error($con));
        }

        // Array to store all cart items
        $cart_items = array();

        // Gather all cart items into an array
        while ($row = mysqli_fetch_assoc($result_cart)) {
            $productName = mysqli_real_escape_string($con, $row['product_name']);
            $productPrice = mysqli_real_escape_string($con, $row['product_price']);
            $productQty = mysqli_real_escape_string($con, $row['product_qty']);
            $productSize = mysqli_real_escape_string($con, $row['product_size']);

            // Format the item string with size, quantity, and total price
            $item_totalprice = $productQty * $productPrice;
            $item_string = "$productName ($productSize) $productPrice x $productQty = $item_totalprice";

            // Add each formatted item to the cart_items array
            $cart_items[] = $item_string;
        }

        // Combine cart items into a string with <br> for new lines
        $items_list = implode(" ", $cart_items);

        // Generate PDF receipt with 58mm width
        $pdf = new TCPDF('P', 'mm', array(58, 150), true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Invoice Receipt');
        $pdf->SetSubject('Transaction Receipt');
        $pdf->SetKeywords('TCPDF, PDF, invoice, receipt, transaction');

        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAutoPageBreak(true, 5);

        $pdf->AddPage();

        // Set small font
        $pdf->SetFont('helvetica', '', 8);

        // Header information
        $header = "
            <div style='text-align: center;'>
                <h7>CAVITE STATE UNIVERSITY</h7>
                <h7>GENERAL TRIAS CAMPUS</h7>
                <br/>
                <h7>EBA OFFICES</h7>
            </div>
        ";

        // Add header to PDF
        $pdf->writeHTML($header, true, false, true, false, '');

        // Content with cart items and transaction details
        $content = "
            <div style='text-align: center;'>
                <p><strong>Items:</strong><br /> $items_list </p>
                <p><strong>Total:</strong> $total_price</p>
                <p><strong>Money:</strong> $customer_money</p>
                <p><strong>Change:</strong> $change</p>
                <br />
                <h7><strong>DATE:</strong> $date</h7>
                <br />
                <h7><strong>EMAIL:</strong> $email</h7>
                <br />
                <h7><strong>Student Number:</strong> $student_number</h7>
            </div>
        ";

        $pdf->writeHTML($content, true, false, true, false, '');

        // Generate the PDF as a string
        $pdf_content = $pdf->Output('', 'S');

        // Escape binary data for insertion into the database
        $pdf_data = mysqli_real_escape_string($con, $pdf_content);

        // Insert transaction into transactions table with the receipt data
        $query = "INSERT INTO transactions (customer_email, customer_snumber, items, total_price, customer_money, receipt, `change`, status, `date`) 
                  VALUES ('$email', '$student_number', '$items_list', '$total_price', '$customer_money', '$pdf_data', '$change', '$status', '$date')";

        if (!mysqli_query($con, $query)) {
            die("Error inserting data: " . mysqli_error($con));
        }

        // Clear the cart
        $query_clear_cart = "DELETE FROM cart";
        if (!mysqli_query($con, $query_clear_cart)) {
            die("Error clearing cart: " . mysqli_error($con));
        }

        // Redirect to home page or wherever needed
        echo "<script>alert('Transaction successful. Change: $change');</script>";
        echo "<script>document.location='instant_transaction.php'</script>";  
    } else {
        echo "<script>alert('Insufficient funds.');</script>";
        echo "<script>document.location='instant_transaction.php'</script>";  
    }
} else {
    echo "<script>alert('Invalid request. Put items in the cart first.');</script>";
    echo "<script>document.location='instant_transaction.php'</script>";  
}
?>
