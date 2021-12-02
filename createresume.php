<?php
session_start();
////////PRofile picture code starts
if(isset($_POST["btnUploadPicture"]))
{
    $target_dir = "images/profilepictures/";
    // $target_file = $target_dir . basename($_FILES["profilephoto"]["name"]);
    $target_file = $target_dir . $_SESSION["new_UUID"]. "_" . basename($_FILES["profilepicture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // $Newtarget_file = $target_dir . basename( . "." . $imageFileType;

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["profilepicture"]["tmp_name"]);
    if($check !== false)
    {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    }
    else
    {
        // echo "File is not an image.";
        $_SESSION["errorProfilePic"] = "File is not an image.";
        $uploadOk = 0;
        // return;
    }
    // Check if file already exists
    // if (file_exists($target_file))
    // {
    //     echo "Sorry, file already exists.";
    //     $uploadOk = 0;
    // }

    // Check file size is greater than 150KB
    if ($_FILES["profilepicture"]["size"] > 150000)
    {
        // echo "Sorry, your file is too large.";
        $_SESSION["errorProfilePic"] = "Sorry, your file is too large.";
        $uploadOk = 0;
        // return;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
    {
        // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $_SESSION["errorProfilePic"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk === 0)
    {
        // echo "Sorry, your file was not uploaded.";
        $_SESSION["errorProfilePic"] = "Sorry, your file was not uploaded - (".$_SESSION["errorProfilePic"].")";
    // if everything is ok, try to upload file
    }
    else
    {
        if (move_uploaded_file($_FILES["profilepicture"]["tmp_name"], $target_file))
        {
            include './includes/knowmeDB.php';
            $updateQuery = "UPDATE tblusers SET profilepicture = '$target_file'  WHERE userid = '{$_SESSION["new_UUID"]}'";
            if($connect -> query($updateQuery) === true)
            {
                // echo "The file ". htmlspecialchars(basename($_FILES["profilepicture"]["name"])). " has been uploaded.";
                $_SESSION["profilepicturepath"] = $target_file;
                $connect -> close();
            }
            else
            {
                echo $connect -> error;
            }
        }
        else
        {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
////////Profile picture code ends

//Select Profession from database for Personal Information begins
try
{
    include './includes/knowmeDB.php';
    $selectProfession = "SELECT * from tblprofessions";
    $retValProf = $connect -> query($selectProfession);
    $connect -> close();
}
catch(Exception $ex)
{
    echo $e->getMessage();
}
//Select Profession from database for Personal Information Ends

/////SKILLS
// if(isset())


include 'includes/headerpage.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Create Resume</h1>
    <hr>


<h5>{{info}}</h5>


    <!-- TABS WITH NEXT BUTTON STARTD -->
    <!-- Display tab pages begin -->
    <div class="tab">
        <button class="tablinks" onclick="doTabs(event, 'profilepicture')" id="btnprofilepicture">Profile Picture</button>
        <button class="tablinks" onclick="doTabs(event, 'personalInfo')" id="btnpersonalInfo">Personal Information</button>
        <button class="tablinks" onclick="doTabs(event, 'coverletter')" id="btncoverletter">Cover Letter</button>
        <button class="tablinks" onclick="doTabs(event, 'skills')" id="btnskills">Skills</button>
        <button class="tablinks" onclick="doTabs(event, 'workexperience')" id="btnworkexperience">Work Experience</button>
        <button class="tablinks" onclick="doTabs(event, 'education')" id="btneducation">Education</button>
        <button class="tablinks" onclick="doTabs(event, 'personalskills')" id="btnpersonalskills">Personal Skills</button>
        <button class="tablinks" onclick="doTabs(event, 'review')" id="btnreview">Review/Submit</button>
    </div>

    <!-- Tab contents -->
    <div id="profilepicture" class="tabcontent">
        <p style="color: red;">
            <?php
            if(isset($_SESSION["errorProfilePic"]))
            {
            echo $_SESSION["errorProfilePic"];
            unset($_SESSION["errorProfilePic"]);
            }
            ?>
        </p>
        <p>Note: image size must be width: 630px and height: 640px, the image size must not be more than 150KB and file format accepted are (jpg, jpeg, png, gif)</p>
        <br>
        <div class="blockpartition">
            <form action="./createresume.php" method="post" enctype="multipart/form-data">
                <p><input type="file" name="profilepicture" id="profilepicture" class="form-control form-control-user col-sm-10 mb-3 mb-sm-0" id="exampleFirstName"></p>
                <p><input type="submit" class="btn btn-primary btn-user" value="Upload Image" name="btnUploadPicture"></p>
            </form>
        </div>
        <div class="blockpartition">
            <img src="<?php
                    if(isset($_SESSION["profilepicturepath"]))
                 {
                 echo $_SESSION["profilepicturepath"];
                 }
                 else{
                 echo './images/defaultsmall.png' ;
                 }
                 ?>" alt="Profile Picture" class="roundprofilepicture" style="width:50%;">
        </div>
        <br>
        <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'personalInfo')">Next <i class="fa fa-arrow-right" aria-hidden="true"></i> </button>
    </div>

    <form action="./createresume.php" method="POST">
        <div id="personalInfo" class="tabcontent">
            <h5>
                First Name:
                <?php
                echo $_SESSION["FirstName"];
                ?>
            </h5>
            <h5>
                Last Name:
                <?php
                echo $_SESSION["LastName"];
                ?>
            </h5>
            <form action="./createresume.php" method="post">
                <div ng-init="fetchProfession()">
                    <p>
                        <!-- <input class="form-control col-sm-3 mb-3 mb-sm-0" list="datalistOptions" id="txtdatalistOptions" name="txtdatalistOptions" placeholder="Click to select OR Type to search..."> -->
                        <!-- <datalist id="datalistOptions" name="itemdatalistOptions"> retValProf-->                        

                        <!-- <option value="0"> Click to select OR Type to search... </option>
                            <option value="Application Developer"> Application Developer</option>
                            <option value="Web Developer">Web Develope</option>
                            <option value="Software Engineer">Software Engineer</option>
                            <option value="Front-End Developer">Front-End Developer </option>
                            <option value="Database Administrator">Database Administrator</option>
                        </select> -->
                        <!-- </datalist> -->
                        Select a Profession: <select ng-model="ddlselectprofession" ng-options="x.professionname for x in professiondata">
                        </select>
                    </p>
                </div>

                <p><input type="text" class="form-control col-sm-5 mb-3 mb-sm-0" id="txttelephone" name="txttelephone" ng-model="txttelephone" placeholder="Telephone"></p>
                <p><input type="text" class="form-control col-sm-5 mb-3 mb-sm-0" id="txtaddress" name="txtaddress" ng-model="txtaddress" placeholder="Address including house/apartment number"></p>
                <p>
                    <input type="text" class="form-control col-sm-2 mb-3 mb-sm-0" id="txtcity" name="txtcity" ng-model="txtcity" placeholder="City" Style="display:inline-block;">
                    <input type="text" class="form-control col-sm-2 mb-3 mb-sm-0" id="txtcountry" name="txtcountry" ng-model="txtcountry" placeholder="Country" Style="display:inline-block;">
                </p>
                <p>
                    <input type="text" class="form-control col-sm-2 mb-3 mb-sm-0" id="txtpostalcode" name="txtpostalcode" ng-model="txtpostalcode" placeholder="Postal Code">
                </p>
                <br>
                <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'profilepicture')"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</button>
                <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'coverletter')">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                <!-- <input type="submit" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'coverletter')" value="Next"> -->

        </div>

        <div id="coverletter" class="tabcontent">
            <p>Note: Maximumm of {{2000 - txtcoverletter.length}} words remaining</p>
            <p><textarea ng-trim="false" class="form-control col-sm-6 mb-3 mb-sm-0" name="txtcoverletter" id="txtcoverletter" cols="30" rows="20" maxlength="2000" ng-model="txtcoverletter" placeholder="Cover letter"></textarea></p>
            <br>
            <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'personalInfo')"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</button>
            <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'skills')">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
        </div>

        <div id="skills" class="tabcontent" ng-init="addSkills()">
            <div class="blockpartition">
                <p>
                    <input type="text" class="form-control col-sm-10 mb-3 mb-sm-0" id="txtskills" name="txtskills" ng-model="txtskills" placeholder="Enter a professional skill and click Add More to add another skill" Style="display:inline-block;">
                    <button type="button" id="changetabbutton" class="btn btn-primary btn-user" Style="display:inline-block;" ng-click="addSkills()"> <i class="fa fa-plus" aria-hidden="true"></i> Add More</button>
                </p>           
                <br>
                <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'coverletter')"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</button>
                <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'workexperience')" name="btnSkill">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
            <div class="blockpartition">
                <div ng-repeat="skills in skillArray track by $index">
                    <!-- Default Card Example -->
                    <div class="card mb-1">
                        <div class="card-header">
                            <div class="itemslistcontainer">
                                {{skills}}
                            </div>
                            <div class="itemslistcontaineroIcon">
                                <a href="" ng-click="removeSkills($index)"><i class="fa fa-trash" aria-hidden="true" style="color:red"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        </div>

        <div id="workexperience" class="tabcontent" ng-init="addWorkExperience()">
           <div class="blockpartition">
                <p><input type="text" class="form-control col-sm-10 mb-3 mb-sm-0" id="txtpositionheld" name="txtpositionheld" ng-model="txtpositionheld" placeholder="Enter position held"></p>
                <p><input type="text" class="form-control col-sm-10 mb-3 mb-sm-0" id="txtnameofcompany" name="txtnameofcompany" ng-model="txtnameofcompany" placeholder="Enter Name of Company/Organization"></p>
                <p><textarea class="form-control col-sm-10 mb-3 mb-sm-0" name="txtjobdescription" id="txtjobdescription" ng-model="txtjobdescription" cols="30" rows="15" placeholder="Job Description"></textarea></p>
                <p><button type="button" class="btn btn-primary btn-user" Style="display:inline-block;" ng-click="addWorkExperience()"> <i class="fa fa-plus" aria-hidden="true"></i> Add More</button></p>
                <br>
                <button type="button" class="btn btn-primary btn-user" onclick="doTabs(event, 'skills')"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</button>
                <button type="button" class="btn btn-primary btn-user" onclick="doTabs(event, 'education')">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
           </div>
           <div class="blockpartition">
               <div ng-repeat="workexp in workExpArray track by $index">
                            <div class="card mb-1">
                                <div class="card-header">
                                    <div class="itemslistcontainer">
                                        {{workexp.positionheld | uppercase}} - {{workexp.nameofcompany  | uppercase}}
                                    </div>
                                    <div class="itemslistcontaineroIcon">
                                        <a href="" ng-click="removeWorkExperience($index)"><i class="fa fa-trash" aria-hidden="true" style="color:red"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{workexp.jobdescription}}
                                </div>
                            </div>
               </div>
           </div>
        </div>

        <div id="education" class="tabcontent" ng-init="addEducation()">
            <div class="blockpartition">
                <p><input type="text" class="form-control col-sm-10 mb-3 mb-sm-0" id="txtcourse" name="txtcourse" ng-model="txtcourse" placeholder="Enter course of study"></p>
                <p><input type="text" class="form-control col-sm-10 mb-3 mb-sm-0" id="txtschool" name="txtschool" ng-model="txtschool" placeholder="Enter name of schoool"></p>
                <p><button type="button" class="btn btn-primary btn-user" Style="display:inline-block;" ng-click="addEducation()"> <i class="fa fa-plus" aria-hidden="true"></i> Add More</button></p>
                <br>
                <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'workexperience')"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</button>
                <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'personalskills')">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
            <div class="blockpartition">
                <div ng-repeat="edu in educationArray track by $index">
                            <div class="card mb-1">
                                <div class="card-header">
                                    <div class="itemslistcontainer">
                                        {{edu.educcourse | uppercase}}
                                    </div>
                                    <div class="itemslistcontaineroIcon">
                                        <a href="" ng-click="removeEducation($index)"><i class="fa fa-trash" aria-hidden="true" style="color:red"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{edu.educschool}}
                                </div>
                            </div>
               </div>
            </div>
        </div>

        <div id="personalskills" class="tabcontent" ng-init="addPersonalSkills()">
            <div class="blockpartition">
                <p>
                    <input type="text" class="form-control col-sm-10 mb-3 mb-sm-0" id="txtpersonalskills" name="txtpersonalskills" ng-model="txtpersonalskills" placeholder="Enter a personal skill and click Add More to add another skill" Style="display:inline-block;">
                    <button type="button" class="btn btn-primary btn-user" Style="display:inline-block;" ng-click="addPersonalSkills()"> <i class="fa fa-plus" aria-hidden="true"></i> Add More</button>
                </p>
                <br>
                <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'education')"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</button>
                <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'review')">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
            <div class="blockpartition">
                <div ng-repeat="personalskills in personalskillArray track by $index">
                        <!-- Default Card Example -->
                        <div class="card mb-1">
                            <div class="card-header">
                                <div class="itemslistcontainer">
                                    {{personalskills}}
                                </div>
                                <div class="itemslistcontaineroIcon">
                                    <a href="" ng-click="removepersonalSkills($index)"><i class="fa fa-trash" aria-hidden="true" style="color:red"></i></a>
                                </div>
                            </div>
                        </div>
                </div>
                {{personalindex}}
            </div>           
        </div>

        <div id="review" class="tabcontent">
            <h1>
                <?php
                    echo $_SESSION["FirstName"]." ".$_SESSION["LastName"];
                ?>
            </h1>
            <hr>
            <h5 style="text-align:center">{{ddlselectprofession.professionname| uppercase}}</h5>
            <p><?php echo "Email: ". $_SESSION["EmailAddress"] ?></p>
            <p>Telephone: {{txttelephone}}</p>
            <p>Address: {{txtaddress}}, {{txtcity}}, {{txtpostalcode}}, {{txtcountry}}</p>
            <br>
            <h4>Cover Letter</h4>
            <hr>
            <p>{{txtcoverletter}}</p>
            <br>
            <h4>Skills</h4>
            <hr>
            <div ng-repeat="skills in skillArray track by $index">
                    <!-- Default Card Example -->
                    <p><i class="fa fa-square"></i>&nbsp;&nbsp; {{skills}}</p>
                    <!-- <div class="card mb-1 col-sm-6">
                        <div class="card-header">
                            <div class="itemslistcontainer">
                                
                            </div>                            
                        </div>
                    </div> -->
            </div>
            <br>
            <h4>Work Experience</h4>
            <hr>
            <div ng-repeat="workexp in workExpArray track by $index">
                            <div class="card mb-1 col-sm-8">
                                <div class="card-header">
                                    <div class="itemslistcontainer">
                                        <p><b>Position:</b> {{workexp.positionheld | uppercase}}</p>
                                        <p><b>Company:</b> {{workexp.nameofcompany  | uppercase}}</p>
                                    </div>                                    
                                </div>
                                <div class="card-body">
                                <b>Job Description:</b> {{workexp.jobdescription}}
                                </div>
                            </div>
               </div>
            <br>
            <h4>Personal Skills</h4>
            <hr>
            <div ng-repeat="personalskills in personalskillArray track by $index">
                        <!-- Default Card Example -->
                        <p><i class="fa fa-square"></i>&nbsp;&nbsp; {{personalskills}}</p>
                        <!-- <div class="card mb-1 col-sm-6">
                            <div class="card-header">
                                <div class="itemslistcontainer">
                                    {{personalskills}}
                                </div>                                
                            </div>
                        </div> -->
            </div>
            <br>
            <h4>Education</h4>
            <hr>
            <div ng-repeat="edu in educationArray track by $index">
                <p>
                    <i class="fa fa-square"></i>&nbsp;&nbsp; {{edu.educcourse | uppercase}}
                    <br>
                    <i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{edu.educschool | uppercase}}</i>
                </p>  
                            <!-- <div class="card mb-1">
                                <div class="card-header">
                                    <div class="itemslistcontainer">
                                        {{edu.educcourse | uppercase}}
                                    </div>                                  
                                </div>
                                <div class="card-body">
                                    {{edu.educschool}}
                                </div>
                            </div> -->
               </div>
            <button type="button" id="changetabbutton" class="btn btn-primary btn-user" onclick="doTabs(event, 'personalskills')"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</button>
            <button type="button" id="changetabbutton" class="btn btn-primary btn-user" ng-click="submitResume()">Submit <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            <!-- <input type="submit" name="btnSubmitResume" value="SUBMIT" class="btn btn-primary btn-user"> -->
        </div>
    </form>
    <!-- Display tab pages end -->
    <!-- TABS WITH NEXT BUTTON ENDS -->
</div>
<!-- /.container-fluid -->
<?php include './includes/footerpage.php'; ?>