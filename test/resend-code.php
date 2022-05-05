<?php

    session_start();
    include('dbcon.php');

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    function resend_email_verify($name,$email,$verify_token)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = "acrux.ssl.hosttech.eu";
        $mail->Username = "register@kurmann.dev";
        $mail->Password = "reg$1234";

        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        $mail->setFrom("register@kurmann.dev",$name);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Email Bestaetigung";

        $email_template = "
            <h2>Du hast dich Registriert</h2>
            <a href='http://localhost/kurmann.dev/verfiy-email.php?token=$verify_token'> Press Hier </a>
        ";

        $mail->Body = $email_template;
        $mail->send();
        //echo 'Message has been sent';
    }

    if(isset($_POST['resend_email_verify_btn']))
    {
        if(!empty(trim($_POST['email'])))
        {
            $email = mysqli_real_escape_string($con,$_POST['email']);

            $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
            $checkemail_query_run = mysqli_query($con, $checkemail_query);

            if(mysqli_num_rows($checkemail_query_run) > 0)
            {
                $row = mysqli_fetch_array($checkemail_query_run);
                if($row['verify_status'] == "0")
                {
                    $name = $row['name'];
                    $email = $row['email'];
                    $verify_token = $row['verify_token'];
                    resend_email_verify($name,$email,$verify_token);

                    $_SESSION['status']= "Verifizierungs Email wurde gesendet.";
                    header("Location: login.php");
                    exit(0); 
                }
                else
                {
                    $_SESSION['status']= "Diese Email ist bersits verifiziert";
                    header("Location: login.php");
                    exit(0); 
                }
            }
            else
            {
                $_SESSION['status']= "Diese Email ist nicht registriert. Bitte Registriere dich!";
                header("Location: register.php");
                exit(0); 
            }
        }
        else
        {
            $_SESSION['status']= "Du hast dich erfolgreich eingeloggt!";
            header("Location: resend-email-verifacation.php");
            exit(0); 
        }
    }
?>