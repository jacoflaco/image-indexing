<?php
    // if user session variable is not set,
    // redirect to logout.php just in case 
    if(!isset($_SESSION['user'])){
        header('location: logout.php');
    }
?>