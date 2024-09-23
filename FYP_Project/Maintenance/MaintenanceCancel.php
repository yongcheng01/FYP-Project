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

            input[type="text"],
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
        include "../connection.php";
        include '../FEHeader.php';
        $msg = "";


            $id = $_GET['cancelid'];
            $mainStatus = "Canceled";
            $sql2 = "SELECT * FROM maintenance WHERE maintenanceID='$id'";
            $result2 = mysqli_query($conn, $sql2);
            $row = mysqli_fetch_assoc($result2);


                if (isset($_POST['reason'])) {
                    $reason = $_POST['reason'];
                    if (empty($reason)) {
                        $msg = "<div class='alert alert-danger'>Please Fill in Reason</div>";
                    } else {
                        $sql = "update maintenance set maintenanceStatus='$mainStatus', reason='$reason' where maintenanceID=$id";
                        mysqli_query($conn, $sql);
                        echo '<script>alert("Cancel Maintenance Successful!");</script>';
                        echo'<form id="message" action="MaintenanceSearch.php" method="post">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
                    }
                }

        ?>
        
        <div class="menu-container" id="menuContainer">
            <a href="MaintenanceSearch.php" class="menu-item" id="item1">Maintenance</a>
            <a href="MaintenanceAdd.php" class="menu-item" id="item2">Request</a>
            <a href="MaintenanceHistory.php" class="menu-item" id="item3">History</a>
            <span class="menu-item active" id="item3">Cancel Maintenance</span>
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
                <h1>Cancel Maintenance</h1>
                <br>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class="form-group">
                        <label for="maintenanceType">Maintenance Type:</label>
                        <input type="text" id="maintenanceType" name="maintenanceType" value="<?php echo $row['maintenanceType']; ?>"disabled>
                    </div>
                    <div class="form-group">
                        <label for="date">Issue Date:</label>
                        <input type="text" id="date" name="date" value="<?php echo $row['maintenanceDate']; ?>"disabled>
                    </div>
                    <div class="form-group">
                        <label for="time">Issue Time:</label>
                        <input type="text" id="time" name="time" value="<?php echo $row['maintenanceTime']; ?>"disabled>
                    </div>
                    <div class="form-group">
                        <label for="problemDescription">Problem Description:</label>
                        <textarea id="problemDescription" name="problemDescription" rows="4" disabled><?php echo $row['maintenanceMSG']; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="reason">Reason for Cancellation:</label>
                        <textarea id="reason" name="reason" rows="4"></textarea>
                    </div>
                    <button type="submit">Cancel Maintenance</button>
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
    </body>
</html>
