
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
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .title {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            margin-top: 3.5%;
            margin-bottom: 2%;
        }

        .wholePage {
            margin-left: 25%;
            width: 50%;
            padding: 20px;
            overflow: auto;
            background-color: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .left h1 {
            padding: 10px;
            border-radius: 5px;
            margin: 0;
        }

        .right {
            margin-left: auto;
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

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 12px;
            font-size: 18px;
        }

        .row p {
            margin: 0;
            font-size: 16px;
            color: #333;
            display: block;
            padding: 10px 12px;
            border: 1px solid #000;
            border-radius: 10px;
        }

        @media only screen and (max-width: 600px) {
             
            .title {
                margin-top: 15%;
            }

             .wholePage {
                 margin: 0; 
                 width: 100%; 
                 box-sizing: border-box;
                 padding: 10px; 
                 margin-top: 30px; 
             }
         }
        </style> 
    </head>
    <body>
        
        <?php
        include'../BEHeader.php';
        include'../connection.php';
        

        $company = array();
        $query = "SELECT * FROM company WHERE companyStatus = 'Available'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
          $company[] = $row;  
        }
        
        
        
        
        ?>
        <div class="title">Company Detail</div>
        <div class="wholePage">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Company Information</h1>
                    </div>
                    <div class="right">
                        <a href="companyFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>   
                <hr>

                    <?php foreach ($company as $com) :?>
                    
                    <div class="row">
                        <label>Company Name</label><p><?= $com['companyName']?></p>
                    </div>
                    
                    <div class="row">
                        <label>Contact No</label><p><?= $com['companyContact']?></p>
                    </div>
                    
                    <div class="row">
                        <label>Email</label><p><?= $com['companyEmail']?></p>
                    </div>

                    <div class="row">
                        <label>Address</label><p><?= $com['companyAddress']?></p>
                    </div>
                    
                    <div class="row">
                        <label>Founded Date</label><p><?= $com['foundedDate']?></p>
                    </div>
                    
                    <div class="row">
                        <label>CEO Name</label><p><?= $com['CEO']?></p>
                    </div>
                    
                    <?php endforeach;?>

            </div>
        </div>
        
    </body>
</html>
