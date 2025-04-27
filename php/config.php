<?php 
    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = "";
    $baseDeDonnees = "sharefile";

    $conn = new mysqli($serveur, $utilisateur, $motDePasse);

    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $req = "CREATE DATABASE IF NOT EXISTS $baseDeDonnees";
    if ($conn->query($req) === FALSE) {
        die("Erreur en création de base de données: " . $conn->error);
    }

    $conn->select_db($baseDeDonnees);
?>