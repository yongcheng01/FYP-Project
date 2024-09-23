
<html>
    <?php session_start();?>
    <head>
        <meta charset="UTF-8">
        <title>Condominium</title>
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="jsCondo.js"></script>
        
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

        if (isset($_POST['condoName'], $_POST['condoBlock'], $_POST['condoFloor'], $_POST['roomPerFloor'], $_POST['carparkFloor'])) {

            $cID = $_POST['condoID'];
            $cName = $_POST['condoName'];
            $cBlock = $_POST['condoBlock'];
            $cFloor = $_POST['condoFloor'];
            $room = $_POST['roomPerFloor'];
            $carparkFloor = $_POST['carparkFloor'];
            
            $query = "UPDATE condominium SET 
                                condoName = '$cName', 
                                condoBlock = '$cBlock',
                                condoFloor = '$cFloor',
                                roomPerFloor = '$room',
                                condoCarParkFloor = '$carparkFloor'
                                WHERE condoID = '$cID'";

            mysqli_query($conn, $query);

            echo '<script>alert("Update Condominium Info Successful");</script>';

            echo'<form id="message" action="condoFunction.php" method="post">
                    <input type="hidden" name="message" value="updated">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            
        } elseif (isset($_POST['condoID']) && $_POST['condoID'] > 0) {
            $selectedCondo = array();
            $id = $_POST['condoID'];

            foreach ($id as $ids) {
                $query = "SELECT * FROM condominium WHERE condoID = $ids";
                $result = mysqli_query($conn, $query);
                $selectedCondo[] = mysqli_fetch_assoc($result);
            }
        }
?>
        
        <div class="wholePage">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Condo Update</h1>
                    </div>
                    <div class="right">
                        <a href="condoFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>   
                <hr>

                <form id="condoUpdate" action="condoUpdate.php" method="post">
                    <?php foreach ($selectedCondo as $sc) :?>
                    <div class="row">
                        <input type="hidden" name="condoID" value="<?= $sc['condoID']?>">

                        <label>Condominium Name</label>
                        <input type="text" name="condoName" id="condoName" class="input" value="<?= $sc['condoName']?>">
                    </div>
                        
                    <div class="row">
                        <label>Condominium Block</label>
                        <select name="condoBlock" id="condoBlock" class="input">
                            <option value="<?= $sc['condoBlock']?>"><?= $sc['condoBlock'];?></option>
                        <?php if($sc['condoBlock'] === "1") :?>
                            <option value="2" >2</option>
                            <option value="3" >3</option>
                            <option value="4" >4</option>
                            <option value="5" >5</option>

                        <?php elseif($sc['condoBlock'] === "2") :?>
                            <option value="1" >1</option>
                            <option value="3" >3</option>
                            <option value="4" >4</option>
                            <option value="5" >5</option>

                        <?php elseif($sc['condoBlock'] === "3") :?>
                            <option value="1" >1</option>
                            <option value="2" >2</option>
                            <option value="4" >4</option>
                            <option value="5" >5</option>

                        <?php elseif($sc['condoBlock'] === "4") :?>
                            <option value="1" >1</option>
                            <option value="2" >2</option>
                            <option value="3" >3</option>
                            <option value="5" >5</option>
                            
                        <?php elseif($sc['condoBlock'] === "5") :?>
                            <option value="1" >1</option>
                            <option value="2" >2</option>
                            <option value="3" >3</option>
                            <option value="4" >4</option>
                        <?php endif;?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <label>Condominium Floor</label>
                        <input type="text" name="condoFloor" id="condoFloor" class="input" value="<?= $sc['condoFloor']?>">
                    </div>

                    <div class="row">
                        <label>Unit Per Floor</label>
                        <input type="text" name="roomPerFloor" id="roomPerFloor" class="input" value="<?= $sc['roomPerFloor']?>">
                    </div>
                    
                    
                    <div class="row">
                        <label>Condominium Carpark Floor</label>
                        <input type="text" name="carparkFloor" id="carparkFloor" class="input" value="<?= $sc['condoCarParkFloor']?>">
                    </div>

                    <?php endforeach;?>

                    <div class="rowbtn">
                        <button class="btnUpdate" onclick="chkCondoVldUpdate()">Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </body>
</html>
