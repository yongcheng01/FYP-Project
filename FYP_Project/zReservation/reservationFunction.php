
<html>
    <?php session_start()?>
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Reservation</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="jsReservation.js"></script>

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
                margin-bottom: 5%;
            }

           .wholePage {
               background-color: #fff;
           }

           .page {
               margin-left: 20%;
               width: 60%;
               padding: 20px;
               overflow: auto;
               min-height: 500px;
           }

           .row {
               margin-bottom: 15px;
           }

           .search {
               text-align: center;
               margin-bottom: 15px;
           }
           #live-search {
               width: 100%;
               padding: 8px;
               border: 1px solid #ccc;
               border-radius: 3px;
           }
           .refresh {
               display: block;
               text-align: center;
               margin-top: 10px;
               color: #007bff;
               text-decoration: none;
           }
           .refresh:hover {
               color: #0056b3;
           }

           table {
               width: 100%;
               border-collapse: collapse;
               margin-bottom: 15px;
           }
           th {
               background-color: #007bff;
               color: #fff;
           }
           th, td {
                padding: 12px;
                text-align: center;
                border-bottom: 1px solid #ddd;
           }
           tbody tr:hover {
                background-color: #f5f5f5;
            }

           .rowPagination {
               display: flex;
               justify-content: center;
               align-items: center; 
               flex-wrap: wrap;
               margin-top: 20px;
           }
           .pagination {
               display: flex;
               justify-content: center;
               align-items: center; 
           }
           .pagination a, .pagination .current {
               display: inline-block;
               padding: 8px;
               margin: 0 4px;
               color: #333;
               text-decoration: none;
               border: 1px solid #ddd;
               border-radius: 4px;
               transition: background-color 0.3s;
           }
           .pagination a:hover {
               background-color: #007bff;
               color: #fff;
           }
           .pagination a:not(:last-child), .pagination .current:not(:last-child) {
               margin-right: 4px;
           }
           .pagination .current {
                background-color: #007bff;
                color: #fff;
                pointer-events: none; 
            }

           .rowbtn {
               text-align: center;
               margin-top: 20px;
           }
           .rowbtn button {
               background-color: #007bff;
               color: #fff;
               border: none;
               padding: 10px 20px;
               border-radius: 5px;
               cursor: pointer;
               margin: 0 5px;
               transition: background-color 0.3s;
           }
           .rowbtn button:hover {
               background-color: #0056b3;
           }
           
           @media only screen and (max-width: 600px) {
             
               .title {
                   margin-top: 15%;
               }
               
                .page {
                    margin: 0; 
                    width: 100%; 
                    box-sizing: border-box;
                    padding: 10px; 
                    margin-top: 30px; 
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
    <body>
        <?php
            include'../BEHeader.php';
            include '../connection.php';
            date_default_timezone_set("Asia/Kuala_Lumpur"); 
            $today = date("Y-m-d");
            
            //Paid, Change status
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
            
            //Expired, Change Status
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
            if(mysqli_num_rows($statusResult1) > 0){
                while ($statusData2 = mysqli_fetch_assoc($statusResult2)){
                    $rID = $statusData2['reservationID'];
                    $updateQuery1 = "UPDATE reservation SET
                                    reservationStatus = 'Canceled'
                                    WHERE reservationID = '$rID'";
                    mysqli_query($conn, $updateQuery1);
                }
            }
            
        ?>
        
        <div class="title">Reservation Management Function</div>
        <div class="wholePage">
            <div class="page">
                
                <div class="row">
                    <div class="search">
                        <input type="text" class="form-control" id="live-search" autocomplete="off" placeholder="Search...">
                    </div>
                    <a href="reservationFunction.php"><label class="refresh">if no data click here refresh</label></a>
                </div>

                <script type="text/javascript">
                $(document).ready(function () {
                    $("#live-search").keyup(function () {
                        var input = $(this).val();
                        if (input != "") {
                            $.ajax({
                                url: "../FYPLiveSearchFunction.php",
                                method: "POST",
                                data: {reservation: input, user: "staff"},
                                success: function (data) {
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
                        <table>

                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Facilities</th>
                                    <th>Reservation Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Owner</th>
                                    <th>Tenant</th>
                                    <th>Condominium</th>
                                </tr>
                            </thead>

                            
                            
                            <tbody>
                                <?php
                                $total_rows = $conn->query("SELECT reservation.*, facilities.*, owner.*, condominium.*, tenant.*
                                                            FROM reservation
                                                            INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                                                            LEFT JOIN owner ON reservation.ownerID = owner.ownerID
                                                            LEFT JOIN tenant ON reservation.tenantID = tenant.tenantID
                                                            INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID")->num_rows;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 5;
                                if ($stmt = $conn->prepare("SELECT reservation.*, facilities.*, owner.*, condominium.*, tenant.*
                                                            FROM reservation
                                                            INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                                                            LEFT JOIN owner ON reservation.ownerID = owner.ownerID
                                                            LEFT JOIN tenant ON reservation.tenantID = tenant.tenantID
                                                            INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                                                            ORDER BY reservationStatus DESC, facilities.condoID, facilities.facilitiesName, reservationDate DESC, reservationEndTime DESC LIMIT ?,?")) {
                                // Calculate the page to get the results we need from our table.
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
                                    <td data-label="Owner"><?php echo $reservation['ownerFName']." ".$reservation['ownerLName'] ?></td>
                                    <td data-label="Tenant"><?= $reservation['tenantName'] ?></td>
                                    <td data-label="Condominium"><?= $reservation['condoName'] ?></td>
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
                            <button class="cancel" formaction="reservationCancel.php?user='Staff'" onclick="confirmCancellation()">Cancel</button>

                        </div>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>
