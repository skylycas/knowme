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
                                        <h1 class="h4 text-gray-900 mb-4">News!</h1>
                                        <hr>
                                    </div>
                                    <form class="user" action="./login.php" method="post">
                                        <p style="text-align: left;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam hendrerit aliquam justo, ut congue neque commodo in. Curabitur convallis ipsum tortor, 
                                            a posuere ipsum semper quis. Phasellus condimentum urna velit, vel eleifend lacus varius at. Vestibulum pellentesque massa laoreet nibh mattis blandit.
                                            Curabitur nec faucibus purus, ac cursus turpis. In non laoreet diam, ut malesuada ante. Vestibulum consequat laoreet lacus. Vivamus ut lectus porttitor,
                                            rutrum magna in, placerat odio. Duis semper arcu ut enim congue, quis mollis dolor semper. Maecenas elementum vitae enim ac viverra. Fusce mollis ligula quis arcu 
                                            pellentesque, at euismod mi facilisis.
                                        </p>
                                    </form>
                                    <hr>                                   
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