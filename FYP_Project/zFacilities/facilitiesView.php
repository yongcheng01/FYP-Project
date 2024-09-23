
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
        
        <title>Facilities</title>
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

            .left h1 {
                margin-bottom: 5%;
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

            .right h2 {
                font-family: 'Times New Roman', Times, serif;
                margin-bottom: 15px;
                font-size: 25px;
            }
            
            .right h4 {
                font-family: 'Times New Roman', Times, serif;
                font-weight: normal;
                margin-bottom: 15px;
                font-size: 20px;
            }
            
            .image {
                margin-left: 10px;
                width: 300px;
                height: 200px;
                padding: 5px;
            }
            
            .image img {
                width: 100%;
                height: 100%;
            }
            
            .type {
                font-size: 30px; 
                font-weight: bold;
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
                
                .right h2 {
                   text-align: center;
                }

                .right h4 {
                   text-align: center;
                }

                .image {
                   margin-left: 65px;
                }

                .type {
                    margin-left: 10px;
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
        
        $facilities = array();

        $query = "SELECT * FROM facilities WHERE facilitiesStatus != 'Removed' AND condoID = '$condoID' ORDER BY facilitiesType";
        $result = mysqli_query($conn, $query);

        while($data = mysqli_fetch_assoc($result)){
                $facilities[] = $data;
        }

        $condoQuery = "SELECT * FROM condominium WHERE condoID = '$condoID'";
        $condoResult = mysqli_query($conn, $condoQuery);
        $condoRow = mysqli_fetch_assoc($condoResult);
        
        $facilitiesType = "";
        
        ?>
        <div class="menu-container" id="menuContainer">
            <a href="facilitiesView.php" class="menu-item active" id="item1">View Facilities</a>
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
            <h1><?= $condoRow['condoName']?>'s Facilities</h1>
            
            <?php foreach ($facilities as $fs) : 
               if ($facilitiesType != $fs['facilitiesType']) :
                   $facilitiesType = $fs['facilitiesType'];
           ?> 
           <hr>
           <p class="type"><?= $facilitiesType?></p>
           <?php endif; ?> 



           <div class="row">
               <div class="left">
                   <img class="image" src="../uploads/<?=$fs['facilitiesImage']?>">
               </div>
               <div class="right">
                   <h2><?= ($fs['facilitiesName']) ?></h2>
                   <?php if($fs['facilitiesStatus'] === "Available") :?>
                   <h4><i class="fa fa-check" style="color: green;"> <?= ($fs['facilitiesStatus']) ?></i></h4>

                   <?php elseif ($fs['facilitiesStatus'] === "Maintain") : ?>
                   <h4><i class="fa fa-wrench" style="color: orange;"> <?= ($fs['facilitiesStatus']) ?></i></h4>

                   <?php elseif ($fs['facilitiesStatus'] === "InProgress") : ?>
                   <h4><i class="fa fa-cog" style="color: red;"> <?= ($fs['facilitiesStatus']) ?></i></h4>

                   <?php endif; ?>
               </div>
           </div>   


           <?php endforeach; ?>       
            
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
