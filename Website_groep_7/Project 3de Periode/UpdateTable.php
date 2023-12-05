<?php
require("ConnectN.php");
require('./fpdf185/fpdf.php');

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



//een functie om de data te updaten 
//Connection voor de database
require("ConnectN.php");
$id = $_GET['updateid'];
//Aflezen wat de user input
if(isset($_POST["Submit"])){
    $OV_Nummer = $_POST["OV_Nummer"];
    $Voornaam = $_POST["Voornaam"];
    $Achternaam = $_POST["Achternaam"];
    $Tussenvoegsel = $_POST["Tussenvoegsel"];
    $Projectdatum = $_POST["projectdatum"];
    $Uren = $_POST["Uren"];
    $Projectnummer = $_POST["Projectnummer"];
    $Projectnaam = $_POST["Projectnaam"];
    $Werkzaamheden = $_POST["Werkzaamheden"];

//insert de ingevoerde data in het database
    $sql = "update `urenreg` set ID=$id,OV_Nummer='$OV_Nummer',Voornaam='$Voornaam',Achternaam='$Achternaam',Tussenvoegsel='$Tussenvoegsel',projectdatum='$Projectdatum',Uren='$Uren',
    Projectnummer='$Projectnummer',Projectnaam='$Projectnaam',Werkzaamheden='$Werkzaamheden' where ID='$id'";
    $result= mysqli_query($conn, $sql);

     // Genereer en download de PDF
     $pdf = new FPDF();
     $pdf->AddPage();
     
     $pdf->SetFont('Arial', 'B', 30);
     $pdf->Cell(0, 10, 'Factuur', 0, 1, 'C');
     $pdf->Ln();
     
     // Voeg andere inhoud toe aan de PDF
        
     $pdf->SetFont('Arial', 'B', 16);
     $pdf->Cell(0, 10, 'Uw OV-Nummer:', 0, 1);
     $pdf->SetFont('Arial', '', 12);
     $pdf->Cell(0, 10, $OV_Nummer, 0, 1);
     
     $pdf->SetFont('Arial', 'B', 16);
     $pdf->Cell(0, 10, 'Voornaam:', 0, 1);
     $pdf->SetFont('Arial', '', 12);
     $pdf->Cell(0, 10, $Voornaam, 0, 1);
     
     $pdf->SetFont('Arial', 'B', 16);
     $pdf->Cell(0, 10, 'Achternaam:', 0, 1);
     $pdf->SetFont('Arial', '', 12);
     $pdf->Cell(0, 10, $Tussenvoegsel . ' ' . $Achternaam, 0, 1);
     
     $pdf->SetFont('Arial', 'B', 16);
     $pdf->Cell(0, 10, 'Project-Datum:', 0, 1);
     $pdf->SetFont('Arial', '', 12);
     $pdf->Cell(0, 10, $Projectdatum, 0, 1);
     
     $pdf->SetFont('Arial', 'B', 16);
     $pdf->Cell(0, 10, 'Uren:', 0, 1);
     $pdf->SetFont('Arial', '', 12);
     $pdf->Cell(0, 10, $Uren, 0, 1);
 
     $pdf->SetFont('Arial', 'B', 16);
     $pdf->Cell(0, 10, 'Project-Nummer:', 0, 1);
     $pdf->SetFont('Arial', '', 12);
     $pdf->Cell(0, 10, $Projectnummer, 0, 1);
 
     $pdf->SetFont('Arial', 'B', 16);
     $pdf->Cell(0, 10, 'Project-Naam:', 0, 1);
     $pdf->SetFont('Arial', '', 12);
     $pdf->Cell(0, 10, $Projectnaam, 0, 1);
 
     $pdf->SetFont('Arial', 'B', 16);
     $pdf->Cell(0, 10, 'Werkzaamheden:', 0, 1);
     $pdf->SetFont('Arial', '', 12);
     $pdf->Cell(0, 10, $Werkzaamheden, 0, 1);
 
     $pdf->Ln();
     $pdf->Ln();
     $pdf->Ln();
     $pdf->Ln();
     $pdf->Ln();
     $pdf->Ln();
     $pdf->Ln();
  
 
     
     $pdf->Cell(0, 10, $_SESSION['email'], 'LTRB', 1, 'C');
     // Opslaan van de PDF op de server
     $pdfFilePath = 'factuur.pdf';
     $pdf->Output();
     $pdf->Output($pdfFilePath, 'F');
 
     // E-mail versturen zonder PHPMailer
     $to = $_SESSION['email'];
     $subject = "Factuur";
     $message = "Beste klant,\n\nHierbij ontvangt u de factuur.\n\nMet vriendelijke groet,\nUw bedrijf";
 
     // Genereer willekeurige boundary en mime-versie
     $boundary = md5(time());
     $mimeVersion = "1.0";
 
     // Headers opstellen
     $headers = "From: urenregistratiegilde@gmail.com\r\n";
     $headers .= "Reply-To: urenregistratiegilde@gmail.com\r\n";
     $headers .= "MIME-Version: $mimeVersion\r\n";
     $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
 
     // Berichtinhoud opstellen
     $emailBody = "--$boundary\r\n";
     $emailBody .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
     $emailBody .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
     $emailBody .= $message."\r\n";
 
     // Bijlage toevoegen
     $fileContent = file_get_contents($pdfFilePath);
     $encodedFileContent = chunk_split(base64_encode($fileContent));
     $emailBody .= "--$boundary\r\n";
     $emailBody .= "Content-Type: application/pdf; name=\"factuur.pdf\"\r\n";
     $emailBody .= "Content-Disposition: attachment\r\n";
     $emailBody .= "Content-Transfer-Encoding: base64\r\n\r\n";
     $emailBody .= $encodedFileContent."\r\n";
     $emailBody .= "--$boundary--";
 
     // E-mail verzenden
     if (mail($to, $subject, $emailBody, $headers)) {
         echo "E-mail met PDF-bijlage succesvol verzonden.";
     } else {
         echo "Er is een fout opgetreden bij het verzenden van de e-mail.";
     }
 
     // Verwijder het PDF-bestand van de server
     unlink($pdfFilePath);
 
     // header("location: Project-Overzicht.php");



    if($result) {
        // header('Location: Project-Overzicht.php');
        // header('location: Project-Overzicht.php');
    }
    else {
        die(mysqli_error($conn));
    }
}
$id = $_GET['updateid'];
$sql = "SELECT * FROM urenreg WHERE ID = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$conn->close();


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Uren-Registratie</title>
        <meta name="Igor Laska" content="Uren-Registratie Groep 2">
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link rel="stylesheet" href="./Css-Styles/TableUpdate.css?v=<?php echo time(); ?>">
 
        </div> 
            <div class="registratie-container">
            <form action="" method="POST">

            <div class="Title"><h3>Update kolom:</h3></div>
                <!-- for gegevens maken zodat de user ze kan invoeren -->
                <div class="tekst-input">
                    <div class="titel"><span style="white-space: nowrap;"><b>OV Nummer:</b></div>
                    <input class="input" name="OV_Nummer" type="text" placeholder="Voer je OV-nummer in." value="<?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo $row['OV_Nummer'];}  else {echo $ov_nummer;} ?>"  <?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo '';} else {echo 'readonly';}?>>
                </div>

                <div class="tekst-input">
                    <div class="titel"><b>Voornaam:</b></div>
                    <input required class="input" name="Voornaam" type="text" placeholder="Voer je Voornaam in." value="<?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo $row['Voornaam'];}  else {echo $_SESSION['Voornaam'];} ?> " <?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo '';} else {echo 'readonly';}?>>
                </div>

                <div class="tekst-input">
                    <div class="titel"><b>Tussenvoegsel:</b></div>
                    <input class="input" name="Tussenvoegsel" type="text" value="<?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo $row['Tussenvoegsel'];} else{ echo $_SESSION['Tussenvoegsel'];}?>" <?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo $row['Tussenvoegsel'];} else {echo 'readonly';}?>>
                </div>

                <div class="tekst-input">
                    <div class="titel"><b>Achternaam:</b></div>
                    <input required class="input" name="Achternaam" type="text" placeholder="Voer je Achternaam in." value="<?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo $row['Achternaam'];} else {echo $_SESSION['Achternaam'];} ?> " <?php if($_SESSION['gebruikersnaam'] == 'Admin'){echo '';} else {echo 'readonly';}?>>
                </div>
                <div class="tekst-input">
                    <div class="titel"><span style="white-space: nowrap;"><b>Project Datum:</b></div>
                    <input required class="input" value="<?php echo $row['projectdatum']; ?>" name="projectdatum" type="date" placeholder="0000-00-00">
                </div>
                <div class="tekst-input">
                    <div class="titel"><b>Uren:</b></div>
                    <input required class="input" value="<?php echo $row['Uren']; ?>" name="Uren" type="number" placeholder="Voer je Uren in.">
                </div>
                <div class="tekst-input">
                    <div class="titel"><b>Projectnummer:</b></div>
                    <input required class="input" name="Projectnummer" value="<?php echo $row['Projectnummer']; ?>" type="number" placeholder="Voer je Projectnummer in.">
                </div>
                <div class="tekst-input">
                    <div class="titel"><b>Projectnaam:</b></div>
                    <input required class="input" name="Projectnaam" type="text" value="<?php echo $row['Projectnaam']; ?>" placeholder="Voer je Projectnaam in.">
                </div>
                <div class="tekst-input">
                    <div class="titel"><b>Werkzaamheden:</b></div>
                    <input class="input" name="Werkzaamheden" value="<?php echo $row['Werkzaamheden']; ?>" type="text" placeholder="Voer je Werkzaamheden in.">
                </div>
                    <input required class="Submit" name="Submit" type="Submit" value="Submit">
                <div class="Backknop">
                    <a class="terug" href="Project-Overzicht.php">Back</a>
                </div>
            </div>
    </body>
</html>
