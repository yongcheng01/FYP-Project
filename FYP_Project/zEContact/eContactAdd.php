
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="jsEmergencyContact.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        
        <title>Emergency Contact</title>
        
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
        include'../connection.php';
        
        if (isset($_POST['ecEmail'], $_POST['ecWhatsapp'], $_POST['ecSecurity'], $_POST['ecAddress'], $_POST['condo'])) {

            $ecEmail = $_POST['ecEmail'];
            $ecWhatsapp = $_POST['ecWhatsapp'];
            $ecSecurity = $_POST['ecSecurity'];
            $ecAddress = $_POST['ecAddress'];
            $condo = $_POST['condo'];


            $query = "INSERT INTO emergencyContact (ecWhatsapp, ecSecurity, ecEmail, ecAddress, condoID) VALUES('$ecWhatsapp', '$ecSecurity', '$ecEmail', '$ecAddress', '$condo[0]')";
            mysqli_query($conn, $query);
           
            echo '<script>alert("Add Emergency Contact Successful");</script>';
            
            echo'<form id="message" action="eContactFunction.php" method="post">
                    <input type="hidden" name="message" value="updated">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            
        }else {
            
            $query = "SELECT * FROM condominium 
                        WHERE condominium.condoStatus = 'Available'
                        AND condominium.condoID NOT IN (
                        SELECT condominium.condoID FROM condominium
                        INNER JOIN emergencyContact ON condominium.condoID = emergencyContact.condoID
                        )";
            $result = mysqli_query($conn, $query);
            $condoArr = array();
            
            while($data = mysqli_fetch_assoc($result)){
                $condoArr[] = $data;
            }
            
            
            
        }
        ?>

        <div class="page">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Add Emergency Contact</h1>
                    </div>
                    <div class="right">
                        <a href="eContactFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>  
                <hr>

                <form id="ecAdd" action="eContactAdd.php" method="post">
                    
                    <div class="row">
                        <label>WhatsApp Number</label>
                        <input type="text" name="ecWhatsapp" id="ecWhatsapp" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Guard House Contact</label>
                        <input type="text" name="ecSecurity" id="ecSecurity" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Email</label>
                        <input type="text" name="ecEmail" id="ecEmail" class="input">
                    </div>
                                        

                    <div class="row">
                        <label>Address</label>
                        <textarea name="ecAddress" id="ecAddress" rows="4" cols="50" class="input"></textarea>
                    </div>
                    
                    <div class="row">
                        <label>Condominium</label>
                        <select name="condo[]" id="condo" class="input">
                            <?php if($result && mysqli_num_rows($result)>0) :?>
                            <?php foreach($condoArr as $condoArray) :?>
                            <option value="<?= $condoArray['condoID']?>"><?= $condoArray['condoName']?></option>
                            <?php endforeach;?>
                            <?php endif;?>
                            
                        </select>
                    </div>
                    
                    <div class="rowbtn">
                        <button class="btnAdd" onclick="chkEcVldAdd()">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
