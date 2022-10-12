<?php
require_once "../../connect.php";

session_start();

if(!isset($_SESSION['ID'])) {
    header('Location: ../../index.php');
    exit();
}

$username = $_SESSION["username"];
$id = $_SESSION['ID'];
$info = retrieveProfileInfo($id);

if (isset($_GET['action'])) {
    if ($_GET['action'] == "update") {
        $new_username = $_POST['username'];
        $new_email = $_POST['email'];
        $new_birthday = $_POST['birthday'];
        $new_gender = $_POST['gender'];

        update($new_username, $new_email, $new_birthday, $new_gender, $id);
    } else if($_GET['action'] == "changePicture") {
        $new_picture = $_POST['file'];

        changePicture($new_picture, $id);
    }
    else if ($_GET['action'] == "logout") {
        session_destroy();
        header('Location: ../../index.php');
        exit();
    }
}

function update($username, $email, $birthday, $gender, $id) {
    $con = connect();
    $stmt = $con->prepare("UPDATE users SET login = (?), email = (?), birthday = (?), gender = (?) WHERE ID = (?)");
    $stmt->bind_param('ssssi', $username, $email, $birthday, $gender, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $_SESSION["username"] = $username;
    retrieveProfileInfo($id);
    header('Location: ./profil.html.php');
}

function retrieveProfileInfo($id) {
    $con = connect();
    $stmt = $con->prepare("SELECT * from users WHERE ID = (?)");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function changePicture($picture, $id) {
    $con = connect();
    $stmt = $con->prepare("UPDATE users SET picture = (?) WHERE ID = (?)");
    $stmt->bind_param('si', $picture, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    retrieveProfileInfo($id);
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
                <li><a href="profil.html.php">MÓJ PROFIL </a><?php echo $username; ?></li>
             
            </ul>
        </div>
        <!-- <i class="fa fa-bars" onclick="showMenu()"></i> -->
    </nav>
    <div id="bg">
		
        <div id="main">
		<!--../images/logo.png"-->
			<div id="picture" class="profil_pic_div">
                <form action="?action=changePicture" method="post">
				<img src="../images/logo_prof.png" id="photo" alt="Profil picture" class="image"/>
				<input type="file" id="file">
<!--				<label for="file" id="uploadBtn" type="submit"> Zmień </label>-->
                </form>
			</div>
			<div id="back1">
				<img id="backa" src="../images/background_prof.png" alt="bacak" class="backgraun"/>
			</div>
		
			<div id="info">
			
				<h1>Mój profil</h1>

                <form action="?action=update" method="post">
                    <div class="form1">
                    <h2>nazwa</h2>
                        <label>
                            <input type="text" name="username" class="input" value=<?php echo $username; ?>>
                        </label>
                        <h2>urodziny</h2>
<!--                    <input type="text" class="input" value="">-->
                        <label>
                            <input type="date" class="input" name='birthday' value=<?php echo $info['birthday']; ?>>
                        </label>
                        <h2>płeć</h2>
                        <label>
                            <input type="text" name="gender" class="input" value=<?php echo $info['gender']; ?>>
                        </label>
                        <h2>email</h2>
                        <label>
                            <input type="email" name="email" class="input" value=<?php echo $info['email']; ?>>
                        </label>
                    </div>
                    <button class="btn" id="updateButton" type="submit" >AKTUALIZUJ</button>
                </form>

                <form action="?action=logout" method="post">
                    <button class="btn" id="logoutButton" type="submit" >WYLOGUJ SIĘ</button>
                </form>

			</div>
			
        </div>
<!--		<div class="graphic" id="graphic"> <img class="icon_footer" src="../images/leaf.png"> </div>-->
    </div>

	
    <footer>
        Autorzy: <br>Katarzyna Ochramowicz, Milena Pawlak, Izabela Owczarek, <br>Przemysław Grubski, Bartosz Janiszewski
    </footer>
    </section>

<script src="script.js"></script>
</body>   
</html>
