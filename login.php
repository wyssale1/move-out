<?php
    include_once "includes/connection.php";
    session_start();
    if(isset($_SESSION['userid'])) {
        header("Location: /");
        die();
    }
?>
<!DOCTYPE html>
 <html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Shopping List | Login</title>
        <meta name="description" content="Shopping List to have the overview about the outgoings">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/login.css">
        <link rel="icon" type="image/svg+xml" href="img/favicon.svg">
    </head>
    <body>
        <svg id="close" class="hide" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M29.58,25,49.05,5.53A3.24,3.24,0,0,0,44.47,1L25,20.42,5.53,1A3.24,3.24,0,0,0,1,5.53L20.42,25,1,44.47a3.24,3.24,0,1,0,4.58,4.58L25,29.58,44.47,49.05a3.24,3.24,0,0,0,4.58-4.58Z"/></svg>
        <header>
            <h1>Login</h1>
        </header>
        <main>
            <div class="users">
                <div class="user" data-name="carmen">
                    <img src="img/girl.svg" alt="Girl">
                    <p class="name">Carmen</p>
                </div>
                <div class="user" data-name="alex">
                    <img src="img/men.svg" alt="Girl">
                    <p class="name">Alex</p>
                </div>
                <label for="password">Passwort</label>
                <input type="password" name="password" class="pwd">
                <button aria-label="login">Login</button>
            </div>
        </main>
        <script src="js/login.js" async defer></script>
    </body>
</html>