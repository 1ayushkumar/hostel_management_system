<?php
session_start();
session_destroy();
header('Location: /hostel_management_system/auth/login.php');
exit();
?>
