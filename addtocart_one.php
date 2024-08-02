<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST['p_name'];
    $product_id = $_POST['p_id'];
    $product_price = $_POST['p_price'];
    $quantity = $_POST['quantity'];

    // Using prepared statements to avoid SQL injection
    $query_stock = $con->prepare("SELECT one_stocks FROM one_stocks WHERE product_id = ?");
    $query_stock->bind_param("i", $product_id);
    $query_stock->execute();
    $result_stock = $query_stock->get_result();

    if ($result_stock) {
        $row = $result_stock->fetch_assoc();
        $available_stock = $row['one_stocks'];

        if ($available_stock < $quantity) {
            echo "<script>alert('Not enough stock available!');</script>";
            echo "<script>document.location='personelhome.php'</script>";
            exit;
        }
    } else {
        echo "Error fetching stock: " . $con->error;
        exit;
    }

    // Calculate the total price
    $total_price = $quantity * $product_price;

    // Check if the item is already in the cart
    $query_cart = $con->prepare("SELECT * FROM cart WHERE product_id = ?");
    $query_cart->bind_param("i", $product_id);
    $query_cart->execute();
    $result_cart = $query_cart->get_result();

    if ($result_cart->num_rows > 0) {
        // Update cart and stock if the item is already in the cart
        $update_cart = $con->prepare("UPDATE cart SET product_qty = product_qty + ?, price = price + ? WHERE product_id = ?");
        $update_cart->bind_param("idi", $quantity, $total_price, $product_id);

        $update_stock = $con->prepare("UPDATE one_stocks SET one_stocks = one_stocks - ? WHERE product_id = ?");
        $update_stock->bind_param("ii", $quantity, $product_id);

        if ($update_cart->execute() && $update_stock->execute()) {
            echo "<script>alert('Item added to cart successfully!');</script>";
        } else {
            echo "Error updating cart or stock: " . $con->error;
        }
    } else {
        // Insert into cart and update stock if the item is not in the cart
        $insert_cart = $con->prepare("INSERT INTO cart (product_id, product_name, product_price, product_qty, product_size, price) VALUES (?, ?, ?, ?, '0', ?)");
        $insert_cart->bind_param("isdis", $product_id, $p_name, $product_price, $quantity, $total_price);

        $update_stock = $con->prepare("UPDATE one_stocks SET one_stocks = one_stocks - ? WHERE product_id = ?");
        $update_stock->bind_param("ii", $quantity, $product_id);

        if ($insert_cart->execute() && $update_stock->execute()) {
            echo "<script>alert('Item added to cart successfully!');</script>";
        } else {
            echo "Error inserting into cart or updating stock: " . $con->error;
        }
    }
    echo "<script>document.location='instant_transaction.php'</script>";
}
?>
