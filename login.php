<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="center">
        <h1>External and Business Affair</h1>
        <form action="login_form.php" method="POST">
            <div class="txt_field">
                <input name="username" type="text" required>
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input name="password" type="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
            <div class="logo_image">
                <img src="css/cvsu-logo.png" alt="">
                <!-- <img src="css/Featured-image.jpg" alt=""> -->
            </div>
        </form>
    </div>
</body>
</html>
    