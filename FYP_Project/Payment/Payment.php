<html>
    <?php
    session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <style>
            .menu-container {
                position: fixed;
                top: 110px;
                left: -150px;
                width: 150px;
                height: 18vh;
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
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }
            .page {
                margin-left: 13%;
                width: 75%;
                padding: 20px;
                margin-bottom: 5%;
                overflow: auto;
            }
            h1 {
              margin-top: 10px;
              text-align: center;
              margin-bottom: 20px;
              text-align: center;
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
            .refresh{
                margin-left: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                text-align: center;
            }

            th, td {
                padding: 10px;
                text-align: center;
                border-bottom: 1px solid #ddd;
            }
            
            th {
                background-color: #ddd;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            th:first-child{
                width: 20px;
            }
            
            .rowPagination {
                display: flex;
                justify-content: center;
                margin-top: 20px;
            }

            .pagination {
                display: flex;
                justify-content: center;
                margin-top: 20px;
            }
            .pagination a {
                display: inline-block;
                padding: 8px 16px;
                text-decoration: none;
                background-color: #007bff;
                border-radius: 5px;
                margin: 0 5px;
                font-weight: bold;
            }

            .pagination a.current {
                background-color: lightcyan;
                color: black;
            }

            .pagination a:hover {
                background-color: #0069d9;
            }
             .btnbtn, .btn {
                background: white;
                border: 2px solid #00a8ff;
                padding: 10px;
                color: white;
                font-size: 15px;
                font-family: 'Poppins', sans-serif;
                transition: 0.3s all ease;     
                text-decoration: none; 
            }
            .btnbtn:hover, .btn:hover{
                opacity: .7;
            }
            .btnbtn{
                width: 85%;
            }

            .success {
                background: #4cd137;
                color: white;
                text-align:center;
                font-size: 15px;
                padding: 10px;
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

                .search {
                    margin-left: 25%;
                    align-items: center;
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
                }
                table td:before {

                  content: attr(data-label);
                  float: left;
                  font-weight: bold;
                  text-transform: uppercase;
                }
                
                .btnbtn{
                    width: 35%;
                    padding: 8px;
                    font-size: 10px;
                }
            }
        </style>
    </head>
    <body class="sub_page">
        <?php
        include '../FEHeader.php';
        include'../connection.php';
        date_default_timezone_set("Asia/Kuala_Lumpur");
        
        
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
        
        $todays = date("Y-m-d");
        $updateStatus = "SELECT * FROM payment WHERE (billType = 'Reservation Fee (BBQ)' OR billType = 'Reservation Fee (Hall)') AND paymentStatus = 'Pending' AND dueDate < '$todays'";
            $statusResult = mysqli_query($conn, $updateStatus);
            if(mysqli_num_rows($statusResult) > 0){
                while ($statusData = mysqli_fetch_assoc($statusResult)){
                    $pID = $statusData['paymentID'];
                    $updateQuery = "UPDATE payment SET
                                    paymentStatus = 'Canceled'
                                    WHERE paymentID = '$pID'";
                    mysqli_query($conn, $updateQuery);
                }
            }
            
        $updatePaymentStatus = "SELECT * FROM payment WHERE (billType = 'Monthly Maintenance Fees' OR billType = 'Damage Repair Fees') AND paymentStatus = 'Pending' AND dueDate < '$todays'";
            $statusPaymentResult = mysqli_query($conn, $updatePaymentStatus);
            if(mysqli_num_rows($statusPaymentResult) > 0){
                while ($statusData = mysqli_fetch_assoc($statusPaymentResult)){
                    $pID = $statusData['paymentID'];
                    $updateQuery = "UPDATE payment SET
                                    paymentStatus = 'Overdue'
                                    WHERE paymentID = '$pID'";
                    mysqli_query($conn, $updateQuery);
                }
            }
        ?>
        <div class="menu-container" id="menuContainer">
            <a href="Payment.php" class="menu-item active" id="item1">Payment</a>
            <a href="PaymentHistory.php" class="menu-item" id="item2">History</a>
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

                    if (target.id === "menuToggle" || target.id === "menuIcon") {

                        menuContainer.style.left = menuContainer.style.left === "0px" ? "-150px" : "0";
                    }
                });
            });
        </script>
        
        <div class="page">
            <h1>Current Billing</h1>
            <div class="row">
                <div class="search">
                    <input type="text" class="form-control" id="live-search" autocomplete="off" placeholder="Search...">
                </div>
                <a href="Payment.php" class="refresh">
                    <i class="las la-sync reload-icon" style="font-size: 25px; margin-top: 5px;"></i>
                </a>     
            </div>
                 
                        <script type="text/javascript">
                        $(document).ready(function() {
                            $("#live-search").keyup(function() {
                                var input = $(this).val();
                                if (input != "") {
                                    $.ajax({
                                        url: "PaymentLiveSearch.php",
                                        method: "POST",
                                        data: {input: input},
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

                            <div class="row">
                                <?php if (isset($_GET['error'])) { ?>
                                    <p class="error"><?php echo $_GET['error']; ?></p>
                                <?php } ?>
                                <?php if (isset($_GET['success'])) { ?>
                                    <p class="success"><?php echo $_GET['success']; ?></p>
                                <?php } ?>
                                <br>
                                <table class="table table-hover table-bordered">
                                    <thead style="background-color: #90aef0;">
                                        <tr>
                                            <th>No</th>
                                            <th>Bill Type</th>
                                            <th>Issue Date</th>
                                            <th>Due Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = "Pending";
                                        $overStatus = "Overdue";
                                        $total_rows = $conn->query("SELECT * FROM payment  
                                                                    WHERE " . $whereText . " = $userID AND (payment.paymentStatus = '$status' OR payment.paymentStatus = '$overStatus')
                                                                    ORDER BY paymentID")->num_rows;
                                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                        $num_results_on_page = 5;
                                        if ($stmt = $conn->prepare('SELECT * FROM payment 
                                                                    WHERE ' . $whereText . ' = ? AND (payment.paymentStatus = ? OR payment.paymentStatus = ?)
                                                                    ORDER BY paymentID 
                                                                    LIMIT ?,?')) {
                                            // Calculate the page to get the results we need from our table.
                                            $calc_page = ($page - 1) * $num_results_on_page;
                                            $stmt->bind_param('issii', $userID, $status, $overStatus, $calc_page, $num_results_on_page);
                                            $stmt->execute();
                                            // Get the results...
                                            $result = $stmt->get_result();
                                            // Loop through the data and output it in the table
                                            if (mysqli_num_rows($result) > 0) {
                                                $no = ($page - 1) * $num_results_on_page + 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td data-label="No"><?php echo $no ?></td>
                                                        <td data-label="Bill Type"><?= $row["billType"] ?></td>
                                                        <td data-label="Issue Date"><?= $row["issueDate"] ?></td>
                                                        <td data-label="Due Date"><?= $row["dueDate"] ?></td>
                                                        <td data-label="Amount"><?= $row["amount"] ?></td>
                                                        <td data-label="Status"><?= $row["paymentStatus"] ?></td>
                                                        <td data-label="">
                                                            <?php
                                                            $dueDate = $row["dueDate"];
                                                            if ($dueDate < $todays) {
                                                            } else {
                                                                echo '<button class="btnbtn"><a href="Pay.php?payid=' . $row["paymentID"] . '">Pay Online</a></button>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-label="">
                                                            <?php
                                                            $dueDate = $row["dueDate"];
                                                            if ($dueDate < $todays) {                                                               
                                                            } else {
                                                                echo'<button class="btnbtn"><a href="PrintBilling.php?printid=' . $row["paymentID"] . '">Print Bills</a></button>';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $no++;
                                                    ?>
                                                    <?php }
                                                } else {
                                                    echo "<tr><td colspan='8'>No Payment Record found</td></tr>";
                                                }
                                            } ?>
                                    </tbody>
                                </table>

                                <div class="rowPagination">
                                            <?php if ($total_rows > $num_results_on_page): ?>

                                        <div class="pagination">
                                            <?php $total_pages = ceil($total_rows / $num_results_on_page); ?>
                                            <?php if ($page > 1): ?>

                                                <a href="?page=1">&laquo; First</a>
                                                <a href="?page=<?php echo $page - 1 ?>">&lsaquo; Prev</a>

                                            <?php endif; ?>
                                            <?php for ($i = max(1, $page - 5); $i <= min($page + 5, $total_pages); $i++): ?>
                                                <?php if ($i == $page): ?>
                                                    <center>
                                                        <a href="#" class="current"><?php echo $i ?></a>
                                                    </center>
                                                <?php else: ?>
                                                    <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <?php if ($page < $total_pages): ?>

                                                <a href="?page=<?php echo $page + 1 ?>">Next &rsaquo;</a>
                                                <a href="?page=<?php echo $total_pages ?>">Last &raquo;</a>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                    </div>
                                </div> 
                            </div>

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
