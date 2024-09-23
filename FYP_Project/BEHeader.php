<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title></title>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        #menu-toggle {
            display: none;
        }

        .sidebar {
            position: fixed;
            height: 100%;
            width: 165px;
            left: 0;
            bottom: 0;
            top: 0;
            z-index: 100;
            background: var(--color-dark);
            transition: left 300ms;
        }

        .side-menu ul li:hover {
            background: #2b384e;
        }

        .side-header {
            box-shadow: 0px 5px 5px -5px rgb(0 0 0 /10%);
            background: var(--main-color);
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .side-header h3, side-head span {
            color: #fff;
            font-weight: 400;
        }

        .side-content {
            height: calc(100vh - 60px);
            overflow: auto;
        }
        /* width */
        .side-content::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        .side-content::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 10px;
        }

        /* Handle */
        .side-content::-webkit-scrollbar-thumb {
            background: #b0b0b0;
            border-radius: 10px;
        }

        /* Handle on hover */
        .side-content::-webkit-scrollbar-thumb:hover {
            background: #b30000;
        }


        :root {
            --main-color: #22BAA0;
            --color-dark: #34425A;
            --text-grey: #B0B0B0;
        }

        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
            list-style-type: none;
            box-sizing: border-box;
            font-family: 'Merriweather', sans-serif;
        }

        .side-menu ul {
            text-align: center;
        }

        .side-menu a {
            display: block;
            padding: 0.35rem 0rem;
        }

        .side-menu a.active {
            background: #2B384E;
        }

        .side-menu a.active span, .side-menu a.active small {
            color: #fff;
        }

        .side-menu a span {
            display: block;
            text-align: center;
            font-size: 1.2rem;
        }

        .side-menu a span, .side-menu a small {
            color: #899DC1;
        }
        #menu-toggle:checked ~ .sidebar {
            width: 60px;
        }

        #menu-toggle:checked ~ .sidebar .side-header span {
            display: none;
        }

        #menu-toggle:checked ~ .main-content {
            margin-left: 60px;
            width: calc(100% - 60px);
        }

        #menu-toggle:checked ~ .main-content header {
            left: 60px;
        }

        #menu-toggle:checked ~ .sidebar .profile,
        #menu-toggle:checked ~ .sidebar .side-menu a small {
            display: none;
        }

        #menu-toggle:checked ~ .sidebar .side-menu a span {
            font-size: 1.8rem;
        }
        .main-content {
            margin-left: 165px;
            width: calc(100% - 165px);
            transition: margin-left 300ms;
        }

        header {
            position: fixed;
            right: 0;
            top: 0;
            left: 165px;
            z-index: 100;
            height: 60px;
            box-shadow: 0px 5px 5px -5px rgb(0 0 0 /10%);
            background: #fff;
            transition: left 300ms;
        }

        .header-content, .header-menu {
            display: flex;
            align-items: center;
        }

        .header-content {
            justify-content: space-between;
            padding: 0rem 1rem;
        }

        .header-content label:first-child span {
            font-size: 1.3rem;
        }

        .header-content label {
            cursor: pointer;
        }

        .header-menu {
            justify-content: flex-end;
            padding-top: .5rem;
        }

        .header-menu label,
        .header-menu .notify-icon {
            margin-right: 2rem;
            position: relative;
        }

        .header-menu label span,
        .notify-icon span:first-child {
            font-size: 1.3rem;
        }

        .notify-icon span:last-child {
            position: absolute;
            background: var(--main-color);
            height: 16px;
            width: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            right: -5px;
            top: -5px;
            color: #fff;
            font-size: .8rem;
            font-weight: 500;
        }

        .user {
            display: flex;
            align-items: center;
        }

        .user div, .client-img {
            height: 40px;
            width: 40px;
            margin-right: 1rem;
        }

        .user span:last-child {
            display: inline-block;
            margin-left: .3rem;
            font-size: .8rem;
        }

        main {
            margin-top: 60px;
        }

        @media only screen and (max-width: 768px) {

            .sidebar {
                left: -165px;
                z-index: 90;
            }

            header {
                left: 0;
                width: 100%;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            #menu-toggle:checked ~ .sidebar {
                left: 0;
            }

            #menu-toggle:checked ~ .sidebar {
                width: 165px;
            }

            #menu-toggle:checked ~ .sidebar .side-header span {
                display: inline-block;
            }

            #menu-toggle:checked ~ .sidebar .profile,
            #menu-toggle:checked ~ .sidebar .side-menu a small {
                display: block;
            }

            #menu-toggle:checked ~ .sidebar .side-menu a span {
                font-size: 0.8rem;
            }

            #menu-toggle:checked ~ .main-content header {
                left: 0px;
            }
            .side-menu a span {
                display: block;
                text-align: center;
                font-size: 1.5rem;
            }
            .side-menu a {
                display: block;
                padding: 1rem 0rem;
            }
        }
        
        
        

    </style>
    
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
        ?>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><img src="../images/houseIcon.png" style="width: 30px; height: 30px;"></h3>

        </div>


            <div class="side-menu">
                <ul>
                    <li>
                       <a href="../adminDashboard.php">
                            <span class="fa fa-tachometer"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <?php if(isset($row) && $row['adminPosition'] != "Staff") :?>
                    <li>
                       <a href="../Admin/AdminSearch.php">
                            <span class="fa fa-user"></span>
                            <small>Admin</small>
                        </a>
                    </li>
                    <?php endif;?>
                    <li>
                       <a href="../Owner/OwnerSearch.php">
                            <span class="fa fa-user-circle-o"></span>
                            <small>Owner</small>
                        </a>
                    </li>
                    <li>
                       <a href="../Payment/PaymentSearch.php">
                            <span class="fa fa-credit-card"></span>
                            <small>Payment</small>
                        </a>
                    </li>
                    <li>
                       <a href="../Maintenance/MaintenanceSearchAdmin.php">
                            <span class="fa fa-wrench"></span>
                            <small>Maintenance</small>
                        </a>
                    </li>
                    <li>
                       <a href="../House/HouseSearch.php">
                            <span class="fa fa-home"></span>
                            <small>House</small>
                        </a>
                    </li>
                    <li>
                       <a href="../Tenant/TenantSearch.php">
                            <span class="fa fa-user-plus"></span>
                            <small>Tenant</small>
                        </a>
                    </li>
                    <li>
                       <a href="../Family/FamilySearch.php">
                            <span class="fa fa-users"></span>
                            <small>Family</small>
                        </a>
                    </li>
                    <li>
                       <a href="../CarPark/CarParkSearch.php">
                            <span class="fa fa-car"></span>
                            <small>Carpark</small>
                        </a>
                    </li>
                    <li>
                       <a href="../zEContact/eContactFunction.php">
                            <span class="fa fa-phone"></span>
                            <small>Emergency Contact</small>
                        </a>
                    </li>
                    <li>
                       <a href="../zFacilities/facilitiesFunction.php">
                            <span class="fa fa-building"></span>
                            <small>Facilities</small>
                        </a>
                    </li>
                    <li>
                       <a href="../zAnnouncement/announcementFunction.php">
                            <span class="fa fa-bell-o"></span>
                            <small>Announcement</small>
                        </a>
                    </li>
                    <li>
                       <a href="../zReservation/reservationFunction.php">
                            <span class="fa fa-calendar"></span>
                            <small>Reservation</small>
                        </a>
                    </li>
                    <li>
                       <a href="../zVisitor/visitorFunction.php">
                            <span class="fa fa-address-card"></span>
                            <small>Visitor</small>
                        </a>
                    </li>
                    <?php if(isset($row) && $row['adminPosition'] != "Staff") :?>
                    <li>
                       <a href="../zCondo/condoFunction.php">
                            <span class="fa fa-building"></span>
                            <small>Condominium</small>
                        </a>
                    </li>
                    <li>
                       <a href="../zCompany/companyFunction.php">
                            <span class="fa fa-building"></span>
                            <small>Company</small>
                        </a>
                    </li>
                    <li>
                       <a href="../zReport/reportMenu.php">
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
                                            <img src="../images/user.jpeg" alt="User Profile" class="images">
                        </a>
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        

                    </div>
                </div>
                <div id="subMenu" class="user-profile-menu">
                                    <?php if(isset($row)) :?>
                                    <p>Welcome, <b><?php echo $row['adminFName'] . ' ' . $row['adminLName']; ?></b></p>
                                    <?php endif;?>
                                    <hr>
                                    <a href="../Admin/AdminViewUserProfile.php" class="sub-menu-link">
                                        <img src="../images/profile.jpeg" alt="Profile">
                                        <p>User Profile</p>
                                        <span>></span>
                                    </a>
                                    <a href="../Admin/AdminChangePassword.php" class="sub-menu-link">
                                        <img src="../images/password.png" alt="Change Password">
                                        <p>Change Password</p>
                                        <span>></span>
                                    </a>
                                    <a href="../Admin/AdminLogOut.php" class="sub-menu-link">
                                        <img src="../images/logout.jpeg" alt="Logout">
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
 
    </body>
</html>
