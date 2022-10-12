<?php
    require_once "../../connect.php";
    session_start();

    if(!isset($_SESSION['ID'])) {
        header('Location: ../../index.php');
        exit();
    }

    $username = $_SESSION["username"];
    $id = $_SESSION['ID'];

    // pobierz rosliny z bazy danych
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM plants INNER JOIN owned ON plants.ID=owned.plant_ID WHERE user_ID=(?)");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
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
                <li><a href="rosliny.html.php">MOJE ROŚLINY</a></li>
                <li><a href="../profil/profil.html.php">MÓJ PROFIL </a><?php echo $username; ?></li>
             
            </ul>
        </div>
        <!-- <i class="fa fa-bars" onclick="showMenu()"></i> -->
    </nav>
    <div id="bg">
        <div id="main">
			<?php

            $row = $result->fetch_assoc();

            while($row!= null) {

                echo
                "<div  class='PlantInfoDiv'>
				<div id='picture' class='profil_pic_div'>
					<img src=".$row['picture']." id='photo' alt='Profil picture' class='image'/>	
				</div>
				
				<div id='info' class='infotext'> 
					<p class='info_plant_text'>nazwa:</p>   	
					<p class='info_plant'>".$row['plant_name']."</p> <br>
					
					<p class='info_plant_text'>opis:</p> 	
					<p class='info_plant'>".$row['description']."</p>	<br>
					
					<p class='info_plant_text'>nawodnienie:</p> 	
					<p class='info_plant'>".$row['water']."</p> <br>
					
					<p class='info_plant_text'>trudność:</p> 	
					<p class='info_plant'>".$row['d_level']."</p>	<br>
					
					<p class='info_plant_text'>toksyczność:</p> 	
					<p class='info_plant'>".$row['toxicity']."</p>	<br>
				</div>
			</div>
                ";

                $row = $result->fetch_assoc();
            }

            ?>

        </div>
    </div>
	
    <footer>
        Autorzy: <br>Katarzyna Ochramowicz, Milena Pawlak, Izabela Owczarek, <br>Przemysław Grubski, Bartosz Janiszewski
    </footer>
    </section>
<script src="script.js"></script>
</body>
</html>    
