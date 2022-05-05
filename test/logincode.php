<?php

    session_start();
    include('dbcon.php');

    if(isset($_POST['login_btn']))
    {

        if(!empty(trim($_POST['name'])) && !empty(trim($_POST['password'])))
        {
            $name = mysqli_real_escape_string($con,$_POST['name']);
            $password = mysqli_real_escape_string($con,$_POST['password']);

            $login_query = "SELECT * FROM users WHERE name='$name' AND password='$password'";
            $login_query_run = mysqli_query($con, $login_query);

            if(mysqli_num_rows($login_query_run) > 0)
            {
                $row = mysqli_fetch_array($login_query_run);
                if($row['verify_status'] == "1")
                {
                    $_SESSION['authenticated'] = TRUE;
                    $_SESSION['auth_user'] = [
                        'username' => $row['name'],
                        'email' => $row['email'],
                    ];

                    $_SESSION['status']= "Du hast dich erfolgreich eingeloggt!";
                    header("Location: dashboard.php");
                    exit(0); 

                }
                else
                {
                    $_SESSION['status']= "Bitte verifiziere deine Email adresse.";
                    header("Location: login.php");
                    exit(0); 
                }
            }
            else
            {
                $_SESSION['status']= "Name oder Passwort falsch.";
                header("Location: login.php");
                exit(0);
            }

        }
        else
        {
            $_SESSION['status']= "Bitte alle Felder ausfüllen!";
            header("Location: login.php");
            exit(0);
        }
    }

?>