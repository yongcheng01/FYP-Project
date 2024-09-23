<html>
    <?php
    session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <link rel="stylesheet" href="../style.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <style>
            .carPark{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }
            .addCarPark {
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
            input[type="number"],
            select{
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
            button {
                display: block;
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                background: #00a8ff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                opacity: .7;
            }
        </style>
    </head>
    <body>
        <?php
        include "../connection.php";
        include'../BEHeader.php';

        $condo = array();
        $cQuery = "SELECT * FROM condominium";
        $cResult = mysqli_query($conn, $cQuery);
        while ($cData = mysqli_fetch_assoc($cResult)) {
            $condo[] = $cData;
        }

        $msg = "";
        $carParkStatus = "Available";
        if (isset($_POST['condo']) && isset($_POST['number'])) {
            $condoSelect = $_POST['condo'];
            $number = $_POST['number'];

            if (isset($_POST["condo"]) && $_POST["condo"] != "0") {

                if (!empty($_POST["number"])) {

                    $condoCheckQuery = "SELECT * FROM carpark WHERE condoID = '$condoSelect' LIMIT 1";
                    $condoCheckResult = mysqli_query($conn, $condoCheckQuery);

                    if (mysqli_num_rows($condoCheckResult) > 0) {
                        $msg = "<div class='alert alert-danger'>The CarPark has already been added for Condo ID $condoSelect</div>";
                    } else {

                        $condoQuery = "SELECT * FROM condominium WHERE condoID = '$condoSelect'";
                        $condoResult = mysqli_query($conn, $condoQuery);
                        if ($condoResult) {
                            $condoData = mysqli_fetch_assoc($condoResult);
                            $totalBlocks = $condoData['condoBlock'];
                            $totalCarPark = $condoData['condoCarParkFloor'];

                            for ($totalFloor = 1; $totalFloor <= $totalCarPark; $totalFloor++) {
                                for ($carParkNumber = 1; $carParkNumber <= $number; $carParkNumber++) {
                                    for ($block = 1; $block <= $totalBlocks; $block++) {
                                        $blockLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                                        $blockLetter = isset($blockLetters[$block - 1]) ? $blockLetters[$block - 1] : '';

                                        $carParkQuery = "INSERT INTO carpark(carFloor, number, carBlock, condoID, carParkStatus) VALUES
                                        ('$totalFloor', '$carParkNumber', '$blockLetter', '$condoSelect', '$carParkStatus')";
                                        $result = mysqli_query($conn, $carParkQuery);
                                        if (!$result) {
                                            $msg .= "<div class='alert alert-danger'>Error adding carPark: " . mysqli_error($conn) . "</div>";
                                        }
                                    }
                                }
                            }
                            $msg = "<div class='alert alert-success'>CarPark added successfully for Condo ID $condoSelect</div>";
                        } else {
                            $msg = "<div class='alert alert-danger'>Error fetching condominium data: " . mysqli_error($conn) . "</div>";
                        }
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Please Enter a valid Number</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Please select a valid Condominium</div>";
            }
        }
        ?>
        
        <div class ="carPark">
        <div class="addCarPark">
            <h2 class="title">Add CarPark</h2>
            <?php echo $msg; ?>
            <form action="" method="post" class="form" autocomplete="off">
                
                <div class="form-group">
                <label>Condominium</label>
                        <select name="condo" id="condo">
                            <option value="0">Select Condominium</option>
                            <?php foreach($condo as $cd):?>
                            <?php
                                // Check if $selectedCondoID is set and equal to the current condoID in the loop
                                $selectedCondoID = isset($_POST['condo']) && $_POST['condo'] == $cd['condoID'] ? 'selected' : '';
                                ?>
                            <option value="<?= $cd['condoID']?>" <?= $selectedCondoID ?>><?= $cd['condoName']?></option>
                            <?php endforeach;?>
                         </select>
                </div>
            
            
            <div class="form-group">
                <label for="number">Carpark Slot per Floor:</label>
                <input type="number" id="number" name="number" placeholder="Please Enter Number">
            </div>
      
            <button type="submit">Add CarPark</button>
            <button type="button" onclick="goBack()">Back</button>
        </form>
    </div>
            <script>
      function goBack() {
      window.location.href = "CarParkSearch.php";
    }
  </script>
    </body>
</html>
