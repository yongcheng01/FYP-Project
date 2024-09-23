
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <title>Facilities</title>
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="jsFacilities.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        
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
                margin-top: 10%;
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

            .btnAdd {
                background-color: #4CAF50; 
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            .btnAdd:hover {
                background-color: #45a049;
            }
            
            @media only screen and (max-width: 600px) {
             
                .form {
                    margin: 0; 
                    width: 100%; 
                    box-sizing: border-box;
                    padding: 10px; 
                    margin-top: 100px; 
                }

            }
        </style>
        
    </head>
    <body>
        <?php
        include'../BEHeader.php';
        include "../connection.php";
        
        $condo = array();
        $cQuery = "SELECT * FROM condominium WHERE condoStatus = 'Available'";
        $cResult = mysqli_query($conn, $cQuery);
        while($cData = mysqli_fetch_assoc($cResult)){
                $condo[] = $cData;
        }

        if (isset($_FILES['facilitiesImage'], $_POST['facilitiesType'], $_POST['facilitiesStatus'], $_POST['condo'])) {
            
            $fName = "";
            $fType = $_POST['facilitiesType'];
            $fStatus = $_POST['facilitiesStatus'];
            $condominium = $_POST['condo'];
            $img_name = $_FILES['facilitiesImage']['name'];
            $img_size = $_FILES['facilitiesImage']['size'];
            $tmp_name = $_FILES['facilitiesImage']['tmp_name'];
            $error = $_FILES['facilitiesImage']['error'];

            $facilities = "SELECT * FROM facilities WHERE facilitiesType = '$fType' AND condoID = '$condominium[0]'";
            $fResult = mysqli_query($conn, $facilities);
            
            if ($fResult && mysqli_num_rows($fResult) > 0) {
                $num = mysqli_num_rows($fResult) + 1;
                $fName = $fType . " " . $num;
            }else {
                $fName = $fType . " " . "1";
            }
            
            if ($error === 0) {
                if (($img_size / 1024) > 300) {
                    echo '<script>alert("Sorry, your file is too large.");</script>';

                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowed_exs = array("jpg", "jpeg", "png");

                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                        $img_upload_path = '../uploads/' . $new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);

                        // Insert into Database
                        $sql = "INSERT INTO facilities(facilitiesName, facilitiesStatus, facilitiesType, facilitiesImage, condoID) 
                                                VALUES('$fName', '$fStatus', '$fType', '$new_img_name', $condominium[0])";
                        mysqli_query($conn, $sql);

                        echo '<script>alert("Add Facilities Info Successful");</script>';

                        echo'<form id="message" action="facilitiesFunction.php" method="post">
                        <input type="hidden" name="message" value="updated">
                        <input type="submit" value="Submit">
                        </form>
                        <script>document.querySelector("#message").submit();</script>';

                    } else {
                        echo '<script>alert("You cant upload files of this type");</script>';
                    }
                }

            } else {
                echo '<script>alert("unknown error occurred!");</script>';
            }
        }
        
        
        ?>

        <div class="page">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Add Facilities</h1>
                    </div>
                    <div class="right">
                        <a href="facilitiesFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>  
                <hr>

                <form id="addFacilitiesForm" action="facilitiesAdd.php" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <label>Facilities Type</label>
                        <select name="facilitiesType" id="facilitiesType" class="input">
                            <option value="0">Select Facilities Type</option>
                            <option value="BBQ" >BBQ</option>
                            <option value="Swimming Pool" >Swimming Pool</option>
                            <option value="Badminton Court" >Badminton Court</option>
                            <option value="Gym Room" >Gym Room</option>
                            <option value="Hall" >Hall</option>
                         </select>
                    </div>

                    <div class="row">
                        <label>Facilities Status</label>
                        <select name="facilitiesStatus" id="facilitiesStatus" class="input">
                            <option value="0">Select Facilities Status</option>
                            <option value="Available" >Available</option>
                            <option value="Maintain" >Maintain</option>
                            <option value="InProgress" >In Progress</option>
                         </select>
                    </div>
                    
                    <div class="row">
                        <label>Facilities Image</label>
                        <input type="file" name="facilitiesImage" id="facilitiesImage" class="input">
                    </div>
                    

                    <div class="row">
                        <label>Condominium</label>
                        <select name="condo[]" id="condo" class="input">
                            <option value="0">Select Condominium</option>
                            <?php foreach($condo as $cd):?>
                            <option value="<?= $cd['condoID']?>" ><?= $cd['condoName']?></option>
                            <?php endforeach;?>
                         </select>
                    </div>

                    <div class="rowbtn">
                        <button class="btnAdd" onclick="chkFacilitiesVldAdd()">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
