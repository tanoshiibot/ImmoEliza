<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

  <?php
    // This condition checks if form is submitted...
    if ((isset($_POST["cp"]) && !empty(trim($_POST["cp"]))) && (isset($_POST["rue"]) && !empty(trim($_POST["rue"]))) && (isset($_POST["numero"]) && !empty(trim($_POST["numero"])))){
      
      // we initiate an array that will contain any potential errors.
      $errors = array();

      // 1. Sanitisation
      // ---------------
   
      // anti xss
      $cp = filter_var($_POST["cp"], FILTER_SANITIZE_STRING);
      $rue = filter_var($_POST["rue"], FILTER_SANITIZE_STRING);
      $numero = filter_var($_POST["numero"], FILTER_SANITIZE_STRING);     
   
      // trim enlève les blancs à gauche et à droite
      $cp = trim($cp);
      $rue = trim($rue);
      $numero = trim($numero);

      // 2. Validation
      // -------------
      //if ... $errors['cp'] = "Ce code postal est invalide"
      //if ... $errors['rue'] = "Cette rue est invalide"
      //if ... $errors['numero'] = "Ce numéro est invalide"

      
      // 3. execution
      // ------------
      if (count($errors)> 0){
        echo "There are mistakes!";
        print_r($errors);
        exit;
      } 
                   
      // If we get here, it's because everything's fine, we can do the next step
      // Fetch API with our data
      echo nl2br("\n".$cp);      
      echo nl2br("\n".$rue);      
      echo nl2br("\n".$numero);  

      // 4. Feedback, Display the response interface.
      // --------------------------------------------

    } else {
      echo nl2br ('Non Valide : ni le code postal, ni la rue et ni le numéro ne peuvent être vide.');
    }

  ?>

    <script src="./assets/js/script.js"></script>
</body>
</html>