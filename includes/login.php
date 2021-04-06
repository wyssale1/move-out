<?php
    include_once "connection.php";
    session_start();
    $pdo = new PDO('mysql:host=localhost;dbname=u373636090_gartenhof', 'u373636090_gartenhof', 'Ju9>Kg$0');
    $input = json_decode(file_get_contents('php://input'), true);
    $name = $input['name'];
    $passwort = $input['password'];

    if(isset($name)) {
        $email = $name;
         
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
             
        //Überprüfung des Passworts
        if ($user !== false && password_verify($passwort, $user['passwort'])) {
            $_SESSION['userid'] = $user['id'];
            echo '{"status":"ok"}';
        } else {
            echo '{"status":"error"}';
        }
    }
?>