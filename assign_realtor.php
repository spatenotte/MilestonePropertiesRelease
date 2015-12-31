<?php
require_once("functions.php");
$connection = connect_to_mysql();
assign_realtor($connection);
// redirects to homepage after completed input
header("Location: admin_database.php");
    exit();
?>

