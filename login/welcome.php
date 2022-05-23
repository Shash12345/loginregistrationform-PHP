<?php
session_start();
$_SESSION=array();
session_destroy();
header("locaation:login.php")
?>