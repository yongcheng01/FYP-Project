<!DOCTYPE html>
<html>
    <?php
        session_start();
    ?>
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/line-awesome/dist/line-awesome/css/line-awesome.min.css">
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
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        
        <style>
            .client_section .client_container .img-box {
                min-width: 500px;
                max-width: 500px;
                min-height: 350px;
                max-height: 350px;
            }


            .images{
                width: 25px;
                border-radius: 50%;
                cursor: pointer;
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
        </style>
    </head>

    <body>
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
                <img src="../images/condo1.jpg" alt="">
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
                                        <a class="nav-link" href="FEIndex.php">Home <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="FEAboutUs.php"> About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="FEService.php">Services</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="FEFutureProject.php"> Project </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="FEContact.php">Contact Us</a>
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
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" onclick="toggleMenu()">
                                            <img src="../images/user.jpeg" alt="User Profile" class="images">
                                        </a>
                                    </li>
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
            <!-- slider section -->
            <section class="slider_section ">
                <div id="customCarousel1" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="container ">
                                <div class="row">
                                    <div class="col-lg-10 col-md-11 mx-auto">
                                        <div class="detail-box">
                                            <h1>
                                                We Provide <br>
                                                Condominium Services
                                            </h1>
                                            <p>
                                                We specialize in delivering comprehensive condominium services, offering a range of solutions tailored to meet the diverse needs of condominium communities.                     </p>
                                            <div class="btn-box">
                                                <a href="FEContact.php" class="btn1">
                                                    Contact Us
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="container ">
                                <div class="row">
                                    <div class="col-lg-10 col-md-11 mx-auto">
                                        <div class="detail-box">
                                            <h1>
                                                We Provide <br>
                                                Condominium Services
                                            </h1>
                                            <p>
                                                From property management to maintenance, we strive to enhance the living experience for residents and ensure the smooth functioning of condominium facilities. 
                                            </p>
                                            <div class="btn-box">
                                                <a href="FEContact.php" class="btn1">
                                                    Contact Us
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="container ">
                                <div class="row">
                                    <div class="col-lg-10 col-md-11 mx-auto">
                                        <div class="detail-box">
                                            <h1>
                                                We Provide <br>
                                                Condominium Services
                                            </h1>
                                            <p>
                                                With a focus on professionalism and customer satisfaction, we aim to create an environment where residents feel secure, amenities flourish, and the condominium community thrives.                    </p>
                                            <div class="btn-box">
                                                <a href="FEContact.php" class="btn1">
                                                    Contact Us
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel_btn-box">
                        <a class="carousel-control-prev" href="#customCarousel1" role="button" data-slide="prev">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#customCarousel1" role="button" data-slide="next">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </section>
            <!-- end slider section -->
        </div>


        <!-- service section -->

        <section class="service_section layout_padding">
            <div class="container">
                <div class="heading_container heading_center ">
                    <h2 class="">
                        Our Services
                    </h2>
                    <p class="col-lg-8 px-0">
                        Our services encompass a broad spectrum of offerings designed to meet the unique needs of our clients. From condominium management to specialized solutions, we provide a comprehensive range of services.        </p>
                </div>
                <div class="service_container">
                    <div class="carousel-wrap ">
                        <div class="service_owl-carousel owl-carousel">
                            <div class="item">
                                <div class="box ">
                                    <div class="img-box">
                                        <img src="../images/reservation.png" alt="" />
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            Booking Facilities
                                        </h5>
                                        <p>
                                            Booking Facilities is a service designed to streamline the process of reserving and utilizing various amenities or spaces
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="box ">
                                    <div class="img-box">
                                        <img src="../images/maintain.png" alt="" />
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            Maintenance
                                        </h5>
                                        <p>
                                            Maintenance services form the core of our commitment to ensuring the longevity and functionality of properties
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="box ">
                                    <div class="img-box">
                                        <img src="../images/payment.png" alt="" />
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            Online Payment
                                        </h5>
                                        <p>
                                            Online Payment is a convenient and secure financial solution that we offer to streamline transactions for our clients
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="box ">
                                    <div class="img-box">
                                        <img src="../images/announcement.png" alt="" />
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            Announcement
                                        </h5>
                                        <p>
                                            Announcement services serve as a vital communication channel to keep our community informed and engaged
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="box ">
                                    <div class="img-box">
                                        <img src="../images/visitor.png" alt="" />
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            Visitor Registration
                                        </h5>
                                        <p>
                                            Visitor Registration is a crucial aspect of our security and management services, designed to enhance safety and control access within our premises
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-box">
                    <a href="FEService.php">
                        Read More
                    </a>
                </div>
            </div>
        </section>

        <!-- service section ends -->

        <!-- about section -->

        <section class="about_section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5 offset-md-1">
                        <div class="detail-box pr-md-2">
                            <div class="heading_container">
                                <h2 class="">
                                    About Us
                                </h2>
                            </div>
                            <p class="detail_p_mt">
                                Welcome to CondoMS, where seamless living meets efficient management. <br>We are a dedicated team committed to enhancing the condominium living experience through innovative and reliable management solutions.
                            </p>
                            <a href="FEAboutUs.php" class="">
                                Read More
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 px-0">
                        <div class="img-box ">
                            <img src="../images/condo2.jpg" class="box_img" alt="about img">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- about section ends -->

        <!-- team section -->

        <section class="team_section layout_padding">
            <div class="container">
                <div class="heading_container heading_center">
                    <h2>
                        Coming Soon Project
                    </h2>

                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 mx-auto">
                        <div class="box">
                            <div class="img-box">
                                <img src="../images/futureProject1.jpeg" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    Azure Haven Suites
                                </h5>
                                <h6 class="">
                                    Penang
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mx-auto">
                        <div class="box">
                            <div class="img-box">
                                <img src="../images/futureProject2.jpeg" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    Harmony Heights Condos
                                </h5>
                                <h6 class="">
                                    Kuala Lumpur
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mx-auto">
                        <div class="box">
                            <div class="img-box">
                                <img src="../images/futureProject3.jpeg" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    SkyVista Residences
                                </h5>
                                <h6 class="">
                                    Johor
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end team section -->

        <!-- contact section -->
        <section class="contact_section ">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-6 px-0">
                        <div class="img-box ">
                            <img src="../images/condo3.png" class="box_img" alt="about img">
                        </div>
                    </div>
                    <div class="col-md-5 mx-auto">
                        <div class="form_container">
                            <div class="heading_container heading_center">
                                <h2>Get In Touch</h2>
                            </div>
                            <form action="">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <input type="text" class="form-control" placeholder="Your Name" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <input type="text" class="form-control" placeholder="Phone Number" />
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <select name="" id="" class="form-control wide">
                                            <option value="">Select Service</option>
                                            <option value="">Service 1</option>
                                            <option value="">Service 2</option>
                                            <option value="">Service 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <input type="email" class="form-control" placeholder="Email" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <input type="text" class="message-box form-control" placeholder="Message" />
                                    </div>
                                </div>
                                <div class="btn_box">
                                    <button>
                                        SEND
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end contact section -->

        <!-- client section -->

        
        <section class="client_section layout_padding">
            <div class="container ">
                <div class="heading_container heading_center">
                    <h2>
                        Facilities
                    </h2>
                    <hr>
                </div>
                <div id="carouselExample2Controls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-lg-7 col-md-9 mx-auto">
                                    <div class="client_container ">
                                        <div class="img-box">
                                            <img src="../images/gym.jpg" alt="">
                                        </div>
                                        <div class="detail-box">
                                            <h5>
                                                Gym Room
                                            </h5>

                                            <span>
                                                <i class="fa fa-quote-left" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-lg-7 col-md-9 mx-auto">
                                    <div class="client_container ">
                                        <div class="img-box">
                                            <img src="../images/badminton.jpg" alt="">
                                        </div>
                                        <div class="detail-box">
                                            <h5>
                                                Badminton Court
                                            </h5>
                                            <span>
                                                <i class="fa fa-quote-left" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-lg-7 col-md-9 mx-auto">
                                    <div class="client_container ">
                                        <div class="img-box">
                                            <img src="../images/swimming.jpg" alt="">
                                        </div>
                                        <div class="detail-box">
                                            <h5>
                                                Swimming Pool
                                            </h5>
                                            <span>
                                                <i class="fa fa-quote-left" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel_btn-box">
                        <a class="carousel-control-prev" href="#carouselExample2Controls" role="button" data-slide="prev">
                            <span>
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExample2Controls" role="button" data-slide="next">
                            <span>
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- end client section -->

        <?php include '../FEFooter.php'; ?>

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
        <script src="../js/jquery-3.4.1.min.js"></script>
        <!-- popper js -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>
        <!-- owl slider -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <!-- nice select -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
        <!-- custom js -->
        <script src="../js/custom.js"></script>
        <!-- Google Map -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
        <!-- End Google Map -->
    
    </body>

</html>