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
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 

header("Location: index.php");
            exit();
?>
    </body>
</html>

