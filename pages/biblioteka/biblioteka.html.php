<?php
require_once "../../connect.php";
session_start();

if(!isset($_SESSION['ID'])) {
    header('Location: ../../index.php');
    exit();
}

$username = $_SESSION["username"];
$ID = $_SESSION["ID"];

$rows = [];

if (isset($_GET['action'])) {
    if ($_GET['action'] == "search") {
        $search = $_POST['query'];
        $rows = searchPlants($search, $ID);
    } else if ($_GET['action'] == "add") {
        $plant_ID = $_POST['plant_ID'];
        addToProfile($plant_ID, $ID);
    }
}

function searchPlants($search, $ID) {
    $con = connect();
    $search = "%$search%";
    $stmt= $con->prepare("SELECT DISTINCT plants.ID, plant_name, picture, description, water, d_level, toxicity
                FROM plants LEFT JOIN owned ON plants.ID=owned.plant_ID WHERE plant_name LIKE (?)
                AND (owned.user_ID!=(?) OR owned.user_ID IS NULL)");
    $stmt->bind_param('si', $search, $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = array();

    while($row = $result->fetch_assoc())
    {
        array_push($rows, $row);
    }

    return $rows;
}

function addToProfile($plant_ID, $user_ID) {
    $con = connect();
    $stmt = $con->prepare("INSERT INTO owned (plant_ID, user_ID) VALUES (?, ?)");
    $stmt->bind_param('ii', $plant_ID, $user_ID);
    $stmt->execute();
    $result = $stmt->get_result();
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;600;700&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/2aa976259f.js" crossorigin="anonymous"></script>
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
                    <li><a href="biblioteka.html.php">BIBLIOTEKA</a></li>
                    <li><a href="../kalendarz/kalendarz.html.php">KALENDARZ</a></li>
                    <li><a href="../rosliny/rosliny.html.php">MOJE ROŚLINY</a></li>
                    <li><a href="../profil/profil.html.php">MÓJ PROFIL </a><?php echo $username; ?></li>

                </ul>
            </div>
            <!-- <i class="fa fa-bars" onclick="showMenu()"></i> -->
        </nav>
        <div id="bg">
            <div id="main">
                <div id="searcher">

                    <!-- <button id="search" class="action-btn">
                        <img src="../images/search-i.jpg" alt="ikona">
                    </button> -->
                    <form action="?action=search" method="post" >
                        <input id="searchText" name="query" placeholder="Wyszukaj roślinę">
                        <button class="btn btn-search" id="searchButton" type="submit" ><i class="fa fa-search fa-2x" aria-hidden="true"></i></button>

                    </form>

                </div>
                <div id="bg">
                    <div id="main">
                    <?php

                    foreach($rows as $row) {
                            echo
                                "<div  class='PlantInfoDiv'>
                            <div id='picture' class='profil_pic_div'>
                                <img src=".$row['picture']." id='photo' alt='Profil picture' class='image'/>	
                            </div>
                            
                            <div id='info' class='infotext'> 
                                <p class='info_plant_text'>nazwa:</p>   	
                                <p class='info_plant name'>".$row['plant_name']."</p> <br>
                                
                                <p class='info_plant_text'>opis:</p> 	
                                <p class='info_plant desc'>".$row['description']."</p>	<br>
                                
                                <p class='info_plant_text'>nawodnienie:</p> 	
                                <p class='info_plant water'>".$row['water']."</p> <br>
                                
                                <p class='info_plant_text'>trudność:</p> 	
                                <p class='info_plant d_lev'>".$row['d_level']."</p>	<br>
                                
                                <p class='info_plant_text'>toksyczność:</p> 	
                                <p class='info_plant toxic'>".$row['toxicity']."</p>	<br>
                            </div>
                            <div class='bform'>
                                <div class='form_btn'>
                                <form action='?action=add' method='post'>
                                    <input type='hidden' name='plant_ID' value=".$row['ID'].">
                                    
                                    <button class='btn add_btn plus' type='submit'><i class='fa fa-solid fa-plus fa-lg'></i></button>
                                    <button class='btn add_btn add_txt' id='addButton' type='submit' >Dodaj do profilu</button>  
                                                         
                                </form >
                                </div>
                             </div>
                            </div>";
                    }

                    ?>
                    </div>
                </div>

                <!--
                <table>
                <br><br>
                <h2>A</h2>
                <table>
                </table>

                <br><br>
                <h2>B</h2>
                <table>
                </table>

                <br><br>
                <h2>C</h2>
                <table>
                </table>

                <br><br>
                <h2>D</h2>
                <table>
                </table>

                <br><br>
                <h2>E</h2>
                <table>
                </table>


                <br><br>
                <h2>F</h2>
                <table>
                </table>


                <br><br>
                <h2>G</h2>
                <table>
                </table>


                <br><br>
                <h2>H</h2>
                <table>
                </table>


                <br><br>
                <h2>J</h2>
                <table>
                </table>


                <br><br>
                <h2>K</h2>
                <table>
                </table>


                <br><br>
                <h2>L</h2>
                <table>
                </table>


                <br><br>
                <h2>M</h2>
                <table>
                </table>


                <br><br>
                <h2>N</h2>
                <table>
                </table>


                <br><br>
                <h2>O</h2>
                <table>
                </table>
            </table>
                -->
            </div>

        </div>

        </div>
        <div class="ftr">
        <footer>
            Autorzy: <br>Katarzyna Ochramowicz, Milena Pawlak, Izabela Owczarek, <br>Przemysław Grubski, Bartosz
            Janiszewski
        </footer>
        </div>
    </section>
    <script src="script.js"></script>
</body>

</html>