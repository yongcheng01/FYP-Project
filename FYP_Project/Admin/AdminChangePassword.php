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
            .changePassword {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            } 
            
            .ResetPassword .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
            }

            .ResetPassword {
                background: white;
                padding: 30px 30px;
                min-width: 400px;
                max-width: 450px;
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
        </style>
    </head>
    <body>
        <?php
        include'../BEHeader.php';
        include "../connection.php";
        $msg = "";

        if (isset($_POST['changePassword'])) {
            if (isset($_SESSION['adminEmail']) && isset($_SESSION['adminID'])) {


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
                    $email = $_SESSION['adminEmail'];

                    $sql = "SELECT adminPassword FROM admin WHERE adminEmail='$email' AND adminPassword='$op'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) === 1) {

                        $sql_2 = "UPDATE admin SET adminPassword='$newpassword' WHERE adminEmail='$email'";
                        mysqli_query($conn, $sql_2);
                        echo '<script>alert("Your password has been changed successfully!");</script>';
                        echo'<form id="message" action="AdminLogin.php" method="post">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
                    } else {
                        $msg = "<div class='alert alert-danger'>Incorrect Old password</div>";
                    }
                }
            }
        }
        ?>
        <div class="changePassword">
            <div class="ResetPassword">
                <h2 class="title">Change Password</h2>
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
