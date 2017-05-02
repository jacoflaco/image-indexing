<?php
/**
 * This file defines database connection. This file is included in any files that needs database connection
 *
 */
 //TODO: change database connect information
$con = mysqli_connect("localhost","root","1234","image_indexing");

// Check connection
if (!$con) {
  die('Connection failed: ' . mysqli_connect_error());
}

?>