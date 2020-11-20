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


<nav class="navbar navbar-light purple lighten-4 mb-4">

  <!-- Navbar brand -->
  <a class="navbar-brand" href="#">ImmoEliza</a>

  <!-- Collapse button -->
  <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1"
    aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"><span class="dark-blue-text"><i
        class="fas fa-bars fa-1x"></i></span></button>

  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="navbarSupportedContent1">

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Acceuil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
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
    <h1 class="text-center">Trouver une propriéte en Walonie</h1>
</div>
<!--CANVAS-->  
<section>
    <div class="container-fluid" id="content">
        <div class="row justify-content-center" id="content-row">            
            <div class=" col-8">
                <div class="card card-search">
                    <div class="position-sticky pt-2">
                        <div class="card-header ">Titre</div>
                            <div class="card-body align-text-center">
                                <div class="tab-content" id="myTabContent">    
                                    <div class="tab-pane fade show active" id="search" role="tabpanel" aria-labelledby="seach-tab">
                                        <div class="card-text text-center">                                
                                            <div class="col-12">
                                                <div class="form_post">
                                                    <form action="results.php" method="post">
                                                        <label for="cp">Code Postal:</label>
                                                        <input type="text" id="cp" name="cp" size="10">
                                                        <br>
                                                        
                                                        <label for="rue">Rue:</label>
                                                        <input type="text" id="rue" name="rue" size="20">
                                                        <br>

                                                        <label for="numero">Numéro:</label>
                                                        <input type="text" id="numero" name="numero" size="10">
                                                        <br>

                                                        <input type="submit" value="Submit">
                                                    </form>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
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
<footer>

</footer>

    <script src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    
</body>
</html>