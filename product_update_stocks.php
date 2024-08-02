<?php
include("connection.php");

$product_id = $_POST['product_id'];
unset($_POST['product_id']);

$updateQuery = "UPDATE multiple_stocks SET ";
$updateFields = [];
$updateValues = [];

foreach ($_POST as $size => $stock) {
    $updateFields[] = "$size = ?";
    $updateValues[] = $stock;
}

$updateQuery .= implode(', ', $updateFields);
$updateQuery .= " WHERE product_id = ?";

$stmt = $con->prepare($updateQuery);
$updateValues[] = $product_id;
$stmt->bind_param(str_repeat('i', count($updateValues)-1) . 'i', ...$updateValues);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Stocks updated successfully.";
} else {
    echo "No changes made.";
}
?>
