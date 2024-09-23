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
            .admin {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }    
            .edit {
                background: white;
                padding: 25px;
                min-width: 700px;
                max-width: 700px;
            }
            .edit .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
            }
            
            .edit .form {
                margin: 10px 0;
            }
            
            .edit .field {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .edit .form .input-field{
                display: flex;
                width: calc(100%/2 - 15px);
                flex-direction: column;
                margin: 10px 0;
            }
            .edit .form .input-field .input{
                font-size: 15px;
                border: 1px solid #ccc;
                padding: 10px;
                outline: none;
                height: 42px;
                margin: 8px 0;
            }
            .edit .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
           
            .edit .form .input-field .input:focus {
                border-color: #00a8ff;
            }
            
            .edit .form .btn {
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
            .edit .form .btn:hover{
                opacity: .7;
            }
            .edit .form .ca{
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
            .edit .form .ca:hover {
                opacity: .7;
            }
             @media only screen and (max-width: 600px) {
                .edit .title {
                    margin: 50px 0;
                    text-align: center;
                    padding-left: 5px;
                    color: black;
                    font-size: 25px;
                }
                .edit {
                    min-width: 100%; 
                }
                .edit .form .input-field {
                    display: flex;
                    width: 100%; 
                    flex-direction: column;
                    margin: 10px 0;
                }
                .edit .form .btn {
                    width: 100%;
                    margin-bottom: 10px;
                }
                .edit .form .ca{
                   margin-left: -8px;
                   width: 100%;
                   text-align: center;
                }
            }
        </style> 
    </head>
    <body>
        <?php
        include'../BEHeader.php';
        include "../connection.php";
        $msg = "";

        $id = $_GET['editid'];
        $sql = "SELECT * FROM admin WHERE adminID='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['gender']) && isset($_POST['age'])) {
            
            $fname = $_POST['fname'];
            $namepattern = '/^[A-Za-z\s]+$/';
            $lname = $_POST['lname'];

            $phone = $_POST['phone'];
            $phonepattern = '/^[0-9]{10}/';

            $email = $_POST['email'];
            $emailpattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
            
            $gender = $_POST['gender'];
            $age = $_POST['age'];
            
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
            } else if (empty($gender)) {
                $msg = "<div class='alert alert-danger'>Please Select Gender</div>";
            } else if (empty($age)) {
                $msg = "<div class='alert alert-danger'>Please Enter Age</div>";
            } elseif ($age < 18) {
                $msg = "<div class='alert alert-danger'>Age cannot be lower than 18</div>";
            } elseif (empty($phone)) {
                $msg = "<div class='alert alert-danger'>Please Enter Phone Number</div>";
            } else if (!preg_match($phonepattern, $phone)) {
                $msg = "<div class='alert alert-danger'>Phone must have 10-11 numeric.</div>";
            } elseif (empty($email)) {
                $msg = "<div class='alert alert-danger'>Please Enter Email</div>";
            } else if (!preg_match($emailpattern, $email)) {
                $msg = "<div class='alert alert-danger'>Enter a valid email with @.</div>";
            } else {
               $sql = "SELECT * FROM admin WHERE adminID='$id'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) === 1) {
                        $sql_2 = "UPDATE admin SET adminFName='$fname', adminLName='$lname', adminGender='$gender', adminAge='$age', adminPhone='$phone', adminEmail='$email' WHERE adminID='$id'";
                        mysqli_query($conn, $sql_2);
                        $msg = "<div class='alert alert-success'>adminID $id profile has been save successfully</div>";
                        
                        $sql = "SELECT * FROM admin WHERE adminID='$id'";
                        $result1 = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result1);
                    } else {
                        $msg = "<div class='alert alert-danger'>Error</div>";
                    }
                }
            }  
        ?>
        <div class="admin">
            <div class="edit">
                <h2 class="title">Edit Admin Information</h2>
                <?php echo $msg; ?>
                <hr>
                <form action="" method="post" class="form" autocomplete="off">

                    <div class ="field">      
                    <div class="input-field">
                    <label class="input-label">First Name</label>
                    <input type="text" name="fname" class= "input" placeholder="Enter your first name" value="<?php echo $row['adminFName']; ?>">
                    </div>

                    <div class="input-field">
                    <label class="input-label">Last Name</label>
                    <input type="text" name="lname" class= "input" placeholder="Enter your last name" value="<?php echo $row['adminLName']; ?>">
                    </div>
                    </div>

                    <div class ="field">
                    <div class="input-field">
                    <label class="input-label">Gender</label>
                    <input type="text" name="gender" class= "input" placeholder="Enter your gender" value="<?php echo $row['adminGender']; ?>">
                    </div>

                    <div class="input-field">
                    <label class="input-label">Age</label>
                    <input type="number" name="age" class= "input" placeholder="Enter your age" value="<?php echo $row['adminAge']; ?>">
                    </div>
                    </div>

                    <div class ="field">
                    <div class="input-field">
                    <label class="input-label">Phone Number</label>
                    <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php echo $row['adminPhone']; ?>"> 
                    </div>

                    <div class="input-field">
                    <label class="input-label">Email</label>
                    <input type="text" name="email" class= "input" placeholder="Enter your email" value="<?php echo $row['adminEmail']; ?>"> 
                    </div>
                    </div>
                    <br>

                    <button type="submit" name="submit" class="btn">Save</button>
                    <a href="AdminSearch.php" class="ca">Back</a>
                </form>
            </div>
        </div>
    </body>
</html>
