<?php
    
    $error = "";

    if(isset($_POST['send-reset'])) {


            if(!$_POST['staticEmail']){

                $error .= "<p>The email address field is required!</p>";

            } else if(!filter_var($_POST['staticEmail'], FILTER_VALIDATE_EMAIL)) {

                $error .= "<p>The email adress is not valid!</p>";

            } /* else if(!checkdnsrr(array_pop(explode("@",$_POST['email-sign-up'])), 'MX')){

                $message_task .= "<p>The domain name is not valid!</p>";

            } */ else if(test_input($_POST['staticEmail']) != $_POST['staticEmail']) {
                
                $error .= "<p>The email can't contain special chars!</p>";
            
            } else {

                include("connectionDB.php");

                $email = mysqli_real_escape_string($link, $_POST['staticEmail']);

                $query = 'SELECT `id`, `email` FROM `users` WHERE `email`="'.$email.'" LIMIT 1';

                $select = mysqli_query($link, $query);

                $row = mysqli_fetch_array($select);

                if($row) {
                    $token = md5($email).rand(10,9999);

                    $expFormat = mktime(date('H'), date('i'), date('s'), date('m'), date('d') + 1, date('Y'));

                    $expDate = date("Y-m-d H:i:s", $expFormat);

                    $query = 'UPDATE `users` SET `reset_token`="'.$token.'", `reset_exp_date`="'.$expDate.'" WHERE `email`="'.$email.'" LIMIT 1';

                    if(mysqli_query($link, $query)){

                        $subject = "Reset password request!";

                        $body =' Follow the instructions.
                        To reset your password please click this link:                 
                        
                        http://secreat-diary-io.stackstaging.com/reset-password.php?key='.$email.'&token='.$token.'
                            

                        !!!WARNING!!!
                        THIS LINK HAS AN EXPIRING DATE
                        !!!WARNING!!!
                        ';

                        $headers = "From: ganealexandru01@gmail.com";

                        if(@mail($email, $subject, $body, $headers)){

                            $error = "";

                        } else {
                            $error = "<p> There was an error sending the email! Please try again later.</p>";
                        }
                    } else {
                        $error = "<p> Something went wrong! Please try again later.</p>";
                    }
            } else {
                $error = "<p> This is email is not registred! </p>";
            }
        }
        if($error != "") {
            $error = '<div class="alert alert-danger" role="alert">
                    '.$error.'
                    </div>';
              
        
        } else {
            $error = '<div class="alert alert-success" role="alert">
                    We sent you an email with instructions for reseting your password!
                    </div>';
            
        }
    } 

   
    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
  


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Secreat Diary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/resetpass.css">
</head>
<body>
    <form action="" class="container" method="post">
        <h2 class="logo-font-smaller">
            <a href="index.php">
                Secreat Diary
            </a>
        </h2>
        <hr>
        <h1>RESET PASSWORD</h1>
        <div id="forgot-pass-errors" class="errors">
        <?php 
          echo $error;
        ?>
      </div>
        <div class="row">
            <div class="col-md-2" id="label-col">
                <label style="padding-left: 15px" for="staticEmail">Email Adress</label>
            </div>
            <div id="email-wrapper" class="col-md">
                <input type="text" class="form-control" id="staticEmail" name='staticEmail'>
            </div>
            <div class="col-md">
                <button class="btn btn-warning" type="submit" id="btn-done" name="send-reset">Send</button>
            </div>
        </div>

        
    </form>
    

    <div class="footer">
        <!-- <div class="sub-color"></div> -->
        
        <div class="sub-color"></div>
        
        <div class="sub-color" id="sub-sub-color"></div>

        <!-- <h1>HMMMM...</h1> -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

</body>
</html>