<?php
   $host = "localhost";
   $username  = "root";
   $passwd = "";
   $dbname = "medicareplus";

   //Creating a connection
   $conn = mysqli_connect($host, $username, $passwd, $dbname);

   if($conn){
      // echo("Connection Established Successfully" );
   }else{
      die("Connection Failed ".mysqli_connect_error());
   }
?>