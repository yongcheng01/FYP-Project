<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
         <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }
            body {
                background-color: rgb(216, 216, 216);
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            } 
            
            .Active {
                background: white;
                padding: 30px 30px;
                min-width: 400px;
                max-width: 400px;
            }
            
            .Active .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
            }

            .Active .form .input-field {
                width: 100%;
                display: block;
                margin-top: 30px;
                margin-bottom: 20px;
            }
            .Active .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
             .Active .form .input-field .input {
                 width: 100%;
                 padding: 10px;
                 outline: none;
                 border: 1px solid #ccc;
                 font-size: 15px;
                 transition: 0.3s all ease;
            }
           
            .Active .form .btn {
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
            .Active .form .btn:hover{
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
        
        if (isset($_POST['ActiveVerifyEmail'])) {
            $_GET['error']="";
        $_SESSION['message'] = "";
        $otp = mysqli_real_escape_string($conn, $_POST['ActiveOTP']);
        $otp_query = "SELECT * FROM admin WHERE code = $otp";
        $otp_result = mysqli_query($conn, $otp_query);

        if (mysqli_num_rows($otp_result) > 0) {
            $fetch_data = mysqli_fetch_assoc($otp_result);
            $fetch_code = $fetch_data['code'];

            $update_status = "Verified";
            $update_code = 0;

            $update_query = "UPDATE admin SET accountStatus = '$update_status' , code = $update_code WHERE code = $fetch_code";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                header("Location: AdminLogin.php?success=Your account has been created successfully");
            } else {
                header("Location: AdminActive.php?error=Failed To Insering Data In Database!");
            }
        } else {
            header("Location: AdminActive.php?error=You enter invalid verification code!");
        }
    }
        ?>
        
        <div class="Active">
            <h2 class="title">Active Account</h2>

            <?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
                <?php if (isset($_POST['success'])) { ?>
               <p class="success"><?php echo $_POST['success']; ?></p>
          <?php } ?>
                

         <form action="" method="post" class="form">
               
            <div class="input-field">
                <label class="input-label">Email Verify Code:</label>
                <input type="number" name="ActiveOTP" class= "input" placeholder="123456" required>
            </div>
            <button type="submit" name="ActiveVerifyEmail" class="btn">Verify</button>
            </form>
        </div>
    </body>
</html>
