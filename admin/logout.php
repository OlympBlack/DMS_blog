<?php
session_start();
$_SESSION = [];
session_destroy();

//la redirection
header('Location: login.php');
exit();
?>