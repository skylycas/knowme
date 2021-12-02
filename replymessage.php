<?php
session_start();
include 'includes/headerpage.php';

if(isset($_POST["btnsend"]))
{
    // echo $_POST["txtemailaddress"];
    try
    {
            //generate message id
        $messageid = include './includes/generateuuid.php';
        $toemailaddress = $_POST["txtemailaddress"];
        $subject = addslashes($_POST["txtsubject"]); //addslashes escapes all special character
        $message = addslashes($_POST["txtmessage"]);


        $toid; //declare a global variable to store th userid of the recipient
        // connect to database
        include './includes/knowmeDB.php';
        $selectQuery = "SELECT userid from tblusers WHERE emailaddress = '$toemailaddress'";
        $retVal = $connect -> query($selectQuery);
        if($retVal -> num_rows > 0)
        {
            $rowRecord = $retVal -> fetch_assoc();
            $toid = $rowRecord["userid"];

            //insert query to insert a new message
            $insertQuery = "INSERT INTO tblmessages(messageid, fromid, toid, subject, message) VALUES('$messageid', '{$_SESSION["new_UUID"]}', '$toid', '$subject', '$message')";
            $retVal = $connect -> query($insertQuery); //execute the query
            if($retVal === true)
            {
                $connect -> close();
                $_SESSION['errorMessage'] = "Hurray!! your message has been sent to ".$toemailaddress." successfully";
                // die();
            }
            else
            {
                $_SESSION["errorMessage"] =  $connect -> error. " There was an issue, please contact the Administrator";
                $connect -> close();
            }
        }
        else
        {
            $_SESSION['errorMessage'] = "The recepient email you enetered does not exist, you can only send messages to registered users.";
        }
    }
    catch(Exception $e)
    {
        echo $e -> getMessage();
    }
}

?>
<!-- Begin Page Content -->
<div class="container-fluid" ng-init="getAmessage()">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Send a Message</h1>
    <hr>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="./replymessage.php" method="post">
            <h5 style="color:red">
                    <?php
                    if(isset($_SESSION['errorMessage']))
                    {
                        echo $_SESSION["errorMessage"];
                        unset($_SESSION["errorMessage"]);
                    }
                    ?>
                </h5>
                <h5 style="color:red"><b>Sender</b> : {{sendername | uppercase}}</h5>
                <p><input readonly type="text" class="form-control col-sm-5 mb-3 mb-sm-0" id="txtemailaddress" name="txtemailaddress" value = {{senderemailaddress}}></p>
                <p><input type="text" class="form-control col-sm-5 mb-3 mb-sm-0" id="txtsubject" name="txtsubject" value ="RE: {{subject}}"></p>
                <p><textarea class="form-control col-sm-5 mb-3 mb-sm-0" name="txtmessage" id="txtmessage" cols="30" rows="15" maxlength="5000"></textarea></p>
                <input type="submit" class="btn btn-primary btn-user col-sm-5 mb-3 mb-sm-0" value="Send Message" name="btnsend">
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php include 'includes/footerpage.php'; ?>