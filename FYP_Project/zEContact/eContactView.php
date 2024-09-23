
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
            <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
            <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <script src="jsEmergencyContact.js"></script>
        
        <title>Emergency Contact</title>
        <style>
            .menu-container {
              position: fixed;
              top: 110px;
              left: -150px;
              width: 150px;
              height: 10vh;
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
            }

            h1 {
                margin-top: 10%;
                text-align: center;
                margin-bottom: 20px;
            }

            .left {
                margin-right: 100px;
            }

            .right {
                flex-grow: 1; 
            }

            .row {
                display: flex;
                align-items: center;
                margin-bottom: 20px;
                margin-top: 10px;
            }

            .row label {
                font-weight: bold;
                margin-bottom: 5px;
                margin-top: 10px;
            }

            .left h2 {
                font-family: 'Times New Roman', Times, serif;
                margin-bottom: 20px;
                font-size: 30px;
            }
            
            .right h3 {
                font-family: 'Times New Roman', Times, serif;
                font-weight: normal;
                margin-bottom: 20px;
                font-size: 20px;
            }
            
            h3 a {
                text-decoration: none;
                color: #444;
            }

            h3 a:hover {
                color: #4682b4;  
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
                
                .left h2{
                    margin-left: 20px;
                }

                .right h3 {
                    margin-left: 20px;
                }

            }


        </style>
    </head>

    
    <body class="sub_page">
        <?php 
        include '../connection.php';
        include '../FEHeader.php';

        $condoID = "";
        if(isset($_SESSION['ownerEmail'])){
            $email = $_SESSION['ownerEmail'];
            $ownerSql = "SELECT * FROM owner WHERE ownerEmail='$email'";
            $ownerResult = mysqli_query($conn, $ownerSql);
            $ownerRow = mysqli_fetch_assoc($ownerResult);
            $condoID = $ownerRow['condoID'];
            
        }elseif(isset($_SESSION['tenantID'])){
            $id = $_SESSION['tenantID'];
            $tenantSql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID WHERE tenantID='$id'";
            $tenantResult = mysqli_query($conn, $tenantSql);
            $tenantRow = mysqli_fetch_assoc($tenantResult);
            $condoID = $tenantRow['condoID'];
        }
        
        
        $ec = array();
        $query = "SELECT * FROM emergencyContact INNER JOIN condominium ON emergencyContact.condoID = condominium.condoID WHERE emergencyContact.condoID = $condoID";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
          $ec[] = $row;  
        }
        ?>
        
        <div class="menu-container" id="menuContainer">
            <a href="eContactView.php" class="menu-item active" id="item1">Emergency Contact</a>
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
            <?php 
            if (mysqli_num_rows($result) > 0) { 
            foreach ($ec as $ecs) : 
            ?>

            <h1><?= ($ecs['condoName']) ?>'s Emergency Contact</h1>
            <hr>

            <div class="row">
                <div class="left">
                    <h2 style="margin-right: 90px;">Email </h2>
                </div>
                <div class="right">
                    <h3><a href="mailto: <?= ($ecs['ecEmail']) ?>"><i class="fa fa-envelope-o"> <?= ($ecs['ecEmail']) ?></i></a></h3>
                </div>
            </div>   
            <hr>

            <div class="row">
                <div class="left">
                    <h2 style="margin-right: 5px;">Management</h2>
                </div>
                <div class="right">
                    <h3><a href="https://wa.me/6<?= ($ecs['ecWhatsapp']) ?>"><i class="fa fa-whatsapp"> +6<?= ($ecs['ecWhatsapp']) ?> </i></a></h3>
                </div>
                <div class="right">
                    <h3><a href="tel:+6<?= $ecs['ecWhatsapp'] ?>"><i class="fa fa-phone"> +6<?= $ecs['ecWhatsapp'] ?> </i></a></h3>
                </div>

            </div>   
            <hr>

            <div class="row">
                <div class="left">
                    <h2>Guard House</h2>
                </div>
                <div class="right">
                    <h3><a href="https://wa.me/6<?= ($ecs['ecSecurity']) ?>"><i class="fa fa-whatsapp"> +6<?= ($ecs['ecSecurity']) ?> </i></a></h3>
                </div>
                <div class="right">
                    <h3><a href="tel:+6<?= $ecs['ecSecurity'] ?>"><i class="fa fa-phone"> +6<?= $ecs['ecSecurity'] ?> </i></a></h3>
                </div>
            </div>   
            <hr>

            <div class="row">
                <div class="left">
                    <h2 style="margin-right: 57px;">Address</h2>
                </div>
                <div class="right">
                    <h3><a href="https://www.google.com/maps?q=<?= urlencode($ecs['ecAddress']) ?>" target="_blank"><i class="fa fa-location-arrow"></i> <?= ($ecs['ecAddress']) ?></a></h3>
                </div>
            </div>   
            <hr>

            <?php endforeach; } else{ echo "<h2></h2>";} ?>
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
