<?php

//logout and session unset
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_email']);
unset($_SESSION['user_role']);
unset($_SESSION['user_profile']);

header('location: ../index.php');

?>