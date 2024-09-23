
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="jsCondo.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        
        <title>Condominium</title>
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
                margin-top: 12%;
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
        include '../connection.php';
        
        if (isset($_POST['condoName'], $_POST['condoBlock'], $_POST['condoFloor'], $_POST['roomPerFloor'], $_POST['carparkFloor'])) {

            $cName = $_POST['condoName'];
            $cBlock = $_POST['condoBlock'];
            $cFloor = $_POST['condoFloor'];
            $room = $_POST['roomPerFloor'];
            $carparkFloor = $_POST['carparkFloor'];


            $query = "INSERT INTO condominium (condoName, condoBlock, condoFloor, roomPerFloor, condoStatus, condoCarParkFloor, companyID) VALUES('$cName', '$cBlock', '$cFloor', '$room', 'Available', '$carparkFloor', '1')";
            mysqli_query($conn, $query);
           
            echo '<script>alert("Add Condominium Successful");</script>';
            
            echo'<form id="message" action="condoFunction.php" method="post">
                    <input type="hidden" name="message" value="updated">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            
        }
        
        ?>

        <div class="page">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Add Condominium</h1>
                    </div>
                    <div class="right">
                        <a href="condoFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>  
                <hr>

                <form id="condoAdd" action="condoAdd.php" method="post">

                    <div class="row">
                        <label>Condominium Name</label>
                        <input type="text" name="condoName" id="condoName" class="input">
                    </div>

                    <div class="row">
                        <label>Condominium Block</label>
                        <select name="condoBlock" id="condoBlock" class="input">
                            <option value="0">Select Condominium Block</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <label>Condominium Floor</label>
                        <input type="text" name="condoFloor" id="condoFloor" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Condominium Unit Per Floor</label>
                        <input type="text" name="roomPerFloor" id="roomPerFloor" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Condominium Carpark Floor</label>
                        <input type="text" name="carparkFloor" id="carparkFloor" class="input">
                    </div>
                                        

                    <div class="rowbtn">
                        <button class="btnAdd" onclick="chkCondoVldAdd()">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
