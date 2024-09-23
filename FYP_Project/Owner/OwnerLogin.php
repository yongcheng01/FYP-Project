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
             .login .form .ca{
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
            .login .form .ca:hover{
                opacity: .7;
            }
        </style>
    </head>
    <body>
        <script>
            function myFunction() {
              var x = document.getElementById("myInput");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
        </script>
        <?php
        session_start();
        include "../connection.php";
        
        $msg ="";
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $emailpattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
            $pass = $_POST['password'];
            if (!empty($email)) {
                if (preg_match($emailpattern, $email)) {
                    if (!empty($pass)) {
                        $pass= md5($pass);
                        $sql = "SELECT * FROM owner WHERE ownerEmail='$email' AND ownerPassword='$pass'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $accountStatus = $row['accountStatus'];
                        $ownerStatus = $row['ownerStatus'];
                        $sql2 = "SELECT * FROM tenant WHERE tenantEmail='$email' AND tenantPassword='$pass'";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        $status = $row2['tenantStatus'];
                        if ($row['ownerEmail'] === $email && $row['ownerPassword'] === $pass) {
                            if($accountStatus !== 'Not Verified'){
                                if($accountStatus !== 'Deleted'){
                                    if($ownerStatus !== 'Pending'){
                                        if($accountStatus === 'Verified'){
                                            $_SESSION['ownerID'] = $row['ownerID'];
                                            $_SESSION['houseID'] = $row['houseID'];
                                            $_SESSION['ownerFName'] = $row['ownerFName'];
                                            $_SESSION['ownerLName'] = $row['ownerLName'];     
                                            $_SESSION['ownerEmail'] = $row['ownerEmail'];
                                            $_SESSION['condoID'] = $row['condoID'];
                                            header("Location:../Main/FEIndex.php?");
                                        }
                                    }else{
                                        header("Location: OwnerLogin.php?error=Wait for management to assign you a house number!");
                                    }
                                }else{
                                    header("Location: OwnerLogin.php?error=Your account be deleted!");
                                }
                            }else{
                                header("Location: OwnerActive.php?error=It's look like you haven't still verify your email&$email");
                            }
                        }else if($row2['tenantEmail'] === $email && $row2['tenantPassword'] === $pass) {
                            if ($status === 'Available') {
                                $_SESSION['tenantID'] = $row2['tenantID'];
                                header("Location:../Main/FEIndex.php?");
                            }else{
                                header("Location: OwnerLogin.php?error=Your account is unavailable and cannot be logged in!");
                            }
                        }else{
                             header("Location: OwnerLogin.php?error=Incorect Email or password!");
                        }
                    }else{
                        header("Location: OwnerLogin.php?error=Password is required!");
                    }
                }else{
                    header("Location: OwnerLogin.php?error=Enter a valid email with @.!");
                }
            }else{
                header("Location: OwnerLogin.php?error=Email is required!");
            }   
        }
        ?>
        
        <div class="login">
            <h2 class="title">Owner Login</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>
            <form action="" method="post" class="form" autocomplete="off">
                <div class="input-field">
                <label class="input-label">Email</label>
                <input type="text" name="email" class= "input" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">   
                </div>
                <div class="input-password">
                <label class="input-label">Password</label>
                <input type="password" name="password" class= "input" id="myInput" placeholder="Password">  
                </div>
                <input type="checkbox" class="viewpassword" onclick="myFunction()"> Show Password
                <a href="OwnerForgotPassword.php" class="forget">Forgot Password?</a><br>                               
                <button type="submit" name="submit" class="btn">Login</button>
                <a href="../Main/FEIndex.php" class="ca" >Back</a><br><br>
                <div class ="registerAccount">
                <p>Not have account? <a href="OwnerRegister.php" class ="registersAccount">Register</a></p>
                </div>
            </form>
        </div>
    </body>
</html>
