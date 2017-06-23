<?php
// lib  of   my ...

      $servername = "localhost";
      $username = "root";
      $password = "Lqsym53029";
      $dbname = "Cyclo";


/*
 * Function for  connecting
 * the database
*/
function connDatabase($servername, $username, $password, $dbname) {
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error){ 
    die("\n Could not connect: " . mysql_error());
  } 
    return $conn;
}

include('parsing.php');
include('newbike.php');
include('sharebike.php');
include('srcbike.php');
?>
