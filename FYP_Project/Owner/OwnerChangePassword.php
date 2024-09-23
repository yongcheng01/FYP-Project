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
           .reset {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            } 
            
            h1{
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
            }

            .ResetPassword {
                background: white;
                padding: 30px 30px;
                min-width: 500px;
                max-width: 550px;
            }

            .ResetPassword .form .input-field {
                width: 100%;
                display: block;
                margin-top: 30px;
                margin-bottom: 20px;
            }
            .ResetPassword .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }

            .ResetPassword .form .input-field .input {
                width: 100%;
                padding: 10px;
                outline: none;
                border: 1px solid #ccc;
                font-size: 15px;
                transition: 0.3s all ease;
            }
            .ResetPassword .form .btn {
                background: #00a8ff;
                border: 1px solid #00a8ff;
                width: 100%;
                padding: 10px;
                outline: none;
                color: white;
                font-size: 15px;
                font-family: 'Poppins', sans-serif;
                cursor: pointer;
                margin: 10px 0;
                transition: 0.3s all ease;
            }
            .ResetPassword .form .btn:hover{
                opacity: .7;
            }
            .ResetPassword .form .ca{
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
            }
            .ResetPassword .form .ca:hover{
                opacity: .7;
            } 
            @media screen and (max-width: 600px) {
                h1 {
                    font-size: 20px; /* Adjusted font size for smaller screens */
                }

                .ResetPassword {
                    min-width: 90%; /* Adjusted for smaller screens */
                    max-width: 90%; /* Adjusted for smaller screens */
                }

                .ResetPassword .form .input-field {
                    margin-top: 20px; /* Adjusted margin for smaller screens */
                    margin-bottom: 15px; /* Adjusted margin for smaller screens */
                }
                
            }
        </style>
    </head>
    <body class="sub_page">
        <?php
        include '../FEHeader.php';
        include "../connection.php";
        $msg = "";

        if (isset($_POST['changePassword'])) {
            if (isset($_POST['oldPassword']) && isset($_POST['password']) && isset($_POST['re_password'])) {

                function validate($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                $op = validate($_POST['oldPassword']);
                $newpassword = validate($_POST['password']);
                $c_np = validate($_POST['re_password']);
            }
            if (empty($op)) {
                $msg = "<div class='alert alert-danger'>Old Password is required</div>";
            } else if (empty($newpassword)) {
                $msg = "<div class='alert alert-danger'>New Password is required</div>";
            } else if (strlen($newpassword) < 8) {
                $msg = "<div class='alert alert-danger'>Your New Password Must Contain At Least 8 Characters!</div>";
            } else if (!preg_match("#[0-9]+#", $newpassword)) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Number!</div>";
            } else if (!preg_match("#[A-Z]+#", $newpassword)) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Capital Letter!</div>";
            } else if (!preg_match("#[a-z]+#", $newpassword)) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Lowercase Letter!</div>";
            } else if ($newpassword !== $c_np) {
                $msg = "<div class='alert alert-danger'>The confirmation password  does not match</div>";
            } else {
                // hashing the password
                $op = md5($op);
                $newpassword = md5($newpassword);
                $email = $_SESSION['ownerEmail'];

                $sql = "SELECT ownerPassword FROM owner WHERE ownerEmail='$email' AND ownerPassword='$op'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) === 1) {

                    $sql_2 = "UPDATE owner SET ownerPassword='$newpassword' WHERE ownerEmail='$email'";
                    $result2 = mysqli_query($conn, $sql_2);
                    if ($result2) {
                        session_unset();
                        session_destroy();
                        echo '<script>alert("Your password has been changed successfully!");</script>';
                        echo'<form id="message" action="OwnerLogin.php" method="post">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
                    } else {
                        $msg = "<div class='alert alert-danger'>Failled Change Password</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Incorrect Old password</div>";
                }
            }
        }
        ?>
        
        <div class="menu-container" id="menuContainer">
            <a href="OwnerViewUserProfile.php" class="menu-item" id="item1">View Profile</a>
            <a href="OwnerEditUserProfile.php" class="menu-item" id="item2">Update Profile</a>
            <a href="OwnerChangePassword.php" class="menu-item active" id="item3">Change Password</a>
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
        
        <div class="reset">
            <div class="ResetPassword">
                <h1>Change Password</h1>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class="input-field">
                        <label class="input-label">Old Password</label>
                        <input type="password" name="oldPassword" class= "input" placeholder="Enter your old password">  
                    </div>
                    <div class="input-field">
                        <label class="input-label">New Password</label>
                        <input type="password" name="password" class= "input" placeholder="Enter your new password">  
                    </div>
                    <div class="input-field">
                        <label class="input-label">Confirm Password</label>
                        <input type="password" name="re_password" class= "input" placeholder="Enter your new re-password">  
                    </div>
                    <button type="submit" name="changePassword" class="btn">Update</button>
                </form>
            </div>
        </div>
    </body>
</html>
