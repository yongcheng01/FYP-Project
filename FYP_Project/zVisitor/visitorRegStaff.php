
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <title>Visitor</title>
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="jsVisitor.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        
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
                margin-top: 4%;
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
                    margin-top: 50px; 
                }

            }
        </style>
        
    </head>
    <body>
        <?php
        include'../BEHeader.php';
        include'../connection.php';

                
        if (isset($_POST['visitorName'], $_POST['visitorContact'], $_POST['visitorIC'] , $_POST['visitDate'] , $_POST['visitTime'] , $_POST['visitorCarpark'], $_POST['owner'])) {
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $vName = $_POST['visitorName'];
            $vContact = $_POST['visitorContact'];
            $vIC = $_POST['visitorIC'];
            $vCP = $_POST['visitorCarpark'];
            $vDate = $_POST['visitDate'];
            $vTime = $_POST['visitTime'];
            $vCarNo = "-";
            $owner = $_POST['owner'];

            $time = strtotime($vTime[0]);
            
            $today = date("Y-m-d");
            $nextWeek = date("Y-m-d", strtotime("+1 week"));
            
            $currentDateTime = new DateTime();
            $currentTimestamp = $currentDateTime->getTimestamp();

            $query = "";

            if ($vDate < $today || $vDate > $nextWeek) {
                echo '<script>alert("Invalid date. Please choose a date between today and the next week.");</script>';

            }
            elseif($vDate == $today && $time < $currentTimestamp){
                    echo '<script>alert("Invalid time. Please choose a time equal to or greater than the current time.");</script>';
            }
            else {
                if (isset($_POST['visitorCarNo'])){
                    $vCarNo = $_POST['visitorCarNo'];
                    $query = "INSERT INTO visitor (visitorName, visitorContact, visitorIC, visitorCarpark, visitDate, visitTime, visitorCarNo, visitorStatus, ownerID, tenantID) VALUES('$vName', '$vContact', '$vIC', '$vCP', '$vDate', '$vTime[0]', '$vCarNo', 'Pending', '$owner', '0')";
                }else {
                    $query = "INSERT INTO visitor (visitorName, visitorContact, visitorIC, visitorCarpark, visitDate, visitTime, visitorCarNo, visitorStatus, ownerID, tenantID) VALUES('$vName', '$vContact', '$vIC', '$vCP', '$vDate', '$vTime[0]', '$vCarNo', 'Pending', '$owner', '0')";
                }
                mysqli_query($conn, $query);

                echo '<script>alert("Register Visitor Successful");</script>';

                echo'<form id="message" action="visitorFunction.php" method="post">
                <input type="hidden" name="message" value="updated">
                <input type="submit" value="Submit">
                </form>
                <script>document.querySelector("#message").submit();</script>';
            }
        }
            
        $condo = array();
        $cQuery = "SELECT * FROM condominium WHERE condoStatus = 'Available'";
        $cResult = mysqli_query($conn, $cQuery);
        while($cData = mysqli_fetch_assoc($cResult)){
                $condo[] = $cData;
        }
 
        ?>

        <div class="page">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Visitor Registration</h1>
                    </div>
                    <div class="right">
                        <a href="visitorFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>  
                <hr>

                <form id="regVisitorForm" action="visitorRegStaff.php" method="post">

                    <div class="row">
                        <label>Visitor Name</label>
                        <input type="text" name="visitorName" id="visitorName" class="input">
                    </div>
                                      
                    <div class="row">
                        <label>Visitor Contact No</label>
                        <input type="text" name="visitorContact" id="visitorContact" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Visitor IC</label>
                        <input type="text" name="visitorIC" id="visitorIC" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Visit Date</label>
                        <input type="date" name="visitDate" id="visitDate" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Visit Time</label>
                        <select name="visitTime[]" id="visitTime" class="input">
                            <option value="0"></option>
                            <?php for ($i = 8; $i < 25; $i++) : ?>
                                <?php $formattedTime = ($i < 10) ? '0' . $i . ':00' : $i . ':00'; ?>
                                <option value="<?php echo $formattedTime; ?>"><?php echo $formattedTime; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <label>Visitor Carpark</label>
                        <select name="visitorCarpark" id="visitorCarpark" class="input" onchange="toggleVisitorCarNo()">
                            <option value="0"></option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <label>Visitor Car Number</label>
                        <input type="text" name="visitorCarNo" id="visitorCarNo" class="input" disabled>
                    </div>

                    
                    <div class="row">
                        <label>Condominium</label>
                        <select name="condo" id="condo" class="input" onchange="updateOwners()">
                            <option value="0">Select Condominium</option>
                            <?php foreach($condo as $condos) :?>
                            <option value="<?= $condos['condoID']?>"><?= $condos['condoName']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <label>Owner</label>
                        <select name="owner" id="owner" class="input">
                            <option value="0">Select Owner</option>
                            
                        </select>
                    </div>
                    
                    <div class="rowbtn">
                        <button class="btnAdd" onclick="chkVisitorVldAdd()">Register</button>
                    </div>
                    
                    
                    <script>
                        function toggleVisitorCarNo() {
                            var carparkSelect = document.getElementById("visitorCarpark");
                            var carNoInput = document.getElementById("visitorCarNo");

                            carNoInput.disabled = carparkSelect.value !== "Y";
                        }
    
                        function updateOwners() {
                            var selectedCondo = $("#condo").val();

                            var ownerDropdown = $("#owner");

                            ownerDropdown.html('<option value="0">Select Owner</option>');

                            if (selectedCondo !== "0") {
                                $.ajax({
                                    url: 'visitorGetOwners.php', 
                                    type: 'POST',
                                    data: { condoID: selectedCondo},
                                    dataType: 'json',
                                    success: function(data) {
                                        $.each(data, function(index, owner) {
                                            ownerDropdown.append('<option value="' + owner.ownerID + '">' + owner.ownerFName + " " + owner.ownerLName + " (" + owner.floor + "-" + owner.houseNumber + ")" + '</option>');
                                        });
                                    },
                                    error: function(error) {
                                        console.log(error);
                                    }
                                });
                            }
                        }
                    </script>
                    
                </form>
            </div>
        </div>
    </body>
</html>
