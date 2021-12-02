<?php
session_start();
include 'includes/loginheader.php';
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
                            <div class="col-lg-6 d-none d-lg-block bg-news-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">                                       
                                        <h1 class="h4 text-gray-900 mb-4">Get in Touch!</h1>
                                        <hr>
                                    </div>
                                    <form class="user" action="./signup.php" method="post">
                                <div class="form-group">
                                    <div class="col-sm-15 mb-3 mb-sm-0">
                                        <input type="text" class="form-control" id="exampleFirstName"
                                               placeholder="Full name" name="fullname" required>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="exampleInputEmail"
                                           placeholder="Email Address" name="Emailaddress" required>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-15 mb-3 mb-sm-0">
                                        <input type="text" class="form-control"
                                               id="exampleInputPassword" placeholder="Subject" required>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-15 mb-3 mb-sm-0">                                        
                                        <textarea name="" class="form-control" id="" cols="20" rows="10" placeholder="message"></textarea>
                                    </div>                                    
                                </div>
                                <!-- <a href="login.php" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </a> -->
                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Send" name="btnSignUp">
                                <hr>                               
                            </form>                                 
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