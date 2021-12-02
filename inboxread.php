<?php
session_start();
include 'includes/headerpage.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Inbox</h1>
    <hr>

    <div class="card shadow mb-4" ng-init="getAmessage()">
        <div class="card-body">
            <div class ="blockpartition">                
                <p><b>Sender</b> : {{sendername | uppercase}}</p>
                <p><b>Subject</b> : {{subject}}</p>
                <p><b>Message</b> : <br> {{message}}</p>
                <a href="./inbox.php" class="btn btn-primary btn-user" > <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Inbox</a>
                <a href="./replymessage.php" class="btn btn-primary btn-user" > <i class="fa fa-reply" aria-hidden="true"></i> Reply</a>
                <a href="./inbox.php" class="btn btn-primary btn-user" > <i class="fa fa-forward" aria-hidden="true"></i> Forward</a>
            </div>
        </div>
    </div>

   
</div>
<!-- /.container-fluid -->
<?php include 'includes/footerpage.php'; ?>