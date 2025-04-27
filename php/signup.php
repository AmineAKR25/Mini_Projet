<?php
    require 'config.php';
    session_start();
    $req1 = "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(50) NOT NULL,
        prenom VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        mdp VARCHAR(100) NOT NULL
    )";

    if ($conn->query($req1) === FALSE) {
        die("Erreur en création de table users: " . $conn->error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        $req2 = "insert into users (nom,prenom,email,mdp) values('$nom','$prenom','$email','$mdp')";
        if ($conn->query($req2) === FALSE) {
            die("Erreur en insersion des donneés: " . $conn->error);
        }
        header('Location: ../login.html');
        exit();
    }
    $conn->close();
?>
