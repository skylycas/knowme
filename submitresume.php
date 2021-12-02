<?php
session_start();
try
{    
    $data = json_decode(file_get_contents("php://input"));
    
    $userid =  $_SESSION["new_UUID"];
    $resumeid = include './includes/generateuuid.php';
    $professionid = $data -> professionid;
    $telephone = $data -> telephone;
    $address = addslashes($data -> address);
    $city = addslashes($data -> city);
    $postalcode = $data -> postalcode;
    $country = $data -> country;
    $coverletter = addslashes($data -> coverletter);

    $skills = array();
    $skills = json_decode($data -> skills, true);

    $workexperience = array();
    $workexperience = json_decode($data -> workexperience, true);

    $education = array();
    $education = json_decode($data -> education, true);

    $personalskills = array();
    $personalskills = json_decode($data -> personalskills, true);


    // $globalArray = array_merge($skills, $workexperience, $education, $personalskills);
    // array_push($globalArray, $skills, $workexperience, $education, $personalskills);

    // array_push($globalArray, $workexperience[]);
    // $globalArray = json_encode($skills);
    
    // $globalArray = json_encode($workexperience);
    // array_push(json_decode($globalArray), json_encode($workexperience));
    // $globalArray = ((array) new $workexperience);

    //  echo json_encode($globalArray);
    // var_dump($globalArray);

    
    // echo json_encode($skills);
    
    $buildQuerySkills = "INSERT INTO tblskills(userid, skilldesc) VALUES ";
    foreach($skills as $skillitem)
    {
        $buildQuerySkills .= "('".$userid."','".addslashes($skillitem)."'),";
    }
    $insertQuerySkills = trim($buildQuerySkills, ',');


    $buildQueryworkexperience = "INSERT INTO tblworkexperience(userid, positionheld, companyname, jobdesc) VALUES ";
    foreach($workexperience as $workexperienceitem)
    {
        $buildQueryworkexperience .= "('".$userid."','".addslashes($workexperienceitem['positionheld'])."','".addslashes($workexperienceitem['nameofcompany'])."','".addslashes($workexperienceitem['jobdescription'])."'),";
    }
    $insertQueryworkexperience = trim($buildQueryworkexperience, ',');


    $buildQueryeducation = "INSERT INTO tbleducation(userid, course, schoolname) VALUES ";
    foreach($education as $educationitem)
    {
        $buildQueryeducation .= "('".$userid."','".addslashes($educationitem['educcourse'])."','".addslashes($educationitem['educschool'])."'),";
    }
    $insertQueryeducation = trim($buildQueryeducation, ',');


    $buildQuerypersonalskills = "INSERT INTO tblpersonalskill(userid, pskilldesc) VALUES ";
    foreach($personalskills as $personalskillsitem)
    {
        $buildQuerypersonalskills .= "('".$userid."','".addslashes($personalskillsitem)."'),";
    }
    $insertQuerypersonalskills = trim($buildQuerypersonalskills, ',');


    $insertQueryResume = "INSERT INTO tblresume(resumeid, userid, professionid, telephone, address, city, country, postalcode, covertletter) VALUES('$resumeid', '$userid', '$professionid', '$telephone', '$address', '$city','$country', '$postalcode','$coverletter')";

    $selectQueryCheck = "SELECT * from tblresume WHERE userd='$userid'";


    include './includes/knowmeDB.php';

    $retVal = $connect -> query($selectQueryCheck);
    if($retVal -> num_rows > 0)
    {
        echo "You have already uploaded a resume, click on the update link to update your resume.";
    }
    else
    {
        try
        {
            $connect -> autocommit(FALSE);
    
            $connect -> query($insertQuerySkills);
            $connect -> query($insertQueryworkexperience);
            $connect -> query($insertQueryeducation);
            $connect -> query($insertQuerypersonalskills);
            $connect -> query($insertQueryResume);
    
            $connect -> commit();
                    
    
            $connect -> close();
    
            echo  "success";
        }
        catch(Exception $e)
        {
            $connect -> rollback();
            echo $e -> getMessage();        
        }
    }
}
catch(Exception $e)
{
    echo $e -> getMessage();
}

// echo "hey";
// echo "hi";
// echo "do";
?>