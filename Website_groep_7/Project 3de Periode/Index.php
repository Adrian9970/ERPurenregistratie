
<?php

session_start();

// if (isset($_SESSION['ID']) && $_SESSION['ID'] === true) {
//     header('Location: Home.php');
//     exit();
// }


// De rest van de inhoud van de homepagina



$conn = mysqli_connect("localhost", "root", "", "urenregistratiedata");

if (!$conn) {
    die("Verbinding mislukt: " . mysqli_connect_error());
}

if (isset($_POST['register'])) {
    $gebruikersnaam = mysqli_real_escape_string($conn, $_POST['gebruikersnaam']);
    $wachtwoord = mysqli_real_escape_string($conn, $_POST['wachtwoord']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $voornaam = mysqli_real_escape_string($conn, $_POST['Voornaam']);
    $tussenvoegsel = mysqli_real_escape_string($conn, $_POST['Tussenvoegsel']);
    $achternaam = mysqli_real_escape_string($conn, $_POST['Achternaam']);

    $check_sql = "SELECT * FROM gebruikers WHERE gebruikersnaam='$gebruikersnaam'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        echo "Gebruikersnaam bestaat al";
        exit();
    }

    $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord, email, Voornaam, Tussenvoegsel, Achternaam) VALUES ('$gebruikersnaam', '$wachtwoord', '$email', '$voornaam', '$tussenvoegsel', '$achternaam')";
    $sql2 = "INSERT INTO medewerkers (Voornaam, Achternaam, Tussenvoegsel) VALUES('$voornaam', '$achternaam', '$tussenvoegsel')";
    if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql2)) {
      $_SESSION['gebruikersnaam'] = $gebruikersnaam;
      header('Location: index.php');
      exit();
  } else {
      echo "Fout bij het toevoegen van gebruiker: " . mysqli_error($conn);
  }
  
}

if (isset($_POST['login'])) {
    $gebruikersnaam = mysqli_real_escape_string($conn, $_POST['gebruikersnaam']);
    $wachtwoord = mysqli_real_escape_string($conn, $_POST['wachtwoord']);

    $sql = "SELECT * FROM gebruikers WHERE gebruikersnaam='$gebruikersnaam'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($wachtwoord == $row['wachtwoord']) {
            $_SESSION['ID'] = true;
            $id = $row['ID'];
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
            $voornaam = $row['Voornaam'];
            $_SESSION['Voornaam'] = $voornaam;
            $achternaam = $row['Achternaam'];
            $_SESSION['Achternaam'] = $achternaam;
            $tussenvoegsel = $row['Tussenvoegsel'];
            $_SESSION['Tussenvoegsel'] = $tussenvoegsel;
            $email = $row['email'];
            $_SESSION['email'] = $email;
            header('Location: Home.php');
            exit();
        }
    }
    
    echo "Fout bij het inloggen: onjuiste gebruikersnaam of wachtwoord";
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
  <title>Registratie en Login</title>
</head>
<body>

<div id="container">
  <form class="regi" method="post">
    <h2 style="position: relative; left: 150px;">Registreer</h2>
    <label for="gebruikersnaam">Gebruikersnaam:</label>
    <input type="text" id="gebruikersnaam" name="gebruikersnaam" required><br><br>
    <label for="wachtwoord">Wachtwoord:</label>
    <input type="password" id="wachtwoord" name="wachtwoord" required><br><br>
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required><br><br>
    <label for="Voornaam">Voornaam:</label>
    <input type="text" id="Voornaam" name="Voornaam" required><br><br>
    <label for="Tussenvoegsel">Tussenvoegsel:</label>
    <input type="text" id="Tussenvoegsel" name="Tussenvoegsel"><br><br>
    <label for="Achternaam">Achternaam:</label>
    <input type="text" id="Achternaam" name="Achternaam" required><br><br>
    <input class="knop1" type="submit" name="register" value="Create" required>
    <input class="knop2" type="button" value="Ga naar Login" onclick="openLoginModal()">
  </form>


  <form class="login" id="login" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2 style="position: relative; left: 170px;">Login</h2>
    <label for="gebruikersnaam">Gebruikersnaam:</label>
    <input type="text" id="gebruikersnaam" name="gebruikersnaam" required><br><br>
    <label for="wachtwoord">Wachtwoord:</label>
    <input type="password" id="wachtwoord" name="wachtwoord" required><br><br>
    <input class="knop1" type="submit" name="login" value="Login" required>    
    <input class="knop3" type="button" value="Ga naar Registratie" onclick = "openRegiModal()">
  </form>
  <canvas id="canvas"></canvas>
</div>

</body>
<script>
    let Gebruiker = document.getElementById("Gebruikersnaam");
    let Wacht = document.getElementById("Wachtwoord");
    let E = document.getElementById("Email");

    function maakaccount(){
        let Gebruikersnaam = Gebruiker.value;
        let Wachtwoord = Wacht.value;
        let Email = E.value;
        document.write(Gebruikersnaam);
    }
    var login =document.querySelector(".login");
    var regi =document.querySelector(".regi");
   

    function openLoginModal() {
       login.style.display = "block";
       regi.style.display = "none";
}
    function openRegiModal(){
       login.style.display = "none";
       regi.style.display = "block";
    }

</script>
<style>
  
    form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 2px solid #ccc;
  border-radius: 10px;
  position: relative;
  top: 100px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-size: 20px;
  font-family: sans-serif;
}

input[type="text"],
input[type="password"],
input[type="email"] {
  display: block;
  width: 96%;
  padding: 10px;
  margin-bottom: 20px;
  border: 2px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}

.knop1 {
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
}
.knop2 {
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
  left: 130px;
  position: relative;
}
.knop3 {
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
  left: 90px;
  position: relative;
}
.knop1:hover{
  background-color: #fff;
    color: black;
    box-shadow: 0px 5px 10px rgba(0, 0, 0);
}
.knop2:hover{
  background-color: #fff;
    color: black;
    box-shadow: 0px 5px 10px rgba(0, 0, 0);
}
.knop3:hover{
  background-color: #fff;
    color: black;
    box-shadow: 0px 5px 10px rgba(0, 0, 0);
}
input[type="button"]:hover {
  background-color: #fff;
    color: black;
    box-shadow: 0px 5px 10px rgba(0, 0, 0);
}
.login{
    display: none;
    top: 240px;
    border: 4px solid gray;
}
.regi{
    top: 10px;
    border: 4px solid gray;
}
h2{
  font-family: sans-serif;
}
#container {
      position: relative;
    }
#canvas {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }
</style>
</html>