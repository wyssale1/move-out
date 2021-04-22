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

    /* Add all tables if they do not exist */
    $user_table = "create table IF NOT EXISTS users (
                        id int(11) not null PRIMARY KEY AUTO_INCREMENT,
                        username varchar(10) not null,
                        password varchar(128) not null,
                        name varchar(40) not null,
                        firstname varchar(40) not null
                    );";
    mysqli_query($conn, $user_table);

    $product_table = "create table IF NOT EXISTS products (
                        id int(11) not null PRIMARY KEY AUTO_INCREMENT,
                        category int(3) not null,
                        state int(1) not null,
                        titel varchar(128) not null,
                        url varchar(256),
                        price int(11),
                        user varchar(20) not null
                    );";
    mysqli_query($conn, $product_table);

    /*
    $dbServername = "localhost";
    $dbUser = "u373636090_gartenhof";
    $dbPassword = "Ju9>Kg$0";
    $dbName = "u373636090_gartenhof";
    $table = "products";
    */
?>