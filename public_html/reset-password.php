

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/reset-password.css">

    
</head>
<body>
    
<div class="container general-form" id="reset-password">
    <?php
        $reset_error = "";
        $flag_succes = 0;

        if(isset($_POST["change-password"])) {
            


            if(!$_POST['rpassword-input']) {
                $reset_error .= "<p> The password field is required! </p>";

                
            } else if(strlen($_POST['rpassword-input']) < 6) {
                $reset_error .= "<p> The password is too short! </p>";
            }

            if(!$_POST['crpassword-input']) {
                $reset_error .= "<p> The confirm password field is required! </p>";
            
                
            }

            if($_POST['crpassword-input'] != $_POST['rpassword-input']) {
                $reset_error .= "<p> The passwords do not match! </p>";
            }

            if($reset_error == "") {

                include("connectionDB.php");

                $password = mysqli_real_escape_string($link, $_POST['rpassword-input']);
                $email = mysqli_real_escape_string($link, $_POST['email']);
                $token = mysqli_real_escape_string($link, $_POST['reset_link_token']);

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $query = 'SELECT `id` FROM `users` WHERE `email`="'.$email.'" AND `reset_token`="'.$token.'" LIMIT 1';

                $result = mysqli_query($link, $query);

                $row = mysqli_fetch_array($result);

                if($row) {
                    $query = 'UPDATE `users` SET `password`="'.$hash.'", `reset_exp_date`="'. NULL . '", `reset_token`="'. NULL .'" WHERE `id`='.$row['id'].' LIMIT 1';

                    $update = mysqli_query($link, $query);

                    ?>

                    <div class="text-center">
                        <h1 class="ops">Congrats!</h1>
                    </div>
                    </div>
                    <div class="container text-center" id="expired-link-panel">
                        <div class="alert alert-success" id="error-message">
                            <h1 style="font-family: roboto-thin;">Your password has been updated successfully.</h1>
                            <a href="index.php">Home</a>
                        </div>
                    </div>
                <?php
                    $flag_succes = 1;
                } else { 
                ?>
                     <div class="text-center">
                        <h1 class="ops">OOOPS!</h1>
                    </div>
                    </div>
                    <div class="container text-center" id="expired-link-panel">
                        <div class="alert alert-danger" id="error-message">
                            <h1 style="font-family: roboto-thin;">Something went wrong!</h1>
                                <p class="lead">
                                    Please try again later.
                                    <a href="index.php">Home</a>
                            </p>
                        </div>
                    </div>
                <?php    

                }

            } else {
                    
                ?>
                <div class="alert alert-danger">
                            <?php
                                echo $reset_error;
                            ?>
                </div>
                <?php
            }   


        }
                        
        if($flag_succes != 1){

        if(isset($_GET['key']) && isset($_GET['token'])){

        if($_GET['key'] && $_GET['token']){
            include("connectionDB.php");

            $email = mysqli_real_escape_string($link, $_GET['key']);
            $token = mysqli_real_escape_string($link, $_GET['token']);
            $query = 'SELECT * FROM `users` WHERE `reset_token`="'.$token.'" AND `email`="'.$email.'" LIMIT 1';

            $result = mysqli_query($link, $query);

            $row = mysqli_fetch_array($result);

            $curDate = date('Y-m-d H:i:s');



            if($row){
                if($row['reset_exp_date'] >= $curDate)  {?>
                <form method="post" action="" id="reset-password-panel">
                    <input type="hidden" name="email" value="<?php echo $email;?>">
                    <input type="hidden" name="reset_link_token" value="<?php echo $token;?>">
                    <div class="form-group">
                        <label for="rpassword-input">New Password</label>
                        <input type="password" class="form-control" id="rpassword-input" name="rpassword-input">
                    </div>
                    <div class="form-group">
                        <label for="crpassword-input">Confirm New Password</label>
                        <input type="password" class="form-control" id="crpassword-input" name="crpassword-input">
                    </div>
                    
                    
                    <button name="change-password" id="change-password" type="submit" class="btn btn-lg btn-warning">Change Password</button>
                        
                </form>
        </div>            
    <?php 
                } else {
    ?>              
    

                    <div class="text-center">
                        <h1 class="ops">OOOPS!</h1>
                    </div>
                    </div>
                    <div class="container text-center" id="expired-link-panel">
                        <div class="alert alert-danger" id="error-message">
                            <h1 style="font-family: roboto-thin;">This forget password link has been expired!</h1>
                                <p class="lead">
                                    <a href="index.php">Home</a>
                            </p>
                        </div>
                    </div>
    <?php
                } 
            } else { 
    ?>
                
                <div class="text-center">
                        <h1 class="ops">OOOPS!</h1>
                    </div>
                </div>
                <div class="container text-center" id="expired-link-panel">
                        <div class="alert alert-danger" id="error-message">
                            <h1 style="font-family: roboto-thin;">This forget password link has been expired!</h1>
                                <p class="lead">
                                    <a href="index.php">Home</a>
                            </p>
                        </div>
                    </div>
    <?php
             }
        }  
    }else {
    ?>
        
        </div>
        
        <div class="alert alert-danger">
                <strong>Token missing! Please return to the home page and press <a href="index.php"><u>Forgot Password?</u></a></strong>
        </div>
    <?php
    }
}
    ?>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
    <script type="text/javascript">
        /* $('#reset-password-panel').submit(function(e){
            var errs = "";
            var flag1 = false, flag2 = false;
            var password = $("#rpassword-input").val();
            var confPassword = $("#crpassword-input").val();
            if(password == ""){
                errs += "<p> The Password field is required!</p>";
            } else {
                
                if(password.lenght < 6){
                    errs += "<p> Your password is too short! Min 6 chars.</p>";
                } else {
                    flag1 = true;
                }
                  
            }
            if(confPassword == ""){
                    errs += "<p> The Confirm Password field is required!</p>";
            } else {
                flag2 = true;
            }

            if(flag1 && flag2) {
                if(password != confPassword) {
                    errs += "<p> The passwords do not match! </p>";
                }
            }

            if(errs != ""){

                $("#reset-password-errors").html(errs);
                e.preventDefault();
                return false;
            } else {
                var email = "<?php #echo $email ?>";
                var token = "<?php #echo $token ?>"
                var url = 'http://secreat-diary-io.stackstaging.com/update-forget-password.php?email=' + email + '&token=' + token + '&'
            }


            
        });
 */
    </script>


</body>
</html>