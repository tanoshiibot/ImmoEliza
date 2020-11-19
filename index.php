<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ImmoEliza</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

  <?php
    echo '<form action="results.php" method="post">
    <p>Code Postal : <input type="text" name="cp" /></p>
    <p>Rue : <input type="text" name="rue" /></p>
    <p>N° : <input type="text" name="numero" /></p>
    <p><input type="submit" value="OK"></p>
   </form>
   '
  ?>

    <script src="./assets/js/script.js"></script>
</body>
</html>