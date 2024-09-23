<html lang="en">
<?php session_start()?> 
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="images/houseIcon.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <title>Admin Dashboard | Keyframe Effects</title>
    <style>
        .images{
            width: 35px;
            border-radius: 50%;
            cursor: pointer;
        }
        .user-profile-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
        }

        .user-profile-menu.open-menu {
            display: block;
        }
        .sub-menu hr{
            border: 0;
            height: 1px;
            width: 100%;
            background: #ccc;
            margin: 15px 0 10px;
        }
        .sub-menu-link{
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #525252;
            margin: 10px 0;
        }
        .sub-menu-link p{
            width: 100%;
        }
        .sub-menu-link img{
            width: 35px;
            background: #e5e5e5;
            border-radius: 50%;
            padding: 8px;
            margin-right: 15px;
        }
        .sub-menu-link span{
            font-size: 15px;
            transition: transform 0.5s;
        }
        .sub-menu-link p{
            font-size: 15px;
            margin-bottom: 2px;
        }
        .sub-menu-link:hover span{
            transform: translateX(5px);
        }
        .sub-menu-link:hover p{
            font-weight: 600;
        }
        td a {
            color: black;
        }
        td a:hover {
            color: #4682b4;  
        }

        .side-menu a {
            display: block;
            padding: 0.35rem 0rem;
        }

        .side-menu a span {
            display: block;
            text-align: center;
            font-size: 1.2rem;
        }

        #menu-toggle:checked ~ .sidebar .side-menu a span {
            font-size: 1.8rem;
        }
            
            
    </style>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <?php
            include'connection.php';
            
            if (isset($_SESSION['adminID'])) {
                $adminID = $_SESSION['adminID'];
                $sql = "SELECT * FROM admin WHERE adminID='$adminID'";

                $result = mysqli_query($conn, $sql);

                $row = mysqli_fetch_assoc($result);
            }
            
            $month = date('F');
            $currentMonth = date('n');
            $queryVisitor = "SELECT * FROM visitor WHERE MONTH(visitDate) = $currentMonth";
            $resultVisitor = mysqli_query($conn, $queryVisitor);
            $countVisitor = mysqli_num_rows($resultVisitor);
            
            $queryReservation = "SELECT * FROM reservation WHERE MONTH(reservationDate) = $currentMonth";
            $resultReservation = mysqli_query($conn, $queryReservation);
            $countReservation = mysqli_num_rows($resultReservation);
            
            $queryPayment = "SELECT * FROM payment WHERE MONTH(issueDate) = $currentMonth AND paymentStatus = 'Successful'";
            $resultPayment = mysqli_query($conn, $queryPayment);
            $countPayment = 0;
            while ($data = mysqli_fetch_assoc($resultPayment)) {
                $countPayment += $data['amount'];
            }
            
            $queryMaintain = "SELECT * FROM maintenance WHERE MONTH(maintenanceDate) = $currentMonth";
            $resultMaintain = mysqli_query($conn, $queryMaintain);
            $countMaintain = mysqli_num_rows($resultMaintain);
            
        ?>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><img src="images/houseIcon.png" style="width: 30px; height: 30px;"></h3>
        </div>
        


            <div class="side-menu">
                <ul>
                    <li>
                       <a href="adminDashboard.php" class="active">
                            <span class="fa fa-tachometer"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <?php if($row['adminPosition'] != "Staff") :?>
                    <li>
                       <a href="Admin/AdminSearch.php">
                            <span class="fa fa-user"></span>
                            <small>Admin</small>
                        </a>
                    </li>
                    <?php endif;?>
                    <li>
                       <a href="Owner/OwnerSearch.php">
                            <span class="fa fa-user-circle-o"></span>
                            <small>Owner</small>
                        </a>
                    </li>
                    <li>
                       <a href="Payment/PaymentSearch.php">
                            <span class="fa fa-credit-card"></span>
                            <small>Payment</small>
                        </a>
                    </li>
                    <li>
                       <a href="Maintenance/MaintenanceSearchAdmin.php">
                            <span class="fa fa-wrench"></span>
                            <small>Maintenance</small>
                        </a>
                    </li>
                    <li>
                       <a href="House/HouseSearch.php">
                            <span class="fa fa-home"></span>
                            <small>House</small>
                        </a>
                    </li>
                    <li>
                       <a href="Tenant/TenantSearch.php">
                            <span class="fa fa-user-plus"></span>
                            <small>Tenant</small>
                        </a>
                    </li>
                    <li>
                       <a href="Family/FamilySearch.php">
                            <span class="fa fa-users"></span>
                            <small>Family</small>
                        </a>
                    </li>
                    <li>
                       <a href="CarPark/CarParkSearch.php">
                            <span class="fa fa-car"></span>
                            <small>Carpark</small>
                        </a>
                    </li>
                    <li>
                       <a href="zEContact/eContactFunction.php">
                            <span class="fa fa-phone"></span>
                            <small>Emergency Contact</small>
                        </a>
                    </li>
                    <li>
                       <a href="zFacilities/facilitiesFunction.php">
                            <span class="fa fa-building"></span>
                            <small>Facilities</small>
                        </a>
                    </li>
                    <li>
                       <a href="zAnnouncement/announcementFunction.php">
                            <span class="fa fa-bell-o"></span>
                            <small>Announcement</small>
                        </a>
                    </li>
                    <li>
                       <a href="zReservation/reservationFunction.php">
                            <span class="fa fa-calendar"></span>
                            <small>Reservation</small>
                        </a>
                    </li>
                    <li>
                       <a href="zVisitor/visitorFunction.php">
                            <span class="fa fa-address-card"></span>
                            <small>Visitor</small>
                        </a>
                    </li>
                    <?php if($row['adminPosition'] != "Staff") :?>
                    <li>
                       <a href="zCondo/condoFunction.php">
                            <span class="fa fa-building"></span>
                            <small>Condominium</small>
                        </a>
                    </li>
                    <li>
                       <a href="zCompany/companyFunction.php">
                            <span class="fa fa-building"></span>
                            <small>Company</small>
                        </a>
                    </li>
                    <li>
                       <a href="zReport/reportMenu.php">
                            <span class="fa fa-file-pdf-o"></span>
                            <small>Report</small>
                        </a>
                    </li>
                    <?php endif;?>

                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                     <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">

                    
                    <div class="user">
                        <a class="nav-link" href="#" onclick="toggleMenu()">
                                            <img src="images/user.jpeg" alt="User Profile" class="images">
                        </a>
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        

                    </div>
                </div>
                <div id="subMenu" class="user-profile-menu">
                                    
                                    <p>Welcome, <b><?php echo $row['adminFName'] . ' ' . $row['adminLName']; ?></b></p>
                                    <hr>
                                    <a href="Admin/AdminViewUserProfile.php" class="sub-menu-link">
                                        <img src="images/profile.jpeg" alt="Profile">
                                        <p>User Profile</p>
                                        <span>></span>
                                    </a>
                                    <a href="Admin/AdminChangePassword.php" class="sub-menu-link">
                                        <img src="images/password.png" alt="Change Password">
                                        <p>Change Password</p>
                                        <span>></span>
                                    </a>
                                    <a href="Admin/AdminLogOut.php" class="sub-menu-link">
                                        <img src="images/logout.jpeg" alt="Logout">
                                        <p>Logout</p>
                                        <span>></span>
                                    </a>
                                </div>
            </div>
            <script>
                let subMenu = document.getElementById("subMenu");
            
                function toggleMenu(){
                subMenu.classList.toggle("open-menu");
                }
            </script>
        </header>
        
        
        <main>
            
            <div class="page-header">
                <h1>Dashboard</h1>
             </div>
            
            <div class="page-content">
            
                <div class="analytics">

                    <div class="card">
                        <div class="card-head">
                            <h2><?= $countVisitor?></h2>
                            <span class="las la-user-friends"></span>
                        </div>
                        <div class="card-progress">
                            <small>Visitor In <?= $month?></small>
                            <div class="card-indicator">
                                <div class="indicator one" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2><?=$countReservation?></h2>
                            <span class="las la-calendar-check"></span>
                        </div>
                        <div class="card-progress">
                            <small>Reservation In <?= $month?></small>
                            <div class="card-indicator">
                                <div class="indicator two" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2>RM <?= $countPayment?></h2>
                            <span class="las la-dollar-sign"></span>
                        </div>
                        <div class="card-progress">
                            <small>Collect Payment in <?= $month?></small>
                            <div class="card-indicator">
                                <div class="indicator three" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2><?= $countMaintain?></h2>
                            <span class="las la-tools"></span>
                        </div>
                        <div class="card-progress">
                            <small>Maintenance Request in <?= $month?></small>
                            <div class="card-indicator">
                                <div class="indicator four" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="records table-responsive">

                    <div class="record-header">
                        <div class="add">
                            <span>Entries</span>
                            <select name="" id="">
                                <option value="">ID</option>
                            </select>
                        </div>

                        <div class="browse">
                           <input type="search" id="live-search" autocomplete="off" placeholder="Search" class="record-search">
                           <a href="adminDashboard.php">
                            <label class="refresh">
                                <span class="las la-sync"></span>
                            </label>
                        </a>
                        </div>
                    </div>

                    <div>
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th colspan="4">Title</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Condominium</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_rows = $conn->query("SELECT * FROM announcement INNER JOIN condominium ON announcement.condoID = condominium.condoID")->num_rows;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 5;
                                if ($stmt = $conn->prepare("SELECT * FROM announcement INNER JOIN condominium ON announcement.condoID = condominium.condoID ORDER BY announcementDate DESC LIMIT ?,?")) {
                                // Calculate the page to get the results we need from our table.
                                $calc_page = ($page - 1) * $num_results_on_page;
                                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                                $stmt->execute();
                                // Get the results...
                                $result = $stmt->get_result();
                                // Loop through the data and output it in the table
                                if (mysqli_num_rows($result) > 0) {
                                while ($announcement = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td colspan="4"><a href="zAnnouncement/announcementView.php?aID=<?= $announcement['announcementID'] ?>"><?= $announcement['announcementTitle'] ?></a></td>
                                    <td><?= $announcement['announcementType'] ?></td>
                                    <td><?= $announcement['announcementDate'] ?></td>
                                    <td><?= $announcement['condoName'] ?></td>
                                </tr>
                                <?php } } else{ echo "<tr><td colspan='8' style='text-align:center'>No Data found</td></tr>"; } } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            
            </div>
            
        </main>
        
    </div>
</body>
</html>