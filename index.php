<?php
session_start();


    $userInfoArray = array();
    include './includes/knowmeDB.php';
    $checkQuery = "SELECT * FROM tblusers";    
    $result = $connect -> query($checkQuery);
    // echo $result -> num_rows; 
    if($result -> num_rows > 0)
    {       
        while($rowRecord = $result -> fetch_array())
        {
            //some iteration           
            $userInfoArray[] = $rowRecord;
        }
    }
    else
    {
        $_SESSION['errorMessage'] = "something wronf happened...";
    }
    $connect -> close();






include 'includes/headerpage.php';
?>
                <!-- Begin Page Content -->
                <div class="container-fluid">                     
                    <h1 class="h3 mb-4 text-gray-800">Dashboard / Home</h1>
                    <hr>
                <?php 
                    if(isset($userInfoArray))
                    {
                        include './includes/knowmeDB.php';
                        foreach($userInfoArray as $userrecord)
                        {
                            //get userid to use for sub query
                            $userid = $userrecord["userid"];
                            // echo "<p><i class='fa fa-square'></i>&nbsp;&nbsp;".$userrecord['userid']."</p>";
                            if($userrecord['profilepicture'])
                            {
                                 $profilepicture = $userrecord['profilepicture'];
                            }
                            else
                            {
                                 $profilepicture = './images/defaultsmall.png';
                            }
                            // echo "<img src='".$profilepicture."'alt='Profile Picture' class='rounded-circle roundprofilepicture' style='width:40px;'>";
                        
                           
                           
                            $fetchQuery = "SELECT * FROM vw_resume WHERE userid='$userid'";    
                            $result = $connect -> query($fetchQuery);
                            // echo $result -> num_rows; 
                            if($result -> num_rows > 0)
                            {       
                                $rowRecord = $result -> fetch_array();

                                $knownprofession = $rowRecord["professioname"];
                            }


                            $fetchQuery = "SELECT * FROM tblworkexperience WHERE userid='$userid' ORDER BY datecreated desc LIMIT 1";    
                            $result = $connect -> query($fetchQuery);
                            // echo $result -> num_rows; 
                            if($result -> num_rows > 0)
                            {       
                                $rowRecord = $result -> fetch_array();

                                $recentposition = $rowRecord["positionheld"];
                                $recentcompany= $rowRecord["companyname"];
                            }
                            

                            $fetchQuery = "SELECT * FROM tbleducation WHERE userid='$userid' ORDER BY datecreated desc LIMIT 1";    
                            $result = $connect -> query($fetchQuery);
                            // echo $result -> num_rows; 
                            if($result -> num_rows > 0)
                            {       
                                $rowRecord = $result -> fetch_array();

                                $recentcourse = $rowRecord["course"];
                                $recentschool = $rowRecord["schoolname"];
                            }

                            // $fetchQuery = "SELECT * FROM tblpersonalskill WHERE userid='$userid' ORDER BY datecreated desc LIMIT 1";    
                            // $result = $connect -> query($fetchQuery);
                            // // echo $result -> num_rows; 
                            // if($result -> num_rows > 0)
                            // {       
                            //     $rowRecord = $result -> fetch_array();

                            //     echo "...".$rowRecord["pskilldesc"];
                            // }

                        echo "<div style='width:5%; display:inline-block'> 
                            <img src='".$profilepicture."'alt='Profile Picture' class='rounded-circle roundprofilepicture' style='width:40px;'>
                            </div>
                        
                        <div style='width:90%; display:inline-block'> 
                        <div class='card shadow mb-4'>
                                <div class='card-header py-3'>
                                    <h6 class='m-0 font-weight-bold text-primary'>".strtoupper($userrecord['firstname']." ".$userrecord['lastname']." - ".$knownprofession)."</h6>
                                </div>
                                <div class='card-body'>
                                    <p> <b>Most Recent Position: </b>".$recentposition."</p>
                                    <p> <b>Most Recent Company: </b>".$recentcompany."</p>

                                    <hr>

                                    <p> <b>Most Course of Study: </b>".$recentcourse."</p>
                                    <p> <b>Most Recent School Attended: </b>".$recentschool."</p>
                                </div>
                            </div>
                        </div>";

                        }
                        $connect -> close();
                    }
                ?>
                </div>
                <!-- /.container-fluid -->
<?php include 'includes/footerpage.php'; ?>