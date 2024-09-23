<html>
    <?php
    session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <style>
             .maintenance{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }
            .addMaintenance {
               background: white;
                padding: 30px 30px;
                min-width: 500px;
                max-width: 550px;            
            }

            h1 {
                text-align: center;
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }

            input[type="date"],
            select,
            textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            textarea {
                resize: vertical;
            }

            button {
                display: block;
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                background-color: #00a8ff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-family: 'Poppins', sans-serif;
            }

            button:hover {
                opacity: .7;
            }
            .menu-container {
                position: fixed;
                top: 110px;
                left: -150px;
                width: 150px;
                height: 23vh;
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
            @media screen and (max-width: 600px) {
                .addMaintenance {
                    min-width: 90%; /* Adjusted for smaller screens */
                    max-width: 90%; /* Adjusted for smaller screens */
                }
                h1 {
                    font-size: 20px; /* Adjusted font size for smaller screens */
                }

                .form-group {
                    margin-bottom: 10px; /* Adjusted margin for smaller screens */
                }
                input[type="date"],
                select,
                textarea {
                    box-sizing: border-box; /* Added to include padding and border in width calculation */
                    margin-bottom: 10px; /* Adjusted margin for smaller screens */
                }
            }
        </style>
    </head>
    <body class="sub_page">
        <?php
        date_default_timezone_set('Asia/Kuala_Lumpur');
        include '../FEHeader.php';
        include "../connection.php";
        $ownerID = $_SESSION['ownerID'];
        $msg = "";
        $maintenanceDate = date("Y-m-d");
        $timestamp = time();
        $formattedTime = date("g:iA", $timestamp);
        $maintenanceStatus = "Pending";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['maintenanceType']) && isset($_POST['problemDescription'])) {
                $maintenanceType = $_POST['maintenanceType'];
                $Description = $_POST['problemDescription'];
                if (isset($_POST['maintenanceType']) && $_POST["maintenanceType"] != "0") {

                    if (empty($Description)) {
                        $msg = "<div class='alert alert-danger'>Please Fill in Problem</div>";
                    } else {

                        $addMaintenance = "INSERT INTO maintenance(ownerID, maintenanceDate, maintenanceTime, maintenanceType, maintenanceMSG, maintenanceStatus) VALUES
                            ('$ownerID', '$maintenanceDate', '$formattedTime', '$maintenanceType', '$Description', '$maintenanceStatus')";
                        $result2 = mysqli_query($conn, $addMaintenance);
                        if ($result2) {
                            $msg = "<div class='alert alert-success'>Request Maintenance Successfully</div>";
                        } else {
                            $msg = "<div class='alert alert-danger'>Request Maintenance failed</div>";
                        }
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Please select a valid Maintenance Type</div>";
                }
            }
        }
        ?>
        <div class="menu-container" id="menuContainer">
            <a href="MaintenanceSearch.php" class="menu-item" id="item1">Maintenance</a>
            <a href="MaintenanceAdd.php" class="menu-item active" id="item2">Request</a>
            <a href="MaintenanceHistory.php" class="menu-item" id="item3">History</a>
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

                    if (target.id === "menuToggle" || target.id === "menuIcon") {

                        menuContainer.style.left = menuContainer.style.left === "0px" ? "-150px" : "0";
                    }
                });
            });
        </script>
        
        <div class ="maintenance">
            <div class="addMaintenance">
                <h1>Request Maintenance</h1>
                <hr>
                <?php echo $msg; ?>
                <form action="MaintenanceAdd.php" method="post" class="form" autocomplete="off">
                    <div class="form-group">
                        <label for="maintenanceType">Maintenance Type:</label>
                        <select id="maintenanceType" name="maintenanceType">            
                            <option value="0">Select Maintenance Type</option>
                            <option value="Water Leakage Problem"<?php echo (isset($_POST["maintenanceType"]) && $_POST["maintenanceType"] == 'Water Leakage Problem') ? 'selected' : ''; ?>>Water Leakage Problem</option>
                            <option value="Light Bulb Problem"<?php echo (isset($_POST["maintenanceType"]) && $_POST["maintenanceType"] == 'Light Bulb Problem') ? 'selected' : ''; ?>>Light Bulb Problem</option>
                            <option value="Other">Other</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="problemDescription">Problem Description:</label>
                        <textarea id="problemDescription" name="problemDescription" rows="4"></textarea>
                    </div>
                    <button type="submit">Add Maintenance</button>
                </form>
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
