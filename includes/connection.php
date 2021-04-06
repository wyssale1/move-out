<?php
    include_once "mySQL.php";

    $sql = "INSERT INTO products (category, state, titel, url, price) VALUES ('1', '1', 'Couch', '-', '300')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "" . mysqli_error($conn);
        }
        $conn->close();

    print "Salve Rebi";

    if(isset($_POST['way'])) {
        $sql = "INSERT INTO products (category, state, titel, url, price) VALUES ('1', '1', 'Couch', '-', '300')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "" . mysqli_error($conn);
        }
        $conn->close();
    }
    $category, '0', $title, '-', $price
?>