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
            
            .UserProfile {
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
                margin-right: 10px;
                width: 120px;
                text-align: left;
                font-size: 15px;
            }

            .data {
                font-weight: normal;
                text-align: center;
                font-size: 15px;
            }
            
            .ca{
                font-size: 15px;
                display: inline-block;
                padding: 10px;
                background: #00a8ff;
                color: white;
                text-decoration: none;
                margin-right: 100px;
                border: 1px solid #00a8ff;
                font-family: 'Poppins', sans-serif;
                cursor: pointer;
                outline: none;
                width: 100%;
                text-align: center;
                margin-bottom: 10px;
            }
            .ca:hover{
                opacity: .7;
            }
            @media screen and (max-width: 600px) {
                form{
                    margin-top: 10%;
                }
                .UserProfile  {
                    width: 90%; /* Adjusted for smaller screens */

                }
                row {
                    flex-direction: row; /* Adjusted to display label and data in a row */
                    justify-content: space-between; /* Adjusted for spacing between label and data */
                }

                .label {
                    width: 100%; /* Adjusted to take full width in smaller screens */
                    text-align: center; /* Adjusted for center alignment in smaller screens */
                    margin-bottom: 5px; /* Adjusted for smaller screens */
                }

                .data {
                    width: 100%; /* Adjusted to take full width in smaller screens */
                    text-align: center; /* Adjusted for center alignment in smaller screens */
                }
            }
            
        </style>
    </head>
    <body class="sub_page">
        <?php
        include "../connection.php";
        include '../FEHeader.php';

        $ownerID = $_SESSION['ownerID'];
        $sql = "SELECT owner.*, house.*, condominium.*, carpark.*
                FROM owner
                INNER JOIN house ON owner.houseID = house.houseID
                INNER JOIN condominium ON owner.condoID = condominium.condoID
                LEFT JOIN carpark ON owner.ownerID = carpark.ownerID
                WHERE owner.ownerID = '$ownerID'";
        $result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);  
        
        ?>
        
        <div class="menu-container" id="menuContainer">
            <a href="OwnerViewUserProfile.php" class="menu-item active" id="item1">View Profile</a>
            <a href="OwnerEditUserProfile.php" class="menu-item" id="item2">Update Profile</a>
            <a href="OwnerChangePassword.php" class="menu-item" id="item3">Change Password</a>
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
            <div class="UserProfile">
                <h1>User Profile</h1>
                <hr>
                <div class="row">
                    <div class="label">Name:</div>
                    <div class="data"><?php echo $row['ownerFName'] . ' ' . $row['ownerLName']; ?></div>
                </div>
                <div class="row">
                    <div class="label">IC:</div>
                    <div class="data"><?php echo $row['ownerIC']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Birth Date:</div>
                    <div class="data"><?php echo $row['ownerBirth']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Phone Number:</div>
                    <div class="data"><?php echo $row['ownerPhone']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Email:</div>
                    <div class="data"><?php echo $row['ownerEmail']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Age:</div>
                    <div class="data"><?php echo $row['ownerAge']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Gender:</div>
                    <div class="data"><?php echo $row['ownerGender']; ?></div>
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
                    <div class="label">Car Park:</div>
                    <div class="data"><?php echo $row['carBlock'].'-'.$row['carFloor'].'-'.$row['number']; ?></div>
                </div>
                <div class="row">
                    <div class="label">Car Plate:</div>
                    <div class="data"><?php echo $row['carPlate']; ?></div>
                </div>
                <br>
                <a href="OwnerEditUserProfile.php" class="ca" >Update Profile</a>

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
