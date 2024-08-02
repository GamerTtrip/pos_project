<?php
session_start();

    include("connection.php");
    include("function.php");


    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $username = $_POST['username'];
        $password = $_POST['password'];


        #ADMIN QUERY
        $query = "select * from users where username = '$username' limit 1";              
        $result = mysqli_query($con, $query);
        
        if($result) 
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $user_data = mysqli_fetch_assoc($result);

                if($user_data['password'] === $password)
                {
                    $_SESSION['username'] = $user_data['username'];
                    header("Location: index_admin.php");
                    die;
                }           
            }
        }
    }
?>
