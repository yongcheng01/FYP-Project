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
            
            .btn {
                background: #00a8ff;
                border: 1px solid #00a8ff;
                width: 100%;
                padding: 10px;
                outline: none;
                color: white;
                font-size: 15px;
                font-family: 'Poppins', sans-serif;
                cursor: pointer;
                margin: 0;
                transition: 0.3s all ease;
            }
            .btn:hover{
                opacity: .7;
            }
            @media screen and (max-width: 600px) {
                form{
                    margin-top: 10%;
                }
                .viewTenant  {
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
    <body>
        <?php
        include'../BEHeader.php';
        include "../connection.php";
        
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
        <form>
            <div class="viewTenant">
                <h2 class="title">Tenant Information</h2>
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
                <br>
                <button class="btn" formaction="TenantSearch.php">Back</button>   

            </div>
        </form>
    </body>
</html>
