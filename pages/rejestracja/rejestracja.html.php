<?php
require_once "../../connect.php";
$alert = false;
$alert_message = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($_POST['name'] && $_POST['password'] && $_POST['email']) {
        $name = $_POST['name'];
        $hash = hash("md5", $_POST['password']);
        $email = $_POST['email'];

        if (!validateLogin($name)) {
            $alert = true;
            $alert_message = "Nazwa użytkownika zajęta.";
        } else if (!validatePassword($_POST['password'])) {
            $alert = true;
            $alert_message = "Hasło powinno mieć przynajmniej 8 znaków.";
        } else {
            register($name, $hash, $email);
        }
    } else {
        $alert = true;
        $alert_message = "Wypełnij wszystkie pola.";
    }
}

function validateLogin($name) {
    $con = connect();
    $stmt_val = $con->prepare("SELECT * from users WHERE login=(?)");
    $stmt_val->bind_param('s', $name);
    $stmt_val->execute();
    if ($stmt_val->get_result()->fetch_assoc() == NULL) {
        return true;
    } else {
        return false;
    }
}

function validatePassword($password) {
    if (strlen($password) < 8) {
        return false;
    } else {
        return true;
    }
}

function register($name, $hash, $email) {
    $con = connect();
    $stmt = $con->prepare("INSERT INTO users (login, hash, email)
            VALUES(?, ?, ?);");
    $stmt->bind_param('sss', $name, $hash, $email);
    $stmt->execute();
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
                <li><a href="../index.html">STRONA GŁÓWNA</a></li>
                <li><a href="../biblioteka/biblioteka.html.php">BIBLIOTEKA</a></li>
                <li><a href="../kalendarz/kalendarz.html.php">KALENDARZ</a></li>
                <li><a href="../rosliny/rosliny.html.php">MOJE ROŚLINY</a></li>
                <li><a href="../profil/profil.html.php">MÓJ PROFIL</a></li>

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

                <h1>Zarejestruj mnie!</h1>

                <h3 name="alert"><?php if ($alert) echo $alert_message; ?></h3>

                <h2>nazwa</h2>
                <form action="?action=register" method="post">
                    <input type="text" name="name" class="input" >
                    <h2>hasło</h2>
                    <input type="password" name="password" class="input">
                    <h2>email</h2>
                    <input type="email" name="email" class="input">
                    <img class="girl" src="../images/girl.png" alt="girl">
                    <br></br>
                    <button class="btn" id="registerButton" type="submit" >Zarejestruj</button>
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