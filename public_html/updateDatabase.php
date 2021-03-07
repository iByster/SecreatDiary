<?php

    session_start();

    if(array_key_exists("content", $_POST)){
        include("connectionDB.php");
        
        $query = 'UPDATE `users` SET `diary`="'.mysqli_real_escape_string($link ,$_POST['content']).'" WHERE `email`="'.mysqli_real_escape_string($link, $_SESSION['user']).'" LIMIT 1';

        

        mysqli_query($link, $query);
             
    }

?>