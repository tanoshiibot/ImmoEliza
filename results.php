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
    // function declaration
    // --------------------

    function get_api_output($p_url){
      //debug
      //echo '$p_url : ' .$p_url;
      //echo nl2br("\n");

      // setup handle
      $handle = curl_init();
      // Set the url
      $url = $p_url;
      // setopt
      curl_setopt($handle, CURLOPT_URL, $url);
      // Set the result output to be a string.
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
      // set the output
      $output = curl_exec($handle);
      // close handle        
      curl_close($handle);

      //debug
      //echo '$output : ' .$output;
      //echo nl2br("\n");

      // return
      return $output;
    }

     // script
     // ------

    // pré validation, les champs doivent exister et ne pas être vide.
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
      // Data from HTML <form>
      echo 'Sanitized Data from HTML <form>';
      echo '-------------------------------';               
      echo nl2br("\n cp : ".$cp);      
      echo nl2br("\n rue : ".$rue);      
      echo nl2br("\n numero : ".$numero);  
      echo nl2br("\n");
      echo nl2br("\n");

      // API GET request
      // -----------
      // Base URL: https://static.wallonia.ml/file/wallonia-lidar/web/
      echo 'API request';
      echo nl2br("\n");
      echo '-----------';
      echo nl2br("\n");
      
      // Etape 1: Point d’entrée, les code postaux
      // -----------------------------------------
      $result_cp_collection = get_api_output("https://static.wallonia.ml/file/wallonia-lidar/web/postal_codes.json");

      // decode string output json to php object or php associative array ("key" => "value")
      // ----------------------------------------------------------------
      // arg2 option not set or set to false will give a php object
      // arg2 option set to true will give a php associative array
      $array_cp = json_decode($result_cp_collection, true);

      // check if user cp is in the array
      // --------------------------------
      if (array_key_exists ($cp, $array_cp)){
        echo "Le code postal existe dans l'API";
      } else {
        die("Le code postal n'existe pas dans l'API !");
      }
      echo nl2br("\n");

      // Etape 2: Obtenir les rues de la ville
      // -------------------------------------
      // ok now that we have the cp
      // let us get all the street of that cp
      $result_street_collection = get_api_output("https://static.wallonia.ml/file/wallonia-lidar/web/$cp.json");
      // json decode
      $array_street = json_decode($result_street_collection, true); 
      
      // check if user street is in the array
      // -------------------------------------
      if (array_key_exists ($rue, $array_street)){
        echo "La rue existe dans l'API";
      } else {
        die("La rue n'existe pas dans l'API !");
      }
      echo nl2br("\n");

      // get value of key representing the street
      // ----------------------------------------
      $id_street = $array_street[$rue];
      echo "l'ID de la rue est : ".$id_street;
      echo nl2br("\n");

      // Etape 3: Obtenir l’id unique de la maison
      // -----------------------------------------
      // ok now that we have the cp and the street
      // let us get all the number of house in that street
      $result_house_collection = get_api_output("https://static.wallonia.ml/file/wallonia-lidar/web/$cp/$id_street.json");
      // json decode
      $array_house = json_decode($result_house_collection, true); 

      // check if user numero of house is in the array
      // ---------------------------------------------
      if (array_key_exists ($numero, $array_house)){
        echo "Le numéro de maison existe dans l'API";
      } else {
        die("Le numéro de maison n'existe pas dans l'API !");
      }
      echo nl2br("\n");

      // get value of key representing the unique house 
      // ----------------------------------------------
      $id_house = $array_house[$numero];     
           
      // 4. Feedback, Display the response interface.
      // --------------------------------------------
      // envoi de id_house finale dans le champ <p id="id_house">
      // il servira pour le relais js 3D https://api.wallonia.ml/v1/model/$id_house

      echo "l'ID de la maison est : ";
      echo "<p id = 'id_house'>".$id_house."</p>";
      echo nl2br("\n");


    } else {
      echo nl2br ('Non Valide : ni le code postal, ni la rue et ni le numéro ne peuvent être vide.');
    }

  ?>

    <script src="./assets/js/script.js"></script>
</body>
</html>