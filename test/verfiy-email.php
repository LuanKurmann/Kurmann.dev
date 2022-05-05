<?php

    session_start();
    include('dbcon.php');

    if(isset($_GET['token']))
    {
        $token = $_GET['token'];
        $verfy_query = "SELECT verify_token, verify_status FROM users WHERE verify_token = '$token' LIMIT 1";
        $verfy_query_run = mysqli_query($con, $verfy_query);

        if(mysqli_num_rows($verfy_query_run) > 0)
        {
            $row = mysqli_fetch_array($verfy_query_run);
            if($row['verify_status'] == "0")
            {
               $clicked_token = $row['verify_token'] ;
               $update_query = "UPDATE users SET verify_status='1' WHERE verify_token='$clicked_token' LIMIT 1";
               $update_query_run = mysqli_query($con, $update_query); 

               if($update_query_run)
               {
                $_SESSION['status'] = "Dein Acount wurde Verifiziert!";
                header("Location: login.php"); 
                exit(0);
               }
               else
               {
                $_SESSION['status'] = "Verifakation Fehlegschlagen!";
                header("Location: login.php"); 
                exit(0);
               }

            }
            else
            {
                $_SESSION['status'] = "Diese E-Mail ist bereit Registriet bitte Anmelden!";
                header("Location: login.php"); 
                exit(0);
            }
        }
        else
        {
            $_SESSION['status'] = "Dieser Token existiert nicht!";
            header("Location: login.php"); 
        }

    }
    else
    {
        $_SESSION['status'] = "Not Allowed";
        header("Location: login.php");
    }

?>