<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $p_name = $_POST['p_name'];
    $product_id = $_POST['p_id'];
    $product_size = $_POST['p_size'];
    $choose_size = $_POST['choose_size'];
    $product_price = $_POST['p_price'];
    $quantity = $_POST['quantity'];

    // Check stock availability
    $query_stock = "SELECT `$choose_size` FROM multiple_stocks WHERE product_id = $product_id";
    $result_stock = mysqli_query($con, $query_stock);
    if ($result_stock) {
        $row = mysqli_fetch_assoc($result_stock);
        if ($row[$choose_size] < $quantity) {
            echo "<script>alert('Not enough stock available!');</script>";
            echo "<script>document.location='personelhome.php'</script>";  
            exit;    
        }
    } else {
        echo "Error fetching stock: " . mysqli_error($con);
        exit;
    }

    // Calculate the total price
    $total_price = $quantity * $product_price;

    $size_column_map = [
        'xsmall' => 'XS',
        'small' => 'S',
        'medium' => 'M',
        'large' => 'L',
        'xlarge' => 'XL',
        '2xlarge' => '2XL',
        '3xlarge' => '3XL',
        '4xlarge' => '4XL',
        '5xlarge' => '5XL',
    ];

    $choose_size_column = $size_column_map[$choose_size];

    // Check if the item is already in the cart
    $query_cart = "SELECT * FROM `cart` WHERE product_id = $product_id AND product_size = '$choose_size_column'";
    $result_cart = mysqli_query($con, $query_cart);

    if (mysqli_num_rows($result_cart) > 0) {
        // Update cart and stock if the item is already in the cart
        $update_cart = "UPDATE cart SET product_qty = product_qty + $quantity, price = price + $total_price 
                        WHERE product_id = $product_id AND product_size = '$choose_size_column'";
        $update_stock = "UPDATE multiple_stocks SET `$choose_size` = `$choose_size` - $quantity WHERE product_id = $product_id";

        if (mysqli_query($con, $update_cart) && mysqli_query($con, $update_stock)) {
            echo "<script>alert('Item added to cart successfully!');</script>";
            echo "<script>document.location='instant_transaction.php'</script>";
        } else {
            echo "Error updating cart or stock: " . mysqli_error($con);
        }
    } else {
        // Insert into cart and update stock if the item is not in the cart
        $insert_cart = "INSERT INTO cart (product_id, product_name, product_price, product_qty, product_size, price) 
                        VALUES ('$product_id', '$p_name', '$product_price', '$quantity', '$choose_size_column', '$total_price')";
        $update_stock = "UPDATE multiple_stocks SET `$choose_size` = `$choose_size` - $quantity WHERE product_id = $product_id";

        if (mysqli_query($con, $insert_cart) && mysqli_query($con, $update_stock)) {
            echo "<script>alert('Item added to cart successfully!');</script>";
            echo "<script>document.location='instant_transaction.php'</script>";
        } else {
            echo "Error inserting into cart or updating stock: " . mysqli_error($con);
        }
    }
}
?>
