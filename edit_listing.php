<?php
require_once("functions.php");
$connection = connect_to_mysql();
edit_listing($connection);
// redirects to homepage after completed input
header("Location: realtor_database.php");
?>
