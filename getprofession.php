<?php
session_start();
try
{
    //  $test;
    // // connect to database
    // $testarray = [];
    // $cars = array("Volvo", "BMW", "Toyota");
    // echo count($cars);

    $output = array();
    include './includes/knowmeDB.php';
    $selectQuery = "SELECT * from tblprofessions";
    $retVal = $connect -> query($selectQuery);
    if($retVal -> num_rows > 0)
    {
        // $rowRecord = $retVal -> fetch_array()
        while($rowRecord = $retVal -> fetch_array())
        {
            //some iteration           
            $output[] = $rowRecord;
        }
       
    }
    else
    {
        $_SESSION["errorMessage"] = "You do not have any message.";
        $connect -> close();
    }

    //  return $output;
     echo json_encode($output);
}
catch(Exception $e)
{
    echo $e -> getMessage();
}

?>