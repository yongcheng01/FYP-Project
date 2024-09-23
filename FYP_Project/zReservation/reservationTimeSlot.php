
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
                margin-left: 11%;
                width: 80%;
                padding: 20px;
                overflow: auto;
                min-height: 500px;
            }

            h1 {
                margin-top: 10%;
                text-align: center;
                margin-bottom: 20px;
            }

            table {
                min-height: 250px;
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                text-align: center;
            }

            th, td {
                padding: 10px;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #ddd;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            th:first-child,
            td:first-child {
                width: 20px;
            }

            td {
                width: 120px;
            }
            
            .fType {
                margin-left: 10px;
            }
            
            .search {
                border-radius: 20px;
                padding: 4px 6px;
            }
            
            .search:hover {
                background-color: #C5C5EC;
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

                table {
                    font-size: 12px; 
                }

                th, td {
                    padding: 8px; 
                }

                button{
                    padding: 3px 8px;
                }
                
                .fType {
                    margin-left: 0;
                }

                .fDate {
                    margin-left: 62px;
                }
            }


        </style>
    </head>

    
    <body class="sub_page">
        <?php 
        include '../connection.php';
        include '../FEHeader.php';
        date_default_timezone_set("Asia/Kuala_Lumpur");
        
        $condoID = "";
        if(isset($_SESSION['ownerEmail'])){
            $email = $_SESSION['ownerEmail'];
            $ownerSql = "SELECT * FROM owner WHERE ownerEmail='$email'";
            $ownerResult = mysqli_query($conn, $ownerSql);
            $ownerRow = mysqli_fetch_assoc($ownerResult);
            $condoID = $ownerRow['condoID'];
            
        }elseif(isset($_SESSION['tenantID'])){
            $id = $_SESSION['tenantID'];
            $tenantSql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID WHERE tenantID='$id'";
            $tenantResult = mysqli_query($conn, $tenantSql);
            $tenantRow = mysqli_fetch_assoc($tenantResult);
            $condoID = $tenantRow['condoID'];
        }

        $facilities = array();
        $query1 = "SELECT * FROM facilities WHERE facilitiesStatus = 'Available' AND condoID = '$condoID'";
        $result1 = mysqli_query($conn, $query1);
        while($data1 = mysqli_fetch_assoc($result1)){
                $facilities[] = $data1;
        }

        $reservations = array();
        $query = "SELECT * FROM reservation WHERE reservationStatus != 'Canceled'";
        $result = mysqli_query($conn, $query);
        while($data = mysqli_fetch_assoc($result)){
                $reservations[] = $data;
        }

        if(isset($_GET['selected_date'])){
            $rDate = $_GET['selected_date'];
            $today = date("Y-m-d");
            $nextWeek = date("Y-m-d", strtotime("+1 week"));

            if ($rDate < $today || $rDate > $nextWeek) {
                echo '<script>alert("Invalid date. Please choose a date between today and the next week.");</script>';
                echo'<form id="message" action="reservationTimeSlot.php" method="post">
                        <input type="hidden" name="message" value="updated">
                        <input type="submit" value="Submit">
                        </form>
                        <script>document.querySelector("#message").submit();</script>';
            }
        }
        // Get the selected date and facility type from the user (you might get this from a form submission)
        $selectedDate = isset($_GET['selected_date']) ? $_GET['selected_date'] : date('Y-m-d');
        $fType = isset($_GET['selected_facility_type']) ? $_GET['selected_facility_type'] : null;

        function getAvailableTimeSlots($reservations, $facilities, $selectedDate, $selectedFacilityType, $allTimeSlots)
        {
            $result = [];

            // Collect taken time slots for the selected day and facility type
            $takenTimeSlots = [];

            foreach ($reservations as $reservation) {
                if ($reservation['reservationDate'] == $selectedDate && in_array($reservation['facilitiesID'], array_column($facilities, 'facilitiesID')) && $facilities[array_search($reservation['facilitiesID'], array_column($facilities, 'facilitiesID'))]['facilitiesType'] == $selectedFacilityType) {
                    $startTime = strtotime($reservation['reservationStartTime']);
                    $endTime = strtotime($reservation['reservationEndTime']);
                    
                    while ($startTime < $endTime) {
                        $takenTimeSlots[$reservation['facilitiesID']][] = date('h:i A', $startTime);
                        $startTime = strtotime('+30 minutes', $startTime);
                    }
                }
            }

            // Get available time slots by excluding taken time slots
            foreach ($facilities as $facility) {
                if ($facility['facilitiesType'] == $selectedFacilityType) {
                    $availableTimeSlots = array_diff($allTimeSlots, $takenTimeSlots[$facility['facilitiesID']] ?? []);
                    $result[] = ['facility' => $facility, 'availableSlots' => $availableTimeSlots];
                }
            }

            return $result;
        }

        $allTimeSlots = [
            '08:00 AM', '09:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM', '06:00 PM', '07:00 PM', '08:00 PM', '09:00 PM', '10:00 PM', '11:00 PM', '24:00 AM',
        ];
 

        // Get available time slots for the selected date and facility type
        $availableTimeSlots = getAvailableTimeSlots($reservations, $facilities, $selectedDate, $fType, $allTimeSlots);
        
        ?>
        
        <div class="menu-container" id="menuContainer">
            <a href="reservationView.php" class="menu-item" id="item1">Reservation History</a>
            <a href="reservationAdd.php" class="menu-item" id="item2">Add Reservation</a>
            <a href="reservationTimeSlot.php" class="menu-item active" id="item2">Available Chart</a>
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
            <h1>Available Chart</h1>
            
            <form action="" method="get">
            <label for="selected_date" class="fDate">Select Date:</label>
            <input type="date" id="selected_date" name="selected_date" value="<?= $selectedDate ?>">

            <label for="selected_facility_type" class="ftype">Select Facility Type:</label>
            <select id="selected_facility_type" name="selected_facility_type">
                <option value="">Select Facilities</option>
                <?php
                $types = array_unique(array_column($facilities, 'facilitiesType'));
                foreach ($types as $type): ?>
                    <?php if($type == "Hall" || $type == "Badminton Court" || $type == "BBQ") :?>
                    <option value="<?= $type ?>" <?= $fType == $type ? 'selected' : '' ?>>
                        <?= $type ?>
                    </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <button type="submit" style="margin-left:10px" class="search">&#128269; </button>
            </form>

            <table border="1">
                <thead>
                    <tr>
                        <th>Facility</th>
                        <?php foreach ($allTimeSlots as $timeSlot): ?>
                            <th><?= $timeSlot ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($availableTimeSlots as $item): ?>
                        <tr>
                            <td><?= $item['facility']['facilitiesName'] ?></td>
                            <?php foreach ($allTimeSlots as $timeSlot): ?>
                                <td><?= in_array($timeSlot, $item['availableSlots']) ? '✔' : '✗' ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
