<?php 

if(isset($_POST['Submit'])) {
    $filter = $_POST['filter'];
    $sql = "SELECT * FROM urenreg WHERE Projectnummer = $filter";
    $result = $connection->query($sql);

        //data aflezen van elke rij
    while($row = $result->fetch_assoc()) {
        $OV = $row['OV_Nummer'];
        $Vn = $row['Voornaam'];
        $An = $row['Achternaam'];
        $Ts = $row['Tussenvoegsel'];
        $Gd = $row['Geboortedatum'];
        $Uren = $row['Uren'];
        $PJn = $row['Projectnummer'];
        $Pn = $row['Projectnaam'];
        $Wz = $row['Werkzaamheden'];
        $id = $row['ID'];

        echo "
        <tr>
        <td>" .$OV. "</td>
        <td>" .$Vn. "</td>
        <td>" .$An. "</td>
        <td>" .$Ts."</td>
        <td>" .$Gd. "</td>
        <td>" .$Uren. "</td>
        <td>" .$PJn."</td>
        <td>" .$Pn. "</td>
        <td>" .$Wz."</td>
        <td>" .$id."</td>
        <td>
            <a class='Update' href='UpdateTable.php?updateid=".$id."'>Update</a>
            <a class='Delete' href='Delete.php?deleteid=".$id."'>Delete</a>
        </td>
    </tr>";
    }
    
    if(!$result) {
        die("Invalid Query: " . $connection->error);
    }
}

?>