<?php
session_start();
include 'includes/loginheader.php';

// Code for Sign up starts here
if(isset($_POST["btnSignUp"]))
{
    try
    {
        $_SESSION["FirstName"] = strtolower(trim($_POST["FirstName"]));
        $_SESSION["LastName"] = strtolower(trim($_POST["LastName"]));
        $_SESSION["Emailaddress"] = strtolower(trim($_POST["Emailaddress"]));
        $password = password_hash($_POST["Password"], PASSWORD_DEFAULT);

        // Create UUID
        $_SESSION["new_UUID"] = include './includes/generateuuid.php';
        // connect to database
        include './includes/knowmeDB.php';
        $checkQuery = "SELECT emailaddress from tblusers WHERE emailaddress= '{$_SESSION["Emailaddress"]}'";
        $retVal = $connect -> query($checkQuery);
        if($retVal -> num_rows > 0)
        {
            $_SESSION["errorMessage"] = $_SESSION["errorMessage"]. " is already registered.";
        }
        else
        {
            $insertQuery = "INSERT INTO tblusers(userid, firstname, lastname, emailaddress, password) VALUES('{$_SESSION["new_UUID"]}', '{$_SESSION["FirstName"]}', '{$_SESSION["LastName"]}', '{$_SESSION["Emailaddress"]}', '$password')";
            $retVal = $connect -> query($insertQuery);
            if($retVal === true)
            {
                $connect -> close();
                header("Location: ./congrats.php");
                die();
            }
            else
            {
                // write something here
                $_SESSION["errorMessage"] =  "There was an issue, please contact the Administrator";
                echo $connect -> error . "-------". $_SESSION["new_UUID"];
                $connect -> close();
            }
        }
    }
    catch(Exception $e)
    {
        echo $e -> getMessage();
    }
    
}

?>

<main>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h5 style="color:red" name="errormessage">
                                     <?php
                                        if (isset($_SESSION["errorMessage"])){
                                        echo $_SESSION["errorMessage"];
                                        session_destroy();
                                        }
                                    ?>
                                </h5>
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" action="./signup.php" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                               placeholder="First Name" name="FirstName" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                               placeholder="Last Name" name="LastName" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                           placeholder="Email Address" name="Emailaddress" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                               id="exampleInputPassword" placeholder="Password" name="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                               id="exampleRepeatPassword" placeholder="Repeat Password" name="ConfirmPassword" required>
                                    </div>
                                </div>
                                <!-- <a href="login.php" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </a> -->
                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Register Account" name="btnSignUp">
                                <hr>
                                <a href="index.php" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.php" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgotpassword.php">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include 'includes/loginfooter.php'; ?>