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
        <link rel="shortcut icon" href="images/houseIcon.png" type="image/x-icon">
        <title>Condominium </title>

        <!-- bootstrap core css -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

        <!-- fonts style -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        <!--owl slider stylesheet -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
        <!-- nice select -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
        <!-- font awesome style -->
        <link href="css/font-awesome.min.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet" />
        <!-- responsive style -->
        <link href="css/responsive.css" rel="stylesheet" />
    </head>


    <?php
    include('connection.php');

    $com = array();
    $query = "SELECT * FROM company WHERE companyStatus = 'Available'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $com[] = $row;
    }
    ?>

    <!-- info section -->
    <section class="info_section ">
        <div class="container">
            <div class="info_top">
                <div class="row">
                    <div class="col-md-3 ">
                        <a class="navbar-brand" href="FEIndex.php">
                            Condo
                        </a>
                    </div>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        foreach ($com as $coms) :
                            ?>
                            <div class="col-md-5">
                                <div class="info_contact">
                                    <a href="https://wa.me/6<?= ($coms['companyContact']) ?>">
                                        <i class="fa fa-phone" aria-hidden="true" style="margin-left: 10px"></i>
                                        <span>
                                            +6<?= ($coms['companyContact']) ?>
                                        </span>
                                    </a>
                                    <a href="mailto: <?= ($coms['companyEmail']) ?>">
                                        <i class="fa fa-envelope-o" aria-hidden="true" style="margin-left: 10px"></i> 
                                        <span>
                                            <?= ($coms['companyEmail']) ?>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach;
                    }else { ?>
                        <div class="col-md-5">
                            <div class="info_contact">
                                    <a href="#">
                                        <i class="fa fa-phone" aria-hidden="true" style="margin-left: 10px"></i>
                                        <span>
                                            Contact No
                                        </span>
                                    </a>
                                    <a href="#">
                                        <i class="fa fa-envelope-o" aria-hidden="true" style="margin-left: 10px"></i> 
                                        <span>
                                            Email 
                                        </span>
                                    </a>
                            </div>
                        </div>
                    <?php }?>
                    
                    <div class="col-md-4 ">
                        <div class="social_box">
                            <a href="">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="info_bottom">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="info_detail">
                            <h5>
                                Vision
                            </h5>
                            <p>
                                To be the leading provider of innovative and comprehensive property solutions, committed to creating vibrant, sustainable, and harmonious communities
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="info_form">
                            <h5>
                                Mission
                            </h5>
                            <p>
                                We are dedicated to delivering exceptional property services, focusing on integrity, sustainability, and client satisfaction
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="info_detail">

                            <h5>
                                Location
                            </h5>
                            <?php if (mysqli_num_rows($result) > 0) {?>
                            <a href="https://www.google.com/maps?q=<?= urlencode($coms['companyAddress']) ?>" target="_blank">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>
                                    <?= ($coms['companyAddress']) ?>
                                </span>
                            </a>
                            <?php }else { ?>
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>
                                    Location
                                </span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="">
                            <h5>
                                Useful links
                            </h5>
                            <ul class="info_menu">
                                <li>
                                    <a href="../Main/FEIndex.php">
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="../Main/FEAboutUs.php">
                                        About
                                    </a>
                                </li>
                                <li>
                                    <a href="../Main/FEService.php">
                                        Services
                                    </a>
                                </li>
                                <li>
                                    <a href="../Main/FEFutureProject.php">
                                        Project
                                    </a>
                                </li>
                                <li class="mb-0">
                                    <a href="../Main/FEContact.php">
                                        Contact Us
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end info_section -->





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

</html>