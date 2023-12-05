<?php
require('./fpdf185/fpdf.php');
session_start();

if (!isset($_SESSION['ID']) || $_SESSION['ID'] !== true) {

    header('Location: Index.php');
    exit();
}
$conn = mysqli_connect("localhost", "root", "", "urenregistratiedata");

$sql2 = "SELECT ID FROM gebruikers WHERE gebruikersnaam = '{$_SESSION['gebruikersnaam']}'";
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    $row = $result2->fetch_assoc();  
    $ov_nummer2 = $row['ID'];
}
else {
    $ov_nummer2 = "";
}

if (isset($_POST['PDF'])) {
    // Generate the PDF here
    
    $pdf = new FPDF();

    $pdf->AddPage();

    // Set the font and font size for table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Table headers
    $pdf->Cell(25, 10, 'OV Nummer', 1);
    $pdf->Cell(25, 10, 'Voornaam', 1);
    $pdf->Cell(25, 10, 'Tussenvoegsel', 1);
    $pdf->Cell(25, 10, 'Achternaam', 1);
    $pdf->Cell(30, 10, 'Project Datum', 1);
    $pdf->Cell(15, 10, 'Uren', 1);
    $pdf->Cell(30, 10, 'Projectnummer', 1);
    $pdf->Cell(30, 10, 'Projectnaam', 1);
    $pdf->Cell(50, 10, 'Werkzaamheden', 1);
    $pdf->Cell(10, 10, 'ID', 1);
    $pdf->Ln();
   
    // Set the font and font size for table content
    $pdf->SetFont('Arial', '', 12);

    // Fetch table data from the database

    if ($_SESSION['gebruikersnaam'] == 'Admin') {
        $sql = "SELECT Projectnaam, SUM(uren) AS TotalHours FROM urenreg GROUP BY Projectnaam";
    } else
    {
    $sql = "SELECT u.*, r.*, SUM(r.uren) AS TotalHours
    FROM gebruikers u
    JOIN urenreg r ON u.ID = r.OV_Nummer
    WHERE u.gebruikersnaam = '{$_SESSION['gebruikersnaam']}'
    GROUP BY u.ID, r.Projectnaam";
    }


    if (isset($_POST['projectnaam']) && !empty($_POST['projectnaam'])) {
        $filter = $_POST['projectnaam'];
        if ($_SESSION['gebruikersnaam'] == 'Admin') {
            $sql = "SELECT Projectnaam, SUM(uren) WHERE Projectnaam = '$filter' AS TotalHours FROM urenreg GROUP BY Projectnaam";
        } else
        {
            $sql = "SELECT u.*, r.*, SUM(r.uren) AS TotalHours
            FROM gebruikers u
            JOIN urenreg r ON u.ID = r.OV_Nummer
            WHERE u.gebruikersnaam = '{$_SESSION['gebruikersnaam']}' AND Projectnaam = '$filter'
            GROUP BY u.ID, r.Projectnaam";
    }
    }
    $result = $conn->query($sql);

    // Loop through the table data and add rows to the PDF
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(25, 10, $row['OV_Nummer'], 1);
        $pdf->Cell(25, 10, $row['Voornaam'], 1);
        $pdf->Cell(25, 10, $row['Tussenvoegsel'], 1);
        $pdf->Cell(25, 10, $row['Achternaam'], 1);
        $pdf->Cell(30, 10, $row['projectdatum'], 1);
        $pdf->Cell(15, 10, $row['TotalHours'], 1);
        $pdf->Cell(30, 10, $row['Projectnummer'], 1);
        $pdf->Cell(30, 10, $row['Projectnaam'], 1);
        $pdf->Cell(50, 10, $row['Werkzaamheden'], 1);
        $pdf->Cell(10, 10, $row['ID'], 1);
        $pdf->Ln();
    }
    $pdf->Ln();
    $pdf->Ln();
   
  
  
    $totaaluren = 0; // Initialiseer de totale uren met 0
    $result = $conn->query($sql);
    // Loop door de rijen en tel de uren op
    while ($row = $result->fetch_assoc()) {
        $totaaluren += $row['TotalHours'];
    }
    
    $celwaarde = $totaaluren * 2;
    $pdf->Cell(0, 10, 'Uw tarief is: $' . $celwaarde, 'LTRB', 1, 'C');
    // Output the PDF
    ob_clean(); // Clean the output buffer
    $pdfFilePath = 'factuurtotaal.pdf';
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


    // header("location: Project-Overzicht.php");

    unlink($pdfFilePath);
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
</div>    <!-- (Form) Een Search feature aanmaken om te filtreren op Projectnummer -->
<form method="POST" action="">
    <div class="position" style="position: relative; left: 470px; top: 15px">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon" style="color: white;">Filter op projectnaam:</span>
                <select name="projectnaam">
                    <option value="" disabled selected hidden>Kies Uit...</option>
                    <?php
                        $selectedOption = ""; // initialize variable to store the selected option

                        if (isset($_POST['Search'])) {
                            $selectedOption = $_POST['projectnaam']; // store the selected option
                        }

                        $conn = mysqli_connect("localhost", "root", "", "urenregistratiedata");
                        $sql = "SELECT Projectnaam FROM urenreg";
                        $result = $conn->query($sql);

                        $projectNames = array(); // initialize an empty array to store project names

                        while ($row = $result->fetch_assoc()) {
                            $Pn = $row['Projectnaam'];
                            if (!in_array($Pn, $projectNames)) { // check if the current project name is already in the array
                                array_push($projectNames, $Pn); // add the project name to the array if it's not already there
                                $selected = ($Pn == $selectedOption) ? "selected" : ""; // set 'selected' attribute if it matches the selected option
                                echo "<option value='{$Pn}' {$selected}>{$Pn}</option>";
                            }
                        }
                    ?>
                </select>
                <input type="Submit" name="Search" class="Search" value="Search">
                <input type="Submit" name="refresh" class="refresh" href="Project-Overzicht.php" value="Reset">
                <input type="Submit" name="PDF" class="PDF" value="PDF">
            </div>
        </div>
    </div> 
</form>
<a href="Project-Overzicht.php"><button class="knop1">Terug</button></a>
          <!-- Een table maken zodat alle gegevens in een tabel weergeven worden -->
<table class="tabeldata">
    <thead>
        <tr>
        <span style="white-space: nowrap;"><th>OV Nummer</th>
            <th>Voornaam</th>
            <th>Tussenvoegsel</th>
            <th>Achternaam</th>
            <th>Project Datum</th>
            <th>Totaal Uren</th>
            <th>Projectnummer</th>
            <th>Projectnaam</th>
            <th>Werkzaamheden</th>
        </tr>
    </thead>
    <tbody>
        <?php
            //declaratie te maken voor de connectie van de database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "urenregistratiedata";
                    

            $id = $_SESSION['ID'];

            //connection maken
            $connection = new mysqli($servername, $username, $password, $database);

            //connection checke 
            if($connection->connect_error) {
                die("foutmelding: " . $connection->connect_error);
            }

   
            if (isset($_POST['Search'])) {
                if (isset($_POST['projectnaam'])) {
                    $filter = $_POST['projectnaam'];
            
                    if ($_SESSION['gebruikersnaam'] == 'Admin') {
                        $sql = "SELECT *, SUM(uren) AS TotalHours FROM urenreg WHERE Projectnaam = '$filter' GROUP BY Projectnaam";
                    } else {
                        $id = $_SESSION['ID'];
                        $sql = "SELECT u.*, r.*, SUM(r.uren) AS TotalHours
                                FROM gebruikers u
                                JOIN urenreg r ON u.ID = r.OV_Nummer
                                WHERE r.Projectnaam = '$filter' AND u.gebruikersnaam = '{$_SESSION['gebruikersnaam']}'
                                GROUP BY u.ID, r.Projectnaam";
                    }
                } else {
                    if ($_SESSION['gebruikersnaam'] == 'Admin') {
                        $sql = "SELECT *, SUM(uren) AS TotalHours FROM urenreg GROUP BY Projectnaam";
                    } else {
                        $sql = "SELECT u.*, r.*, SUM(r.uren) AS TotalHours
                                FROM gebruikers u
                                JOIN urenreg r ON u.ID = r.OV_Nummer
                                WHERE u.gebruikersnaam = '{$_SESSION['gebruikersnaam']}'
                                GROUP BY u.ID, r.Projectnaam";
                    }
                }
            
            
                // Execute the SQL query and process the results to get the total hours

            
                // Execute the SQL query and process the results to get the total hours
            
                $result = $connection->query($sql);
                    
                    if(!$result) {
                        die("Invalid Query: " . $connection->error);
                    }
              
            while($row = $result->fetch_assoc()) {
                    $OV = $row['OV_Nummer'];
                    $Vn = $row['Voornaam'];
                    $Ts = $row['Tussenvoegsel'];
                    $An = $row['Achternaam'];
                    $Pd = $row['projectdatum'];
                    $Uren = $row['TotalHours'];
                    $PJn = $row['Projectnummer'];
                    $Pn = $row['Projectnaam'];
                    $Wz = $row['Werkzaamheden'];
                   
                
                    echo "
                    <tr>
                    <td>" .$OV. "</td>
                    <td>" .$Vn. "</td>
                    <td>" .$Ts."</td>
                    <td>" .$An. "</td>
                    <td>" .$Pd. "</td>
                    <td>" .$Uren. "</td>
                    <td>" .$PJn."</td>
                    <td>" .$Pn. "</td>
                    <td>" .$Wz."</td>
      
                </tr>";
                }
                
                if(!$result) {
                    die("Invalid Query: " . $connection->error);
                }
            }
        
        
            
                //als er niks gebeurt in de search krijg je de hele tabel
            else {
                if ($_SESSION['gebruikersnaam'] == 'Admin') {
                    $sql = "SELECT Projectnaam, SUM(uren) AS TotalHours FROM urenreg GROUP BY Projectnaam";
                } else {
                    $sql = "SELECT u.*, r.*, SUM(r.uren) AS TotalHours
                    FROM gebruikers u
                    JOIN urenreg r ON u.ID = r.OV_Nummer
                    WHERE u.gebruikersnaam = '{$_SESSION['gebruikersnaam']}'
                    GROUP BY u.ID, r.Projectnaam";
                }
                
                $result = $connection->query($sql);

                //als er iets anders gebeurt dan wat er moet gebeuren (eindig connectie)
                if(!$result) {
                    die("Invalid Query: " . $connection->error);
                }

                //data aflezen van elke rij
                while($row = $result->fetch_assoc()) {
                    $OV = $row['OV_Nummer'];
                    $Vn = $row['Voornaam'];
                    $Ts = $row['Tussenvoegsel'];
                    $An = $row['Achternaam'];
                    $Pd = $row['projectdatum'];
                    $Uren = $row['TotalHours'];
                    $PJn = $row['Projectnummer'];
                    $Pn = $row['Projectnaam'];
                    $Wz = $row['Werkzaamheden'];
                

                    echo "
                    <tr>
                    <td>" .$OV. "</td>
                    <td>" .$Vn. "</td>
                    <td>" .$Ts."</td>
                    <td>" .$An. "</td>
                    <td>" .$Pd. "</td>
                    <td>" .$Uren. "</td>
                    <td>" .$PJn."</td>
                    <td>" .$Pn. "</td>
                    <td>" .$Wz."</td>
                    
              
                </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </body>
</html>
<style>
    .PDF{
    transform: translate(-50%,-50%);
    position: fixed;
    left: 78%;
    top: 15.5%;
    width: 10vw;
    height: 2.5vw;
    border-radius: 50px;   
    background: orange; 
    text-align: center;
    text-transform: uppercase;
    font-size: 100%;
    color: white;
    font-family: 'Open Sans', sans-serif;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    box-shadow: 0px 5px 10px rgba(128, 128, 128);

}
.PDF:hover{
    background: white;
    color: orange;
}
.position{
    position: absolute;
    left: 620px;
    top: 100px
}
.tabeldata{
    position: absolute;
    bottom: 100px;
    left: 95px;
}

    body {
    font-family: 'Open Sans', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    background-image: url(fotooverzicht.jpg);
    background-repeat: repeat-x;
    background-position: 0 0;

  /* Define the animation */
  animation: moveBackground 15s linear infinite;
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
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    max-width: 600px;
    text-align: center;
}

.welcome-container h1 {
    font-size: 30px;
    font-weight: 600;
    color: #333;
    margin: 0;
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
nav .Logo h1{
    font-size: 24px;
    font-weight: 600;
    margin: 0;
    padding: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    left: 50px;
}

table {
  width: 90%;
  border: 3px solid black;
  margin-top: 40px;
  margin-left: auto;
  margin-right: auto;
  border-collapse: collapse;
  overflow-y: scroll;
  height: 500px;
  display: block;
}

tr {
  transition: background-color 0.8s ease;
}

tr:hover {
  background-color: #3a3a53;
}

td {
  border: 3px solid black;
  padding: 15px;
  text-align: center;
  font-size: 18px;
  font-weight: bold;
}

.Update, .Delete {
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
    left: 0%;
}


table {
    background: #2c2c39;
    opacity: 0.9;
    transition-duration: 0.8;
}
table:hover {

    opacity: 1;
}
.Update {
    background-color: rgb(20, 70, 15);
    
}

.Update:hover {
    background-color: greenyellow;
}

.Delete {
    background-color: rgb(92, 12, 12);
}

.Delete:hover {
    background-color: rgb(255, 47, 47);
}

.containersearch {
    width: 500px;
    height: auto;
    padding: 20px 10px;
    margin: 20px auto;
    background-image: linear-gradient(#374041, #39bae1);;
    box-shadow:  5px 10px #020202;
    font-size: 20px;
}

.Search {
    background-color: red;
    font-size: 15px;
    height: 35px;
    width: 120px;
    margin-top: 0px;
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    background-color: gray;
    border-radius: 50px;
    border: none;
    box-shadow: 0px 5px 10px rgba(128, 128, 128);
    transition: all 0.3s ease-in-out;
    cursor: pointer;
}

.T {
    width: 100px;
    height: 20px;
    float: left;
    margin-top: 5px;
}

.filter {
    width: auto;
    height: 20px;
    padding: 15px 10px;
}
.Search:hover {
    background-color: rgb(255,255,255);
    color: black;
}
.refresh {
    float: left;
    width: 120px;
    height: 35px;
    margin-right: 5px;
    margin-top: 2px;
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    background-color: gray;
    border-radius: 50px;
    border: none;
    box-shadow: 0px 5px 10px rgba(128, 128, 128);
    transition: all 0.3s ease-in-out;
    cursor: pointer;
}
.refresh:hover {
    background-color: rgb(255,255,255);
    color: black;
}
th,td{
    color:white;
}
select {
  width: 200px;
  padding: 10px;
  font-size: 16px;
  border: 2px solid #ccc;
  border-radius: 4px;
  background-color: #f2f2f2;
  color: #333;
  border-radius: 10%;
}

select:hover {
  border-color: #999;
}

select:focus {
  outline: none;
  border-color: #555;
  box-shadow: 0 0 5px rgba(85, 85, 85, 0.3);
}
.knop1{
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
    position: absolute;
    left: 18%;
    top: 13%;
}
.knop1:hover {
    background-color: rgb(255,255,255);
    color: black;

}
</style>

