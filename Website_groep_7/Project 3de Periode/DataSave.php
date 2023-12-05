<?php
require('./fpdf185/fpdf.php');


if (isset($_POST["Submit"])) {
    session_start();
    $OV_Nummer = $_POST["OV_Nummer"];
    $Voornaam = $_POST["Voornaam"];
    $Achternaam = $_POST["Achternaam"];
    $Tussenvoegsel = $_POST["Tussenvoegsel"];
    $Projectdatum = $_POST["projectdatum"];
    $Uren = $_POST["Uren"];
    $Projectnummer = $_POST["Projectnummer"];
    $Projectnaam = $_POST["Projectnaam"];
    $Werkzaamheden = $_POST["Werkzaamheden"];

    $query = "INSERT INTO urenreg VALUES('$OV_Nummer', '$Voornaam', '$Achternaam', '$Tussenvoegsel', '$Projectdatum', '$Uren', '$Projectnummer', '$Projectnaam', '$Werkzaamheden', '')";
    mysqli_query($conn, $query);

    // Genereer de PDF
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

    $pdf->SetFont('Arial', 'B' ,16);
    $pdf->Cell(0,10, 'Uw Tarief is:',0,1);
    $pdf->SetFont('Arial','B', 16);
    $pdf->Cell(0,10, '$' . $Uren * 2);

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
}
?>
