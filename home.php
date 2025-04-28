<?php
    require 'php/config.php';
    session_start();
    $req1 = "CREATE TABLE id not exists fichiers (
    id int primary key AUTO_INCREMENT,
    id_user int references users,
    nom_fichier varchar(50) NOT NULL,
    type_fichier varchar(50) NOT NULL,
    taille float NOT NULL,
    lien varchar(100) NOT NULL,
    date_upload date NOT NULL,
    unique(id_user,lien)
    )";
    if ($conn->query($req) === FALSE) {
        die("Erreur en création de table users: " . $conn->error);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FileShare - Home</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #222;
            font-size: 32px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }

        .file-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .file-upload-label {
            background: linear-gradient(135deg, #4CAF50, #43a047);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 17px;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
        }
        .custom-file-upload {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .custom-file-upload:hover {
            background-color: #45a049;
        }
        .file-upload-label:hover {
            background: linear-gradient(135deg, #45a049, #388e3c);
            transform: scale(1.05);
        }

        .file-upload-input {
            display: none;
        }

        .file-name {
            margin-top: 5px;
            font-size: 15px;
            color: #444;
        }

        .submit-button {
            background: linear-gradient(135deg, #2196F3, #1e88e5);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 17px;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
        }

        .submit-button:hover {
            background: linear-gradient(135deg, #1976D2, #1565c0);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            table-layout: fixed;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        th {
            background: linear-gradient(135deg, #47a3ff, #1e88e5);
            color: white;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            width: 20px;
            cursor: pointer;
            margin: 7%;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <form method="POST" action="php/home_page.php" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
            <label for="file-upload" class="custom-file-upload">
                Choose File
            </label>
            <input id="file-upload" type="file" name="fileToUpload" style="display: none;" onchange="updateFileName()">
            <span id="file-name">No file chosen</span>
            
            <input type="submit" class="submit-button">
        </form>
        <h3>Files Uploaded</h3>
        <table>
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Taille</th>
                <th>Date</th>
                <th></th>
            </tr>
            <?php
                $req1 = "select * from fichiers where id_user = '".$_SESSION["id_user"]."'";
                $result = $conn -> query(($req1));
                while ($row = $result -> fetch_assoc()) {
                    echo"
                    <tr>
                    <td rowspan='1'>".$row["nom_fichier"]."</td>
                    <td>".$row["type_fichier"]."</td>
                    <td>".$row["taille"]." KB</td>
                    <td>".$row["date_upload"]."</td>
                    <td>
                    <a  href='".$row["lien"]."' download ><img style = 'margin-left:10%'  src='img/download.png' alt='download'></a>
                    <a  href='php/delete.php?id_user=".$row["id_user"]."&lien=".$row["lien"]."'><img src='img/delete.png' alt='delete'></a>
                    <a href='php/share.php?lien=".$row["lien"]."' target='_blank'><img src='img/share.png' alt='share'>
                    </td>
                    </tr>
                    ";
                }
            ?>
        </table>
        
        
    </div>
    <center><a href="index.html"><button class="submit-button">Déconnecter</button></a></center>
    <script>
        function updateFileName() {
            const input = document.getElementById('file-upload');
            const fileName = input.files.length > 0 ? input.files[0].name : "No file chosen";
            document.getElementById('file-name').textContent = fileName;
        }
    </script>
</body>
</html>
