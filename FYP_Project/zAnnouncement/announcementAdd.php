
<html>
    <?php session_start();?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="jsAnnouncement.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        
        <title>Announcement</title>
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
        
        if (isset($_POST['announcementType'], $_POST['announcementTitle'], $_POST['announcementMSG'], $_POST['condoID'])) {
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $aDate = date('y-m-d');
            $aTime = date('h:i:sa');
            $aType = $_POST['announcementType'];
            $aTitle = $_POST['announcementTitle'];
            $aMSG = $_POST['announcementMSG'];
            $condoID = $_POST['condoID'];


            $query = "INSERT INTO announcement (announcementDate, announcementTime, announcementType, announcementTitle, announcementMSG, condoID) VALUES('$aDate', '$aTime', '$aType', '$aTitle', '$aMSG', '$condoID')";
            mysqli_query($conn, $query);
           
            echo '<script>alert("Add Announcement Successful");</script>';
            
            echo'<form id="message" action="announcementFunction.php" method="post">
                    <input type="hidden" name="message" value="updated">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            
        }else {
            $condo = array();
            $cQuery = "SELECT * FROM condominium WHERE condoStatus = 'Available'";
            $cResult = mysqli_query($conn, $cQuery);
            while($cData = mysqli_fetch_assoc($cResult)){
                    $condo[] = $cData;
            }
        }
        ?>

        <div class="page">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Add Announcement</h1>
                    </div>
                    <div class="right">
                        <a href="announcementFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>  
                <hr>

                <form id="announcementAdd" action="announcementAdd.php" method="post">

                    <div class="row">
                        <label>Announcement Type</label>
                        <select name="announcementType" id="announcementType" class="input">
                            <option value="0">Select Announcement Type</option>
                            <option value="Maintain" >Maintain</option>
                            <option value="Notice" >Notice</option>
                         </select>
                    </div>

                    <div class="row">
                        <label>Announcement Title</label>
                        <input type="text" name="announcementTitle" id="announcementTitle" class="input">
                    </div>
                                        
                    <div class="row">
                        <label>Announcement Message</label>
                        <textarea name="announcementMSG" id="announcementMSG" rows="6" cols="50" class="input"></textarea>
                    </div>

                    <div class="row">
                        <label>Condominium</label>
                        <select name="condoID" id="condoID" class="input">
                            <?php foreach($condo as $condos) :?>
                            <option value="<?= $condos['condoID']?>"><?= $condos['condoName']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    
                    <div class="rowbtn">
                        <button class="btnAdd" onclick="chkAnnouncementVldAdd()">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
