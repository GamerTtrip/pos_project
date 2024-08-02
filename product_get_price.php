<?php
include("connection.php");

$product_id = $_GET['product_id'];

$query = "SELECT * FROM multiple_price WHERE product_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '<input type="hidden" name="product_id" value="'.$row['product_id'].'">';
    foreach ($row as $size => $price) {
        if ($size != 'product_id') {
            echo '<div class="form-group">
                    <label for="'.$size.'">'.ucfirst(str_replace('_', ' ', $size)).'</label>
                    <input type="number" class="form-control" name="'.$size.'" value="'.$price.'">
                  </div>';
        }
    }
} else {
    echo "No prices found for this product.";
}
?>
