<?php
session_start();
include 'includes/loginheader.php';


if(isset($_POST["btnLogin"]))
{
    $_SESSION["EmailAddress"] = strtolower(trim($_POST["emailaddress"]));
    $password = $_POST["password"];    

    // connect to database
    include './includes/knowmeDB.php';
    $checkQuery = "SELECT * FROM tblusers WHERE emailaddress = '{$_SESSION["EmailAddress"]}'";    
    $result = $connect -> query($checkQuery);
    // echo $result -> num_rows; 
    if($result -> num_rows > 0)
    {       
        $rowRecord = $result -> fetch_assoc();
        if(password_verify($password, $rowRecord["password"]) === true ) //validate password
        {
            $_SESSION["FirstName"] = ucwords($rowRecord["firstname"]);
            $_SESSION["LastName"] = ucwords($rowRecord["lastname"]);
            $_SESSION["EmailAddress"] = strtolower($rowRecord["emailaddress"]);
            $_SESSION["new_UUID"] = $rowRecord["userid"];
            $_SESSION["profilepicturepath"] = $rowRecord["profilepicture"];

            $connect -> close();
            header("Location: index.php");
            die();
        }
        else
        {
            $_SESSION['errorMessage'] = "Invalid password! Click Forgot Password to reset your password.";
        }
    }
    else
    {
        $_SESSION['errorMessage'] = "Invalid email address! click Create an Account below to register.";
    }
    $connect -> close();
}
?>

<main>
    <div class="container" ng-init="logout()">

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
                                        <p style="color: red"> 
                                            <?php 
                                                if(isset($_SESSION['errorMessage']))
                                                {
                                                    echo $_SESSION["errorMessage"];
                                                    session_unset();
                                                    session_destroy();
                                                }
                                            ?>
                                        </p>
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" action="./login.php" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                   id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="Enter Email Address..." name="emailaddress" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                   id="exampleInputPassword" placeholder="Password" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">
                                                    Remember
                                                    Me
                                                </label>
                                            </div>
                                        </div>
                                        <!-- <a href="index.php" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </a> -->
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Login" name="btnLogin">
                                        <hr>
                                        <a href="index.php" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.php" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgotpassword.php">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="signup.php">Create an Account!</a>
                                    </div>
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