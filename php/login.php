<?php
    require 'config.php';
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        $req1 = "select id from users where email = '$email' and mdp = '$mdp'";

        $result = $conn->query($req1);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["id_user"] = $row["id"];
            header('Location: ../home.php');
            exit();
        }
        else {
            echo "Aucun utilisateur trouvé";
        }
        
    }
    $conn->close();
?>
