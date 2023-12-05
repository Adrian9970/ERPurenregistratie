<?php
require("ConnectN.php");
session_start();    


if (!isset($_SESSION['ID']) || $_SESSION['ID'] !== true) {

    header('Location: Index.php');
    exit();
}

if (isset($_GET['logout'])) {

    session_unset();

    session_destroy();

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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1 style="position: absolute; top: 35px;"><a href = "Home.php">Terug</a></h1>
    <center><h1>Profile Page</h1></center>
    <h1><a href="Index.php?logout=true" style="position: relative; left: 1350px; top: -19px;">Log uit</a></h1>
  </header>
  <main>
    <h3>Hallo, <?php echo $_SESSION['Voornaam'] . ' ' . $_SESSION['Tussenvoegsel'] . ' ' . $_SESSION['Achternaam']; ?></h3>
    <h3>Uw E-mail: <?php echo $_SESSION['email'];?></h3>
    <h3>Uw OV-nummer: <?php echo $ov_nummer;?></h3>
  </main>
  <footer>
    <p>&copy; 2023 My Website. All Rights Reserved.</p>
  </footer>
</body>
</html>

<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
}

header {
  background-color: #333;
  color: #fff;
  padding: 10px;
}

header h1 {
  margin: 0;
}

main {
  max-width: 800px;
  margin: 0 auto;
  background-color: #fff;
  padding: 20px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

main h3 {
  margin-top: 0;
}

footer {
  background-color: #333;
  color: #fff;
  padding: 10px;
  text-align: center;
}

footer p {
  margin: 0;
}
a {
    text-decoration: none;
    color: inherit;
  }

</style>