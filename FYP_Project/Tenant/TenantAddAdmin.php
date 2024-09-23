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
            .addTenant {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }    
            .tenant {
                background: white;
                padding: 25px;
                min-width: 700px;
                max-width: 700px;
            }
            .tenant .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
                margin-top: 45px;
            }
            
            .tenant .form {
                margin: 10px 0;
            }
            
            .tenant .field {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .tenant .form .input-field{
                display: flex;
                width: calc(100%/2 - 15px);
                flex-direction: column;
                margin: 10px 0;
            }
            .tenant .form .input-field .input{
                font-size: 15px;
                border: 1px solid #ccc;
                padding: 10px;
                outline: none;
                height: 42px;
                margin: 8px 0;
            }
            .tenant .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
           
            .tenant .form .input-field .input:focus {
                border-color: #00a8ff;
            }
            
            .tenant .form .btn {
                float: right;
                background: #00a8ff;
                padding: 10px 65px;
                color: white;
                border-radius: 5px;
                margin-right: 10px;
                border: none;
                transition: 0.3s all ease;
                font-size:15px;
            }
            .tenant .form .btn:hover{
                opacity: .7;
            }
            .tenant .form .ca{
                float: left;
                background: #00a8ff;
                padding: 10px 75px;
                color: white;
                border-radius: 5px;
                margin-left: 10px;
                border: none;
                transition: 0.3s all ease;
                font-size:15px;
                text-decoration: none;
            }
            .tenant .form .ca:hover {
                opacity: .7;
            }   
            @media only screen and (max-width: 600px) {
                .tenant .title {
                    margin: 60px 0;
                    text-align: center;
                    padding-left: 5px;
                    color: black;
                    font-size: 25px;
                }
                .tenant {
                    min-width: 100%; 
                }
                .tenant .form .input-field {
                    display: flex;
                    width: 100%; 
                    flex-direction: column;
                    margin: 10px 0;
                }
                .tenant .form .btn {
                    width: 100%;
                    margin-bottom: 10px;
                }
                .tenant .form .ca{
                   margin-left: -8px;
                   width: 100%;
                   text-align: center;
                }
            }
        </style>
    </head>
    <body>
        <?php
        include'../BEHeader.php';
        include "../connection.php";
        $msg = "";
        $startDate = date("Y-m-d");
        
        $owner = array();
        $oQuery = "SELECT * FROM owner";
        $oResult = mysqli_query($conn, $oQuery);
        while($oData = mysqli_fetch_assoc($oResult)){
                $owner[] = $oData;
        }
        

        if (isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['ic']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['owner']) && isset($_POST['age']) && isset($_POST['password']) && isset($_POST['re_password'])) {

            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $ic = $_POST['ic'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $ownerID = $_POST['owner'];
            $pass = $_POST['password'];
            $re_pass = $_POST['re_password'];
            
            $namepattern = '/^[A-Za-z\s]+$/';
            $emailpattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
            $icpattern = '/^[0-9]{6}[0-9]{2}[0-9]{4}$/';
            $phonepattern = '/^[0-9]{10}/';
           
            if (isset($_POST["owner"]) && $_POST["owner"] != "0") {
            if (empty($email)) {
                $msg = "<div class='alert alert-danger'>Please Enter Email</div>";
            } else if (!preg_match($emailpattern, $email)) {
                $msg = "<div class='alert alert-danger'>Enter a valid email with @.</div>";
            } elseif (empty($name)) {
                $msg = "<div class='alert alert-danger'>Please Enter Your Name</div>";
            } elseif (!preg_match($namepattern, $name)) {
                $msg = "<div class='alert alert-danger'>Name only letters and spaces are allowed.</div>";
            } elseif (strlen($name) < 2) {
                $msg = "<div class='alert alert-danger'>Your name must be at least 2 characters</div>";
            } else if (empty($gender)) {
                $msg = "<div class='alert alert-danger'>Please Select Gender</div>";
            } elseif (empty($ic)) {
                $msg = "<div class='alert alert-danger'>Please Enter IC</div>";
            } else if (!preg_match($icpattern, $ic)) {
                $msg = "<div class='alert alert-danger'>IC must have 12 numeric.</div>";
            } else if (empty($age)) {
                $msg = "<div class='alert alert-danger'>Please Enter Age</div>";
            } elseif ($age < 18) {
                $msg = "<div class='alert alert-danger'>Age cannot be lower than 18</div>";
            } else if (strlen($pass) < 8) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 8 Characters!</div>";
            } else if (!preg_match("#[0-9]+#", $pass)) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Number!</div>";
            } else if (!preg_match("#[A-Z]+#", $pass)) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Capital Letter!</div>";
            } else if (!preg_match("#[a-z]+#", $pass)) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Lowercase Letter!</div>";
            } else if ($pass !== $re_pass) {
                $msg = "<div class='alert alert-danger'>The confirmation password  does not match</div>";
            } elseif (empty($phone)) {
                $msg = "<div class='alert alert-danger'>Please Enter Phone Number</div>";
            } else if (!preg_match($phonepattern, $phone)) {
                $msg = "<div class='alert alert-danger'>Phone must have 10-11 numeric.</div>";
            }  else {
                $sql1 = "SELECT * FROM owner WHERE ownerID='$ownerID'";
                $result = mysqli_query($conn, $sql1);
                $row = mysqli_fetch_assoc($result);
                $condoID = $row['condoID'];
                $houseID = $row['houseID'];
                $pass = md5($pass);
                $status = "Available";
                $sql2 = "INSERT INTO tenant(ownerID, houseID, tenantName, tenantIC, tenantAge, tenantPhone, tenantEmail, tenantGender, startDate , tenantPassword, tenantStatus, condoID) VALUES
                            ('$ownerID', '$houseID', '$name', '$ic', '$age', '$phone', '$email', '$gender', '$startDate', '$pass', '$status', $condoID)";
                           $result2 = mysqli_query($conn, $sql2);
                if ($result2) {
                    $msg = "<div class='alert alert-success'>Tenant added successfully</div>";
                    $name = "";
                    $gender = "";
                    $ic = "";
                    $phone = "";
                    $email = "";
                    $age = "";
                    $re_pass = "";
                    $pass = "";
                } else {
                    $msg = "<div class='alert alert-danger'>Tenant added Failled</div>";
                }
            } 
        }else{
            $msg = "<div class='alert alert-danger'>Please select a valid Owner</div>";
        }
        }
        ?>
        <div class="addTenant">
            <div class="tenant">
                <h2 class="title">Add Tenant</h2>
                <?php echo $msg; ?>
                    <form action="" method="post" class="form" autocomplete="off">
                        <div class ="field">
                            <div class="input-field">
                                <label class="input-label">Owner</label>
                                    <select name="owner" class= "input">
                                        <option value="0">Please Select Owner</option>
                                        <?php foreach ($owner as $owners): ?>
                                    <?php
                                    // Check if $selectedCondoID is set and equal to the current condoID in the loop
                                    $selectedOwnerID = isset($_POST['owner']) && $_POST['owner'] == $owners['ownerID'] ? 'selected' : '';
                                    ?>
                                    <option value="<?= $owners['ownerID'] ?>" <?= $selectedOwnerID ?>><?=$owners['ownerID']. ' '. $owners['ownerFName'] . ' ' . $owners['ownerLName'] ?></option>
                                <?php endforeach; ?>
                                    </select>
                            </div> 

                            <div class="input-field">
                                <label class="input-label">Email</label>
                                <input type="text" name="email" class= "input" placeholder="Enter your email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>"> 
                            </div>
                        </div>
                        <div class ="field">
                            <div class="input-field">
                                <label class="input-label">Tenant Name</label>
                                <input type="text" name="name" class= "input" placeholder="Enter your name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>">
                            </div>

                            <div class="input-field">
                                <label class="input-label">Gender</label>
                                    <select name="gender" class= "input">
                                        <option value="0">Please Select Gender</option>
                                        <option <?php if (isset($_POST['submit']) && $_POST['gender'] == 'Male') echo "selected='selected'";?>>Male</option>
                                        <option <?php if (isset($_POST['submit']) && $_POST['gender'] == 'Female') echo "selected='selected'";?>>Female</option>
                                        <option <?php if (isset($_POST['submit']) && $_POST['gender'] == 'Other') echo "selected='selected'";?>>Other</option>
                                    </select>
                            </div> 
                        </div>

                        <div class ="field">
                            <div class="input-field">
                                <label class="input-label">IC:</label>
                                <input type="number" name="ic" class= "input" placeholder="111111111111" value="<?php if (isset($_POST['submit'])) { echo $ic; } ?>">
                            </div>

                            <div class="input-field">
                                <label class="input-label">Age</label>
                                <input type="number" name="age" class= "input" placeholder="Enter your age" value="<?php if (isset($_POST['submit'])) { echo $age; } ?>">
                            </div>
                        </div>
                        
                        <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Password</label>
                            <input type="password" name="password" class= "input" placeholder="Enter your password" value="<?php if (isset($_POST['submit'])) {echo $pass;} ?>"> 
                        </div>

                        <div class="input-field">
                            <label class="input-label">Re Password</label>
                            <input type="password" name="re_password" class= "input" placeholder="Enter your re-password" value="<?php if (isset($_POST['submit'])) {echo $re_pass;} ?>"> 
                        </div>
                    </div>

                        <div class ="field">
                            <div class="input-field">
                                <label class="input-label">Phone Number</label>
                                <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php if (isset($_POST['submit'])) { echo $phone; } ?>"> 
                            </div>

                        </div>

                        <br>

                        <button type="submit" name="submit" class="btn">Add</button>
                        <a href="TenantSearch.php" class="ca">Back</a>
                    </form>
            </div>
        </div>
    </body>
</html>
