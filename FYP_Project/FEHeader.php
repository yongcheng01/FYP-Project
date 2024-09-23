<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
  <title>Condominium</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="../css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />
  <style>
      .images{
          width: 25px;
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
      .custom_nav-container .navbar-nav .nav-item.dropdown:hover .nav-link,
      .custom_nav-container .navbar-nav .nav-item.dropdown:focus .nav-link {
          color: #2c7873; /* Change text color on hover/focus */
      }

      .custom_nav-container .navbar-nav .nav-item.dropdown:hover .dropdown-menu,
      .custom_nav-container .navbar-nav .nav-item.dropdown:focus .dropdown-menu {
          background-color: #000000; /* Change background color of the dropdown */
          border-color: #2c7873; /* Change border color of the dropdown */
      }

      .custom_nav-container .navbar-nav .nav-item.dropdown .dropdown-menu {
          border-radius: 0; /* Remove border-radius for square corners */
      }

      .custom_nav-container .navbar-nav .nav-item.dropdown .dropdown-item {
          color: #ffffff; /* Set text color for dropdown items */
      }

      .custom_nav-container .navbar-nav .nav-item.dropdown .dropdown-item:hover,
      .custom_nav-container .navbar-nav .nav-item.dropdown .dropdown-item:focus {
          background-color: #2c7873; /* Change background color on hover/focus */
          color: #ffffff; /* Change text color on hover/focus */
      }

      /* Additional styles to prevent full white background on mouseout */
      .custom_nav-container .navbar-nav .nav-item.dropdown:not(:hover) .nav-link {
          color: #ffffff; /* Set default text color */
      }

      .custom_nav-container .navbar-nav .nav-item.dropdown:not(:hover) .dropdown-menu {
          display: none; /* Hide the dropdown menu by default */
      }
      

  </style>
</head>

<?php
        include "../connection.php";
        $ownerID = "";
        $tenantID = "";
        if (isset($_SESSION['ownerID'])) {
            $ownerID = $_SESSION['ownerID'];
            $sql = "SELECT * FROM owner INNER JOIN condominium ON owner.condoID = condominium.condoID WHERE ownerID='$ownerID'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            $condoID = $row['condoID'];
            $condoName = $row['condoName'];
            $query = "SELECT * FROM emergencyContact INNER JOIN condominium ON emergencyContact.condoID = condominium.condoID WHERE emergencyContact.condoID = $condoID";
            $result = mysqli_query($conn, $query);
            $ec = mysqli_fetch_assoc($result);
        
        }else if (isset($_SESSION['tenantID'])) {
            $tenantID = $_SESSION['tenantID'];
            $sql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID INNER JOIN condominium ON owner.condoID = condominium.condoID WHERE tenantID='$tenantID'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            
            $condoID = $row['condoID'];
            $condoName = $row['condoName'];
            $query = "SELECT * FROM emergencyContact INNER JOIN condominium ON emergencyContact.condoID = condominium.condoID WHERE emergencyContact.condoID = $condoID";
            $result = mysqli_query($conn, $query);
            $ec = mysqli_fetch_assoc($result);
        }
        ?>

<div class="hero_area">
    <div class="hero_bg_box">
        <img src="images/condo1.jpg" alt="">
    </div>
    <!-- header section strats -->
    <header class="header_section">
        <div class="header_bottom">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                            <a class="navbar-brand " href="../Main/FEIndex.php"><?php if($ownerID !== "" || $tenantID !== ""):?> <?=$condoName ?><?php else: ?> Condominium <?php endif;?></a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav  ">
                            <li class="nav-item active">
                                <a class="nav-link" href="../Main/FEIndex.php">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../Main/FEAboutUs.php">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../Main/FEService.php">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../Main/FEFutureProject.php"> Project </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../Main/FEContact.php">Contact Us</a>
                            </li>
                            <?php 
                            if ($ownerID === "" && $tenantID === "") {
                            ?>
                            <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Login
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </a>
                                        
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="../Admin/AdminLogin.php">Admin</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="../Owner/OwnerLogin.php">Owner</a>
                                        </div>
                            </li>
                            <?php
                            }
                            ?>
                            <?php 
                            if($ownerID !==""){
                            ?>
                            <li class="nav-item">
                                        <a class="nav-link" href="../zEContact/eContactView.php">Emergency Contact</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Functions
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="../zReservation/reservationAdd.php">Booking Facilities</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../zAnnouncement/announcementList.php">View Announcement</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../zFacilities/facilitiesView.php">View Facilities</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../Maintenance/MaintenanceAdd.php">Request Maintenance</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../Payment/Payment.php">Online Payment</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../zVisitor/visitorReg.php">Register Visitor</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../Tenant/TenantAdd.php">Register Tenant</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../Family/FamilyAdd.php">Register Family</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="toggleMenu()">
                                    <img src="../images/user.jpeg" alt="User Profile" class="images">
                                </a>
                            </li>
                        </ul>
                        <div id="subMenu" class="user-profile-menu">

                            <p>Welcome, <b><?php echo $row['ownerFName'] . ' ' . $row['ownerLName']; ?></b></p>
                            <hr>
                            <a href="../Owner/OwnerViewUserProfile.php" class="sub-menu-link">
                                <img src="../images/profile.jpeg" alt="Profile">
                                <p>User Profile</p>
                                <span>></span>
                            </a>
                            <a href="../Owner/OwnerChangePassword.php" class="sub-menu-link">
                                <img src="../images/password.png" alt="Change Password">
                                <p>Change Password</p>
                                <span>></span>
                            </a>
                            <a href="../Owner/OwnerLogOut.php" class="sub-menu-link">
                                <img src="../images/logout.jpeg" alt="Logout">
                                <p>Logout</p>
                                <span>></span>
                            </a>
                        </div>
                        <a class="nav-link" href="tel:<?= $ec['ecSecurity']?>" style="color: red; font-size: 30px;">
                            <i class="las la-phone-alt phone-icon" style="font-size: 30px;"></i>
                        </a>
                        <?php
                        }else if($tenantID !==""){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../zEContact/eContactView.php">Emergency Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Functions
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="../zReservation/reservationAdd.php">Booking Facilities</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../zAnnouncement/announcementList.php">View Announcement</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../zFacilities/facilitiesView.php">View Facilities</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../Payment/Payment.php">Online Payment</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../zVisitor/visitorReg.php">Register Visitor</a>
                            </div>
                        </li>
                        <a class="nav-link" href="#" onclick="toggleMenu()">
                            <img src="../images/user.jpeg" alt="User Profile" class="images">
                        </a>
                    </ul>
                        <div id="subMenu" class="user-profile-menu">

                            <p>Welcome, <b><?php echo $row['tenantName']; ?></b></p>
                            <hr>
                            <a href="../Tenant/TenantViewUserProfile.php" class="sub-menu-link">
                                <img src="../images/profile.jpeg" alt="Profile">
                                <p>User Profile</p>
                                <span>></span>
                            </a>
                            <a href="../Tenant/TenantChangePassword.php" class="sub-menu-link">
                                <img src="../images/password.png" alt="Change Password">
                                <p>Change Password</p>
                                <span>></span>
                            </a>
                            <a href="../Owner/OwnerLogOut.php" class="sub-menu-link">
                                <img src="../images/logout.jpeg" alt="Logout">
                                <p>Logout</p>
                                <span>></span>
                            </a>
                        </div>
                        <a class="nav-link" href="tel:<?= $ec['ecSecurity']?>" style="color: red; font-size: 30px;">
                            <i class="las la-phone-alt phone-icon" style="font-size: 30px;"></i>
                        </a>
                        <?php
                        }
                        ?>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <script>
                let subMenu = document.getElementById("subMenu");
            
                function toggleMenu(){
                subMenu.classList.toggle("open-menu");
                }
    </script>
    <!-- end header section -->
  </div>
 


  <!-- jQery -->
  <script src="../js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <!-- bootstrap js -->
  <script src="../js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
  <!-- custom js -->
  <script src="../js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
  <!-- End Google Map -->

</html>