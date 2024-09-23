
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <title>Facilities</title>
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="jsFacilities.js"></script>
        
        <style>
            body {
                background-color: #fff; 
                font-family: Arial, sans-serif; 
                margin: 0;
                padding: 0;
            }

            .page {
                margin-left: 5%;
                width: 90%;
                padding: 20px;
                overflow: auto;
            }

            .form {
                max-width: 600px;
                margin: 0 auto;
                margin-top: 5%;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #fff; 
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .header h1 {
                margin-top: 10px; 
                color: #333;
            }

            .btnBack {
                color: #000; 
                border: 1px solid #000;
                padding: 6px 6px;
                border-radius: 25px;
                cursor: pointer;
                transition: color 0.3s ease; 
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none; 
                margin-top: 10px;
            }

            .btnBack .las {
                font-size: 2em;
            }

            .btnBack:hover {
                color: #555; 
                background-color: #eee;
            }

            hr {
                margin-top: 15px;
                margin-bottom: 25px;
                border: none;
                border-top: 1px solid #ccc;
            }

            .row {
                margin-bottom: 15px;
            }

            .label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
                color: #333; 
            }

            .input {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 3px;
            }

            .rowbtn {
                text-align: center;
                margin-top: 15px;
            }

            .btnUpdate {
                background-color: #4CAF50; 
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            .btnUpdate:hover {
                background-color: #45a049;
            }
            
            .image {
                margin-top: 10px;
                width: 560px;
                height: 250px;
            }
            
            @media only screen and (max-width: 600px) {
             

                .wholePage {
                    margin: 0; 
                    width: 100%; 
                    box-sizing: border-box;
                    padding: 10px; 
                    margin-top: 80px; 
                }

                .image {
                   margin-top: 10px;
                   width: 340px;
                   height: 200px;
               }
            }
            
        </style>
        
    </head>
    <body>
        
        <?php
        include'../BEHeader.php';
        include "../connection.php";

        if (isset($_POST['facilitiesStatus'], $_POST['condo'])) {

            $fID = $_POST['fID'];
            $fStatus = $_POST['facilitiesStatus'];
            $condominium = $_POST['condo'];
            $img_name = $_FILES['fImage']['name'];
            $img_size = $_FILES['fImage']['size'];
            $tmp_name = $_FILES['fImage']['tmp_name'];
            $error = $_FILES['fImage']['error'];

            if ($error === 0) {
                if (($img_size / 1024) > 300) {
                    echo '<script>alert("Sorry, your file is too large.");</script>';
                    
                    echo'<form id="message" action="facilitiesFunction.php" method="post">
                        <input type="hidden" name="facilitiesID" value="'.$fID.'">
                        <input type="submit" value="Submit">
                        </form>
                        <script>document.querySelector("#message").submit();</script>';

                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowed_exs = array("jpg", "jpeg", "png");

                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                        $img_upload_path = '../uploads/' . $new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);

                        $query = "UPDATE facilities SET 
                                    facilitiesStatus='$fStatus', 
                                    facilitiesImage='$new_img_name',
                                    condoID='$condominium[0]'
                                    WHERE facilitiesID='$fID'";
                        mysqli_query($conn, $query);

                        echo '<script>alert("Update Facilities Info Successful");</script>';

                        echo'<form id="message" action="facilitiesFunction.php" method="post">
                            <input type="submit" value="Submit">
                            </form>
                            <script>document.querySelector("#message").submit();</script>';
                    } else {
                        echo '<script>alert("You cant upload files of this type");</script>';
                        
                        echo'<form id="message" action="facilitiesFunction.php" method="post">
                            <input type="hidden" name="facilitiesID" value="'.$fID.'">
                            <input type="submit" value="Submit">
                            </form>
                            <script>document.querySelector("#message").submit();</script>';
                    }
                }
            } else {
                $query = "UPDATE facilities SET 
                            facilitiesStatus='$fStatus', 
                            condoID='$condominium[0]'
                            WHERE facilitiesID='$fID'";
                mysqli_query($conn, $query);

                echo '<script>alert("Update Facilities Info Successful");</script>';

                echo'<form id="message" action="facilitiesFunction.php" method="post">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            }
            
        }
        if (isset($_POST['facilitiesID']) && $_POST['facilitiesID'] > 0) {
            $condo = array();
            $cQuery = "SELECT * FROM condominium";
            $cResult = mysqli_query($conn, $cQuery);
            while($cData = mysqli_fetch_assoc($cResult)){
                    $condo[] = $cData;
            }
            
            $selectedFacilities = array();
            $id = $_POST['facilitiesID'];

            foreach ($id as $ids) {
                $query = "SELECT facilities.*, condominium.condoName
                            FROM facilities
                            INNER JOIN condominium ON facilities.condoID = condominium.condoID
                            WHERE facilities.facilitiesID = $ids";
                $result = mysqli_query($conn, $query);
                $selectedFacilities[] = mysqli_fetch_assoc($result);
            }
        }
        ?>
        
        <div class="wholePage">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Facilities Update Form</h1>
                    </div>
                    <div class="right">
                        <a href="facilitiesFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>   
                <hr>

                <form id="facilitiesUpdateForm" action="facilitiesUpdate.php" method="post" enctype="multipart/form-data">
                    <?php foreach ($selectedFacilities as $sf) :?>
                    <div class="row">
                        <input type="hidden" name="fID" value="<?= $sf['facilitiesID']?>">
                        
                        <label>Facilities Name</label>
                        <input type="text" name="facilitiesName" id="facilitiesName" class="input" value="<?= $sf['facilitiesName']?>" disabled="true">
                    </div>
                    
                    <div class="row">
                        <label>Facilities Status</label>
                        <select name="facilitiesStatus" id="facilitiesStatus" class="input">
                            <option value="<?= $sf['facilitiesStatus']?>"><?= $sf['facilitiesStatus'];?></option>
                            <?php if($sf['facilitiesStatus'] === "Available") :?>
                                <option value="Maintain" >Maintain</option>
                                <option value="InProgress" >In Progress</option>
                                
                            <?php elseif($sf['facilitiesStatus'] === "Maintain") :?>
                                <option value="Available" >Available</option>
                                <option value="InProgress" >In Progress</option>
                                
                            <?php elseif($sf['facilitiesStatus'] === "InProgress") :?>
                                <option value="Available" >Available</option>
                                <option value="Maintain" >Maintain</option>
                            <?php endif;?>
                         </select>
                    </div>
                    
                    <div class="row">
                        <label>Condominium</label>
                        <select name="condo[]" id="condo" class="input">
                            <option value="<?= $sf['condoID']?>" ><?= $sf['condoName']?></option>
                            <?php foreach($condo as $cd):?>
                            <?php if($cd['condoID'] != $sf['condoID']) :?>
                            <option value="<?= $cd['condoID']?>" ><?= $cd['condoName']?></option>
                            <?php endif;?>
                            <?php endforeach;?>
                         </select>
                    </div>

                    <div class="row">
                        <label>Facilities Image (If no changes, left it blank)</label>
                        <input type="file" name="fImage" id="fImage" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Current Facilities Image</label>
                        <img class="image" src="../uploads/<?=$sf['facilitiesImage']?>">
                    </div>

                    <?php endforeach;?>

                    <div class="rowbtn">
                        <button class="btnUpdate">Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </body>
</html>
