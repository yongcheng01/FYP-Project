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
        <title>Our Service</title>

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
    </head>

    <body class="sub_page">
        <?php include '../FEHeader.php'; ?>

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
                
            </div>
        </section>

        <!-- service section ends -->

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