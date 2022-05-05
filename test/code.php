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

    function sendemail_verify($name,$email,$verify_token)
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

    if(isset($_POST['register_btn']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $verify_token = md5(rand());


        // Email Exisistiert oder nicht
        
        $check_emial_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
        $check_emial_query_run = mysqli_query($con, $check_emial_query);

        if(mysqli_num_rows($check_emial_query_run) > 0)
        {
            $_SESSION['status'] = "Email existiert Bereits";
            header("Location: register.php");
        }
        else
        {
            // Benutzer Registrieren und in DB eintragen
            $query = "INSERT INTO users (name,email,password,verify_token) VALUES ('$name','$email','$password','$verify_token')";
            $query_run = mysqli_query($con, $query);

            if($query_run)
            {
                sendemail_verify("$name","$email","$verify_token");
                $_SESSION['status'] = "Registration erfolgreich! Bitte bestätige deine E-Mail Adresse.";
                header("Location: register.php");
            }
            else
            {
                $_SESSION['status'] = "Registration fehlgeschlagen";
                header("Location: register.php");
            }
        }
    }

?>