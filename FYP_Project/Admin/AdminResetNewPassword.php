<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <link rel="stylesheet" href="../style.css">
        <style>
            body {
                background-color: rgb(216, 216, 216);
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
            .error {
                background: #e84118;
                color: white;
                text-align:center;
                padding: 10px;
                width: 100%;
                margin: 10px 0;
            }

            .success {
                background: #4cd137;
                color: white;
                text-align:center;
                font-size: 15px;
                padding: 10px;
                width: 100%;
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
        <?php
        session_start();
        include "../connection.php";
        

        if (isset($_POST['changePassword'])) {
            $password = md5($_POST['password']);
            $confirmPassword = md5($_POST['re_password']);

            if (strlen($_POST['password']) < 8) {
                header("Location: AdminResetNewPassword.php?error=Use 8 or more characters with a mix of letters, numbers & symbols!");
            } else {
                // if password not matched so
                if ($_POST['password'] != $_POST['re_password']) {
                    header("Location: AdminResetNewPassword.php?error=Password not matched!");
                } else {
                    $email = $_SESSION['email'];
                    $updatePassword = "UPDATE admin SET adminPassword = '$password' WHERE adminEmail = '$email'";
                    $updatePass = mysqli_query($conn, $updatePassword) or die("Query Failed");
                    session_destroy();
                     header("Location: AdminLogin.php?success=Password Reset Successful!");
                    exit();
                }
            }
        }
         
        ?>
        <div class="ResetPassword">
            <h2 class="title">Reset Password</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>
            <form action="" method="post" class="form">
            <div class="input-field">
                <label class="input-label">Enter New Password</label>
                <input type="password" name="password" class= "input" placeholder="Enter your password">  
                </div>
                <div class="input-field">
                <label class="input-label">Confirm Password</label>
                <input type="password" name="re_password" class= "input" placeholder="Enter your re-password">  
                </div>
            <button type="submit" name="changePassword" class="btn">Update</button>
            </form>
        </div>
    </body>
</html>
