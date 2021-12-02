<?php
session_start();



$selectQueryresume = "SELECT * FROM vw_resume WHERE userid = '{$_SESSION["new_UUID"]}'";
$selectQueryskills = "SELECT * FROM tblskills WHERE userid = '{$_SESSION["new_UUID"]}'";
$selectQuerypersonalskill = "SELECT * FROM tblpersonalskill WHERE userid = '{$_SESSION["new_UUID"]}'";
$selectQueryeducation = "SELECT * FROM tbleducation WHERE userid = '{$_SESSION["new_UUID"]}'";
$selectQueryworkexperience = "SELECT * FROM tblworkexperience WHERE userid = '{$_SESSION["new_UUID"]}'";


    $retSkillArray = array();
    $retpersonalskillArray = array();
    $reteducationArray = array();
    $retworkexperienceArray = array();
    include './includes/knowmeDB.php';

    try
    {

        $retVal = $connect -> query($selectQueryresume);
        if($retVal -> num_rows > 0)
        {
            $rowRecord = $retVal -> fetch_array();

            $_SESSION["fullname"] = ucwords($rowRecord["firstname"] ." ".$rowRecord["lastname"]);
            $_SESSION["emailaddress"] = strtolower($rowRecord["emailaddress"]);
            $_SESSION["professioname"] = strtoupper($rowRecord["professioname"]);
            $_SESSION["telephone"] = strtoupper($rowRecord["telephone"]);
            $_SESSION["address"] = ucwords($rowRecord["address"]);
            $_SESSION["city"] = ucwords($rowRecord["city"]);
            $_SESSION["country"] = ucwords($rowRecord["country"]);
            $_SESSION["postalcode"] = strtoupper($rowRecord["postalcode"]);
            $_SESSION["covertletter"] = $rowRecord["covertletter"];
        }


        $retVal = $connect -> query($selectQueryskills);
        if($retVal -> num_rows > 0)
        {
            // $rowRecord = $retVal -> fetch_array()
            while($rowRecord = $retVal -> fetch_array())
            {
                //some iteration           
                $retSkillArray[] = $rowRecord;
            }
        
        }


        $retVal = $connect -> query($selectQuerypersonalskill);
        if($retVal -> num_rows > 0)
        {
            // $rowRecord = $retVal -> fetch_array()
            while($rowRecord = $retVal -> fetch_array())
            {
                //some iteration           
                $retpersonalskillArray[] = $rowRecord;
            }
        
        } 

        $retVal = $connect -> query($selectQueryeducation);
        if($retVal -> num_rows > 0)
        {
            // $rowRecord = $retVal -> fetch_array()
            while($rowRecord = $retVal -> fetch_array())
            {
                //some iteration           
                $reteducationArray[] = $rowRecord;
            }
        
        }


        $retVal = $connect -> query($selectQueryworkexperience);
        if($retVal -> num_rows > 0)
        {
            // $rowRecord = $retVal -> fetch_array()
            while($rowRecord = $retVal -> fetch_array())
            {
                //some iteration           
                $retworkexperienceArray[] = $rowRecord;
            }
        
        }

        $connect -> close();

    }
    catch(Exception $e)
    {
        echo $e -> getMessage();
    }





include 'includes/headerpage.php';
?>
                <!-- Begin Page Content -->
                <div class="container-fluid">                    
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Profile Page</h1>
                    <hr>
                    <br><br>
                    <h1><?php if(isset($_SESSION["fullname"])) { echo $_SESSION["fullname"];} ?></h1>
                    <hr>
                    <h5 style="text-align:center"><?php if(isset($_SESSION["professioname"])) {echo $_SESSION["professioname"];} ?></h5>
                    <p><?php if(isset($_SESSION["emailaddress"])) {echo "<b>Email:</b> ". $_SESSION["emailaddress"];} ?></p>
                    <p><?php if(isset($_SESSION["telephone"])) { echo "<b>Telephone:</b> ". $_SESSION["telephone"];} ?></p>
                    <p><?php if(isset($_SESSION["address"])) { echo "<b>Address:</b> ". $_SESSION["address"].", ".$_SESSION["city"].", ".$_SESSION["postalcode"].", ".$_SESSION["country"];}?></p>
                    <br>
                    <h4>Cover Letter</h4>
                    <hr>
                    <p><?php if(isset($_SESSION["covertletter"])) { echo $_SESSION["covertletter"];} ?></p>
                    <br>
                    <h4>Skills</h4>
                    <hr>
                    <?php
                        if(isset($retSkillArray))
                        {
                            foreach($retSkillArray as $ret)
                            {
                               echo "<p><i class='fa fa-square'></i>&nbsp;&nbsp;".$ret['skilldesc']."</p>";                               
                            }
                        }
                    ?>
                    <br>                    
                    <h4>Work Experience</h4>
                    <hr>
                    <?php
                        if(isset($retworkexperienceArray))
                        {
                            foreach($retworkexperienceArray as $ret)
                            {
                            //    echo "<p><i class='fa fa-square'></i>&nbsp;&nbsp;".$ret['pskilldesc']."</p>";
                               
                               echo "<div class='card mb-1 col-sm-8'>
                                        <div class='card-header'>
                                            <div class='itemslistcontainer'>
                                                <p><b>Position:</b> ".$ret['positionheld']."</p>
                                                <p><b>Company:</b> ".$ret['companyname']."</p>
                                            </div>                                    
                                        </div>
                                        <div class='card-body'>
                                        <b>Job Description:</b><br>".$ret['jobdesc'].
                                        "</div>
                                    </div>";
                            }
                        }
                    ?>
                    <br>
                    <br>
                    <h4>Personal Skills</h4>
                    <hr>
                    <?php
                        if(isset($retpersonalskillArray))
                        {
                            foreach($retpersonalskillArray as $ret)
                            {
                               echo "<p><i class='fa fa-square'></i>&nbsp;&nbsp;".$ret['pskilldesc']."</p>";                               
                            }
                        }
                    ?>
                    <br>
                    <h4>Education</h4>
                    <hr>

                    <?php
                        if(isset($reteducationArray))
                        {
                            foreach($reteducationArray as $ret)
                            {
                             echo  "<p>
                                        <i class='fa fa-square'></i>&nbsp;&nbsp;". $ret['course'].
                                        "<br>
                                        <i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ret['schoolname']."</i>
                                    </p>";
                            }
                        }
                    ?>
                </div>
                <!-- /.container-fluid -->
<?php include 'includes/footerpage.php'; ?>