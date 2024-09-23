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
             .carPark{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }
            .assignCarPark {
               background: white;
                padding: 30px 30px;
                min-width: 400px;
                max-width: 450px;            
            }

            h2 {
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
            select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
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

        $id = $_GET['editid'];
        $carParkStatus = "Unavailable";
        $sql = "SELECT * FROM carPark WHERE carParkID = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $condoID = $row["condoID"];

        $sql2 = "SELECT * FROM condominium WHERE condoID = '$condoID'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        $oQuery = "SELECT * FROM owner WHERE condoID = '$condoID'";
        $oResult = mysqli_query($conn, $oQuery);
        while ($oData = mysqli_fetch_assoc($oResult)) {
            $owner[] = $oData;
        }

        if (isset($_POST['owner']) && isset($_POST['carPlate'])) {
            $ownerID = $_POST['owner'];
            $carPlate = $_POST['carPlate'];
            if (isset($_POST["owner"]) && $_POST["owner"] != "0") {
                if (empty($carPlate)) {
                    $msg = "<div class='alert alert-danger'>Please Enter Car Plate</div>";
                } else {
                    $carPark = "UPDATE carpark SET ownerID='$ownerID', carPlate='$carPlate' , carParkStatus='$carParkStatus' WHERE carParkID = '$id'";
                    mysqli_query($conn, $carPark);
                    echo '<script>alert("Assign Car Park successfully!");</script>';
                        echo'<form id="message" action="CarParkSearch.php" method="post">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
                    $carPlate = "";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Please select a valid Owner</div>";
            }
        }
        ?>
        <div class ="carPark">
            <div class="assignCarPark">
                <h2>Assign Car Park</h2>
                <br>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class="form-group">
                        <label for="condoName">Condominium Name:</label>
                        <input type="text" id="condoName" name="condoName" value="<?php echo $row2['condoName']; ?>"disabled>
                    </div>
                    <div class="form-group">
                        <label for="carPark">Car Park:</label>
                        <input type="text" id="carPark" name="carPark" value="<?php echo $row['carBlock'].'-'.$row['carFloor'].'-'.$row['number']; ?>"disabled>
                    </div>
                     <div class="form-group">
                            <label for="owner">Owner</label>
                                <select name="owner" class= "input">
                                    <option value="0">Please Select Owner</option>
                                    <?php foreach ($owner as $owners): ?>
                                <?php
                                // Check if $selectedCondoID is set and equal to the current condoID in the loop
                                $selectedOwnerID = isset($_POST['owner']) && $_POST['owner'] == $owners['ownerID'] ? 'selected' : '';
                                ?>
                                <option value="<?= $owners['ownerID'] ?>" <?= $selectedOwnerID ?>><?=$owners['ownerID']. ' '. $owners['ownerFName'] . ' ' . $owners['ownerLName'] ?></option>
                            <?php endforeach; ?>
                                </select>
                      </div> 
                    <div class="form-group">
                        <label for="carPlate">Car Plate:</label>
                        <input type="text" id="carPlate" name="carPlate" placeholder="Enter Car Plate" value="<?php if (isset($_POST['submit'])) { echo $carPlate; } ?>">
                    </div>
                    <button type="submit">Assign</button>
                    <button type="back" formaction="CarParkSearch.php">Back</button>
                </form>
            </div>
        </div>
       
    </body>
</html>
