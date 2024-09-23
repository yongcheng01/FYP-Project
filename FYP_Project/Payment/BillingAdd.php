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
            .bill {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }
            .addBill {
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

            input[type="number"],
            input[type="date"],
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
                background: #00a8ff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                opacity: .7;
            }
            .amount-group {
            display: none;
        }
        </style>
    </head>
    <body>
        <?php
        include'../BEHeader.php';
        include'../connection.php';
        $query = "SELECT * FROM house";
        $result = mysqli_query($conn, $query);
        $houses = array();

        while ($data = mysqli_fetch_assoc($result)) {
            $house[] = $data;
        }
        
        $condo = array();
        $cQuery = "SELECT * FROM condominium";
        $cResult = mysqli_query($conn, $cQuery);
        while($cData = mysqli_fetch_assoc($cResult)){
                $condo[] = $cData;
        }

        $msg = "";
        $dueDate = "";
        $issueDate = date("Y-m-d");
        $status = "Pending";
        $amountError = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['billType']) && isset($_POST['condo']) && isset($_POST['house']) && isset($_POST['dueDate'])) {
                    $billType = $_POST['billType'];
                    $condoSelect = $_POST['condo'];
                    $houseSelect = $_POST['house'];
                    $dueDate = $_POST['dueDate'];
                
        if (isset($_POST["billType"]) && $_POST["billType"] == "Monthly Maintenance Fees") {
            
            if (!empty($dueDate)) {

                if (isset($_POST["condo"]) && $_POST["condo"] != "0") {

                    if (isset($_POST["house"]) && $_POST["house"] != "0") {

                        if ($houseSelect == "Select All") {
                            $amount = "";
                            $maintenanceFees = 0.3;

                            // Fetch all houses for the selected condominium
                            $query ="SELECT h.*, o.ownerID
                                    FROM house h
                                    JOIN owner o ON h.houseID = o.houseID
                                    WHERE o.condoID = $condoSelect";
                            $result = mysqli_query($conn, $query);

                            while ($data = mysqli_fetch_assoc($result)) {
                                $houseID = $data["houseID"];
                                $ownerID = $data["ownerID"];
                                $amount = $data["squareFeet"] * $maintenanceFees;

                                $insertHouse = "INSERT INTO payment(houseID, ownerID, billType, issueDate, dueDate, amount, paymentStatus) VALUES
                            ('$houseID', '$ownerID', '$billType', '$issueDate', '$dueDate', '$amount', '$status')";
                                mysqli_query($conn, $insertHouse);
                            }

                            $msg = "<div class='alert alert-success'>The Bills Added Successfully</div>";
                            $billType = "";
                            $dueDate = "";
                            $condoSelect = "";
                            $houseSelect = "";
                        } else {
                            $sql = "SELECT h.*, o.ownerID
                                    FROM house h
                                    JOIN owner o ON h.houseID = o.houseID
                                    WHERE h.houseID = $houseSelect";
                            $result1 = mysqli_query($conn, $sql);
                            $data = mysqli_fetch_assoc($result1);
                            $ownerID = $data["ownerID"];
                            $amount = $data["squareFeet"] * 0.3;
                            $insertHouse1 = "INSERT INTO payment(houseID, ownerID, billType, issueDate, dueDate, amount, paymentStatus) VALUES
                                ('$houseSelect','$ownerID', '$billType', '$issueDate', '$dueDate', '$amount', '$status')";
                            mysqli_query($conn, $insertHouse1);
                            $msg = "<div class='alert alert-success'>The Bill Added Successfully</div>";
                            $billType = "";
                            $dueDate = "";
                            $condoSelect = "";
                            $houseSelect = "";
                        }
                    } else {
                        $msg = "<div class='alert alert-danger'>Please select a valid House ID</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Please select a valid Condominium</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Please Select Due Date</div>";
            }
        } elseif (isset($_POST["billType"]) && $_POST["billType"] == "Damage Repair Fees") {

            if (!empty($dueDate)) {

                if (!empty($_POST["amount"])) {

                    if (isset($_POST["condo"]) && $_POST["condo"] != "0") {

                        if (isset($_POST["house"]) && $_POST["house"] != "0") {
                            $amount = $_POST['amount'];
                            if ($houseSelect == "Select All") {
                            $query ="SELECT h.*, o.ownerID
                                    FROM house h
                                    JOIN owner o ON h.houseID = o.houseID
                                    WHERE o.condoID = $condoSelect";
                            $result = mysqli_query($conn, $query);

                            while ($data = mysqli_fetch_assoc($result)) {
                                $ownerID = $data["ownerID"];
                                $houseID = $data["houseID"];

                                $insertHouse = "INSERT INTO payment(houseID, ownerID, billType, issueDate, dueDate, amount, paymentStatus) VALUES
                            ('$houseID', '$ownerID', '$billType', '$issueDate', '$dueDate', '$amount', '$status')";
                                mysqli_query($conn, $insertHouse);
                            }

                            $msg = "<div class='alert alert-success'>The Bills Added Successfully</div>";
                            $billType = "";
                            $dueDate = "";
                            $condoSelect = "";
                            $houseSelect = "";
                            $amount = "";
                            }else{
                                $sql = "SELECT h.*, o.ownerID
                                    FROM house h
                                    JOIN owner o ON h.houseID = o.houseID
                                    WHERE h.houseID = $houseSelect";
                            $result1 = mysqli_query($conn, $sql);
                            $data = mysqli_fetch_assoc($result1);
                            $ownerID = $data["ownerID"];
                                $insertHouse1 = "INSERT INTO payment(houseID, ownerID, billType, issueDate, dueDate, amount, paymentStatus) VALUES
                                ('$houseSelect', '$ownerID', '$billType', '$issueDate', '$dueDate', '$amount', '$status')";
                            mysqli_query($conn, $insertHouse1);
                            $msg = "<div class='alert alert-success'>The Bill Added Successfully</div>";
                            $billType = "";
                            $dueDate = "";
                            $condoSelect = "";
                            $houseSelect = "";
                            $amount = "";
                            }
                            
                        } else {
                            $msg = "<div class='alert alert-danger'>Please select a valid House ID</div>";
                        }
                    } else {
                        $msg = "<div class='alert alert-danger'>Please select a valid Condominium</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Please Enter Amount</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Please Select Due Date</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Please select a valid Bill Type</div>";
        }
    }
            }
?>
        <div class ="bill">
            <div class="addBill">
                <h2>Add Bill</h2>
                <?php echo $msg; ?>
                <form action="BillingAdd.php" method="post" class="form" autocomplete="off">
                    <div class="form-group">
                        <label for="billType">Bill Type:</label>
                        <select id="billType" name="billType">
                            <option value="select">Select Bill Type</option>
                            <option value="Monthly Maintenance Fees" <?php echo (isset($_POST["billType"]) && $_POST["billType"] == 'Monthly Maintenance Fees') ? 'selected' : ''; ?>>Monthly Maintenance Fees</option>
                            <option value="Damage Repair Fees" <?php echo (isset($_POST["billType"]) && $_POST["billType"] == 'Damage Repair Fees') ? 'selected' : ''; ?>>Damage Repair Fees</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dueDate">Due Date:</label>
                        <input type="date" id="dueDate" name="dueDate" value="<?php echo htmlspecialchars($dueDate); ?>" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group amount-group">
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount" placeholder="Please Enter Amount" value="<?php echo isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Condominium</label>
                        <select name="condo" id="condo">
                            <option value="0">Select Condominium</option>
                            <?php foreach ($condo as $cd): ?>
                                <?php
                                // Check if $selectedCondoID is set and equal to the current condoID in the loop
                                $selectedCondoID = isset($_POST['condo']) && $_POST['condo'] == $cd['condoID'] ? 'selected' : '';
                                ?>
                                <option value="<?= $cd['condoID'] ?>" <?= $selectedCondoID ?>><?= $cd['condoName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="houseID">House ID:</label>
                         <select name="house" id="house">
                            <option value="0">Select House ID</option>
                            <option value="Select All">Select All</option>
                         </select>
                    </div>
                        
                    <script>
        $(document).ready(function(){
            // Initial check on page load
            checkAmountVisibility();

            $('#billType').change(function(){
                checkAmountVisibility();
            });
        });

        function checkAmountVisibility() {
            var selectedValue = $('#billType').val();
            var amountError = <?php echo json_encode($amountError); ?>;

            // Check if the selected value is "Damage Repair Fees" and there are no errors in the amount field
            if (selectedValue === 'Damage Repair Fees' && !amountError) {
                $('.amount-group').show(); // Show the amount column
            } else {
                $('.amount-group').hide(); // Hide the amount column
            }
        }
        

$(document).ready(function() {
    // Bind change event to the Condominium dropdown
    $('#condo').on('change', function() {
        // Get the selected Condominium ID
        var condoID = $(this).val();
        
        // Make an AJAX request to fetch corresponding house data
        $.ajax({
            type: 'POST',
            url: 'getHouses.php', // Replace with the actual PHP script to fetch houses based on the Condominium ID
            data: { condoID: condoID },
            success: function(response) {
                // Update the House ID dropdown with the fetched data
                $('#house').html(response);
            }
        });
    });
});



                    </script>
                    <button type="submit">Add Bill</button>
                    <button type="button" onclick="goBack()">Back</button>

                </form>

            </div>
        </div>
         <script>
    function goBack() {
      // You can use window.location.href to navigate to the desired page
      window.location.href = "PaymentSearch.php";
    }
  </script>
    </body>
</html>
