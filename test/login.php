<?php 
    session_start();

    if(isset($_SESSION['authenticated']))
    {
        $_SESSION['status']= "Du bist bereits eingeloggt!";
        header("Location: dashboard.php");
        exit(0); 
    }

    $page_title = "Login";
    include('includes/header.php');
    include('includes/navbar.php'); 
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <?php
                    if(isset($_SESSION['status']))
                    {
                        ?>
                        <div class="alert alert-success">
                            <h5><?= $_SESSION['status']; ?></h5>
                        </div>
                        <?php
                        unset($_SESSION['status']);
                    }
                ?>

                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login</h5>
                    </div>
                    <div class="card-body">
                        <form action="logincode.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Passwort</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <hr>
                        <h5>
                            Keine Verifakation erhalten?
                            <a href="resend-email-verifacation.php">Erneut Senden</a>
                        </h5>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    include('includes/footer.php');
?>