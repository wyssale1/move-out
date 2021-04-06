<?php
    $dbServername = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "bill";
    $table = "products";

    $conn = new mysqli($dbServername, $dbUser, $dbPassword, $dbName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    /*
    $dbServername = "localhost";
    $dbUser = "u373636090_gartenhof";
    $dbPassword = "Ju9>Kg$0";
    $dbName = "u373636090_gartenhof";
    $table = "products";
    */
?>