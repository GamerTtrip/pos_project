<?php
include("connection.php");

$product_id = $_POST['product_id'];
unset($_POST['product_id']);

$updateQuery = "UPDATE multiple_price SET ";
$updateFields = [];
$updateValues = [];

foreach ($_POST as $size => $price) {
    $updateFields[] = "$size = ?";
    $updateValues[] = $price;
}

$updateQuery .= implode(', ', $updateFields);
$updateQuery .= " WHERE product_id = ?";

$stmt = $con->prepare($updateQuery);
$updateValues[] = $product_id;
$stmt->bind_param(str_repeat('d', count($updateValues)-1) . 'i', ...$updateValues);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Prices updated successfully.";
} else {
    echo "No changes made.";
}
?>
