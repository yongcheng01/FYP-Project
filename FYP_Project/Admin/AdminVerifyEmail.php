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
            
            .VerifyEmail {
                background: white;
                padding: 30px 30px;
                min-width: 400px;
                max-width: 450px;
            }

            .VerifyEmail .form .input-field {
                width: 100%;
                display: block;
                margin-top: 30px;
                margin-bottom: 20px;
            }
            .VerifyEmail .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
            
            .VerifyEmail .form .input-field .input {
                width: 100%;
                padding: 10px;
                outline: none;
                border: 1px solid #ccc;
                font-size: 15px;
                transition: 0.3s all ease;
            }
            .VerifyEmail .form .btn {
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
            .VerifyEmail .form .btn:hover{
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
        include "../connection.php";
        
       
        if (isset($_POST['verifyEmail'])) {     
                $_SESSION['message'] = "";
                $OTPverify = mysqli_real_escape_string($conn, $_POST['OTPverify']);
                $verifyQuery = "SELECT * FROM admin WHERE code = '$OTPverify'";
                $runVerifyQuery = mysqli_query($conn, $verifyQuery);
                if ($runVerifyQuery) {
                    if (mysqli_num_rows($runVerifyQuery) > 0) {
                        $newQuery = "UPDATE admin SET code = 0";
                        $run = mysqli_query($conn, $newQuery);
                        header("location: AdminResetNewPassword.php");
                }else {    
                        header("Location: AdminVerifyEmail.php?error=Invalid Verification Code!");
                    }
                } else {
                    header("Location: AdminVerifyEmail.php?error=Failed while checking email from database!");
                }     
            }
        ?>
        
        <div class="VerifyEmail">
            <h2 class="title">Verify Email</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>
            
         <form action="" method="post" class="form">
               
            <div class="input-field">
                <label class="input-label">Email Verify Code:</label>
                <input type="number" name="OTPverify" class= "input" placeholder="123456" required>
            </div>
            <button type="submit" name="verifyEmail" class="btn">Verify</button>
            </form>
        </div>
    </body>
</html>
