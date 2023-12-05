<?php
session_start();

if (!isset($_SESSION['ID']) || $_SESSION['ID'] !== true) {
    header('Location: Index.php');
    exit();
}
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
        <section class="welcome-section">
            <div class="welcome-container">
                <h1>Welkom <?php echo $_SESSION['Voornaam']; ?> bij onze Dataregistratie site!</h1>
            </div>
        </section>
        <div class="blokmetinfo">
        <h2 style="color:white;">Wat is dit voor Site?</h2><p style="color: white;"><br>We begrijpen hoe belangrijk het is om uw gewerkte uren nauwkeurig bij te houden en te beheren. Of u nu een freelancer bent die zijn factureerbare uren moet registreren, een zelfstandig ondernemer die inzicht wil hebben in projectijd, of een bedrijfseigenaar die de productiviteit van het team wil volgen, onze urenregistratie site biedt u de perfecte oplossing.

</p><br><h2 style="color:white;">Hoe werkt het?</h2><br> <p style="color:white;"> Met behulp van onze intuïtieve en gebruiksvriendelijke interface kunt u moeiteloos uw uren invoeren en organiseren. U kunt uw projecten, klanten en taken gemakkelijk beheren en uw gewerkte uren toewijzen aan de juiste categorieën. Bovendien kunt u belangrijke details en notities toevoegen om een compleet overzicht te behouden.
   <a href="Project-Overzicht.php"><button>Ga Overzicht</button></a>
</div>
        
    </body>
</html>

<style>
  body {
    font-family: 'Open Sans', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    overflow: hidden; /* Ensures the image doesn't overflow the body element */

    /* Set the background image properties */
    background-image: url(fotohome.jpg);
    background-repeat: repeat-x;
    background-position: 0 0;

    /* Define the animation */
    animation: moveBackground 15s linear infinite alternate; /* Alternate between forward and backward */
}

@keyframes moveBackground {
    0% { background-position: 0 0; }
    50% { background-position: -110px 0; } /* Move forward halfway */
    100% { background-position: 0px 0; } /* Move back to the initial position */
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
    border: 2px solid white;
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
    transition-duration: 0.8s; /* Add 's' for seconds */
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

.welcome-section {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 100px);
    
}


.welcome-container {
    background-color: black;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    max-width: 600px;
    text-align: center;
    border: 4px solid white;
    transition-duration: 0.7s;
    opacity: 0.9;
    border-radius: 20px;
    
}

.welcome-container:hover {
    transform: translateY(8px);
    opacity: 1;
}
    
.welcome-container h1 {
    font-size: 30px;
    font-weight: 600;
    color: #333;
    margin: 0;
    color: white;
 
}

@media screen and (max-width: 600px) {
  nav {
    height: auto;
    padding: 0;
  }
  
  nav .Logo p {
    font-size: 24px;
  }
  
  nav ul {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  nav li {
    margin: 10px 0;
  }
  
  nav li a {
    padding: 10px;
    font-size: 18px;
  }
}
.blokmetinfo{
    height: 600px;
    width: 400px;
    position: absolute;
    border: 4px solid white;
    top: 100px;
    left: 100px;
    background-color: black;
    opacity: 0.9;
    transition-duration: 0.7s;
    border-radius: 10px;
}
.blokmetinfo p{
   margin-left: 3px;
} 
.blokmetinfo:hover{
    opacity: 1;
    transform: translateY(2px);
}
p{
    letter-spacing: 1px;
}
h2{
    position: relative;
    left: 80px;
}
button{
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
    left: 50px;
    top: 25px;
    transition-duration: 0.5s;

}
button:hover{
    background-color: rgb(255,255,255);
    color: black;
    transform: translateY(4px);
}
</style>
