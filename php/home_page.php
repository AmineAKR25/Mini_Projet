<?php
    require 'config.php';
    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
            $fileTmpName = $_FILES['fileToUpload']['tmp_name'];
            $fileName = $_FILES['fileToUpload']['name'];
            
            $fileType = $_FILES['fileToUpload']['type'];
            $fileSize = $_FILES['fileToUpload']['size'];
            
            $filePath = '../uploads/' . basename($_FILES['fileToUpload']['name']);
            
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $downloadLink = 'http://localhost/Mini_Projet/uploads/' . $fileName;
                $dateUpload = date("Y-m-d H:i:s");
                $query = "select * from fichiers where id_user = '".$_SESSION["id_user"]."' and lien = '$downloadLink'";
                $result = $conn->query($query);
                if($result->num_rows > 0) {
                    echo "you cant add the same file twice!";
                }else{
                    $req2 = "INSERT INTO fichiers (id_user, nom_fichier, type_fichier, taille, lien, date_upload) 
                    VALUES (".$_SESSION["id_user"].", '$fileName', '$fileType', $fileSize, '$downloadLink', '$dateUpload')";
    
                    if ($conn->query($req2) === FALSE) {
                        echo "Erreur: " . $conn->error;
                    } else {
                        header("Location: ../home.php");
                        exit();
                    }
                }
            } else {
                echo "Error while moving the file to the server.";
            }
        } else {
            echo "No file uploaded or there was an error.";
        }
    }



    $conn -> close();

?>