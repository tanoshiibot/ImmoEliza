<?php  
  // This condition checks if form is submitted...
  if ((!isset($_POST['rue'])) || (!isset($_POST['rue'])) || (!isset($_POST['rue']))){
    //echo 'not yet submitted';      
  } else {   
    // error handle
    // ------------
    $error_handle = [];
    $feedback = [];
    
    // pré validation, les champs doivent exister et ne pas être vide.
    if ((isset($_POST["cp"]) && !empty(trim($_POST["cp"]))) && (isset($_POST["rue"]) && !empty(trim($_POST["rue"]))) && (isset($_POST["numero"]) && !empty(trim($_POST["numero"])))){
      // function declaration
      // --------------------
      function get_api_output($p_url){
        $url = $p_url;
        $data = array('key1' => 'value1', 'key2' => 'value2');

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */ };
        return $result;
      }
      
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
      
      // validation CP
      // Test si $variable est un code postal
      // le cp belge vas de 1000 à 9999 (4 chiffres)
            
      if (preg_match("#^[0-9]{4}$#",$cp)){
          //echo "le CP est valide.";
      } else {
        $error_handle['cp'] = "Le CP n'est pas valide. (Veuillez encoder un CP valide numérique entre 1000 et 9999)."; 
      }

      if(count($error_handle) == 0){
        // amélioration de l'expérience d'encodage coté utilisateur   
        // --------------------------------------------------------   
        // on supprime les blancs en trop entre les mots !
        $rue = preg_replace('#[\s]+#', ' ', $rue);
                          
        // 3. execution
        // ------------
                          
        // If we get here, it's because everything's fine, we can do the next step
        // Fetch API with our data
        // Data from HTML <form>
        array_push($feedback, "<u><b>Sanitized Data from HTML form</b></u>");                     
        array_push($feedback, "cp : ".$cp);      
        array_push($feedback, "rue : ".$rue);      
        array_push($feedback, "numero : ".$numero);  
        
        // API GET request
        // -----------
        // Base URL: https://static.wallonia.ml/file/wallonia-lidar/web/
        array_push($feedback, '<u><b>API request</u></b>');
                        
        // Etape 1: Point d’entrée, les code postaux
        // -----------------------------------------
        $result_cp_collection = get_api_output("http://static.wallonia.ml/file/wallonia-lidar/web/postal_codes.json");

        // decode string output json to php object or php associative array ("key" => "value")
        // ----------------------------------------------------------------
        // arg2 option not set or set to false will give a php object
        // arg2 option set to true will give a php associative array
        $array_cp = json_decode($result_cp_collection, true);

        // check if user cp is in the array
        // --------------------------------
        if (array_key_exists ($cp, $array_cp)){
          array_push($feedback, "Le code postal existe dans l'API");
        } else {
          $error_handle['cp not exist'] = "Le code postal n'existe pas dans l'API !";
        }
        
        if(count($error_handle) == 0){
          // Etape 2: Obtenir les rues de la ville
          // -------------------------------------
          // ok now that we have the cp
          // let us get all the street of that cp
          $result_street_collection = get_api_output("http://static.wallonia.ml/file/wallonia-lidar/web/$cp.json");
          // json decode
          $array_street = json_decode($result_street_collection, true); 
                
          // to compare data string API, we create new variables in lower caser
          // rue_lower_case and array_street_lower_case
          $rue_lower_case = strtolower($rue);
          $array_street_lower_case = array_change_key_case($array_street,CASE_LOWER);
        
          // check if user street is in the array      
          if (array_key_exists ($rue_lower_case, $array_street_lower_case)){
            array_push($feedback, "La rue existe dans l'API");
          } else {
            $error_handle['rue not exist'] = "La rue n'existe pas dans l'API !";
          }
          
          if(count($error_handle) == 0){
            // get value of key representing the street            
            $id_street = $array_street_lower_case[$rue_lower_case];
            array_push($feedback, "l'ID de la rue est : ".$id_street);
                        
            // Etape 3: Obtenir l’id unique de la maison
            // -----------------------------------------
            // ok now that we have the cp and the street
            // let us get all the number of house in that street
            $result_house_collection = get_api_output("http://static.wallonia.ml/file/wallonia-lidar/web/$cp/$id_street.json");
            // json decode
            $array_house = json_decode($result_house_collection, true); 

            // check if user numero of house is in the array
            // ---------------------------------------------
            if (array_key_exists ($numero, $array_house)){
              array_push($feedback, "Le numéro de maison existe dans l'API");
            } else {
              $error_handle['house number is not into API'] = "Le numéro de maison n'existe pas dans l'API !";
            }
            
            if(count($error_handle) == 0){
              // get value of key representing the unique house 
              // ----------------------------------------------
              $id_house = $array_house[$numero];     
                  
              // 4. Feedback, Display the response interface.
              // --------------------------------------------
              // envoi de id_house finale dans le champ <p id="id_house">
              // il servira pour le relais js 3D https://api.wallonia.ml/v1/model/$id_house

              array_push($feedback, "l'ID de la maison est : ");
              array_push($feedback, "<p id = 'id_house'>".$id_house."</p>");              
            }
          }
        }
      }
    } else {
      $error_handle['not a valid submission'] = 'Non Valide : ni le code postal, ni la rue et ni le numéro ne peuvent être vide.';      
    }    

  } // end if not submitted   

  ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="size=device-size, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ImmoEliza</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<header>           
<!--Navbar-->

<<<<<<< HEAD

<nav class="navbar navbar-light btn btn-dark lighten-4 mb-4">
=======
<nav class="navbar navbar-light purple lighten-4 mb-4">
>>>>>>> post-API

  <!-- Navbar brand -->
  <a class="navbar-brand" href="#"><img class="btn btn-warning" src="./assets/img/ImmoEliza.png" width="20%"  ></a>

  <!-- Collapse button -->
  <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1"
    aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"><span class="dark-blue-text"><i
        class="fas fa-bars fa-1x"></i></span></button>

  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="navbarSupportedContent1">

    <!-- Links -->
    <ul class="navbar-nav mr-auto btn btn-warning">
      <li class="nav-item active">
        <a class="nav-link" href="#">Acceuil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Information</a>
      </li>
      
    </ul>
    <!-- Links -->

  </div>
  <!-- Collapsible content -->

</nav>
<!--/.Navbar-->
</header>
<main>
<div class="container-fluid">
    <h1 class="text-center">Trouver une propriéte en Wallonie</h1>
</div>
<!--CANVAS-->  
<section>
    <div class="container-fluid" id="content">
        <div class="row justify-content-center" id="content-row">            
            <div class="card position-sticky  pt-2 col-12 col-sm-8 col-md-8 col-lg-6 ">
                <div class="card-header text-center">remplis les coordonnées</div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">    
                            <div class="card-text text-center">                                
                                <div class="form_post">
<<<<<<< HEAD
                                    <form action="results.php" method="post">
                                        <div class="container btn btn-dark">
                                            <div class="  justify-content-center pt-2">
                                                <label for="cp" class="yellow" >Code Postal:</label>
                                                <input type="text" class="form-control" id="cp" name="cp" size="10">
                                            </div>

                                            <div class="  justify-content-center pt-2">
                                                <label  for="rue" class="yellow" >Rue:</label>                                                  
                                                <input type="text" class="form-control" id="rue" name="rue" size="15">
                                            </div>

                                            <div class="  justify-content-center pt-2">
                                                <label for="numero"class="yellow"  >Numéro:</label>
                                                <input type="text" class="form-control" id="numero" name="numero" size="11">
=======
                                    <form action="index.php" method="post">
                                        <div class="container btn btn-secondary">
                                            <div class="  justify-content-center pt-2">
                                                <label for="cp">Code Postal:</label>
                                                <input type="text" class="form-control" id="cp" name="cp" size="10" value="<?php echo $cp; ?>">
                                            </div>

                                            <div class="  justify-content-center pt-2">
                                                <label class="form-check-label" for="rue">Rue:</label>                                                  
                                                <input type="text" class="form-control" id="rue" name="rue" size="15" value="<?php echo $rue; ?>">
                                            </div>

                                            <div class="  justify-content-center pt-2">
                                                <label for="numero">Numéro:</label>
                                                <input type="text" class="form-control" id="numero" name="numero" size="11" value="<?php echo $numero; ?>">
>>>>>>> post-API
                                            </div>
                                            <input type="submit" class="btn btn-success btn-sm" value="submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
        </div>  
    </div>
</section>
<!--fin CANVA-->
    
<!--**  FORM  **-->
<section>

</section>
<!--fin-->
</main>

<?php
  // Feedback, Display the response interface.
  // -----------------------------------------

  echo '<div style="display: flex; flex-direction: column; justify-content: center;">';

    echo '<div>';
      foreach ($error_handle as $value) {
        echo "<p>$value</p>"; 
      }
      
      // si pas d'erreur on affiche les étapes du process 
      // qui a permit de recevoir l'id unique de la maison.
      if(count($error_handle) == 0){
        foreach ($feedback as $value) {
        echo "<p>$value</p>";    
        }
      }

    echo '</div>';
  echo "</div>";

?>

<footer>

</footer>

    <script src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    
</body>
</html>