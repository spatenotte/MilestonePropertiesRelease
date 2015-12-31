<?php
session_start();
include_once 'functions.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <?php
//        echo $_POST['user_email'];
//        echo md5($_POST['user_password']);
            $connection = connect_to_mysql();
            $row = user_sign_in($connection);
            if ($row){
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['admin'] = $row['admin'];

            echo "<br>You're logged in!!!!";
            }
            
        header("Location: index.php");
            exit();
            
        ?>
    </body>
</html>

