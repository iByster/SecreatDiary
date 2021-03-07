<?php

    $message = "";

    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
        
        include("connectionDB.php");

        
        $email = mysqli_real_escape_string($link, $_GET['email']);
        $hash = mysqli_real_escape_string($link, $_GET['hash']);


        $search = mysqli_query($link, 'SELECT `email`, `hash` FROM `users` WHERE `email`="'.$email.'" AND `hash`="'.$hash.'"');

        $match = mysqli_num_rows($search);

        if($match == 1){

            $query = 'UPDATE `users` SET `active`= 1 WHERE `email`="'.$email.'" AND `hash`="'.$hash.'" LIMIT 1';

            mysqli_query($link, $query);

            $message = '<div id="zzz1" class="alert alert-success" role="alert">
            Congratulations! Your account is now active and ready to go.
            </div>';

        } else {
            $message = '<div id="zzz1" class="alert alert-danger" role="alert">
            Something went wrong. Try to contact us or try again later.
            </div>';
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secreat Diary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/main.css">

</head>
<body>
     <nav class="navbar navbar-light justify-content-center">
    <a class="navbar-brand" href="#">
      <p class="logo-font text-center">Secret Diary</p>
      <p class="lead">Store your thoughts permanently and securely.</p>
    </a>
  </nav>
  <br><br>
  <hr style="width:50%">
    <br>
    <div id="message" class="container d-flex justify-content-center">
        <?php echo $message;?>
        <br>


    </div>
    <div class="container text-center">
        <button onclick='location.href = "index.php";' name="login-submit" id="login-btn" type="button" class="btn btn-lg btn-warning">Home</button>
    </div>

  <br>
  <hr style="width:50%">


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
  

</body>
</html>