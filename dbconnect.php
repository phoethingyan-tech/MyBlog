<?php

try {
    $host = "localhost";
    $dbname = "myblog";
    $dbuser = "root";
    $dbpassword = "";

    //Data Source Name
    $dsn = "mysql:host=$host;dbname=$dbname";
    $conn = new PDO($dsn,$dbuser, $dbpassword);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection success!";
}
catch(PDOException $e) {
    die("Connection Fail :".$e->getMessage());
}