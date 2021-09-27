<?php

    include("connection.php");


    /* Add all tables if they do not exist */
    $user_table = "create table $userTable (
        id int(11) not null PRIMARY KEY AUTO_INCREMENT,
        username varchar(10) not null,
        password varchar(128) not null,
        name varchar(40) not null,
        firstname varchar(40) not null
    );";


    if($conn->query($user_table) === TRUE) {
        echo "User table successfully! \r\n";
        $sql_first_setup_user_one = "INSERT INTO $userTable (username, password, name, firstname) VALUES ('carmen', '\$2y\$10\$c6.rUz7OYP02puisF0g03.ClVFlzIb2oVbqhXpThUkRvf4yc2hJhi', 'Hofer', 'Carmen')";
        $sql_first_setup_user_two = "INSERT INTO $userTable (username, password, name, firstname) VALUES ('alex', '\$2y\$10\$R25mNwMZILdbXvmhnYuqfOTt2AbBjPqR1hCVRRykdmY7J233jpk3C', 'Wyss', 'Alexander')";
        if (mysqli_query($conn, $sql_first_setup_user_one)) {
            echo "first user done \n";
        }
        if (mysqli_query($conn, $sql_first_setup_user_two)) {
            echo "second user done \n";
        }
    } else {
        echo "User table failed! \r\n";
    }

    $product_table = "create table $productTable (
        id int(11) not null PRIMARY KEY AUTO_INCREMENT,
        category int(3) not null,
        state int(1) not null,
        titel varchar(128) not null,
        url varchar(256),
        price int(11),
        user varchar(20) not null
    );";

    if($conn->query($product_table) === TRUE) {
        echo "Product table successfully! \r\n";
    } else {
        echo "Product table failed! \r\n";
    }

?>