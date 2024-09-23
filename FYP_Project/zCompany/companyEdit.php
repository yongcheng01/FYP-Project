
<html>
    <?php session_start();?>
    <head>
        <meta charset="UTF-8">
        <title>Company</title>
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="jsCompany.js"></script>
        
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
                margin-top: 8%;
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

            .btnEdit {
                background-color: #4CAF50; 
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            .btnEdit:hover {
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
        
        
        
        if (isset($_POST['comName'], $_POST['comContact'], $_POST['comEmail'], $_POST['comAddress'], $_POST['comFoundedDate'], $_POST['comCEO'])) {

            $comName = $_POST['comName'];
            $comContact = $_POST['comContact'];
            $comEmail = $_POST['comEmail'];
            $comAddress = $_POST['comAddress'];
            $comFoundedDate = $_POST['comFoundedDate'];
            $comCEO = $_POST['comCEO'];
            $comID = $_POST['companyID'];
            
            $query = "UPDATE company SET 
                        companyName = '$comName',
                        companyContact = '$comContact',
                        companyEmail = '$comEmail',
                        companyAddress = '$comAddress',
                        foundedDate = '$comFoundedDate',
                        CEO = '$comCEO'
                        WHERE companyID = $comID";
            mysqli_query($conn, $query);
            
            echo '<script>alert("Edit Company Info Successful");</script>';
            
            echo'<form id="message" action="companyFunction.php" method="post">
                    <input type="hidden" name="message" value="updated">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            
        }else {
            $company = array();
            $query = "SELECT * FROM company WHERE companyStatus = 'Available'";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result)){
              $company[] = $row;  
            }
        }
        
        
        
        ?>
        
        <div class="wholePage">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Edit Company</h1>
                    </div>
                    <div class="right">
                        <a href="companyFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>   
                <hr>

                <form id="companyUpdate" action="companyEdit.php" method="post">
                    <?php foreach ($company as $com) :?>
                    
                    <div class="row">
                        <input type="hidden" name="companyID" value="<?= $com['companyID']?>">
                        
                        <label>Company Name</label>
                        <input name="comName" id="comName" class="input" value="<?= $com['companyName']?>">
                    </div>
                    
                    <div class="row">
                        <label>Contact No</label>
                        <input type="text" name="comContact" id="comContact" class="input" value="<?= $com['companyContact']?>">
                    </div>
                    
                    <div class="row">
                        <label>Email</label>
                        <input type="text" name="comEmail" id="comEmail" class="input" value="<?= $com['companyEmail']?>">
                    </div>

                    <div class="row">
                        <label>Address</label>
                        <textarea name="comAddress" id="comAddress" rows="4" cols="50" class="input"><?= $com['companyAddress']?></textarea>
                    </div>
                    
                    <div class="row">
                        <label>Founded Date</label>
                        <input type="date" name="comFoundedDate" id="comFoundedDate" class="input" value="<?= $com['foundedDate']?>">
                    </div>
                    
                    <div class="row">
                        <label>CEO Name</label>
                        <input type="text" name="comCEO" id="comCEO" class="input" value="<?= $com['CEO']?>">
                    </div>
                    
                    <?php endforeach;?>

                    <div class="rowbtn">
                        <button class="btnEdit" onclick="chkCompanyVldUpdate()">Edit</button>
                    </div>
                </form>
            </div>
        </div>
        
    </body>
</html>
