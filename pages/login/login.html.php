<?php
require_once "../../connect.php";
$alert = false;
$alert_message = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($_POST['name'] && $_POST['password']) {
        $name = $_POST['name'];
        $hash = hash("md5", $_POST['password']);

        // logowanie

        $con = connect();

        // sprawdź czy użytkownik istnieje
        $stmt = $con->prepare("SELECT * FROM users WHERE login=(?);");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (mysqli_num_rows($result) == 0) {
            $alert = true;
            $alert_message = "Niepoprawna nazwa użytkownika.";
        } else {
            // istnieje
            // sprawdź hasło
            $correct_hash = $row['hash'];
            if ($hash == $correct_hash) {
                // hasło poprawne
                session_start();
                $_SESSION['ID'] = $row['ID'];
                $_SESSION['username'] = $row['login'];
                $_SESSION["email"] = $row["email"];

                header('Location: ../../../index.php');
                exit();

            } else {
                $alert = true;
                $alert_message = "Niepoprawne hasło.";
            }
        }

    } else {
        $alert = true;
        $alert_message = "Wypełnij wszystkie pola.";
    }
}
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
                <li><a href="../kalendarz/kalendarz.html.php">KALENDARZ</a></li>
                <li><a href="../rosliny/rosliny.html.php">MOJE ROŚLINY</a></li>
                <li><a href="../profil/profil.html.php">MÓJ PROFIL </a></li>

            </ul>
        </div>

        <!-- <i class="fa fa-bars" onclick="showMenu()"></i> -->
    </nav>
    <div id="bg">

        <div id="main">
            <div id="back1">
                <img id="backa" src="" alt="bacak" class="backgraun"/>
            </div>

			<div id="box">
			</div> 
			
            <div id="info">

                <h1>Logowanie</h1>
                <h3><?php if($alert) echo $alert_message; ?></h3>
                <h2>nazwa</h2>
                <form action="?action=login" method="post">
                    <input type="text" name="name" class="input" >
                    <h2>hasło</h2>
                    <input type="password" name="password" class="input">
                    <button class="btn" id="loginButton" type="submit" >Zaloguj</button>
                </form>
            </div>

        </div>
        <div id="graphic">  </div>
    </div>



    <footer>
        Autorzy: <br>Katarzyna Ochramowicz, Milena Pawlak, Izabela Owczarek, <br>Przemysław Grubski, Bartosz Janiszewski
    </footer>
</section>

<script src="script.js"></script>
</body>
</html>