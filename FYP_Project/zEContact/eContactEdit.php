
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Emergency Contact</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="jsEmergencyContact.js"></script>
        
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
        include'../connection.php';
        
        
        
        if (isset($_POST['ecID'], $_POST['ecEmail'], $_POST['ecWhatsapp'], $_POST['ecSecurity'], $_POST['ecAddress'])) {
            
            $ecEmail = $_POST['ecEmail'];
            $ecWhatsapp = $_POST['ecWhatsapp'];
            $ecSecurity = $_POST['ecSecurity'];
            $ecAddress = $_POST['ecAddress'];
            $ecID = $_POST['ecID'];
            
            
            $query = "UPDATE emergencyContact SET 
                        ecEmail='$ecEmail', 
                        ecWhatsapp='$ecWhatsapp', 
                        ecSecurity='$ecSecurity', 
                        ecAddress='$ecAddress'
                        WHERE ecID='$ecID'";

            mysqli_query($conn, $query);
           
            
            echo '<script>alert("Update Emergency Contact Successful");</script>';
            
            echo'<form id="message" action="eContactFunction.php" method="post">
                    <input type="hidden" name="message" value="updated">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            
        }else {
            if(isset($_POST['ecID'])){
                $ecID = $_POST['ecID'];
                $query = "SELECT * FROM emergencyContact INNER JOIN condominium ON emergencyContact.condoID = condominium.condoID  WHERE ecID = '$ecID[0]'";
                $result = mysqli_query($conn, $query);
                $ecs = mysqli_fetch_assoc($result);

                
            }
        }
        
        
        
        ?>
        
        <div class="wholePage">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Emergency Contact Update Form</h1>
                    </div>
                    <div class="right">
                        <a href="eContactFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>   
                <hr>

                <form id="ecUpdateForm" action="eContactEdit.php" method="post">
                    <div class="row">
                        <input type="hidden" name="ecID" value="<?= $ecs['ecID']?>">
                        
                        <label>Email</label>
                        <input type="text" name="ecEmail" id="ecEmail" class="input" value="<?= $ecs['ecEmail']?>">
                        </div>
                    <div class="row">
                        <label>Whatsapp</label>
                        <input type="text" name="ecWhatsapp" id="ecWhatsapp" class="input" value="<?= $ecs['ecWhatsapp']?>">
                    </div>

                    <div class="row">
                        <label>Guard House Contact</label>
                        <input type="text" name="ecSecurity" id="ecSecurity" class="input" value="<?= $ecs['ecSecurity']?>">
                    <div>
                        
                    <div class="row">    
                        <label>Address</label>
                        <textarea name="ecAddress" id="ecAddress" rows="4" cols="50" class="input" ><?= $ecs['ecAddress']?></textarea>
                    </div>
                    
                    <div class="row">
                        <label>Condominium</label>
                        <input type="text" name="ecCondo" id="ecCondo" class="input" value="<?= $ecs['condoName']?>" disabled="true">
                    </div>
                    

                    <div class="rowbtn">
                        <button class="btnUpdate" onclick="chkEcVldUpdate()">Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </body>
</html>
