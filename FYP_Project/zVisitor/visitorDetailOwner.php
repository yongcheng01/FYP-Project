
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
            <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
            <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <script src="jsVisitor.js"></script>
        
        <title>Visitor</title>
        <style>
            .menu-container {
              position: fixed;
              top: 110px;
              left: -150px;
              width: 150px;
              height: 15vh;
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


            .row {
                margin-bottom: 15px;
            }

            .row label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }

            .row p {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 3px;
            }

            
            hr {
                margin-top: 15px;
                margin-bottom: 25px;
                border: none;
                border-top: 1px solid #ccc;
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
                
                .row label {
                    margin-left: 35px;
                }

                .row p {
                    margin-left: 35px;
                    width: 80%;
                }


            }


        </style>
    </head>

    
    <body class="sub_page">
        <?php 
        include '../connection.php';
        include '../FEHeader.php';

        if (isset($_GET['vID'])) {
            $id = $_GET['vID'];

            $query = "SELECT * FROM visitor 
                        LEFT JOIN owner ON visitor.ownerID = owner.ownerID
                        LEFT JOIN tenant ON visitor.tenantID = tenant.tenantID
                        WHERE visitorID = $id";
            $result = mysqli_query($conn, $query);
            $selectedVisitor = mysqli_fetch_assoc($result);
            
        }
        
        ?>
        <div class="menu-container" id="menuContainer">
            <a href="visitorView.php" class="menu-item active" id="item1">Visitor History</a>
            <a href="visitorReg.php" class="menu-item" id="item2">Visitor Register</a>
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
            <h1>Visitor Profile</h1>
            <hr>
                        
            <div class="row">
                <label>Visitor Name</label><p><?= $selectedVisitor['visitorName']?></p>
            </div>

            <div class="row">
                <label>Contact No</label><p><?= $selectedVisitor['visitorContact']?></p>
            </div>

            <div class="row">
                <label>IC</label><p><?= $selectedVisitor['visitorIC']?></p>
            </div>

            <div class="row">
                <label>Visit Date</label><p><?= $selectedVisitor['visitDate']?></p>
            </div>

            <div class="row">
                <label>Visit Time</label><p><?= $selectedVisitor['visitTime']?></p>
            </div>

            <div class="row">
                <label>Carpark</label><p><?php if($selectedVisitor['visitorCarpark'] == 'Y') {echo 'YES';}else{echo 'NO';}?></p>
            </div>

            <div class="row">
                <label>Car No</label><p><?= $selectedVisitor['visitorCarNo']?></p>
            </div>

            <div class="row">
                <?php if($selectedVisitor['ownerFName'] != ""):?>
                <label>User</label><p>Owner : <?php echo $selectedVisitor['ownerFName']." ".$selectedVisitor['ownerLName'] ?></p>
                <?php elseif($selectedVisitor['tenantName'] != ""):?>
                <label>User</label><p>Tenant : <?= $selectedVisitor['tenantName'] ?></p>
                <?php endif;?>
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
