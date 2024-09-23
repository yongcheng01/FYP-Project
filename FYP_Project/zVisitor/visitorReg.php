
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

            .form {
                max-width: 600px;
                margin: 0 auto;
                margin-top: 12%;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #f5f5f5;
            }

            .row {
                margin-bottom: 15px;
            }

            label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }

            .input {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 3px;
            }

            .rowbtn {
                text-align: center;
                margin-top: 15px;
            }

            .btnAdd {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
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
                
                label {
                    margin-left: 35px;
                }

                .input {
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

        
        
        $ownerID = "";
        $tenantID = "";
        if(isset($_SESSION['ownerEmail'])){
            $email = $_SESSION['ownerEmail'];
            $ownerSql = "SELECT * FROM owner WHERE ownerEmail='$email'";
            $ownerResult = mysqli_query($conn, $ownerSql);
            $ownerRow = mysqli_fetch_assoc($ownerResult);
            $ownerID = $ownerRow['ownerID'];
            
        }elseif(isset($_SESSION['tenantID'])){
            $id = $_SESSION['tenantID'];
            $tenantSql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID WHERE tenantID='$id'";
            $tenantResult = mysqli_query($conn, $tenantSql);
            $tenantRow = mysqli_fetch_assoc($tenantResult);
            $tenantID = $tenantRow['tenantID'];
        }
        
        
        
        if (isset($_POST['visitorName'], $_POST['visitorContact'], $_POST['visitorIC'] , $_POST['visitDate'] , $_POST['visitTime'] , $_POST['visitorCarpark'])) {
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $vName = $_POST['visitorName'];
            $vContact = $_POST['visitorContact'];
            $vIC = $_POST['visitorIC'];
            $vCP = $_POST['visitorCarpark'];
            $vDate = $_POST['visitDate'];
            $vTime = $_POST['visitTime'];
            $vCarNo = "-";

            $time = strtotime($vTime[0]);
            
            $today = date("Y-m-d");
            $nextWeek = date("Y-m-d", strtotime("+1 week"));
            
            $currentDateTime = new DateTime();
            $currentTimestamp = $currentDateTime->getTimestamp();

            $query = "";

            if ($vDate < $today || $vDate > $nextWeek) {
                echo '<script>alert("Invalid date. Please choose a date between today and the next week.");</script>';

            }
            elseif($vDate == $today && $time < $currentTimestamp){
                echo '<script>alert("Invalid time. Please choose a time equal to or greater than the current time.");</script>';
                    
            }
            else {
                if (isset($_POST['visitorCarNo'])){
                    $vCarNo = $_POST['visitorCarNo'];
                    $query = "INSERT INTO visitor (visitorName, visitorContact, visitorIC, visitorCarpark, visitDate, visitTime, visitorCarNo, visitorStatus, ownerID, tenantID) VALUES('$vName', '$vContact', '$vIC', '$vCP', '$vDate', '$vTime[0]', '$vCarNo', 'Pending', '$ownerID', '$tenantID')";
                }else {
                    $query = "INSERT INTO visitor (visitorName, visitorContact, visitorIC, visitorCarpark, visitDate, visitTime, visitorCarNo, visitorStatus, ownerID, tenantID) VALUES('$vName', '$vContact', '$vIC', '$vCP', '$vDate', '$vTime[0]', '$vCarNo', 'Pending','$ownerID', '$tenantID')";

                }
                mysqli_query($conn, $query);

                echo '<script>alert("Register Visitor Successful");</script>';

                echo'<form id="message" action="visitorView.php" method="post">
                <input type="hidden" name="message" value="updated">
                <input type="submit" value="Submit">
                </form>
                <script>document.querySelector("#message").submit();</script>';
            }
        }
        
        ?>
        <div class="menu-container" id="menuContainer">
            <a href="visitorView.php" class="menu-item" id="item1">Visitor History</a>
            <a href="visitorReg.php" class="menu-item active" id="item2">Visitor Register</a>
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
            <h1>Visitor Registration</h1>
            <hr>
                        
            <form id="regVisitorForm" action="visitorReg.php" method="post">
                    
                    <div class="row">
                        <label>Visitor Name</label>
                        <input type="text" name="visitorName" id="visitorName" class="input">
                    </div>
                                      
                    <div class="row">
                        <label>Visitor Contact No</label>
                        <input type="text" name="visitorContact" id="visitorContact" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Visitor IC</label>
                        <input type="text" name="visitorIC" id="visitorIC" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Visit Date</label>
                        <input type="date" name="visitDate" id="visitDate" class="input">
                    </div>
                    
                    <div class="row">
                        <label>Visit Time</label>
                        <select name="visitTime[]" id="visitTime" class="input">
                            <option value="0"></option>
                            <?php for ($i = 8; $i < 25; $i++) : ?>
                                <?php $formattedTime = ($i < 10) ? '0' . $i . ':00' : $i . ':00'; ?>
                                <option value="<?php echo $formattedTime; ?>"><?php echo $formattedTime; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <label>Visitor Carpark</label>
                        <select name="visitorCarpark" id="visitorCarpark" class="input" onchange="toggleVisitorCarNo()">
                            <option value="0"></option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <label>Visitor Car Number</label>
                        <input type="text" name="visitorCarNo" id="visitorCarNo" class="input" disabled>
                    </div>

                    <script>
                        function toggleVisitorCarNo() {
                            var carparkSelect = document.getElementById("visitorCarpark");
                            var carNoInput = document.getElementById("visitorCarNo");

                            // If "Yes" is selected, enable the input; otherwise, disable it
                            carNoInput.disabled = carparkSelect.value !== "Y";
                        }
                    </script>
                    

                    <div class="rowbtn">
                        <button class="btnAdd" onclick="chkVisitorVldAdd()">Register</button>
                    </div>
                </form>
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
