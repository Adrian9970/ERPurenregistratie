<?php
include("ConnectN.php");

if(isset($_GET['deleteid'])) {
    $id =$_GET['deleteid'];

    $sql = "delete from `urenreg` where ID=$id";
    $result = mysqli_query($conn, $sql);
    if($result) {
        header('location:Project-Overzicht.php');
    }
    else{
        die(mysqli_error($conn));
    }
}


?>