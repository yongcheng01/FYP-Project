
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
                min-height: 500px;
            }

            h1 {
                margin-top: 10%;
                text-align: center;
                margin-bottom: 20px;
            }

            table {
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

            
            .search {
                margin-bottom: 20px;
                display: flex;
                align-items: center;
            }

            .search input[type="text"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
            }

            /* Refresh link */
            .refresh {
                display: block;
                margin-bottom: 20px;
                margin-left: 10px;
                color: #007bff;
                font-size: 14px;
                text-decoration: none;
            }

            .refresh:hover {
                text-decoration: underline;
            }

            button {
                margin-top: 20px;
                margin-right: 10px;
                display: inline-block;
                padding: 6px 12px;
                text-decoration: none;
                background-color: lightcyan;
                font-weight: bold;
                border: none;
            }

            .add, .cancel{
                font-size: 14px;
                border-radius: 5px;
            }

            button:hover {
                background-color: #0069d9;
            }

            .rowbtn {
                text-align: right;
                margin-top: 20px;
            }
            
            .rowPagination {
                display: flex;
                justify-content: center;
                margin-top: 10px;
            }

            .pagination {
                display: flex;
                justify-content: center;
            }

            .pagination a {
                font-size: 14px;
                display: inline-block;
                padding: 6px 12px;
                text-decoration: none;
                background-color: #007bff;
                border-radius: 5px;
                margin: 0 5px;
                font-weight: bold;
                color: black;
            }

            .pagination a.current {
                background-color: lightcyan;
                color: black;
            }

            .pagination a:hover {
                background-color: #0069d9;
            }

            @media only screen and (max-width: 600px) {
                .page {
                    margin: 0; 
                    width: 100%; 
                    box-sizing: border-box;
                    padding: 10px; 
                    margin-top: 30px; 
                }
                
                .refresh {
                    margin-left: 10px;
                    margin-bottom: 10px;
                }

                h1 {
                    margin-top: 5%; 
                }

                .search {
                    margin-left: 20px;
                }

                table {
                    font-size: 12px;
                    margin-left: 20px;
                    margin-right: 20px;
                }

                th, td {
                    padding: 8px; 
                }

                button, .pagination a {
                    padding: 3px 8px;
                }
                
                table {
                  border: 0;
                }
                table caption {
                  font-size: 1.3em;
                }

                table thead {
                  display: none;
               }

                 table tr {
                  border-bottom: 3px solid blue;
                  display: block;
                  margin-bottom:0.625em;
                }
                table td {
                  border-bottom: 1px solid green;
                  display: block;
                  font-size: .8em;
                  text-align: right;
                  min-height: 40px;
                }
                table td:before {

                  content: attr(data-label);
                  float: left;
                  font-weight: bold;
                  text-transform: uppercase;
                }


            }


        </style>
    </head>

    
    <body class="sub_page">
        <?php 
        include '../connection.php';
        include '../FEHeader.php';
        
        date_default_timezone_set("Asia/Kuala_Lumpur"); 
        $today = date("Y-m-d");
        
        $userID = "";
        $whereText = "";
        if(isset($_SESSION['ownerEmail'])){
            $email = $_SESSION['ownerEmail'];
            $ownerSql = "SELECT * FROM owner WHERE ownerEmail='$email'";
            $ownerResult = mysqli_query($conn, $ownerSql);
            $ownerRow = mysqli_fetch_assoc($ownerResult);
            $userID = $ownerRow['ownerID'];
            $whereText = "ownerID";
            
        }elseif(isset($_SESSION['tenantID'])){
            $id = $_SESSION['tenantID'];
            $tenantSql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID WHERE tenantID='$id'";
            $tenantResult = mysqli_query($conn, $tenantSql);
            $tenantRow = mysqli_fetch_assoc($tenantResult);
            $userID = $tenantRow['tenantID'];
            $whereText = "tenantID";

        }
        
        $updateStatus = "SELECT * FROM reservation INNER JOIN payment ON reservation.paymentID = payment.paymentID WHERE payment.paymentStatus = 'Paid'";
        $statusResult = mysqli_query($conn, $updateStatus);
        if(mysqli_num_rows($statusResult) > 0){
            while ($statusData = mysqli_fetch_assoc($statusResult)){
                $rID = $statusData['reservationID'];
                $updateQuery = "UPDATE reservation SET
                                reservationStatus = 'Approved'
                                WHERE reservationID = '$rID'";
                mysqli_query($conn, $updateQuery);
            }
        }
        
        $updateStatus1 = "SELECT * FROM reservation INNER JOIN payment ON reservation.paymentID = payment.paymentID WHERE payment.paymentStatus = 'Pending' AND payment.dueDate < '$today'";
        $statusResult1 = mysqli_query($conn, $updateStatus1);
        if(mysqli_num_rows($statusResult1) > 0){
            while ($statusData1 = mysqli_fetch_assoc($statusResult1)){
                $rID = $statusData1['reservationID'];
                $updateQuery1 = "UPDATE reservation SET
                                reservationStatus = 'Canceled'
                                WHERE reservationID = '$rID'";
                mysqli_query($conn, $updateQuery1);
            }
        }
        
        $updateStatus2 = "SELECT * FROM reservation INNER JOIN payment ON reservation.paymentID = payment.paymentID WHERE payment.paymentStatus = 'Canceled'";
        $statusResult2 = mysqli_query($conn, $updateStatus2);
        if(mysqli_num_rows($statusResult2) > 0){
            while ($statusData2 = mysqli_fetch_assoc($statusResult2)){
                $rID = $statusData2['reservationID'];
                $updateQuery2 = "UPDATE reservation SET
                                reservationStatus = 'Canceled'
                                WHERE reservationID = '$rID'";
                mysqli_query($conn, $updateQuery2);
            }
        }
        
        
        ?>
        <div class="menu-container" id="menuContainer">
            <a href="reservationView.php" class="menu-item active" id="item1">Reservation History</a>
            <a href="reservationAdd.php" class="menu-item" id="item2">Add Reservation</a>
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
            <h1>Reservation History</h1>
            <div class="row">
                <div class="search">
                    <input type="text" class="form-control" id="live-search" autocomplete="off" placeholder="Search...">
                </div>
                <a href="reservationView.php" class="refresh"> 
                    <i class="las la-sync reload-icon" style="font-size: 25px; margin-top: 5px;"></i>
                </a>
                
            </div>

            <script type="text/javascript">
            $(document).ready(function() {
                $("#live-search").keyup(function() {
                    var input = $(this).val();
                    if (input != "") {
                        $.ajax({
                            url: "../FYPLiveSearchFunction.php",
                            method: "POST",
                            data: {reservation: input, user: "owner"},
                            success: function(data) {
                                $("#searchresult").html(data).show();
                            }
                        });
                    } else {
                        $("#searchresult").hide();
                    }
                });
            });
            </script>  
                        
            <div id="searchresult">
                <form method="post" id="reservation">
                    <div class="row">
                    
                        <table class="table table-hover table-bordered">
                            <thead style="background-color: #90aef0;">
                                <tr>
                                    <th></th>
                                    <th>Facilities</th>
                                    <th>Reservation Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_rows = $conn->query("SELECT reservation.*, facilities.*
                                                            FROM reservation
                                                            INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                                                            WHERE ".$whereText." = $userID")->num_rows;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 5;
                                if ($stmt = $conn->prepare("SELECT reservation.*, facilities.*
                                                            FROM reservation
                                                            INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                                                            WHERE ".$whereText." = $userID 
                                                            ORDER BY reservationStatus DESC, facilities.facilitiesName, reservationDate DESC, reservationEndTime DESC LIMIT ?,?")) {
                                $calc_page = ($page - 1) * $num_results_on_page;
                                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                                $stmt->execute();
                                // Get the results...
                                $result = $stmt->get_result();
                                // Loop through the data and output it in the table
                                if (mysqli_num_rows($result) > 0) {
                                while ($reservation = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <?php if ($reservation['reservationStatus'] == "Pending") :?>
                                    <td data-label="Action"><input type="radio" name="reservationID[]" value="<?=$reservation['reservationID']?>"></td>
                                    <?php else : ?>
                                    <td data-label="Action"></td>
                                    <?php endif; ?>

                                    <td data-label="Facilities"><?= $reservation['facilitiesName'] ?></td>
                                    <td data-label="Reservation Date"><?= $reservation['reservationDate'] ?></td>
                                    <?php 
                                    $startTime = strtotime($reservation['reservationStartTime']);
                                    $endTime = strtotime($reservation['reservationEndTime']);
                                    echo '<td data-label="Time">'.date('H:i', $startTime) . '~' . date('H:i', $endTime).'</td>';
                                    ?>
                                    <td data-label="Status"><?= $reservation['reservationStatus'] ?></td>
                                </tr>
                                <?php } } else{ echo "<tr><td colspan='8' style='text-align:center'>No Data found</td></tr>"; } } ?>
                            </tbody>
                        </table>

                        <div class="rowPagination">
                            <?php if ($total_rows > $num_results_on_page): ?>
                                <div class="pagination">
                                    <?php $total_pages = ceil($total_rows / $num_results_on_page); ?>
                                    <?php if ($page > 1): ?>
                                        <a href="?page=1">&laquo; </a>
                                        <a href="?page=<?php echo $page - 1 ?>">&lsaquo; </a>
                                    <?php endif; ?>

                                    <?php
                                    $start_page = max(1, min($page - 2, $total_pages - 4));
                                    $end_page = min($start_page + 4, $total_pages);

                                    for ($i = $start_page; $i <= $end_page; $i++):
                                        ?>
                                        <?php if ($i == $page): ?>
                                            <center><a href="#" class="current"><?php echo $i ?></a></center>
                                        <?php else: ?>
                                            <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <a href="?page=<?php echo $page + 1 ?>"> &rsaquo;</a>
                                        <a href="?page=<?php echo $total_pages ?>"> &raquo;</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                    
                    <div class="rowbtn">
                        <button class="cancel" formaction="reservationCancel.php" onclick="confirmCancellation()">Cancel</button>
                    </div>
                </form>
            </div>
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
