<?php
    include_once "includes/connection.php";
    session_start();
    if(!isset($_SESSION['userid'])) {
        header("Location: login.php");
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
            <h2 class="page-title"></h2>
        </main>
        <footer>
            <button class="logoutBtn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M31.25 27.08a2.09 2.09 0 0 0-2.08 2.09v8.33a2.09 2.09 0 0 1-2.09 2.08h-6.25V8.33a4.19 4.19 0 0 0-2.83-4l-.62-.2h9.7a2.09 2.09 0 0 1 2.09 2.08v6.29a2.08 2.08 0 0 0 4.16 0V6.25A6.25 6.25 0 0 0 27.08 0H4.69a1.89 1.89 0 0 0-.23.05 2.93 2.93 0 0 0-.29 0A4.17 4.17 0 0 0 0 4.17v37.5a4.19 4.19 0 0 0 2.84 4l12.53 4.18a4.4 4.4 0 0 0 1.3.19 4.17 4.17 0 0 0 4.16-4.17v-2.12h6.25a6.25 6.25 0 0 0 6.25-6.25v-8.33a2.09 2.09 0 0 0-2.08-2.09z"/><path d="M49.39 19.36L41.06 11a2.08 2.08 0 0 0-3.56 1.5v6.25h-8.33a2.09 2.09 0 1 0 0 4.17h8.33v6.25a2.09 2.09 0 0 0 3.56 1.47l8.33-8.33a2.09 2.09 0 0 0 0-2.95z"/></svg></button>
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
        <template id="option"><option value=""></option></template>
        <template id="newCategory">
            <div data-id class="category">
                <img class="icon" src="" alt="">
                <h3 class="title"></h3>
                <svg class="arrowBtn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.75 20"><path d="M11.43 9.22L2.53.32A1.08 1.08 0 0 0 1.75 0a1.06 1.06 0 0 0-.77.32L.32 1a1.11 1.11 0 0 0 0 1.55L7.8 10 .31 17.48a1.09 1.09 0 0 0-.31.77 1.13 1.13 0 0 0 .31.78l.66.65a1.1 1.1 0 0 0 1.55 0l8.91-8.91a1 1 0 0 0 .31-.77 1.07 1.07 0 0 0-.31-.78z"></path></svg>
                <div class="title-line"><p></p><p>Titel</p><p>Preis [CHF]</p></div>
                <div class="products open"></div>
            </div>
        </template>
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 41.72 50"><path d="M20.54 24.08c10.69 0 16.11-13 8.52-20.55a12 12 0 1 0-8.52 20.55zM41.72 41.4l-.1-2.95c-.43-5.15-2-11.55-7.29-13.65a9.86 9.86 0 0 0-3.61-.65 3.7 3.7 0 0 0-2 .83l-2 1.32a11.05 11.05 0 0 1-9.09 1.16A12.25 12.25 0 0 1 15 26.3L12.95 25a3.65 3.65 0 0 0-1.95-.83 9.82 9.82 0 0 0-3.61.65C2.05 26.92.53 33.32.1 38.47c-.06.95-.1 1.95-.1 2.95-.07 5.17 3.68 8.64 8.86 8.58h24c5.17.06 8.93-3.41 8.86-8.6z"/></svg>
                    <select id="user" name="user"><option value="0">-</option></select>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M50,9.59a27.74,27.74,0,0,1-3.45,13.35,1.5,1.5,0,0,1-1.27.71,1.46,1.46,0,0,1-.77-.22,1.49,1.49,0,0,1-.5-2,25.13,25.13,0,0,0,3-11.8C47,5.75,44.53,3,41.09,3A6,6,0,0,0,35.15,8.9a46.78,46.78,0,0,0,.94,6.19,1.49,1.49,0,0,1-2.91.61,49.16,49.16,0,0,1-1-6.8A8.92,8.92,0,0,1,41.09,0C46.17,0,50,4.12,50,9.59Zm-8.66,2.34c.59,4.93,1.45,14.53.47,15.51L20.23,49a3.41,3.41,0,0,1-4.81,0L1,34.59a3.4,3.4,0,0,1,0-4.81L22.57,8.22c.35-.34,4.08-.35,8.27-.14,0,.28-.08.54-.08.82a29.18,29.18,0,0,0,.49,4.21A4.08,4.08,0,1,0,37,12.05a24.26,24.26,0,0,1-.39-3.15c0-.13,0-.25,0-.38l1.5.17C41,9,41,9,41.34,11.93ZM29.84,28.06a9.26,9.26,0,0,0-2.1-3.33l1.64-1.64-1.82-1.82L25.79,23c-2.37-1.62-4.81-1.49-6.46.17C17.52,25,18,27.3,19.27,30c.91,1.84,1.08,2.9.37,3.6s-1.89.42-3-.64A9.33,9.33,0,0,1,14.42,29l-2.74,1.62a10.74,10.74,0,0,0,2.38,3.94l-1.78,1.78,1.82,1.83L16,36.26c2.53,1.78,5.09,1.55,6.74-.11s1.84-3.59.39-6.6c-1-2.16-1.25-3.22-.65-3.82s1.45-.67,2.66.54a8.16,8.16,0,0,1,2,3.33Z" transform="translate(0 0)"/></svg>
                    <p class="price"></p>
                    <button class="deleteBtn" aria-label="delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.61 50"><path d="M27.22 18.11a1.17 1.17 0 0 0-1.17 1.18v22.13a1.17 1.17 0 1 0 2.34 0V19.29a1.18 1.18 0 0 0-1.17-1.18zm-13.81 0a1.17 1.17 0 0 0-1.17 1.18v22.13a1.17 1.17 0 1 0 2.34 0V19.29a1.17 1.17 0 0 0-1.17-1.18zM3.33 14.88v28.85a6.48 6.48 0 0 0 1.72 4.46A5.75 5.75 0 0 0 9.23 50h22.18a5.77 5.77 0 0 0 4.18-1.81 6.48 6.48 0 0 0 1.72-4.46V14.88a4.47 4.47 0 0 0-1.15-8.79h-6V4.62A4.61 4.61 0 0 0 25.51 0h-10.4a4.59 4.59 0 0 0-4.64 4.62v1.47h-6a4.47 4.47 0 0 0-1.15 8.79zm28.08 32.78H9.23a3.71 3.71 0 0 1-3.56-3.93V15h29.28v28.73a3.71 3.71 0 0 1-3.54 3.93zM12.81 4.62A2.3 2.3 0 0 1 13.48 3a2.26 2.26 0 0 1 1.63-.66h10.4a2.25 2.25 0 0 1 2.29 2.28v1.47h-15zM4.48 8.43h31.66a2.11 2.11 0 0 1 0 4.22H4.48a2.11 2.11 0 0 1 0-4.22zm15.83 9.68a1.17 1.17 0 0 0-1.17 1.18v22.13a1.17 1.17 0 1 0 2.34 0V19.29a1.17 1.17 0 0 0-1.17-1.18z"/></svg></button>
                    <button class="saveBtn" aria-label="save">Speichern</button>
                </div>
            </div>
        </template>
        <template id="costs">
            <div class="costs">
                <div class="my-costs">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46.66 50"><path d="M32.66 29.17c1.75 0 3.17 1.12 3.17 2.5a.83.83 0 0 0 1.66 0c0-2.3-2.16-4.17-4.83-4.17h-.16v-1.6a.84.84 0 0 0-.84-.83.83.83 0 0 0-.83.83v1.6h-.17c-2.66 0-4.83 1.87-4.83 4.17s2.17 4.17 4.83 4.17h.17v5h-.17c-1.74 0-3.16-1.12-3.16-2.5a.84.84 0 0 0-.84-.83.83.83 0 0 0-.83.83c0 2.3 2.17 4.17 4.83 4.17h.17v1.67a.83.83 0 0 0 .83.83.84.84 0 0 0 .84-.83V42.5h.16c2.67 0 4.83-1.87 4.83-4.17s-2.16-4.16-4.83-4.16h-.16v-5zm-1.83 5h-.17c-1.74 0-3.16-1.12-3.16-2.5s1.42-2.5 3.16-2.5h.17zm1.83 1.67c1.75 0 3.17 1.12 3.17 2.49s-1.42 2.5-3.17 2.5h-.16v-5zm-1-15.84a14.82 14.82 0 0 0-4.18.6 15.26 15.26 0 0 0-7.54-5 8.33 8.33 0 0 0-8.218-14.492A8.33 8.33 0 0 0 8.58 12.46a8.42 8.42 0 0 0 3.13 3.14 15 15 0 0 0-7.11 4.53A19.81 19.81 0 0 0 0 33.36a.81.81 0 0 0 .43.72c.31.18 7.77 4.27 15.4 4.27h1.2c1.752 7.648 9.103 12.654 16.862 11.482a15 15 0 0 0 12.717-15.951C46.023 26.056 39.507 20.005 31.66 20zM9.17 8.34A6.67 6.67 0 1 1 15.83 15a6.67 6.67 0 0 1-6.66-6.66zm7.58 28.31h-.92c-6.18 0-12.48-3-14.16-3.84a18 18 0 0 1 4.18-11.6 13.24 13.24 0 0 1 20 0 15 15 0 0 0-9.1 15.44zm14.91 11.68c-7.362 0-13.33-5.968-13.33-13.33s5.968-13.33 13.33-13.33S44.99 27.638 44.99 35s-5.968 13.33-13.33 13.33z"/></svg>
                    <h3>Meine Ausgaben</h3>
                    <p class="money" id="personal-costs"></p>
                    <svg class="openBtn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M45.54,20.54H30.36a.9.9,0,0,1-.9-.9V4.46a4.46,4.46,0,0,0-8.92,0V19.64a.9.9,0,0,1-.9.9H4.46a4.46,4.46,0,0,0,0,8.92H19.64a.9.9,0,0,1,.9.9V45.54a4.46,4.46,0,0,0,8.92,0V30.36a.9.9,0,0,1,.9-.9H45.54a4.46,4.46,0,0,0,0-8.92Z"/></svg>
                </div>
                <div class="overall-costs">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M33.39 28.4a2 2 0 0 1 2.15 1.88 1 1 0 1 0 2 0 3.93 3.93 0 0 0-3.13-3.75V26a1 1 0 1 0-1.95 0v.51c-4.68 1.2-3.86 7.49 1 7.61A2 2 0 0 1 35.54 36c-.11 2.49-4.18 2.49-4.29 0a1 1 0 1 0-2 0 3.94 3.94 0 0 0 3.13 3.75v.42a1 1 0 1 0 1.95 0v-.42c4.67-1.2 3.85-7.5-1-7.61-2.79-.09-2.79-3.64.06-3.74zm10.7-2.12a12.84 12.84 0 0 0-5.2-4.66 1 1 0 0 0-1.3.47 1 1 0 0 0 .46 1.32 11 11 0 0 1 4.84 14.9 1 1 0 0 0 .86 1.45 1 1 0 0 0 .86-.52 13 13 0 0 0-.52-12.96zm-9.17-3.94a1 1 0 1 0-1-1 1 1 0 0 0 1 1zM28.75 43a11 11 0 0 1-4.84-14.91 1 1 0 0 0-.4-1.33 1 1 0 0 0-1.33.4 13.14 13.14 0 0 0-1.48 6 12.94 12.94 0 0 0 7.2 11.64 1 1 0 0 0 .85-1.8zm3.18 1.08a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM37.83 17a4.47 4.47 0 0 0-.43-.81h2.54a4.55 4.55 0 0 0 0-9.09h-7.82a4.56 4.56 0 0 0-3.7-7.1H4.49a4.55 4.55 0 0 0 0 9.09h7.82a4.62 4.62 0 0 0 0 5.14H9.77A4.57 4.57 0 0 0 7 22.34a4.6 4.6 0 0 0 0 7.12 4.59 4.59 0 0 0 0 7.11 4.59 4.59 0 0 0-1.7 3.56 4.53 4.53 0 0 0 4.5 4.55h11.5C31.42 55.72 50 48.46 50 33.21A16.8 16.8 0 0 0 37.83 17zm2.11-7.93a2.57 2.57 0 0 1 0 5.14H16a2.57 2.57 0 0 1 0-5.14zm-35.45-2a2.57 2.57 0 0 1 0-5.07h23.93a2.57 2.57 0 0 1 0 5.14zm5.28 9.09h23.92a2.48 2.48 0 0 1 1.11.26 16.49 16.49 0 0 0-13.15 4.88H9.77a2.57 2.57 0 0 1 0-5.14zM17 35.58H9.77a2.57 2.57 0 0 1 0-5.14H17a17.37 17.37 0 0 0 0 5.14zm-7.23-7.11a2.57 2.57 0 0 1 0-5.14H20a16.84 16.84 0 0 0-2.51 5.14zm0 14.23a2.57 2.57 0 0 1 0-5.14h7.59a17 17 0 0 0 2.34 5.14zM33.4 48a14.75 14.75 0 0 1-14.65-14.79c.8-19.67 28.5-19.66 29.3 0A14.75 14.75 0 0 1 33.4 48z"/></svg>
                    <h3>Gesamt Ausgaben</h3>
                    <p class="money" id="general-costs"></p>
                    <svg class="openBtn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M45.54,20.54H30.36a.9.9,0,0,1-.9-.9V4.46a4.46,4.46,0,0,0-8.92,0V19.64a.9.9,0,0,1-.9.9H4.46a4.46,4.46,0,0,0,0,8.92H19.64a.9.9,0,0,1,.9.9V45.54a4.46,4.46,0,0,0,8.92,0V30.36a.9.9,0,0,1,.9-.9H45.54a4.46,4.46,0,0,0,0-8.92Z"/></svg>
                </div>
            </div>
        </template>
        <template class="costs-detail">
            <div class="details">
                <div class="product"><p class="title">Sofa (Wohnzimmer)</p><p class="money">500</p></div>
            </div>
        </template>
        <script src="js/main.js" async defer></script>
        <script src="js/costs.js" async defer></script>
    </body>
</html>