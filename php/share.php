<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Link</title>
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            z-index: 9999;
        }

        .popup .link-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .popup button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .popup button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="popup" id="popup">
    <div class="link-container">
        <input type="text" id="shareLink" value="<?php echo $_GET["lien"]; ?>" readonly>
        <button onclick="copyLink()">Copier lien</button>
    </div>
</div>

<script>
    window.onload = function() {
        document.getElementById('popup').style.display = 'block';
    }

    function copyLink() {
        var copyText = document.getElementById('shareLink');
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
    }
</script>

</body>
</html>