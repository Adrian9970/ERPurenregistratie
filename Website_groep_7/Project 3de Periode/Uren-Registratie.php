<?php

require("ConnectN.php");
require("DataSave.php");



session_start();

if (!isset($_SESSION['ID']) || $_SESSION['ID'] !== true) {

    header('Location: Index.php');
    exit();
}


if (!isset($_SESSION['ID']) || $_SESSION['ID'] !== true) {
    header('Location: Index.php');
    exit();
}




$sql = "SELECT ID FROM gebruikers WHERE gebruikersnaam = '{$_SESSION['gebruikersnaam']}'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();  
    $ov_nummer = $row['ID'];
}
else {
    $ov_nummer = "";
}
$conn->close();
?>




<!DOCTYPE html>
<html>
<head>
    <title>Startpagina</title>
    <meta name="Igor Laska" content="Startpagina Groep 2">
    <link rel="stylesheet" href="./Css-Styles/Startpagina-Style.css?v=<?php echo time(); ?>">

    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="nav-section">
    <nav style="background-color: grey">
        <div class="logo" style="background-color: grey">
            <a href="Home.php"><h1 style="color: white;">Startpagina</h1></a>
        </div>
        <ul style="background-color: grey">
            <li><a href="Project-Overzicht.php" style="color: white">Project overzicht</a></li>
            <li><a href="Uren-Registratie.php" style="color: white">Uren registratie</a></li>
            <li><a href="Profiel.php" style="color: white">Profiel</a></li>
        </ul>
    </nav>
</div>
        </div> <!-- Form aanmaken voor de input voor de database -->
            <div class="registratie-container">
            <form action="" method="POST">
                

            <div class="Title"><h3>Vul je gegevens in</h3></div>
                <!-- for gegevens maken zodat de user ze kan invoeren -->
                

                <!-- for gegevens maken zodat de user ze kan invoeren -->
                <div class="tekst-input">
                    <div class="titel"><span style="white-space: nowrap;"><b>OV Nummer:</b></div>
                    <input class="input" name="OV_Nummer" type="text" placeholder="Voer je OV-nummer in." value="<?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo '';}  else {echo $ov_nummer;} ?>"  <?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo '';} else {echo 'readonly';}?>>
                </div>

                <div class="tekst-input">
                    <div class="titel"><b>Voornaam:</b></div>
                    <input required class="input" name="Voornaam" type="text" placeholder="Voer je Voornaam in." value="<?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo '';}  else {echo $_SESSION['Voornaam'];} ?> " <?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo '';} else {echo 'readonly';}?>>
                </div>

                <div class="tekst-input">
                    <div class="titel"><b>Tussenvoegsel:</b></div>
                    <input class="input" name="Tussenvoegsel" type="text" value="<?php echo $_SESSION['Tussenvoegsel'];?>" <?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo '';} else {echo 'readonly';}?>>
                </div>

                <div class="tekst-input">
                    <div class="titel"><b>Achternaam:</b></div>
                    <input required class="input" name="Achternaam" type="text" placeholder="Voer je Achternaam in." value="<?php echo $_SESSION['Achternaam'];?>" <?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo '';} else {echo 'readonly';}?>>
                </div>
                <div class="tekst-input">
                    <div class="titel"><span style="white-space: nowrap;"><b>Project Datum:</b></div>
                    <input required class="input" name="projectdatum" type="date" placeholder="0000-00-00">
                </div>
                <div class="tekst-input">
                    <div class="titel"><b>Uren:</b></div>
                    <input required class="input" name="Uren" type="number" placeholder="Voer je Uren in." oninput="if(this.value<0) this.value=0; if(this.value>24) this.value=24;">
                </div>
                <div class="tekst-input">
                    <div class="titel"><b>Projectnummer:</b></div>
                    <input required class="input" name="Projectnummer" type="number" placeholder="Voer je Projectnummer in." oninput="if(this.value<0)this.value=0">
                </div>
                <div class="tekst-input">
                    <div class="titel"><b>Projectnaam:</b></div>
                    <input required class="input" name="Projectnaam" type="text" placeholder="Voer je Projectnaam in.">
                </div>
                <div class="tekst-input">
                    <div class="titel"><b>Werkzaamheden:</b></div>
                    <input class="input" name="Werkzaamheden" type="text" placeholder="Voer je Werkzaamheden in.">
                </div>
                    <input required class="Submit" name="Submit" type="Submit" value="Submit">
            </div>
        </div>
    </body>
</html>
<style>
    body {
    font-family: 'Open Sans', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    background-image: url(fotoregiupdate.jpg);
    background-repeat: repeat-x;
    background-position: 0 0;

  /* Define the animation */
  animation: moveBackground 100s linear infinite;
}

@keyframes moveBackground {
    0% { background-position: 0 0; }
    50% { background-position: -110px 0; } 
    100% { background-position: 110px 0; } 
}
.nav-section {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(80px);
    position: relative;
    transition-duration:  0.5s;
    
}
.nav-section:hover {
    transform: translateY(45px);
}
nav {
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    padding: 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    opacity: 0.8;
    transition-duration: 0.6s;
    top: -50px;
    position: relative;
}
nav:hover {
    opacity: 1;
}
.logo h1 {
    font-size: 24px;
    font-weight: 600;
    margin: 0;
    padding: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    left: 100px;
    transition-duration: 0.8s; 
}

.logo h1:hover {
    transform: translateY(4px);
    
}
nav ul {
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition-duration: 0.8s;
}

nav ul li {
    list-style: none;
    margin-right: 30px;
    transition-duration: 0.8s;
}

nav ul li:last-child {
    margin-right: 0;
}
nav ul li:hover {
    transform: translateY(4px);
}
nav ul li a {
    color: #333;
    font-size: 16px;
    text-decoration: none;
    transition-duration: 0.8s;
}

nav ul li a:hover {
    color: #666;
    transform: translateY(4px);
}
.registratie-container {
    width: 500px;
    height: auto;
    padding: 50px 30px;
    margin: 30px auto;
    background-color: #1a1720;
    box-shadow:  5px 10px #020202;
    border: 4px solid white;
    color: white;
}

.tekst-input {
    width: 100%;
    height: 30px;
    margin-bottom: 15px;
    font-family:'Times New Roman', Times, serif;
    font-size: 19px;
}

.titel {
    width: 100px;
    height: 20px;
    float: left;
    margin-top: 5px;
}

.input {
    width: auto;
    height: 20px;
    float: right;
    padding: 13px 6px;
    border: none;
    border-bottom: 2px solid #ccc;
    background-color: #f7f7f7;
    color: #333;
    font-size: 16px;
    transition: border-bottom-color 0.3s ease;
    font-family: sans-serif;
  }
  
  .input:focus {
    outline: none;
    border-bottom-color: #4c8bf5;
  }
  
  .input::placeholder {
    color: #999;
  }

.Submit {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    background-color: black;
    border-radius: 50px;
    border: none;
    box-shadow: 0px 5px 10px rgba(255, 255, 255);
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    position: relative;
    left: 38%;
    bottom: -10px;
}

.Submit:hover {
    background-color: #fff;
    color: black;
    box-shadow: 0px 5px 10px rgba(0, 0, 0);
}


.Title, h3 {
    text-align: center;
    margin-bottom: 40px;
}
b{
    font-family: sans-serif;
}

</style>