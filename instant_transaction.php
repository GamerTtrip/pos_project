<?php
session_start();
include("connection.php");

// $user_data = check_login($con);

$query_uniforms = "SELECT products.*, multiple_stocks.*, multiple_price.* FROM products
          JOIN multiple_stocks ON products.product_id = multiple_stocks.product_id
          JOIN multiple_price ON products.product_id = multiple_price.product_id";


$result_uniform = mysqli_query($con, $query_uniforms);

if (!$result_uniform) {
    die("Error fetching data: " . mysqli_error($con));
}

//for books sql
$query_books = "SELECT products.*, one_stocks.*, one_price.* FROM products
          JOIN one_stocks ON products.product_id = one_stocks.product_id
          JOIN one_price ON products.product_id = one_price.product_id";

$result_books = mysqli_query($con, $query_books);

if (!$result_books) {
    die("Error fetching data: " . mysqli_error($con));
}

//for cart 
$query_cart = "SELECT * FROM cart";    

$result_cart = mysqli_query($con, $query_cart);

if (!$result_cart) {
    die("Error fetching data: " . mysqli_error($con));
}

// Fetch total price
$query_total = "SELECT SUM(price) AS total_price FROM cart";
$result_total = mysqli_query($con, $query_total);
$total_price_row = mysqli_fetch_assoc($result_total);
$total_price = $total_price_row['total_price'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="js.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="index/style_home.css">
    <title>External and Business Affair Shop</title>

    <style>
        input[type="number"]::-webkit-inner-spin-button {
        display: none;}
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function calculateChange() {
            const total_price = parseFloat(document.getElementById('total_price_input').value);
            const customer_money = parseFloat(document.getElementById('customer_money').value) || 0;
            const change = customer_money - total_price;
            document.getElementById('change').innerText = change >= 0 ? `Change: ${change.toFixed(2)}` : 'Insufficient funds';
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('customer_money').addEventListener('input', calculateChange);
        });
    </script>

</head>
<body>

<div class="right-sidebar-grid">
    <header class="header">    
        <nav class="navbar">
            <div class="logo"><h6>External and Business Affair </h6></div> 
                <ul class="menu">
                    <li><a href="">View Transaction</a></li>
                    <li><a href="">View all stocks</a></li>
                    <li><a href="index_admin.php">Dashboard</a></li>
                </ul>
            <div class="menu-btn">
                <i class="fa fa-bars"></i>
            </div>
        </nav>
    </header>

    <main class="main-content">
    <section class="sec">
    <p>Uniform Section</p>
        <div class="products">
            <?php
            while ($row = mysqli_fetch_assoc($result_uniform)) {
                ?>
                <div class="card" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $row['product_id']; ?>">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_image']); ?>" alt="">
                    <div class="title"> <?php echo $row['product_name']; ?> </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="productModal<?php echo $row['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $row['product_name']; ?></h5>
                            </div>
                            <div class="modal-body">
                            <form id="productForm" method="POST" action="addtocart_multiple.php">
                        <input type="hidden" name="p_name" id="p_name">
                        <input type="hidden" name="p_id" id="p_id">
                        <input type="hidden" name="p_size" id="p_size">
                        <input type="hidden" name="choose_size" id="choose_size">
                        <input type="hidden" name="p_price" id="p_price">
                        <input type="hidden" name="quantity" value="1">

                                    <div class="grid_buttons">
                                        <div class="div_button">
                                            <button type="button" class="btn btn-success btn-sm p-1" onclick="submitForm('xsmall', '<?php echo $row['product_name']; ?>', '<?php echo $row['product_id']; ?>', '<?php echo $row['xsmall']; ?>', '<?php echo $row['price_xsmall']; ?>')">XSMALL <?php echo $row['xsmall']; ?> <p> price <?php echo $row['price_xsmall']; ?> </p></button>
                                        </div class="div_button">
                                            <button type="button" class="btn btn-success btn-sm p-1" onclick="submitForm('small', '<?php echo $row['product_name']; ?>', '<?php echo $row['product_id']; ?>', '<?php echo $row['small']; ?>', '<?php echo $row['price_small']; ?>')">SMALL <?php echo $row['small']; ?> <p> price <?php echo $row['price_small']; ?> </p></button>
                                        <div class="div_button">
                                            <button type="button" class="btn btn-success btn-sm p-1" onclick="submitForm('medium', '<?php echo $row['product_name']; ?>', '<?php echo $row['product_id']; ?>', '<?php echo $row['medium']; ?>', '<?php echo $row['price_medium']; ?>')">MEDIUM <?php echo $row['medium']; ?> <p> price <?php echo $row['price_medium']; ?> </p></button>
                                        </div class="div_button">
                                            <button type="button" class="btn btn-success btn-sm p-1" onclick="submitForm('large', '<?php echo $row['product_name']; ?>', '<?php echo $row['product_id']; ?>', '<?php echo $row['large']; ?>', '<?php echo $row['price_large']; ?>')">LARGE <?php echo $row['large']; ?> <p> price <?php echo $row['price_large']; ?> </p></button>
                                        <div class="div_button">
                                            <button type="button" class="btn btn-success btn-sm p-1" onclick="submitForm('xlarge', '<?php echo $row['product_name']; ?>', '<?php echo $row['product_id']; ?>', '<?php echo $row['xlarge']; ?>', '<?php echo $row['price_xlarge']; ?>')">XLARGE <?php echo $row['xlarge']; ?> <p> price <?php echo $row['price_xlarge']; ?> </p></button>
                                        </div class="div_button">
                                            <button type="button" class="btn btn-success btn-sm p-1" onclick="submitForm('2xlarge', '<?php echo $row['product_name']; ?>', '<?php echo $row['product_id']; ?>', '<?php echo $row['2xlarge']; ?>', '<?php echo $row['price_2xlarge']; ?>')">2XLARGE <?php echo $row['2xlarge']; ?> <p> price <?php echo $row['price_2xlarge']; ?> </p></button>
                                        <div class="div_button">
                                            <button type="button" class="btn btn-success btn-sm p-1" onclick="submitForm('3xlarge', '<?php echo $row['product_name']; ?>', '<?php echo $row['product_id']; ?>', '<?php echo $row['3xlarge']; ?>', '<?php echo $row['price_3xlarge']; ?>')">3XLARGE <?php echo $row['3xlarge']; ?> <p> price <?php echo $row['price_3xlarge']; ?> </p></button>    
                                        </div class="div_button">
                                        <div class="div_button">
                                            <button type="button" class="btn btn-success btn-sm p-1" onclick="submitForm('4xlarge', '<?php echo $row['product_name']; ?>', '<?php echo $row['product_id']; ?>', '<?php echo $row['4xlarge']; ?>', '<?php echo $row['price_4xlarge']; ?>')">4XLARGE <?php echo $row['4xlarge']; ?> <p> price <?php echo $row['price_4xlarge']; ?> </p></button>  
                                        </div>
                                        <div class="div_button">
                                            <button type="button" class="btn btn-success btn-sm p-1" onclick="submitForm('5xlarge', '<?php echo $row['product_name']; ?>', '<?php echo $row['product_id']; ?>', '<?php echo $row['5xlarge']; ?>', '<?php echo $row['price_5xlarge']; ?>')">5XLARGE <?php echo $row['5xlarge']; ?> <p> price <?php echo $row['price_5xlarge']; ?> </p></button>    
                                        </div>

                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <p>Books Section</p>

        <div class="products">
    <?php
    while ($row = mysqli_fetch_assoc($result_books)) {
        ?>
        <div class="card" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $row['product_id']; ?>">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_image']); ?>" alt="">
            <div class="title"><?php echo $row['product_name']; ?></div>
        </div>

        <div class="modal fade" id="productModal<?php echo $row['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $row['product_name']; ?></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="addtocart_one.php" method="POST">
                            <input type="hidden" name="p_name" value="<?php echo $row['product_name']; ?>">
                            <input type="hidden" name="p_id" value="<?php echo $row['product_id']; ?>">
                            <input type="hidden" name="p_price" value="<?php echo $row['one_price']; ?>">
                            <input type="hidden" name="quantity" value="1">

                            <div class="">
                                <div class="div_button">
                                    <button type="submit" class="btn btn-success btn-sm p-1">
                                        Add to cart
                                        <p>Stocks: <?php echo $row['one_stocks']; ?></p>
                                        <p>Price: <?php echo $row['one_price']; ?></p>
                                    </button>
                                </div>               
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>


    </section>
    </main>
    <section class="right-sidebar">
    <div class="cart">
        <div class="cart-content">
            <form action="transaction_confirm.php" method="post">   
                <?php if (mysqli_num_rows($result_cart) > 0) { ?>
                    <div class="input-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        <br>
                        <input type="text" name="student_number" id="student_number" class="form-control" placeholder="Student Number"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                     </div> 
                    <br>
                    <?php while ($row = mysqli_fetch_assoc($result_cart)) { ?>
                        <div class="cart-item">
                            <div class="item-details">
                                <span class="item-name"><?php echo $row['product_name']; ?> (<?php echo $row['product_size']; ?>)</span>
                                <span class="item-price"><?php echo $row['product_price']; ?> x <?php echo $row['product_qty']; ?> = <?php echo $row['price']; ?></span>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p style="color: Red; font-family: Arial, sans-serif; text-align: center; font-size: 20px;">Cart is empty</p>
                <?php } ?>
            </div>
            <div class="cart-total">
                <?php if (mysqli_num_rows($result_cart) > 0) { ?>
                    <label for="total_price">Total: <?php echo $total_price; ?></label>
                    <input type="hidden" name="total_price" value="<?php echo $total_price; ?>" id="total_price_input">
                    <input type="number" name="customer_money" id="customer_money" placeholder="Enter Customer Money" class="form-control"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <br>
                    <p id="change">Change: <span id="change_amount">0.00</span></p>
                    <button type="submit" class="btn btn-success" id="checkout-button">Checkout</button>
                <?php } ?>
            </div>
        </form>
    </div>
</section>

    <footer class="footer">        
        <p>Copyright at <a href="">External and Business Affair Office</a></p> 
    </footer>
</div>


<script src="index/js.js">

</script>

</body>
</html>
