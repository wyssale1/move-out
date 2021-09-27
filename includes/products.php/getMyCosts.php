<?php

    session_start();
    include "../config.php";

    if(isset($_SESSION['gender'])) {
        $conn->close();
    } else {
        echo "false";
    }

?>