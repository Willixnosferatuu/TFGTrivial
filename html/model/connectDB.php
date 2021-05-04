<?php

    function connectDB()
    {
      $servername = "localhost";
      $username = "root";
      $password = "weed420";
      $dbname = "TriviaWill";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
      $conn->set_charset("utf8");      
      return $conn;
    }
?>