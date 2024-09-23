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
            h1 {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
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
                background: #00a8ff;
                padding: 10px 105px;
                color: white;
                border-radius: 5px;
                border: none;
                transition: 0.3s all ease;
                font-size:15px;
                margin-left: 30%;
            }
            .UserProfile .form .btn:hover{
                opacity: .7;
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
                    margin-left: 0%;
                }
            }
        </style>
    </head>
    <body class="sub_page">
        <?php
        include '../FEHeader.php';
        include "../connection.php";
        $msg = "";

        $email = $_SESSION['ownerEmail'];
        $sql = "SELECT * FROM owner WHERE ownerEmail='$email'";

        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);

        if (isset($_POST['submit'])) {
            if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['ic']) && isset($_POST['birth']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['gender']) && isset($_POST['age'])) {

                function validate($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                $fname = validate($_POST['fname']);
                $lname = validate($_POST['lname']);
                $ic = validate($_POST['ic']);
                $birth = validate($_POST['birth']);
                $phone = validate($_POST['phone']);
                $currentemail = validate($_POST['email']);
                $gender = validate($_POST['gender']);
                $age = validate($_POST['age']);

                $namepattern = '/^[A-Za-z\s]+$/';
                $icpattern = '/^[0-9]{6}[0-9]{2}[0-9]{4}$/';
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
                } else if (empty($gender)) {
                    $msg = "<div class='alert alert-danger'>Please Enter Gender</div>";
                } else if (!preg_match($icpattern, $ic)) {
                    $msg = "<div class='alert alert-danger'>IC must have 12 numeric.</div>";
                } else if (!preg_match($phonepattern, $phone)) {
                    $msg = "<div class='alert alert-danger'>Phone only allow enter numeric value and must have 10-11 numeric.</div>";
                } else if (!preg_match($emailpattern, $currentemail)) {
                    $msg = "<div class='alert alert-danger'>Enter a valid email with @.</div>";
                } else if (empty($birth)) {
                    $msg = "<div class='alert alert-danger'>Please Select Date of Birth</div>";
                } else if (empty($age)) {
                    $msg = "<div class='alert alert-danger'>Please Enter age</div>";
                } elseif ($age < 18) {
                    $msg = "<div class='alert alert-danger'>Age cannot be lower than 18</div>";
                } else {
                    $sql = "SELECT * FROM owner WHERE ownerEmail='$email'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) === 1) {
                        $sql_2 = "UPDATE owner SET ownerFName='$fname', ownerLName='$lname', ownerIC='$ic', ownerPhone='$phone', ownerEmail='$currentemail', ownerBirth='$birth', ownerGender='$gender', ownerAge='$age' WHERE ownerEmail='$email'";
                        mysqli_query($conn, $sql_2);
                        $msg = "<div class='alert alert-success'>Your profile has been save successfully</div>";
                        $sql = "SELECT * FROM owner WHERE ownerEmail='$currentemail'";

                        $result1 = mysqli_query($conn, $sql);

                        $row = mysqli_fetch_assoc($result1);
                    } else {
                        $msg = "<div class='alert alert-danger'>Error</div>";
                    }
                }
            }
        }
        ?>
        
        <div class="menu-container" id="menuContainer">
            <a href="OwnerViewUserProfile.php" class="menu-item" id="item1">View Profile</a>
            <a href="OwnerEditUserProfile.php" class="menu-item active" id="item2">Update Profile</a>
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
        
        <div class ="EditUserProfile">
            <div class="UserProfile">
                <h1>User Profile</h1>
                <hr>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class ="field">

                        <div class="input-field">
                            <label class="input-label">First Name</label>
                            <input type="text" name="fname" class= "input" placeholder="Enter your first name" value="<?php echo $row['ownerFName']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Last Name</label>
                            <input type="text" name="lname" class= "input" placeholder="Enter your last name" value="<?php echo $row['ownerLName']; ?>">
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">IC:</label>
                            <input type="number" name="ic" class= "input" placeholder="111111111111" value="<?php echo $row['ownerIC']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Date of Birth</label>
                            <input type="date" name="birth" class= "input" placeholder="dd/mm/yyyy" value="<?php echo $row['ownerBirth']; ?>">
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Phone Number</label>
                            <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php echo $row['ownerPhone']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Email</label>
                            <input type="text" name="email" class= "input" placeholder="Enter your email" value="<?php echo $row['ownerEmail']; ?>">
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Gender</label>
                            <input type="text" name="gender" class= "input" placeholder="Enter your gender" value="<?php echo $row['ownerGender']; ?>">     
                        </div>

                        <div class="input-field">
                            <label class="input-label">Age</label>
                            <input type="number" name="age" class= "input" placeholder="Enter your age" value="<?php echo $row['ownerAge']; ?>">
                        </div>
                    </div>

                    <br>

                    <button type="submit" name="submit" class="btn">Save</button>

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
