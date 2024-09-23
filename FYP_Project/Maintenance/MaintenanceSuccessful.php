<html>
    <?php
    session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <link rel="stylesheet" href="../style.css">
        <style>
             .maintenance{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }
            .addMaintenance {
               background: white;
                padding: 30px 30px;
                min-width: 400px;
                max-width: 450px;            
            }

            h2 {
                margin-top:15%;
                text-align: center;
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }

            input[type="text"],
            select,
            textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            textarea {
                resize: vertical;
            }

            button {
                display: block;
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                background-color: #00a8ff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-family: 'Poppins', sans-serif;
            }

            button:hover {
                opacity: .7;
            }
        </style>
    </head>
    <body>
        <?php
        include'../BEHeader.php';
        include "../connection.php";
        $msg = "";

        $id = $_GET['approveid'];
        $mainStatus = "Approved";
        $sql2 = "SELECT * FROM maintenance WHERE maintenanceID='$id'";
        $result2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_assoc($result2);

        if (isset($_POST['comment'])) {
            $comment = $_POST['comment'];
            $sql = "update maintenance set maintenanceStatus='$mainStatus', maintenanceComment='$comment' where maintenanceID=$id";
            mysqli_query($conn, $sql);
            echo '<script>alert("Approved Maintenance Successful!");</script>';
            echo'<form id="message" action="MaintenanceSearchAdmin.php" method="post">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
        }
        ?>
        
        <div class ="maintenance">
            <div class="addMaintenance">
                <h2>Approve Maintenance</h2>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class="form-group">
                        <label for="maintenanceType">Maintenance Type:</label>
                        <input type="text" id="maintenanceType" name="maintenanceType" value="<?php echo $row['maintenanceType']; ?>"disabled>
                    </div>
                    <div class="form-group">
                        <label for="date">Issue Date:</label>
                        <input type="text" id="date" name="date" value="<?php echo $row['maintenanceDate']; ?>"disabled>
                    </div>
                    <div class="form-group">
                        <label for="time">Issue Time:</label>
                        <input type="text" id="time" name="time" value="<?php echo $row['maintenanceTime']; ?>"disabled>
                    </div>
                    <div class="form-group">
                        <label for="problemDescription">Problem Description:</label>
                        <textarea id="problemDescription" name="problemDescription" rows="4" disabled><?php echo $row['maintenanceMSG']; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea id="comment" name="comment" rows="4"></textarea>
                    </div>
                    <button type="submit">Approve Maintenance</button>
                    <button type="back" formaction="MaintenanceSearchAdmin.php">Back</button>
                </form>
            </div>
        </div>
    </body>
</html>
