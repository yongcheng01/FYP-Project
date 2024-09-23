
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <title>Announcement</title>
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="jsAnnouncement.js"></script>

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
            margin-bottom: 3%;
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

        .row h4 {
            margin: 0;
            font-size: 18px;
            line-height: 1.6;
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

        if (isset($_GET['aID']) && $_GET['aID'] > 0) {
            $id = $_GET['aID'];
            
            $query = "SELECT * FROM announcement WHERE announcementID = $id";
            $result = mysqli_query($conn, $query);
            $selectedAnnouncement = mysqli_fetch_assoc($result);
            
            $location = "";
            if(isset($_GET['user'])){
                $location = "announcementFunction.php";
                
            }else {
                $location = "../adminDashboard.php";
                
            }
        }
        ?>
        <div class="title">Announcement Detail</div>
        <div class="wholePage">
            <div class="form">
                    <div class="header">
                        <div class="left">
                            <h1><?= $selectedAnnouncement['announcementTitle'] ?></h1>
                        </div>
                        <div class="right">
                            <a href="<?= $location?>" class="btnBack"><span class="las la-arrow-left"></span></a>
                        </div>
                    </div>   
                    <hr>

                    <div class="row">
                        <h4><?= nl2br($selectedAnnouncement['announcementMSG']) ?></h4>
                    </div>
            </div>
        </div>

    </body>
</html>
