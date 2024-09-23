
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
            <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
            <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <script src="jsReservation.js"></script>
        
        <title>Reservation</title>
        <style>
            .menu-container {
              position: fixed;
              top: 110px;
              left: -150px;
              width: 150px;
              height: 35vh;
              display: flex;
              flex-direction: column;
              background-color: white;
              transition: left 0.3s;
            }

            .menu-item {
              padding: 15px;
              color: black;
              text-align: center;
              cursor: pointer;
              transition: background-color 0.3s, color 0.3s;
            }

            .menu-item:hover,
            .menu-item.active {
              background-color: #555;
              color: #fff;
            }

            .content {
              margin-left: 0;
              padding: 20px;
            }

             Additional styling for a cleaner look
            a {
              text-decoration: none;
              color: inherit;
            }

            .menu-item {
              border-bottom: 1px solid #444;
            }

            .menu-item:last-child {
              border-bottom: none;
            }

            .menu-toggle {
                position: fixed;
                top: 80px;
                left: 10px;
                cursor: pointer;
                z-index: 2;
                background-color: transparent;
                border: none;
            }

            .menu-toggle .las {
                font-size: 24px;
                color: #000;
            }

            .page {
                margin-left: 25%;
                width: 50%;
                padding: 20px;
                overflow: auto;
            }

            h1 {
                margin-top: 10%;
                text-align: center;
                margin-bottom: 20px;
            }

            .form {
                max-width: 600px;
                margin: 0 auto;
                margin-top: 12%;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #f5f5f5;
            }

            .row {
                margin-bottom: 15px;
            }

            label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
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
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            hr {
                margin-top: 15px;
                margin-bottom: 25px;
                border: none;
                border-top: 1px solid #ccc;
            }

            @media only screen and (max-width: 600px) {
                .page {
                    margin: 0; 
                    width: 100%; 
                    box-sizing: border-box;
                    padding: 10px; 
                    margin-top: 30px; 
                    
                }
                
                h1 {
                    margin-top: 5%; 
                }
                
                label {
                    margin-left: 35px;
                }

                .input {
                    margin-left: 35px;
                    width: 80%;
                }


            }


        </style>
    </head>

    
    <body class="sub_page">
        <?php 
        include '../connection.php';
        include '../FEHeader.php';
        
        $condoID = "";
        $houseID = "";
        $ownerID = "";
        $tenantID = "";
        if(isset($_SESSION['ownerEmail'])){
            $email = $_SESSION['ownerEmail'];
            $ownerSql = "SELECT * FROM owner WHERE ownerEmail='$email'";
            $ownerResult = mysqli_query($conn, $ownerSql);
            $ownerRow = mysqli_fetch_assoc($ownerResult);
            $ownerID = $ownerRow['ownerID'];
            $houseID = $ownerRow['houseID'];
            $condoID = $ownerRow['condoID'];
            
        }elseif(isset($_SESSION['tenantID'])){
            $id = $_SESSION['tenantID'];
            $tenantSql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID WHERE tenantID='$id'";
            $tenantResult = mysqli_query($conn, $tenantSql);
            $tenantRow = mysqli_fetch_assoc($tenantResult);
            $tenantID = $tenantRow['tenantID'];
            $houseID = $tenantRow['houseID'];
            $condoID = $tenantRow['condoID'];
        }
        
        
        $facilities = array();
        $query = "SELECT * FROM facilities WHERE facilitiesStatus = 'Available' AND condoID = $condoID AND facilitiesType != 'Swimming Pool' AND facilitiesType != 'Gym Room' ORDER BY facilitiesType";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
          $facilities[] = $row;  
        }
        
        if(isset($_POST['reservationStartTime'], $_POST['reservationEndTime'])){
            
            date_default_timezone_set("Asia/Kuala_Lumpur");   
            
            $fType = $_POST['facilities'];
            $rDate = $_POST['reservationDate'];
            $rStart = $_POST['reservationStartTime'];
            $rEnd = $_POST['reservationEndTime'];
            
            $timeS = strtotime($rStart[0]);
            $timeE = strtotime($rEnd[0]);
            
            $today = date("Y-m-d");
            $nextWeek = date("Y-m-d", strtotime("+1 week"));
            $tmrDate = date("Y-m-d", strtotime("+1 day"));
            $dueDate = date("Y-m-d", strtotime("+3 day"));
            
            $currentDateTime = new DateTime();
            $currentTimestamp = $currentDateTime->getTimestamp();

            $time = "";
            if ($fType[0] == "BBQ"){
                $time = 6;
            }elseif ($fType[0] == "Hall"){
                $time = 12;
            }elseif ($fType[0] == "Badminton Court"){
                $time = 2;
            }
            
            $chkBookTime = "SELECT * FROM facilities
                WHERE facilitiesType = '$fType[0]'
                AND condoID = '$condoID'
                AND facilities.facilitiesID NOT IN (
                    SELECT facilities.facilitiesID FROM reservation
                    INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                    WHERE facilities.facilitiesType = '$fType[0]'
                    AND condoID = '$condoID'
                    AND reservationDate = '$rDate'
                    AND reservationStatus != 'Canceled'
                    AND (
                        ('$rStart[0]' >= reservationStartTime AND '$rEnd[0]' <= reservationEndTime)
                        OR ('$rStart[0]' <= reservationStartTime AND '$rEnd[0]' BETWEEN reservationStartTime AND reservationEndTime AND '$rEnd[0]' != reservationStartTime)
                        OR ('$rStart[0]' BETWEEN reservationStartTime AND reservationEndTime AND '$rEnd[0]' >= reservationEndTime AND '$rStart[0]' != reservationEndTime)
                    )
                )";

            $result1 = mysqli_query($conn, $chkBookTime);
            
        
            if (($timeE - $timeS) > $time * 60 * 60) { // 2 hours in seconds
                echo '<script>alert("Reservation time cant be more than '.$time.' hours.");</script>';
                
            }
            elseif ($rDate < $today || $rDate > $nextWeek) {
                echo '<script>alert("Invalid date. Please choose a date between today and the next week.");</script>';
                
            }
            elseif ($result1 && mysqli_num_rows($result1) == 0) {
                echo '<script>alert("This time slot is already booked. Please choose another time.");</script>';
                
            }
            elseif ($timeE <= $timeS) {
                echo '<script>alert("Invalid end time. Please choose an end time after the start time.");</script>';
                
            }
            elseif($rDate == $today && $timeS < $currentTimestamp){
                echo '<script>alert("Invalid time. Please choose a time equal to or greater than the current time.");</script>';
                
            }
            else {
                $timeData = mysqli_fetch_assoc($result1);
                $fID = $timeData['facilitiesID'];
                
                $amount = "";
                if ($fType[0] == "BBQ"){
                    $amount = 50.00;
                }elseif ($fType[0] == "Hall"){
                    $amount = 150.00;
                }
                
                
                
                if($fType[0] == "BBQ" || $fType[0] == "Hall"){
                    $paymentText = "Reservation Fee (".$fType[0].")";
                    $paymentQuery = "INSERT INTO payment (houseID, ownerID, tenantID, billType, issueDate, dueDate, amount, paymentStatus)
                                    VALUES('$houseID', '$ownerID', '$tenantID', '$paymentText', '$today', '$rDate', '$amount', 'Pending')";
                    mysqli_query($conn, $paymentQuery);
                    
                    $paymentID = mysqli_insert_id($conn);
                    
                    $query = "INSERT INTO reservation (reservationDate, reservationStartTime, reservationEndTime, reservationStatus, facilitiesID, ownerID, tenantID, paymentID)
                                VALUES('$rDate', '$rStart[0]', '$rEnd[0]', 'Pending', '$fID', '$ownerID', '$tenantID', '$paymentID')";
                    mysqli_query($conn, $query);
                    
                }else {
                    $query = "INSERT INTO reservation (reservationDate, reservationStartTime, reservationEndTime, reservationStatus, facilitiesID, ownerID, tenantID, paymentID)
                                VALUES('$rDate', '$rStart[0]', '$rEnd[0]', 'Approved', '$fID', '$ownerID', '$tenantID', '0')";
                    mysqli_query($conn, $query);
                }
                
                echo '<script>alert("Add Reservation Successful");</script>';
            
                echo'<form id="message" action="reservationView.php" method="post">
                    <input type="hidden" name="message" value="updated">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            }
            
        }
        
        $facilitiesType = "";
        
        ?>
        <div class="menu-container" id="menuContainer">
            <a href="reservationView.php" class="menu-item" id="item1">Reservation History</a>
            <a href="reservationAdd.php" class="menu-item active" id="item2">Add Reservation</a>
            <a href="reservationTimeSlot.php" class="menu-item" id="item2">Available Chart</a>
        </div>
     
        <div class="menu-toggle" id="menuToggle">
            <span class="las la-bars" id="menuIcon"></span>
        </div>   
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const menuContainer = document.getElementById("menuContainer");
                const menuToggle = document.getElementById("menuToggle");

                document.addEventListener("click", function (event) {
                    const target = event.target;

                    // Check if the clicked element is the menu toggle button or icon
                    if (target.id === "menuToggle" || target.id === "menuIcon") {
                        // Toggle the menu when the button or icon is clicked
                        menuContainer.style.left = menuContainer.style.left === "0px" ? "-150px" : "0";
                    }
                });
            });
        </script>
        
        <div class="page">
            <h1>Add Reservation</h1>
            <hr>
                        
            <form id="reservationAdd" action="reservationAdd.php" method="post">
                    
                    <div class="row">
                        <label>Facilities</label>
                        <select name="facilities[]" id="facilities" class="input">
                            <option value="0">Select Facilities Type</option>
                            <?php foreach ($facilities as $fs) :
                            if ($facilitiesType != $fs['facilitiesType']) :
                                $facilitiesType = $fs['facilitiesType'];
                            
                            if ($fs['facilitiesType'] == "BBQ") : ?>
                                <option value="<?= $fs['facilitiesType'] ?>" ><?php echo $fs['facilitiesType']." (Reservation Fee RM 50/Max Reservation 6 Hours)" ?></option>
                            <?php elseif ($fs['facilitiesType'] == "Hall") : ?>
                                <option value="<?= $fs['facilitiesType'] ?>" ><?php echo $fs['facilitiesType']." (Reservation Fee RM 150/Max Reservation 12 Hours)" ?></option>
                            <?php else : ?>
                                <option value="<?= $fs['facilitiesType'] ?>" ><?= $fs['facilitiesType'] ?></option>
                            <?php endif; ?> 
                            <?php endif; ?> 
                            <?php endforeach;?>
                         </select>
                    </div>
                    
                    <div class="row">
                        <label>Reservation Date</label>
                        <input type="date" name="reservationDate" id="reservationDate" class="input">
                    </div>

                    <div class="row">
                        <label>Reservation Form</label>
                        <select name="reservationStartTime[]" id="reservationStartTime" class="input">
                            <option value="0"></option>
                            <?php for ($i = 8; $i < 25; $i++) : ?>
                                <?php $formattedTime = ($i < 10) ? '0' . $i . ':00' : $i . ':00'; ?>
                                <option value="<?php echo $formattedTime; ?>"><?php echo $formattedTime; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="row">
                        <label>Reservation To</label>
                        <select name="reservationEndTime[]" id="reservationEndTime" class="input">
                            <option value="0"></option>
                            <?php for ($i = 8; $i < 25; $i++) : ?>
                                <?php $formattedTime = ($i < 10) ? '0' . $i . ':00' : $i . ':00'; ?>
                                <option value="<?php echo $formattedTime; ?>"><?php echo $formattedTime; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    


                    <div class="rowbtn">
                        <button class="btnAdd" onclick="validateReservation()">Add</button>
                    </div>
                </form>
        </div>
        

        <?php
        include '../FEFooter.php';
        ?>

        <!-- footer section -->
        <footer class="footer_section">
            <div class="container">
                <p>
                    &copy; <span id="displayYear"></span> 
                    <a href="https://html.design/"></a>
                </p>
            </div>
        </footer>
        <!-- footer section -->
        <!-- jQery -->
        <script src="js/jquery-3.4.1.min.js"></script>
        <!-- popper js -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>
        <!-- owl slider -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <!-- nice select -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
        <!-- custom js -->
        <script src="js/custom.js"></script>
        <!-- Google Map -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
        <!-- End Google Map -->


    </body>

</html>
