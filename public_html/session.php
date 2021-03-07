<?php

    session_start();

    $diaryContent = "";

    if(array_key_exists('user', $_COOKIE)) {
        $_SESSION['user'] = $_COOKIE['user'];
    }     

    if(array_key_exists('user', $_SESSION)){
        #echo "LOGGED IN!";
        #echo $_COOKIE['user'];
        #echo $_SESSION['user'];

        include("connectionDB.php");

        $query = 'SELECT `diary` FROM `users` WHERE email="'.mysqli_real_escape_string($link, $_SESSION['user']).'" LIMIT 1';

        $row = mysqli_fetch_array(mysqli_query($link, $query));

        $diaryContent = $row['diary'];

    } else {
        header("Locotation: index.php");
    }
    



    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/session.css">
    <title>Document</title>
</head>
<body>
    <nav class="navbar sticky-top">
        <a class="navbar-brand" href="#">
        <p class="logo-font text-center">Secret Diary</p>
        </a>


        <button class="navbar-toggler second-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent23"
            aria-controls="navbarSupportedContent23" aria-expanded="false" aria-label="Toggle navigation">
            <div class="animated-icon2"><span></span><span></span><span></span><span></span></div>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent23">
            <hr>
            <!-- Links -->
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Change color <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?logout=1">Log out</a>
            </li>
            </ul>
            <!-- Links -->

        </div>
        <!-- Collapsible content -->
    </nav>
    <div class="wrapper">
        <textarea class="form-control" id="diary" cols="30" rows="30"><?php echo $diaryContent?></textarea>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script type="text/javascript" src="script/session_script.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#diary").bind('input propertychange', function(){
                $.ajax({
                    method: "POST",
                    url: "updateDatabase.php",
                    data: {content : $("#diary").val() }
                });

            });


        });

    </script> 
</body>
</html>