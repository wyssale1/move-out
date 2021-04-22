<?php
    include_once "connection.php";
    session_start();
    $input = json_decode(file_get_contents('php://input'), true);
    $function = $input['function'];
    
    if ($function == "login") {
        $username = $input['username'];
        $password = $input['password'];

        if(isset($username)) {
            $sql = "SELECT * from users WHERE username LIKE '$username';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($user = mysqli_fetch_assoc($result)) {
                    if ($user !== false && password_verify($password, $user['password'])) {
                        $_SESSION['userid'] = $user['id'];
                        $_SESSION['user'] = $user['username'];
                        $_SESSION['firstname'] = $user['firstname'];
                        $_SESSION['name'] = $user['name'];
                        echo 'true';
                    } else {
                        echo 'false';
                    }
                }
            } else {
                echo 'false';
            }
        }
    } elseif($function == "logout") {
        session_destroy();
    }
    
?>