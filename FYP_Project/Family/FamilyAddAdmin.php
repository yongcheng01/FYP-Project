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
            .addFamily {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }    
            .family {
                background: white;
                padding: 25px;
                min-width: 700px;
                max-width: 700px;
            }
            .family .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
            }
            
            .family .form {
                margin: 10px 0;
            }
            
            .family .field {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .family .form .input-field{
                display: flex;
                width: calc(100%/2 - 15px);
                flex-direction: column;
                margin: 10px 0;
            }
            .family .form .input-field .input{
                font-size: 15px;
                border: 1px solid #ccc;
                padding: 10px;
                outline: none;
                height: 42px;
                margin: 8px 0;
            }
            .family .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
           
            .family .form .input-field .input:focus {
                border-color: #00a8ff;
            }
            
            .family .form .btn {
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
            .family .form .btn:hover{
                opacity: .7;
            }
            .family .form .ca{
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
            .family .form .ca:hover {
                opacity: .7;
            }
            @media only screen and (max-width: 600px) {
                .family .title {
                    margin: 60px 0;
                    text-align: center;
                    padding-left: 5px;
                    color: black;
                    font-size: 25px;
                }
                .family {
                    min-width: 100%; 
                }
                .family .form .input-field {
                    display: flex;
                    width: 100%; 
                    flex-direction: column;
                    margin: 10px 0;
                }
                .family .form .btn {
                    width: 100%;
                    margin-bottom: 10px;
                }
                .family .form .ca{
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
        
        $owner = array();
        $oQuery = "SELECT * FROM owner";
        $oResult = mysqli_query($conn, $oQuery);
        while($oData = mysqli_fetch_assoc($oResult)){
                $owner[] = $oData;
        }

        if (isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['ic']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['age']) && isset($_POST['owner']) && isset($_POST['relationship'])) {

            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $ic = $_POST['ic'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $relationship = $_POST['relationship'];
            $ownerID = $_POST['owner'];

            $namepattern = '/^[A-Za-z\s]+$/';
            $icpattern = '/^[0-9]{6}[0-9]{2}[0-9]{4}$/';
            
            if (isset($_POST["owner"]) && $_POST["owner"] != "0") {
            if (empty($name)) {
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
            }  elseif (empty($relationship)) {
                $msg = "<div class='alert alert-danger'>Please Enter Relationship</div>";        
            }else {
                $status = "Available";
                $sql2 = "INSERT INTO family(ownerID, familyName, familyIC, familyAge, familyPhone, familyEmail, familyGender, familyRelationship , familyStatus) VALUES
                            ('$ownerID', '$name', '$ic', '$age', '$phone', '$email', '$gender', '$relationship', '$status')";
                             mysqli_query($conn, $sql2);
                $msg = "<div class='alert alert-success'>Family added successfully</div>";
                $name = "";
                $gender = "";
                $ic = "";
                $phone = "";
                $email = "";
                $age = "";
                $relationship = "";
            } 
            }else{
            $msg = "<div class='alert alert-danger'>Please select a valid Owner</div>";
        }
        }
        ?>
        <div class="addFamily">
            <div class="family">
                <h2 class="title">Add Family Information</h2>
                <hr>
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
                                <label class="input-label">Name</label>
                                <input type="text" name="name" class= "input" placeholder="Enter your first name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>">
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
                                <label class="input-label">Phone Number</label>
                                <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php if (isset($_POST['submit'])) { echo $phone; } ?>"> 
                            </div>

                            <div class="input-field">
                                <label class="input-label">Relationship</label>
                                <input type="text" name="relationship" class= "input" placeholder="Enter your family relationship" value="<?php if (isset($_POST['submit'])) { echo $relationship; } ?>"> 
                            </div>

                        </div>

                        <br>

                        <button type="submit" name="submit" class="btn">Add</button>
                        <a href="FamilySearch.php" class="ca">Back</a>
                    </form>
            </div>
        </div>
    </body>
</html>
