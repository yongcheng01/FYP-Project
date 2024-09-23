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
            .EditUserProfile {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }     
            
            .UserProfile {
                background: white;
                padding: 25px;
                min-width: 700px;
                max-width: 700px;
            }
            .UserProfile .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
            }
            
            .UserProfile .form {
                margin: 10px 0;
            }
            
            .UserProfile .field {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .UserProfile .form .input-field{
                display: flex;
                width: calc(100%/2 - 15px);
                flex-direction: column;
                margin: 10px 0;
            }
            .UserProfile .form .input-field .input{
                font-size: 15px;
                border: 1px solid #ccc;
                padding: 10px;
                outline: none;
                height: 42px;
                margin: 8px 0;
            }
            .UserProfile .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
            .UserProfile .form .input-field .input:focus {
                border-color: #00a8ff;
            }
            .UserProfile .form .btn {
                float: right;
                background: #00a8ff;
                padding: 10px 75px;
                color: white;
                border-radius: 5px;
                margin-right: 10px;
                border: none;
                transition: 0.3s all ease;
                font-size: 15px;
            }
            .UserProfile .form .btn:hover, .UserProfile .form .ca:hover{
                opacity: .7;
            }
            .UserProfile .form .ca{
                float: left;
                font-size: 15px;
                display: inline-block;
                background: #00a8ff;
                padding: 10px 75px;
                color: white;
                border-radius: 5px;
                border: none;
                transition: 0.3s all ease;
            } 
            
            @media only screen and (max-width: 600px) {
                .UserProfile .title {
                    margin: 60px 0;
                    text-align: center;
                    padding-left: 5px;
                    color: black;
                    font-size: 25px;
                }
                .UserProfile {
                    min-width: 100%; 
                }
                .UserProfile .form .input-field {
                    display: flex;
                    width: 100%; 
                    flex-direction: column;
                    margin: 10px 0;
                }
                .UserProfile .form .btn {
                    width: 100%;
                    margin-bottom: 10px;
                }
                .UserProfile .form .ca{
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

        $email = $_SESSION['adminEmail'];
        $sql = "SELECT * FROM admin WHERE adminEmail='$email'";

        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);
        
        if (isset($_POST['submit'])) {
            if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['gender']) && isset($_POST['age'])) {

                function validate($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                $fname = validate($_POST['fname']);
                $lname = validate($_POST['lname']);
                $phone = validate($_POST['phone']);
                $currentemail = validate($_POST['email']);
                $gender = validate($_POST['gender']);
                $age = validate($_POST['age']);

                $namepattern = '/^[A-Za-z\s]+$/';
                $phonepattern = '/^[0-9]{10}/';
                $emailpattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
                
                if (!preg_match($namepattern, $fname)) {
                    $msg = "<div class='alert alert-danger'>First Name only letters and spaces are allowed.</div>";
                } elseif (strlen($fname) < 2) {
                    $msg = "<div class='alert alert-danger'>Your first name must be atleast 2 characters</div>";
                } else if (!preg_match($namepattern, $lname)) {
                    $msg = "<div class='alert alert-danger'>Last Name only letters and spaces are allowed.</div>";
                } elseif (strlen($lname) < 2) {
                    $msg = "<div class='alert alert-danger'>Your last name must be atleast 2 characters</div>";
                } else if (!preg_match($phonepattern, $phone)) {
                    $msg = "<div class='alert alert-danger'>Phone only allow enter numeric value and must have 10-11 numeric.</div>";
                } else if (!preg_match($emailpattern, $currentemail)) {
                    $msg = "<div class='alert alert-danger'>Enter a valid email with @.</div>";
                } else if (empty($gender)) {
                    $msg = "<div class='alert alert-danger'>Please Enter Gender</div>";
                } else if (empty($age)) {
                    $msg = "<div class='alert alert-danger'>Please Enter age</div>";
                } elseif ($age < 18) {
                    $msg = "<div class='alert alert-danger'>Age cannot be lower than 18</div>";
                } else {
                    $sql = "SELECT * FROM admin WHERE adminEmail='$email'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) === 1) {
                        $sql_2 = "UPDATE admin SET adminFName='$fname', adminLName='$lname', adminPhone='$phone', adminEmail='$currentemail', adminGender='$gender', adminAge='$age' WHERE adminEmail='$email'";
                        mysqli_query($conn, $sql_2);
                        $msg = "<div class='alert alert-success'>Your profile has been save successfully</div>";
                        $sql = "SELECT * FROM admin WHERE adminEmail='$currentemail'";

                        $result1 = mysqli_query($conn, $sql);

                        $row = mysqli_fetch_assoc($result1);
                    } else {
                        $msg = "<div class='alert alert-danger'>Error</div>";
                    }
                }
            }
        }
        ?>
        <div class ="EditUserProfile">
            <div class="UserProfile">
                <h2 class="title">User Profile</h2>
                <hr>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class ="field">

                        <div class="input-field">
                            <label class="input-label">First Name</label>
                            <input type="text" name="fname" class= "input" placeholder="Enter your first name" value="<?php echo $row['adminFName']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Last Name</label>
                            <input type="text" name="lname" class= "input" placeholder="Enter your last name" value="<?php echo $row['adminLName']; ?>">
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Phone Number</label>
                            <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php echo $row['adminPhone']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Email</label>
                            <input type="text" name="email" class= "input" placeholder="Enter your email" value="<?php echo $row['adminEmail']; ?>">
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Gender</label>
                            <input type="text" name="gender" class= "input" placeholder="Enter your gender" value="<?php echo $row['adminGender']; ?>">     
                        </div>

                        <div class="input-field">
                            <label class="input-label">Age</label>
                            <input type="number" name="age" class= "input" placeholder="Enter your age" value="<?php echo $row['adminAge']; ?>">
                        </div>
                    </div>

                    <br>

                    <button type="submit" name="submit" class="btn">Save</button>
                    <button type="back" class ="ca" formaction="AdminViewUserProfile.php">Back</button>

                </form>
            </div>
        </div>
    </body>
</html>
