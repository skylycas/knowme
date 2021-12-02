<?php
session_start();
include 'includes/headerpage.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Inbox</h1>
    <hr>

    <!-- Dropdown Card Example -->
    <div class="card shadow mb-4 col-sm-7" ng-repeat = "items in inboxdata">
            <!-- Card Header - Dropdown -->
            <p hidden>{{items.messageid}}</p>
            <p hidden>{{items.senderemailaddress}}</p>
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="blockpartition2">
                    <h6 class="m-0 text-primary">{{items.sendername | uppercase}}</h6>
                </div>
                <div>
                    <h6 class="m-0 text-primary">{{items.datecreated | date }}</h6>
                </div>                
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Reply</a>
                        <a class="dropdown-item" href="#">Delete</a>
                        <!-- <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a> -->
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
            <!-- <a href="#" class="btn btn-light" ng-click="selectAmessage(items)"> -->
                <a href="./inboxread.php" class="btn btn-light" ng-click="selectAmessage(items)">
                    <span class="text"><b>{{items.subject}}</b> - {{items.message | limitTo:70 }}...</span>
                </a>
            </div>                      
    </div>

   <p>{{valuee}}</p>
</div>
<!-- /.container-fluid -->
<?php include 'includes/footerpage.php'; ?>