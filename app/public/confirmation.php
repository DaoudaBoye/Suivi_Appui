<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message-container {
            text-align: center;
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
    <script>
        setTimeout(function(){
            window.location.href = "http://localhost:81/demande-appui/app/views/formulaire.php";
        }, 3000); // Redirection après 3 secondes ("3000 millisecondes)
    </script>
</head>
<body>
    <div class="message-container">
        <?php
        session_start();

        if (isset($_SESSION['success_message'])) {
            echo "<p class='success'>" . $_SESSION['success_message'] . "</p>";
            unset($_SESSION['success_message']); // Effacer le message après l'avoir affiché
        } elseif (isset($_SESSION['error_message'])) {
            echo "<p class='error'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']); // Effacer le message après l'avoir affiché
        }
        ?>
    </div>
</body>
</html>
