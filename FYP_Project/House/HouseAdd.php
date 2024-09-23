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
            .house{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }
            .addHouse {
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
        $houseStatus = "Available";
        $msg = "";
        if (isset($_POST['condo'])) {
            if (isset($_POST['condo']) && $_POST['condo'] != "0") {
                $condoSelect = $_POST['condo'];

                $condoCheckQuery = "SELECT * FROM house WHERE condoID = '$condoSelect' LIMIT 1";
                $condoCheckResult = mysqli_query($conn, $condoCheckQuery);

                if (mysqli_num_rows($condoCheckResult) > 0) {
                    $msg = "<div class='alert alert-danger'>The house has already been added for Condo ID $condoSelect</div>";
                } else {

                    $condoQuery = "SELECT * FROM condominium WHERE condoID = '$condoSelect'";
                    $condoResult = mysqli_query($conn, $condoQuery);

                    if ($condoResult) {
                        $condoData = mysqli_fetch_assoc($condoResult);

                        $totalFloors = $condoData['condoFloor'];
                        $housesPerFloor = $condoData['roomPerFloor'];
                        $totalBlocks = $condoData['condoBlock'];
                        $totalCarPark = $condoData['condoCarParkFloor'];

                        for ($totalCarPark; $totalCarPark <= $totalFloors; $totalCarPark++) {
                            for ($houseNumber = 1; $houseNumber <= $housesPerFloor; $houseNumber++) {
                                for ($block = 1; $block <= $totalBlocks; $block++) {

                                    $blockLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                                    $blockLetter = isset($blockLetters[$block - 1]) ? $blockLetters[$block - 1] : '';

                                    if ($totalCarPark <= 10) {
                                        $squareFeet = 800;
                                    } else {
                                        $squareFeet = 1000;
                                    }

                                    $houseQuery = "INSERT INTO house(floor, houseNumber, block, squareFeet, houseStatus, condoID) VALUES ('$totalCarPark', '$houseNumber', '$blockLetter', '$squareFeet', '$houseStatus','$condoSelect')";
                                    $result = mysqli_query($conn, $houseQuery);

                                    if (!$result) {
                                        $msg .= "<div class='alert alert-danger'>Error adding house: " . mysqli_error($conn) . "</div>";
                                    }
                                }
                            }
                        }

                        $msg = "<div class='alert alert-success'>Houses added successfully for Condo ID $condoSelect</div>";
                    } else {
                        $msg = "<div class='alert alert-danger'>Error fetching condominium data: " . mysqli_error($conn) . "</div>";
                    }
                }
            } else {
                $msg = "<div class='alert alert-danger'>Please select a valid Condominium</div>";
            }
        }
        ?>
        
        <div class ="house">
        <div class="addHouse">
            <h2 class="title">Add House</h2>
            <br>
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
                <button type="submit">Add House</button>
                <button type="submit" formaction="HouseSearch.php">Back</button>
        </form>

    </body>
</html>
