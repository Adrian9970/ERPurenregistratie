<?php
// Verbind met de database
$conn = mysqli_connect("localhost", "root", "", "urenregistratiedata");

// Controleer of de verbinding is geslaagd
if (!$conn) {
  die("Verbinding mislukt: " . mysqli_connect_error());
}

// Ontvang de gegevens van de POST-request
$gebruikersnaam = mysqli_real_escape_string($conn, $_POST['gebruikersnaam']);
$wachtwoord = mysqli_real_escape_string($conn, $_POST['wachtwoord']);
$email = mysqli_real_escape_string($conn, $_POST['email']);

// Versleutel het wachtwoord
$wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

// Voeg de gegevens toe aan de database
$sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord, email) VALUES ('$gebruikersnaam', '$wachtwoord', '$email')";
if (mysqli_query($conn, $sql)) {
  echo "Gebruiker toegevoegd";
} else {
  echo "Fout bij het toevoegen van gebruiker: " . mysqli_error($conn);
}

// Sluit de databaseverbinding
mysqli_close($conn);
?>