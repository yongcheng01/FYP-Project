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
            
            .form .ca{
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
            .form .ca:hover{
                opacity: .7;
            }
            
            .forgotPassword .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
            }

            .forgotPassword {
                background: white;
                padding: 30px 30px;
                min-width: 400px;
                max-width: 450px;
            }
            .forgotPassword .form .input-field {
                width: 100%;
                display: block;
                margin-top: 30px;
                margin-bottom: 20px;
            }
            .forgotPassword .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }

            .forgotPassword .form .input-field .input {
                width: 100%;
                padding: 10px;
                outline: none;
                border: 1px solid #ccc;
                font-size: 15px;
                transition: 0.3s all ease;
            }
            .forgotPassword .form .btn {
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
            .forgotPassword .form .btn:hover{
                opacity: .7;
            }
        </style>
    </head>
    <body>
        <?php
        session_start();
        include "../connection.php";

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';

        /* if forgot button will clicked. */
        if (isset($_POST['forgot_password'])) {
            $email = $_POST['email'];
            $_SESSION['email'] = $email;
            $emailCheckQuery = "Select * FROM owner Where ownerEmail = '$email'";
            $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

            if ($emailCheckResult) {
                if (mysqli_num_rows($emailCheckResult) > 0) {
                    $code = rand(999999, 111111);
                    $updateQuery = "UPDATE owner SET code = $code WHERE ownerEmail = '$email'";
                    $updateResult = mysqli_query($conn, $updateQuery);
                    if ($updateResult) {
                        $mail = new PHPMailer(true);

                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = 'ssl';
                        $mail->Username = 'lowhq-wm20@student.tarc.edu.my';
                        $mail->Password = 'knhzwpcmxxdfizua';

                        $mail->Port = 465;
                        $mail->setFrom('lowhq-wm20@student.tarc.edu.my');

                        $mail->addAddress($_POST["email"]);

                        $mail->isHTML(true);

                        $mail->Subject = 'Email verification';
                        $mail->Body = "Your password reset code is: $code";
                        try {
                            $mail->send();
                            header("Location: OwnerVerifyEmail.php?success=We've sent a verification code to your Email&$email");
                        } catch (Exception $e) {
                            $msg = "<div class='alert alert-danger'>Failed while sending code! Error: {$mail->ErrorInfo}</div>";
                        }
                    } else {
                        header("Location: OwnerForgotPassword.php?error=Failed while inserting data into database!");
                    }
                } else {
                    header("Location: OwnerForgotPassword.php?error=Invalid Email Address");
                }
            } else {
                header("Location: OwnerForgotPassword.php?error=Failed while checking email from database!");
            }
        }
        ?>
        <div class="forgotPassword">
            <h2 class="title">Owner Forgot Password</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>
            <form action="" method="post" class="form">
            <div class="input-field">
                <label class="input-label">Email:</label>
                <input type="text" name="email" class= "input" placeholder="abc@gmail.com" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>"> 
            </div>
            <button type="submit" name="forgot_password" class="btn">Send</button>
            <a href="OwnerLogin.php" class="ca" >Back</a>
            </form>
        </div>
    </body>
</html>
