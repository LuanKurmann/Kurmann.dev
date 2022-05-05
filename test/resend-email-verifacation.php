<?php 
    session_start();

    if(isset($_SESSION['authenticated']))
    {
        $_SESSION['status']= "Du bist bereits eingeloggt!";
        header("Location: dashboard.php");
        exit(0); 
    }

    $page_title = "Email verifikation";
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

                <div class="card">
                    <div class="card-header">
                        <h5>E-Mail Verification erneut senden</h5>
                    </div>
                    <div class="card-body">
                        <form action="resend-code.php" method="POST">
                            <div class="form-group mb-3">
                                <label>Email Adresse</label>
                                <input type="text" name="email" class="form-control" placeholder="Bitte E-Mail Adresse eiengeben">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="resend_email_verify_btn" class="btn btn-primary">Absenden</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    include('includes/footer.php');
?>