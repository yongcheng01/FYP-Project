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
        <title>About Us</title>

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
        <div class="hero_area">
            <div class="hero_bg_box">
                <img src="../images/hero-bg.jpg" alt="">
            </div>
            <?php include '../FEHeader.php' ?>
        </div>


        <!-- about section -->

        <section class="about_section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5 offset-md-1">
                        <div class="detail-box pr-md-2">
                            <div class="heading_container">
                                <br>
                                <h2 class="">
                                    About Us
                                </h2>
                            </div>
                            <p class="detail_p_mt">
                                Welcome to CondoMS, where seamless living meets efficient management. We are a dedicated team committed to enhancing the condominium living experience through innovative and reliable management solutions.
                                <br><br><b>Our Vision</b><br>
                                At CondoMS, we envision a harmonious and well-managed community where residents can thrive and enjoy a worry-free lifestyle. We aim to be the leading provider of comprehensive condominium management solutions that streamline processes, foster community engagement, and ensure the well-being of residents.
                                <br><br><b>Who We Are</b><br>
                                We are a team of experienced professionals passionate about transforming condominium living. With a deep understanding of the unique challenges faced by condominium associations and property managers, we have developed a cutting-edge Condominium Management System that empowers communities to thrive.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 px-0">
                        <div class="img-box ">
                            <img src="../images/condo2.jpg" class="box_img" alt="about img">
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </section>
        <!-- about section end -->

        <?php include '../FEFooter.php' ?>

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