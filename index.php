<?php
    include_once "includes/connection.php";
    session_start();
    if(!isset($_SESSION['userid'])) {
        header("Location: /login.php");
        die();
    }
?>

<!DOCTYPE html>
 <html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Shopping List</title>
        <meta name="description" content="Shopping List to have the overview about the outgoings">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/svg+xml" href="img/favicon.svg">
    </head>
    <body>
        <header>
            <h1>Hallo <i><?php echo $_SESSION['firstname']; ?></i></h1>
            <div class="nav">
                <p class="active" data-page="categories">Übersicht</p>
                <p data-page="costs">Kosten</p>
            </div>
        </header>
        <main>
            <h2>Kategorie auswählen</h2>
            
        </main>
        <footer>
            <button class="addProduct"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M45.54,20.54H30.36a.9.9,0,0,1-.9-.9V4.46a4.46,4.46,0,0,0-8.92,0V19.64a.9.9,0,0,1-.9.9H4.46a4.46,4.46,0,0,0,0,8.92H19.64a.9.9,0,0,1,.9.9V45.54a4.46,4.46,0,0,0,8.92,0V30.36a.9.9,0,0,1,.9-.9H45.54a4.46,4.46,0,0,0,0-8.92Z"/></svg></button>
            <div class="new-product-form">
                <label for="category">Kategorie</label>
                <select id="category" name="category"></select>
                <label for="title" class="title-label">Titel</label>
                <input type="text" id="title" name="title">
                <label for="price">Preis</label>
                <input type="number" id="price" name="price">
                <button id="addNewProduct"><svg class="arrowBtn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.75 20"><path d="M11.43 9.22L2.53.32A1.08 1.08 0 0 0 1.75 0a1.06 1.06 0 0 0-.77.32L.32 1a1.11 1.11 0 0 0 0 1.55L7.8 10 .31 17.48a1.09 1.09 0 0 0-.31.77 1.13 1.13 0 0 0 .31.78l.66.65a1.1 1.1 0 0 0 1.55 0l8.91-8.91a1 1 0 0 0 .31-.77 1.07 1.07 0 0 0-.31-.78z"/></svg></button>
            </div>
        </footer>
        <template id="pageTitle"><h2></h2></template>
        <template id="option"><option value=""></option></template>
        <template id="newEntryTemp">
            <div class="product" data-id data-state="0"> 
                <img src="img/mark-open.svg" alt="State">
                <p class="product-title"></p>
                <p class="product-price"></p>
            </div>
        </template>
        <template id="detail-modal">
            <div class="detail">
                <div class="container" data-id>
                    <h4></h4>
                    <svg id="close-modal" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M29.58,25,49.05,5.53A3.24,3.24,0,0,0,44.47,1L25,20.42,5.53,1A3.24,3.24,0,0,0,1,5.53L20.42,25,1,44.47a3.24,3.24,0,1,0,4.58,4.58L25,29.58,44.47,49.05a3.24,3.24,0,0,0,4.58-4.58Z"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M18.52,12.56a13.77,13.77,0,0,0,2.14,20.75.59.59,0,0,0,.71-.07,22.94,22.94,0,0,0,3.68-4.46.54.54,0,0,0-.21-.75,6.73,6.73,0,0,1-2.63-2.71h0a6.55,6.55,0,0,1-.56-4.52h0c.42-2,2.61-3.94,4.28-5.7h0l6.26-6.41a6.41,6.41,0,0,1,9.12,0,6.53,6.53,0,0,1,.1,9.19l-3.8,3.91a.69.69,0,0,0-.15.69A18,18,0,0,1,38,31.25a.08.08,0,0,0,.13.07l8.07-8.26A13.66,13.66,0,0,0,46.06,4a13.52,13.52,0,0,0-19.24.1l-8.27,8.46,0,0Z" transform="translate(0 0)"/><path d="M33.61,34.47h0a13.9,13.9,0,0,0,1.2-9.86h0a13.64,13.64,0,0,0-5.48-7.84.76.76,0,0,0-.83,0,13.11,13.11,0,0,0-3.63,4.4.6.6,0,0,0,.24.79,6.86,6.86,0,0,1,2.6,2.66h0a6.28,6.28,0,0,1,.66,4.1h0C28.09,31,25.83,33.05,24,34.9h0l-6.23,6.38a6.49,6.49,0,1,1-9.26-9.1l3.8-3.92a.69.69,0,0,0,.16-.67,19,19,0,0,1-.55-8.8.08.08,0,0,0-.13-.07L3.88,26.85A13.8,13.8,0,0,0,4,46.14a13.55,13.55,0,0,0,19.14-.2c1.81-2,9.56-9.22,10.49-11.47Z" transform="translate(0 0)"/></svg>
                    <a href="url">Link</a>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M50,9.59a27.74,27.74,0,0,1-3.45,13.35,1.5,1.5,0,0,1-1.27.71,1.46,1.46,0,0,1-.77-.22,1.49,1.49,0,0,1-.5-2,25.13,25.13,0,0,0,3-11.8C47,5.75,44.53,3,41.09,3A6,6,0,0,0,35.15,8.9a46.78,46.78,0,0,0,.94,6.19,1.49,1.49,0,0,1-2.91.61,49.16,49.16,0,0,1-1-6.8A8.92,8.92,0,0,1,41.09,0C46.17,0,50,4.12,50,9.59Zm-8.66,2.34c.59,4.93,1.45,14.53.47,15.51L20.23,49a3.41,3.41,0,0,1-4.81,0L1,34.59a3.4,3.4,0,0,1,0-4.81L22.57,8.22c.35-.34,4.08-.35,8.27-.14,0,.28-.08.54-.08.82a29.18,29.18,0,0,0,.49,4.21A4.08,4.08,0,1,0,37,12.05a24.26,24.26,0,0,1-.39-3.15c0-.13,0-.25,0-.38l1.5.17C41,9,41,9,41.34,11.93ZM29.84,28.06a9.26,9.26,0,0,0-2.1-3.33l1.64-1.64-1.82-1.82L25.79,23c-2.37-1.62-4.81-1.49-6.46.17C17.52,25,18,27.3,19.27,30c.91,1.84,1.08,2.9.37,3.6s-1.89.42-3-.64A9.33,9.33,0,0,1,14.42,29l-2.74,1.62a10.74,10.74,0,0,0,2.38,3.94l-1.78,1.78,1.82,1.83L16,36.26c2.53,1.78,5.09,1.55,6.74-.11s1.84-3.59.39-6.6c-1-2.16-1.25-3.22-.65-3.82s1.45-.67,2.66.54a8.16,8.16,0,0,1,2,3.33Z" transform="translate(0 0)"/></svg>
                    <p class="price"></p>
                    <button class="deleteBtn" aria-label="delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.61 50"><path d="M27.22 18.11a1.17 1.17 0 0 0-1.17 1.18v22.13a1.17 1.17 0 1 0 2.34 0V19.29a1.18 1.18 0 0 0-1.17-1.18zm-13.81 0a1.17 1.17 0 0 0-1.17 1.18v22.13a1.17 1.17 0 1 0 2.34 0V19.29a1.17 1.17 0 0 0-1.17-1.18zM3.33 14.88v28.85a6.48 6.48 0 0 0 1.72 4.46A5.75 5.75 0 0 0 9.23 50h22.18a5.77 5.77 0 0 0 4.18-1.81 6.48 6.48 0 0 0 1.72-4.46V14.88a4.47 4.47 0 0 0-1.15-8.79h-6V4.62A4.61 4.61 0 0 0 25.51 0h-10.4a4.59 4.59 0 0 0-4.64 4.62v1.47h-6a4.47 4.47 0 0 0-1.15 8.79zm28.08 32.78H9.23a3.71 3.71 0 0 1-3.56-3.93V15h29.28v28.73a3.71 3.71 0 0 1-3.54 3.93zM12.81 4.62A2.3 2.3 0 0 1 13.48 3a2.26 2.26 0 0 1 1.63-.66h10.4a2.25 2.25 0 0 1 2.29 2.28v1.47h-15zM4.48 8.43h31.66a2.11 2.11 0 0 1 0 4.22H4.48a2.11 2.11 0 0 1 0-4.22zm15.83 9.68a1.17 1.17 0 0 0-1.17 1.18v22.13a1.17 1.17 0 1 0 2.34 0V19.29a1.17 1.17 0 0 0-1.17-1.18z"/></svg></button>
                    <button class="saveBtn" aria-label="save">Speichern</button>
                </div>
            </div>
        </template>
        <script src="js/main.js" async defer></script>
    </body>
</html>