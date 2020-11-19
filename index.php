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

  <div class="form_post">
  <form action="results.php" method="post">
      <label for="cp">Code Postal:</label>
      <input type="text" id="cp" name="cp" size="10">
      <br>
      
      <label for="rue">Rue:</label>
      <input type="text" id="rue" name="rue" size="40">
      <br>

      <label for="numero">Numéro:</label>
      <input type="text" id="numero" name="numero" size="10">
      <br>

      <input type="submit" value="Submit">
    </form> 
  </div>

    <script src="./assets/js/script.js"></script>
</body>
</html>