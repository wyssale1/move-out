<?php

    session_start();
    include "../config.php";

    if(isset($_SESSION['gender'])) {
        $input = json_decode(file_get_contents('php://input'), true);
        $category = $input['category'];
        $new_title = $input['title'];
        $price = $input['price'];

        $sql_add_entry = "INSERT INTO $table(category, state, titel, url, price) VALUES('$category', '0', '$new_title', '-', '$price');";

        if (mysqli_query($conn, $sql_add_entry)) {
            $inseret_id = $conn->insert_id;
            echo "$inseret_id";
        } else {
            echo "Error: " . $sql_add_entry . "" . mysqli_error($conn);
        }
        $conn->close();
    } else {
        echo "false";
    }

?>