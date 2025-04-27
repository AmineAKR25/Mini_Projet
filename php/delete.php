<?php
    require 'config.php';
    $id = $_GET["id_user"];
    $lien = $_SERVER['DOCUMENT_ROOT'] . "/Mini_Projet/uploads/" . basename($_GET['lien']);

    $conn->query("delete from fichiers where id_user = $id and lien = '".$_GET["lien"]."'");
    if (file_exists($lien)) {
        unlink($lien);
    }
    header("Location: ../home.php");
    exit();
?>