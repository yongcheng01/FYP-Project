<html>
    <?php
    session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <link rel="stylesheet" href="../style.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }
           form {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }     
            
            .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
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
                .UserProfile {
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

                .ca {
                    margin-right: 0; /* Remove margin-right in smaller screens */
                }
            }
        </style>
    </head>
    <body>
        <?php
        include'../BEHeader.php';
        include "../connection.php";

        $email = $_SESSION['adminEmail'];
        $sql = "SELECT * FROM admin WHERE adminEmail='$email'";
        
        $result = mysqli_query($conn, $sql);

			$row = mysqli_fetch_assoc($result);  
        ?>
        <form>
        <div class="UserProfile">
            <h2 class="title">User Profile</h2>
            <hr>
            <br>
            <div class="row">
                <div class="label">Name:</div>
                <div class="data"><?php echo $row['adminFName'] . ' ' . $row['adminLName']; ?></div>
            </div>
             <div class="row">
                <div class="label">Age:</div>
                <div class="data"><?php echo $row['adminAge']; ?></div>
            </div>
            <div class="row">
                <div class="label">Phone Number:</div>
                <div class="data"><?php echo $row['adminPhone']; ?></div>
            </div>
            <div class="row">
                <div class="label">Email:</div>
                <div class="data"><?php echo $row['adminEmail']; ?></div>
            </div>
            <div class="row">
                <div class="label">Position:</div>
                <div class="data"><?php echo $row['adminPosition']; ?></div>
            </div>
            <div class="row">
                <div class="label">Gender:</div>
                <div class="data"><?php echo $row['adminGender']; ?></div>
            </div>
            <br>
            <a href="AdminEditUserProfile.php" class="ca" >Update Profile</a>
            
        </div>
                    </form>

    </body>
</html>
