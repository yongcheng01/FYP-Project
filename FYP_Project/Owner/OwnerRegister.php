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
            .register {
                background: white;
                padding: 25px;
                min-width: 700px;
                max-width: 700px;
            }
            .register .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
            }
            
            .register .form {
                margin: 10px 0;
            }
            
            .register .field {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .register .form .input-field{
                display: flex;
                width: calc(100%/2 - 15px);
                flex-direction: column;
                margin: 10px 0;
            }
            .register .form .input-field .input{
                font-size: 15px;
                border: 1px solid #ccc;
                padding: 10px;
                outline: none;
                height: 42px;
                margin: 8px 0;
            }
            .register .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
           
            .register .form .input-field .input:focus {
                border-color: #00a8ff;
            }
            
            .register .form .btn {
                float: right;
                background: #00a8ff;
                padding: 10px 65px;
                color: white;
                border-radius: 5px;
                margin-right: 10px;
                border: none;
                transition: 0.3s all ease;
                font-size:15px;
            }
            .register .form .btn:hover{
                opacity: .7;
            }
            .register .form .ca{
                float: left;
                background: #00a8ff;
                padding: 10px 75px;
                color: white;
                border-radius: 5px;
                margin-left: 10px;
                border: none;
                transition: 0.3s all ease;
                font-size:15px;
                text-decoration: none;
            }
            .register .form .ca:hover {
                opacity: .7;
            }   
        </style>
    </head>
    <body>
        <?php
        session_start();
        include "../connection.php";
        
        $condo = array();
        $cQuery = "SELECT * FROM condominium";
        $cResult = mysqli_query($conn, $cQuery);
        while ($cData = mysqli_fetch_assoc($cResult)) {
            $condo[] = $cData;
        }
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';
        
        $msg = "";
        if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['ic']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['gender']) && isset($_POST['age']) && isset($_POST['condo']) && isset($_POST['password']) && isset($_POST['re_password'])) {

            function validate($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            $fname = validate($_POST['fname']);
            $namepattern = '/^[A-Za-z\s]+$/';
            $lname = validate($_POST['lname']);
            $phone = validate($_POST['phone']);
            $phonepattern = '/^[0-9]{10}/';
            $email = validate($_POST['email']);
            $emailpattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
            $ic = validate($_POST['ic']);
            $icpattern = '/^[0-9]{6}[0-9]{2}[0-9]{4}$/';
            $gender = validate($_POST['gender']);
            $age = validate($_POST['age']);
            $birth = validate($_POST['birth']);
            $pass = validate($_POST['password']);
            $re_pass = validate($_POST['re_password']);
            $condoSelect = validate($_POST['condo']);

            if (empty($fname)) {
                $msg = "<div class='alert alert-danger'>Please Enter First Name</div>";
            } elseif (!preg_match($namepattern, $fname)) {
                $msg = "<div class='alert alert-danger'>First Name only letters and spaces are allowed.</div>";
            } elseif (strlen($fname) < 2) {
                $msg = "<div class='alert alert-danger'>Your first name must be at least 2 characters</div>";
            } elseif (empty($lname)) {
                $msg = "<div class='alert alert-danger'>Please Enter Last Name</div>";
            } else if (!preg_match($namepattern, $lname)) {
                $msg = "<div class='alert alert-danger'>Last Name only letters and spaces are allowed.</div>";
            } elseif (strlen($lname) < 2) {
                $msg = "<div class='alert alert-danger'>Your last name must be at least 2 characters</div>";
            } elseif (empty($ic)) {
                $msg = "<div class='alert alert-danger'>Please Enter IC</div>";
            } else if (!preg_match($icpattern, $ic)) {
                $msg = "<div class='alert alert-danger'>IC must have 12 numeric.</div>";
            } else if (empty($age)) {
                $msg = "<div class='alert alert-danger'>Please Enter Age</div>";
            } elseif ($age < 18) {
                $msg = "<div class='alert alert-danger'>Age cannot be lower than 18</div>";
            } elseif (empty($phone)) {
                $msg = "<div class='alert alert-danger'>Please Enter Phone Number</div>";
            } else if (!preg_match($phonepattern, $phone)) {
                $msg = "<div class='alert alert-danger'>Phone must have 10-11 numeric.</div>";
            } else if (!preg_match($emailpattern, $email)) {
                $msg = "<div class='alert alert-danger'>Enter a valid email with @.</div>";
            } else if (empty($birth)) {
                 $msg = "<div class='alert alert-danger'>Please Select Date of Birth</div>";
            } else if (isset($_POST["gender"]) && $_POST["gender"] == "0"){
                $msg = "<div class='alert alert-danger'>Please Select Gender</div>";
            } else if (strlen($pass) < 8) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 8 Characters!</div>";
            } else if (!preg_match("#[0-9]+#", $pass)) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Number!</div>";
            } else if (!preg_match("#[A-Z]+#", $pass)) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Capital Letter!</div>";
            } else if (!preg_match("#[a-z]+#", $pass)) {
                $msg = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Lowercase Letter!</div>";
            } else if ($pass !== $re_pass) {
                $msg = "<div class='alert alert-danger'>The confirmation password  does not match</div>";
            } else if (isset($_POST["condo"]) && $_POST["condo"] == "0") {
                $msg = "<div class='alert alert-danger'>Please Select Condominium</div>";
            } else {
                $pass = md5($pass);
                $code = rand(999999, 111111);
                $accountStatus = "Not Verified";  
                $ownerStatus ="Pending";

                $sql = "SELECT * FROM owner WHERE ownerEmail='$email'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $msg = "<div class='alert alert-danger'>The email is has been register</div>";
                } else {
                    $sql2 = "INSERT INTO owner(ownerFName, ownerLName, ownerIC, ownerPassword, ownerAge, ownerPhone, ownerEmail, ownerBirth, ownerGender, code , accountStatus, ownerStatus, condoID) VALUES
                            ('$fname', '$lname', '$ic', '$pass', '$age', '$phone', '$email', '$birth', '$gender', '$code', '$accountStatus', '$ownerStatus', '$condoSelect')";
                    $result2 = mysqli_query($conn, $sql2);
                    if ($result2) {
                        $mail = new PHPMailer(true);

                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = 'ssl';
                        $mail->Username = ''; //put email
                        $mail->Password = ''; //put password

                        $mail->Port = 465;
                        $mail->setFrom(''); //put email same as above

                        $mail->addAddress($_POST["email"]);

                        $mail->isHTML(true);

                        $mail->Subject = 'Email verification';
                        $mail->Body = "Your email verification code is: $code";
                        try {
                            $mail->send();
                            header("Location: OwnerActive.php?success=We've sent a verification code to your Email&$email");
                        } catch (Exception $e) {
                            $msg = "<div class='alert alert-danger'>Failed while sending code! Error: {$mail->ErrorInfo}</div>";
                        }
                    }
                }
            }
        }
        ?>
        
        <div class="register">
            <h2 class="title">Owner Register</h2>
            <?php echo $msg; ?>
            <form action="" method="post" class="form" autocomplete="off">
                <div class ="field">

                    <div class="input-field">
                        <label class="input-label">First Name</label>
                        <input type="text" name="fname" class= "input" placeholder="Enter your first name" value="<?php if (isset($_POST['submit'])) {echo $fname;} ?>">
                    </div>

                    <div class="input-field">
                        <label class="input-label">Last Name</label>
                        <input type="text" name="lname" class= "input" placeholder="Enter your last name" value="<?php if (isset($_POST['submit'])) {echo $lname;} ?>">
                    </div>
                </div>

                <div class ="field">
                    <div class="input-field">
                        <label class="input-label">IC:</label>
                        <input type="number" name="ic" class= "input" placeholder="111111111111" value="<?php if (isset($_POST['submit'])) {echo $ic;} ?>">
                    </div>

                    <div class="input-field">
                        <label class="input-label">Age</label>
                        <input type="number" name="age" class= "input" placeholder="Enter your age" value="<?php if (isset($_POST['submit'])) {echo $age;} ?>">
                    </div>
                </div>

                <div class ="field">
                    <div class="input-field">
                        <label class="input-label">Phone Number</label>
                        <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php if (isset($_POST['submit'])) {echo $phone;} ?>"> 
                    </div>

                    <div class="input-field">
                        <label class="input-label">Email</label>
                        <input type="text" name="email" class= "input" placeholder="Enter your email" value="<?php if (isset($_POST['submit'])) {echo $email;} ?>"> 
                    </div>
                </div>

                <div class ="field">
                    <div class="input-field">
                        <label class="input-label">Date of Birth</label>
                        <input type="date" name="birth" class= "input" placeholder="dd/mm/yyyy" value="<?php if (isset($_POST['submit'])) {echo $birth;} ?>"> 
                    </div>

                    <div class="input-field">
                        <label class="input-label">Gender</label>
                        <select name="gender" class= "input">
                            <option value="0">Please Select Gender</option>
                            <option <?php if (isset($_POST['submit']) && $_POST['gender'] == 'Male') echo "selected='selected'"; ?>>Male</option>
                            <option <?php if (isset($_POST['submit']) && $_POST['gender'] == 'Female') echo "selected='selected'"; ?>>Female</option>
                            <option <?php if (isset($_POST['submit']) && $_POST['gender'] == 'Other') echo "selected='selected'"; ?>>Other</option>
                        </select>
                    </div>         
                </div>

                <div class ="field">
                    <div class="input-field">
                        <label class="input-label">Password</label>
                        <input type="password" name="password" class= "input" placeholder="Enter your password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">   
                    </div>

                    <div class="input-field">
                        <label class="input-label">Re Password</label>
                        <input type="password" name="re_password" class= "input" placeholder="Enter your re-password" value="<?php if (isset($_POST['submit'])) { echo $re_pass; } ?>">  
                    </div>
                </div>
                
                <div class ="field">
                    <div class="input-field">
                        <label class="input-label">Condominium</label>
                        <select name="condo" id="condo" class= "input">
                            <option value="0">Select Condominium</option>
                            <?php foreach($condo as $cd):?>
                            <?php
                                // Check if $selectedCondoID is set and equal to the current condoID in the loop
                                $selectedCondoID = isset($_POST['condo']) && $_POST['condo'] == $cd['condoID'] ? 'selected' : '';
                                ?>
                            <option value="<?= $cd['condoID']?>" <?= $selectedCondoID ?>><?= $cd['condoName']?></option>
                            <?php endforeach;?>
                         </select>
                    </div>
                </div>
                <br>

                <button type="submit" name="submit" class="btn">Register</button>
                <a href="OwnerLogin.php" class="ca">Back</a>
            </form>
        </div>
    </body>
</html>
