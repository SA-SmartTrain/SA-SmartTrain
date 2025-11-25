 <?php

    require_once '../../db/conn.php';

    session_start();
    if (isset($_SESSION["email_usuarios"])) {
        session_destroy();
        echo "";
    } else {
        echo "";
    }
    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: cadastre-se-page.php');
        echo '<script>
            setTimeout(function() {
            window.location.href = "cadastre-se-page.php";
            }, 5000);
        </script>';
    }
    ?>

 <!DOCTYPE html>

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="shortcut icon" href="../../src/assets/logo/favicon.ico" type="image/x-icon">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
     <title>SmartTrain - Logout</title>
 </head>

 <body>
     <img class="logo" src="../../src/assets/images/logo-smarttrain.png" alt="SmartTrain Logo">
 </body>
 <style>
     body {
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         background-color: #f8f9fa;
         font-family: Arial, sans-serif;
     }

     .logo {
         width: 310px;
         height: auto;
         margin-bottom: 20px;
     }
     
 </style>
 </html>
 <script>
    setTimeout(function() {
        window.location.href = "cadastre-se-page.php";
    }, 3000);
 </script>