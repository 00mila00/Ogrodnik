<?php
require_once "../../connect.php";
session_start();

if(!isset($_SESSION['ID'])) {
    header('Location: ../../index.php');
    exit();
}

$username = $_SESSION["username"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;600;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../style.css"> -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="icon" href="../images/leaf.png">
    <title>Gardening app</title>
</head>
<body>
    <section class="header">
    <nav>
        <a href="../index.html"><img src="../images/logo.png" alt="logo"></a>

        <div class="nav-links" id="navLinks">
            <!-- <i class="fa fa-times" onclick="hideMenu()"></i> -->
            
            <ul>
                <li><a href="../biblioteka/biblioteka.html.php">BIBLIOTEKA</a></li>
                <li><a href="kalendarz.html.php">KALENDARZ</a></li>
                <li><a href="../rosliny/rosliny.html.php">MOJE ROŚLINY</a></li>
                <li><a href="../profil/profil.html.php">MÓJ PROFIL </a><?php echo $username; ?></li>
             
            </ul>
        </div>
        <!-- <i class="fa fa-bars" onclick="showMenu()"></i> -->
    </nav>
    <div id="bg">
    <div id="main">
    <div id ="out">
    <div id="container">
        <div id="headr">
            <p id="demo"></p>

            <div id="monthDisplay"></div>
            <div>
                <button id="backButton">Poprzedni</button>
                <button id="nextButton">Następny</button>
            </div>
        </div>
        <div id="weekdays">
            <div>Niedziela</div>
            <div>Poniedzialek</div>
            <div>Wtorek</div>
            <div>Środa</div>
            <div>Czwartek</div>
            <div>Piątek</div>
            <div>Sobota</div>
        </div>
        <div id="calendar"></div>
    </div>
    <div id="newEventModal">
        <h2>Ustaw powiadomienie</h2>
        <input id= "eventTitleInput" placeholder = "Tytuł">

        <button id="saveButton">Zapisz</button>
        <button id="cancelButton">Anuluj</button>
    </div>
    <div id="deleteEventModal">
        <h2>Powiadomienie</h2>
        <p id="eventText"></p>
        <button id="deleteButton">Usuń</button>
        <button id="closeButton">Zamknij</button>

    </div>
    <div id="modalBackDrop"></div>

</div>
</div>
<footer>
    <br>Autorzy: <br>Katarzyna Ochramowicz, Milena Pawlak, Izabela Owczarek, <br>Przemysław Grubski, Bartosz Janiszewski
</footer>
</div>
</section>
    <script src="script.js"></script>

</body>
</html>