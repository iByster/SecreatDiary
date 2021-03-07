<?php 

    session_start();

    $conclusion_success = $conclusion = $conclusion2 = "";
    

    if(array_key_exists('logout', $_GET)) {
      $_SESSION['user'] = '';
      unset($_SESSION);
      
      setcookie('user', '', time() - 60*60);
      $_COOKIE['user'] = '';

    } else if((array_key_exists('user', $_SESSION) AND $_SESSION['user'] != '') OR (array_key_exists('user', $_COOKIE) AND $_COOKIE['user']) != '') {
      header("Location: session.php");
    }
    
   
    if(isset($_POST['sign-in-submit'])){

      $email = $password = $re_password = "";

      $message_task = "";

      include("connectionDB.php");

     
      if(!$_POST['email-sign-up']){

        $message_task .= "<p>The email address field is required!</p>";

      } else if(!filter_var($_POST['email-sign-up'], FILTER_VALIDATE_EMAIL)) {

        $message_task .= "<p>The email adress is not valid!</p>";

      } /* else if(!checkdnsrr(array_pop(explode("@",$_POST['email-sign-up'])), 'MX')){

        $message_task .= "<p>The domain name is not valid!</p>";

      } */ else if(test_input($_POST['email-sign-up']) != $_POST['email-sign-up']) {
        
        $message_task .= "<p>The email can't contain special chars!</p>";
      
      } else {

        $query = 'SELECT `id` FROM `users` WHERE `email`="'.mysqli_real_escape_string($link, $_POST['email-sign-up']).'" LIMIT 1';

        $result = mysqli_query($link, $query);

        if(mysqli_fetch_array($result) != false){

          $message_task .= '<p> This email is already used! </p>';
          
        } else {
          $email = $_POST['email-sign-up'];

          
        }

        
      }

      if(!$_POST['password-sign-in']) {
        
        $message_task .= "<p>The password field is required!</p>";

      } else if(test_input($_POST['password-sign-in']) != $_POST['password-sign-in']) {
        
        $message_task .= "<p>The password can't contain special chars!</p>";
      
      } else if(strlen($_POST['password-sign-in']) < 6) {

        $message_task .= "<p>The password is too short! It must have at least 6 chars!</p>";
      
      } else {

        $password = $_POST['password-sign-in'];
      
      }


      if(!$_POST['repassword-sign-in']) {

        $message_task .= "<p>The confirm password field is required!</p>";

      } else if($_POST['repassword-sign-in'] != $password) {

        $message_task .= "<p>The passwords do not match!</p>";

      } else {

        $re_password = $_POST['repassword-sign-in'];

      }

      

      if($email != "" && $password != "" && $re_password != ""){

          $activation_code = md5(rand(0, 1000));

          $emailTo = $_POST['email-sign-up'];

          $subject = "Welcome to my Secret Diary!";

          $body =' Thanks for signing up!
          Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
            
          ------------------------
          Username: '.$email.'
          Password: '.$password.'
          ------------------------
            
          Please click this link to activate your account:
          http://secreat-diary-io.stackstaging.com/verify.php?email='.$email.'&hash='.$activation_code.'
            
          ';

          $headers = "From: ganealexandru01@gmail.com";

          if(@mail($emailTo, $subject, $body, $headers)){
            $hash = password_hash($password, PASSWORD_DEFAULT);

        
        
            $query = 'INSERT INTO `users`(`email`, `password`, `hash`)
                  VALUES("'.mysqli_real_escape_string($link, $email).'", "'.$hash.'", "'.$activation_code.'")';

            mysqli_query($link, $query);

            $conclusion = '<div id="zzz1" class="alert alert-success" role="alert">
                        Registration successeful! A confirmation email was sent!
                        </div>';
          
          } else {

            $message_task .= "<p>The email does not exist!</p>"; 
          
          }

        

      }

      if($message_task != ""){
        $conclusion = '<div id="zzz" class="alert alert-danger" role="alert">
                        '.$message_task.'
                        </div>';
      }
    }

   
    
    if(isset($_POST['login-submit'])){

      

      $email = $password = "";

      $message_task = "";

      include("connectionDB.php");
      
      if(!$_POST['email-login']){
  
        $message_task .= "<p>The email address field is required!</p>";
  
      }
      if(!$_POST['password-login']) {

        $message_task .= "<p>The password field is required!</p>";

      }



      $query = 'SELECT `email`, `password`, `active` FROM `users` WHERE `email`="'.mysqli_real_escape_string($link, $_POST['email-login']).'"';
      
      $result = mysqli_query($link, $query);
      
      $row = mysqli_fetch_array($result);

      if($row != false){

        

        if (password_verify($_POST['password-login'], $row['password'])) {
          
          if($row['active'] == 1 ){
            $_SESSION['user'] = $row['email'];

            if(isset($_POST['exampleCheck1'])) {
              setcookie('user', $row['email'], time() + 60  * 60 * 24);
            }
            header("Location: session.php");
          } else {
            $message_task .= '<p>This account is not active!</p>';  
          }
          

        } else {
          
          $message_task .= '<p>Incorect password!</p>';

        }
      } else {

        $message_task .= '<p> Email or password incorrect!</p>';

      }
      
      if($message_task != ""){
        $conclusion2 = '<div class="alert alert-danger">'.$message_task.'</div>';
      }

   
  }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

  
?>
<!-- 
TODO: email verification - send email with a code blablabla
TODO: change password, forgot password? 
TODO: change color-->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Secret Diary</title>

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
  <hr style="width:50%">
  <div class="container general-form" id="login">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="login-panel">
      <div class="form-group" id="info-log-in">
        <p><strong>Log in using your email and password.</strong></p>  
      </div>
      <hr>
      <div id="login-errors" class="errors">
        <?php 
          echo $conclusion2;
        ?>
      </div>
      <div class="form-group">
        <label for="email-login">Email address</label>
        <input type="email" class="form-control" id="email-login" aria-describedby="emailHelp" name="email-login">
      </div>
      <div class="form-group">
        <label for="password-login">Password</label>
        <input type="password" class="form-control" id="password-login" name="password-login">
      </div>

      <div id="last-form-row" class="row container">
        <div class="form-group form-check col">
          <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <div id ="pass-reset"class="col text-right float-right">
          
          <a id="forgot-pass" href="forgotPass.php">Forgot password?</a>
        
        </div>
      </div>
      <button name="login-submit" id="login-btn" type="submit" class="btn btn-lg btn-warning">Login</button>
      <button type="button" id="sign-in-switch" class="btn btn-warning">Sign in</button>
    </form>
   
  </div>

  <div class="container general-form" id="sign-in">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="signup-panel">
      <div class="form-group" id="info-log-in">
        <p><strong>Interested? Sign up now!</strong></p>  
      </div>
      <hr>
      <div id="sign-in-errors" class="errors">
        <?php 
          echo $conclusion;
        ?>
      </div>
      <div class="form-group">
        <label for="email-sign-up">Email address</label>
        <input type="email" class="form-control" id="email-sign-up" aria-describedby="emailHelp" name="email-sign-up">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="password-sign-in">Password</label>
        <input type="password" class="form-control" id="password-sign-in" name="password-sign-in">
      </div>
      <div class="form-group">
        <label for="repassword-sign-in">Confirm Password</label>
        <input type="password" class="form-control" id="repassword-sign-in" name="repassword-sign-in">
      </div>
      
      
      <button name="sign-in-submit" id="sign-in-btn" type="submit" class="btn btn-primary btn-lg btn-warning">Sign in</button>
      <button type="button" id="login-switch" class="btn btn-warning">Login</button>
    </form>
    
  </div>
  <br>
  <hr style="width:50%">

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
  <script type="text/javascript" src="script/script.js"></script>
  <script type="text/javascript">
    console.log($('#zzz').text());
    console.log($('#zzz1').text());
    
     if($('#zzz').text() != "" || $('#zzz1').text() != ""){
      
      $("#sign-in").css("display", "block");
      $("#login").css("display", "none");    
    }
  </script>

</body>
</html>
