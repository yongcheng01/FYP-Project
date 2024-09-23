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
           form {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }     
            
            h1 {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
            } 
            
            .viewTenant {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
                max-width: 600px;
                width: 50%;
                padding: 20px;
            }

            .row {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: left;
                margin-bottom: 20px;
            }

            .label {
                font-weight: bold;
                margin-right: 30px;
                width: 120px;
                text-align: left;
                font-size: 15px;
            }

            .data {
                font-weight: normal;
                text-align: center;
                font-size: 15px;
            }
            @media only screen and (max-width: 600px) {
                .viewTenant {
                    width: 90%; /* Adjusted for smaller screens */
                }

                row {
                    flex-direction: row; /* Adjusted to display label and data in a row */
                    justify-content: space-between; /* Adjusted for spacing between label and data */
                }

                .label {
                    margin-bottom: 5px; /* Adjusted for smaller screens */
                }
            }
        </style>
    </head>
    <body class="sub_page">
        <?php
        include "../connection.php";
        include '../FEHeader.php';
        $id=$_GET['viewid'];
        $sql = "SELECT t.*, o.*, c.*, h.*
                FROM tenant t
                INNER JOIN owner o ON t.ownerID = o.ownerID
                INNER JOIN house h ON o.houseID = h.houseID
                INNER JOIN condominium c ON o.condoID = c.condoID
                WHERE t.tenantID ='$id'";

        $result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);  
        ?>
         <div class="menu-container" id="menuContainer">
            <a href="TenantRecord.php" class="menu-item" id="item1">Tenant</a>
            <a href="TenantAdd.php" class="menu-item" id="item2">Add Tenant</a>
            <span class="menu-item active" id="item3">View Tenant</span>
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
        
        <form>
            <div class="viewTenant">
                <h1>Tenant Information</h1>
                <hr>
                <br>
                <div class="row">
                    <div class="label">Name:</div>
                    <div class="data"><?php echo $row['tenantName']; ?></div>
                </div>
                <div class="row">
                    <div class="label">IC:</div>
                    <div class="data"><?php echo $row['tenantIC']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Age:</div>
                    <div class="data"><?php echo $row['tenantAge']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Phone Number:</div>
                    <div class="data"><?php echo $row['tenantPhone']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Email:</div>
                    <div class="data"><?php echo $row['tenantEmail']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Gender:</div>
                    <div class="data"><?php echo $row['tenantGender']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Rental From:</div>
                    <div class="data"><?php echo $row['startDate']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Rental Until:</div>
                    <div class="data"><?php echo $row['endDate']; ?></div>
                </div>
                <div class="row">
                    <div class="label">House:</div>
                    <div class="data"><?php echo $row['block'].'-'.$row['floor'].'-'.$row['houseNumber']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Condominium:</div>
                    <div class="data"><?php echo $row['condoName']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Status:</div>
                    <div class="data"><?php echo $row['tenantStatus']; ?></div>
                </div>
                   

            </div>
        </form>
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
