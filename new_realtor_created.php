<?php
require_once("functions.php");
$connection = connect_to_mysql();
input_user($connection);
// redirects to homepage after completed input
header("Location: add_realtor.php");
?>
