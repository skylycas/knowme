<?php
session_start();
try
{    
     include './includes/knowmeDB.php';
     $data = json_decode(file_get_contents("php://input"));
    
         $currentdate = date("Y-m-d h:i:sa");
         $messageid = $data -> varmessageid;
         $updateQuery = "UPDATE tblmessages SET isread = true, dateread = '$currentdate' WHERE messageid = '$messageid'";

         if($retVal = $connect -> query($updateQuery))
         {
             echo "success";
         }
         else{
             echo  "Message could not be read/updated";
         }
     $connect -> close();    

    // echo  $messageid;
}
catch(Exception $e)
{
    echo $e -> getMessage();
}

?>