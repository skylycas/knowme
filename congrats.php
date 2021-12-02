
<?php
session_start();
include 'includes/loginheader.php';
?>

<main>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">HURRAY!!! 
                                            <?php
                                            if (isset($_SESSION["FirstName"]))
                                            {
                                                echo " ". strtoupper($_SESSION["FirstName"]);
                                                session_unset();
                                                session_destroy();
                                            }
                                            else
                                            {
                                                header("Location: ./login.php");
                                            }
                                            ?>
                                        </h1>
                                        <P>You are one step closer to getting known by millions of like minds and employers.</P>
                                    </div>                                    
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Now, Click Here to Login?</a>
                                    </div> 
                                    <br><br><br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</main>

<?php include 'includes/loginfooter.php'; ?>