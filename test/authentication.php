<?php

    session_start();

    if(!isset($_SESSION['authenticated']))
    {
        $_SESSION['status']= "Bitte Anmelden um zum Dashboard zu gelangen.";
        header("Location: login.php");
        exit(0); 
    }

?>