
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        
        <title>Report</title>
        
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
                margin-top: 12%;
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
        session_start();
        include'../BEHeader.php';
        include'../connection.php';
        
        ?>
    
        <script>
                function toggleFields() {
                    var reportType = document.getElementById('reportType').value;
                    document.getElementById('reportYear').disabled = reportType === 'Monthly';
                    document.getElementById('reportMonth').disabled = reportType === 'Annual';
                    
                }
                
                function chkReportVld() {
                    var reportType = $('#reportType').val();
                    
                    const form1 = document.getElementById('reservationReport');
                    const formData1 = new FormData(form1);


                    if (reportType === "0") {
                        alert("Please select report type!");
                        event.preventDefault();
                        return false;
                    } else {
                        form1.submit();
                        return true;
                    }

                }
        </script>

        <div class="page">
            <div class="form">

                <div class="header">
                    <div class="left">
                        <h1>Reservation Report Query</h1>
                    </div>
                    <div class="right">
                        <a href="reportMenu.php" class="btnBack"><span class="las la-arrow-left"></span></a>
                    </div>
                </div>  
                <hr>

                <form id="reservationReport" action="reportPrintReservation.php" method="post">
                    
                    <div class="row">
                        <label>Report Type</label>
                        <select name="reportType" id="reportType" class="input" onchange="toggleFields()">
                            <option value="0">Select Report Type</option>
                            <option value="Annual">Annual</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <label>Year</label>
                        <select name="reportYear" id="reportYear" class="input">
                            <option value="0">Select Year</option>
                            <?php
                            $currentYear = date("Y");
                            $startYear = $currentYear - 10; // adjust this based on your needs
                            for ($year = $startYear; $year <= $currentYear; $year++) {
                                echo "<option value='$year'>$year</option>";
                            }
                            ?>
                        </select>                    
                    </div>
                    
                    <div class="row">
                        <label>Months</label>
                        <select name="reportMonth" id="reportMonth" class="input">
                            <option value="0">Select Month</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    
                    <div class="rowbtn">
                        <button class="btnAdd" onclick="chkReportVld()">Print Report</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
