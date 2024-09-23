<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <link rel="stylesheet" href="../style.css">
        <style>
            .adminLogin {
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

            function validate($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            $email = validate($_POST['email']);
            $emailpattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
            $pass = validate($_POST['password']);

            if (empty($email)) {
                header("Location: AdminLogin.php?error=Email is required!");
            } else if (!preg_match($emailpattern, $email)) {
                header("Location: AdminLogin.php?error=Enter a valid email with @.!");
            }else if (empty($pass)) {
                header("Location: AdminLogin.php?error=Password is required!");
            } else {
                // hashing the password
                $pass = md5($pass);
                
                $sql = "SELECT * FROM admin WHERE adminEmail='$email' AND adminPassword='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['adminEmail'] === $email && $row['adminPassword'] === $pass) {
                $_SESSION['adminID'] = $row['adminID'];
                $_SESSION['adminFName'] = $row['adminFName'];
                $_SESSION['adminLName'] = $row['adminLName'];
            	$_SESSION['adminPhone'] = $row['adminPhone'];
                $_SESSION['adminEmail'] = $row['adminEmail'];
                $_SESSION['adminGender'] = $row['adminGender'];
                $_SESSION['adminPosition'] = $row['adminPosition'];
                $_SESSION['adminAge'] = $row['adminAge'];   
                $status = $row['accountStatus'];
                $adminStatus = $row['adminStatus'];
                if ($status === 'Verified') {
                    if ($adminStatus === 'Available'){
                    $id = $_SESSION['adminID'];
                    $email = $_SESSION['adminEmail'];
                    $position = $_SESSION['adminPosition'];
                    $fname = $_SESSION['adminFName'];
                    $lname = $_SESSION['adminLName'];
                    header("Location: ../adminDashboard.php?");
                    }else {
                        header("Location: AdminLogin.php?error=You cannot login, your status is Unvailable!");
                    
                    }                  
                }else {          
                    header("Location: AdminActive.php?error=It's look like you haven't still verify your email&$email");
                }
                }else{
                    header("Location: AdminLogin.php?error=Incorect Email or password!");
                    $pass = "";
                }
		}else{
                header("Location: AdminLogin.php?error=Incorect Email or password!");
                $pass = "";
		}
	}
            }
        ?>
        <div class="adminLogin">
            <div class="login">
                <h2 class="title">Login</h2>
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo $_GET['success']; ?></p>
                <?php } ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class="input-field">
                    <label class="input-label">Email</label>
                    <input type="text" name="email" class= "input" placeholder="Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>">
                    </div>
                    <div class="input-password">
                    <label class="input-label">Password</label>
                    <input type="password" name="password" class= "input" id="myInput" placeholder="Password">  
                    </div>
                    <input type="checkbox" class="viewpassword" onclick="myFunction()"> Show Password
                    <a href="AdminForgotPassword.php" class="forget">Forgot Password?</a><br>                               
                    <button type="submit" name="submit" class="btn">Login</button>
                    <a href="../Main/FEIndex.php" class="ca" >Back</a><br><br>
                    <div class ="registerAccount">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
