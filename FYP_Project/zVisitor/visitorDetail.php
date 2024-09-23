
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <title>Visitor</title>
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
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
        include('../connection.php');

        if (isset($_GET['vID'])) {
            $id = $_GET['vID'];

            $query = "SELECT * FROM visitor 
                        LEFT JOIN owner ON visitor.ownerID = owner.ownerID
                        LEFT JOIN tenant ON visitor.tenantID = tenant.tenantID
                        WHERE visitorID = $id";
            $result = mysqli_query($conn, $query);
            $selectedVisitor = mysqli_fetch_assoc($result);
            
        }
        ?>
        <div class="title">Visitor Detail</div>
        <div class="wholePage">
            <div class="form">
                    <div class="header">
                        <div class="left">
                            <h1>Visitor Profile</h1>
                        </div>
                        <div class="right">
                            <a href="visitorFunction.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                        </div>
                    </div>   
                    <hr>

                    <div class="row">
                        <label>Visitor Name</label><p><?= $selectedVisitor['visitorName']?></p>
                    </div>
                    
                    <div class="row">
                        <label>Contact No</label><p><?= $selectedVisitor['visitorContact']?></p>
                    </div>
                    
                    <div class="row">
                        <label>IC</label><p><?= $selectedVisitor['visitorIC']?></p>
                    </div>

                    <div class="row">
                        <label>Visit Date</label><p><?= $selectedVisitor['visitDate']?></p>
                    </div>
                    
                    <div class="row">
                        <label>Visit Time</label><p><?= $selectedVisitor['visitTime']?></p>
                    </div>
                    
                    <div class="row">
                        <label>Carpark</label><p><?php if($selectedVisitor['visitorCarpark'] == 'Y') {echo 'YES';}else{echo 'NO';}?></p>
                    </div>
                    
                    <div class="row">
                        <label>Car No</label><p><?= $selectedVisitor['visitorCarNo']?></p>
                    </div>

                    <div class="row">
                        <?php if($selectedVisitor['ownerFName'] != ""):?>
                        <label>User</label><p>Owner : <?php echo $selectedVisitor['ownerFName']." ".$selectedVisitor['ownerLName'] ?></p>
                        <?php elseif($selectedVisitor['tenantName'] != ""):?>
                        <label>User</label><p>Tenant : <?= $selectedVisitor['tenantName'] ?></p>
                        <?php endif;?>
                    </div>

            </div>
        </div>

    </body>
</html>
