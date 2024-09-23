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
            .EditOwner {
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
                padding: 10px 75px;
                color: white;
                border-radius: 5px;
                margin-right: 10px;
                border: none;
                transition: 0.3s all ease;
                font-size: 15px;
            }
            .edit .form .btn:hover, .edit .form .ca:hover{
                opacity: .7;
            }
            .edit .form .ca{
                float: left;
                font-size: 15px;
                display: inline-block;
                background: #00a8ff;
                padding: 10px 75px;
                color: white;
                border-radius: 5px;
                border: none;
                transition: 0.3s all ease;
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
        $sql = "SELECT * FROM owner WHERE ownerID='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        if (isset($_POST['submit'])) {
            if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['ic']) && isset($_POST['birth']) && isset($_POST['phone']) && isset($_POST['gender']) && isset($_POST['age'])) {

                function validate($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                $fname = validate($_POST['fname']);
                $lname = validate($_POST['lname']);
                $ic = validate($_POST['ic']);
                $birth = validate($_POST['birth']);
                $phone = validate($_POST['phone']);
                $gender = validate($_POST['gender']);
                $age = validate($_POST['age']);

                $namepattern = '/^[A-Za-z\s]+$/';
                $icpattern = '/^[0-9]{6}[0-9]{2}[0-9]{4}$/';
                $phonepattern = '/^[0-9]{10}/';

                if (!preg_match($namepattern, $fname)) {
                    $msg = "<div class='alert alert-danger'>First Name only letters and spaces are allowed.</div>";
                } elseif (strlen($fname) < 2) {
                    $msg = "<div class='alert alert-danger'>Your first name must be atleast 2 characters</div>";
                } else if (!preg_match($namepattern, $lname)) {
                    $msg = "<div class='alert alert-danger'>Last Name only letters and spaces are allowed.</div>";
                } elseif (strlen($lname) < 2) {
                    $msg = "<div class='alert alert-danger'>Your last name must be atleast 2 characters</div>";
                } else if (empty($gender)) {
                    $msg = "<div class='alert alert-danger'>Please Enter Gender</div>";
                } else if (!preg_match($icpattern, $ic)) {
                    $msg = "<div class='alert alert-danger'>IC must have 12 numeric.</div>";
                } else if (!preg_match($phonepattern, $phone)) {
                    $msg = "<div class='alert alert-danger'>Phone only allow enter numeric value and must have 10-11 numeric.</div>";
                } else if (empty($birth)) {
                    $msg = "<div class='alert alert-danger'>Please Select Date of Birth</div>";
                } else if (empty($age)) {
                    $msg = "<div class='alert alert-danger'>Please Enter age</div>";
                } elseif ($age < 18) {
                    $msg = "<div class='alert alert-danger'>Age cannot be lower than 18</div>";
                } else {
                    $sql = "SELECT * FROM owner WHERE ownerID='$id'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) === 1) {
                        $sql_2 = "UPDATE owner SET ownerFName='$fname', ownerLName='$lname', ownerIC='$ic', ownerPhone='$phone', ownerBirth='$birth', ownerGender='$gender', ownerAge='$age' WHERE ownerID='$id'";
                        mysqli_query($conn, $sql_2);
                        $msg = "<div class='alert alert-success'>OwnerID $id profile has been save successfully</div>";
                        $sql = "SELECT * FROM owner WHERE ownerID='$id'";

                        $result1 = mysqli_query($conn, $sql);

                        $row = mysqli_fetch_assoc($result1);
                    } else {
                        $msg = "<div class='alert alert-danger'>Error</div>";
                    }
                }
            }
        }
        ?>
        <div class ="EditOwner">
            <div class="edit">
                <h2 class="title">Edit Owner</h2>
                <hr>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class ="field">

                        <div class="input-field">
                            <label class="input-label">First Name</label>
                            <input type="text" name="fname" class= "input" placeholder="Enter your first name" value="<?php echo $row['ownerFName']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Last Name</label>
                            <input type="text" name="lname" class= "input" placeholder="Enter your last name" value="<?php echo $row['ownerLName']; ?>">
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">IC:</label>
                            <input type="number" name="ic" class= "input" placeholder="111111111111" value="<?php echo $row['ownerIC']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Date of Birth</label>
                            <input type="date" name="birth" class= "input" placeholder="dd/mm/yyyy" value="<?php echo $row['ownerBirth']; ?>">
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Phone Number</label>
                            <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php echo $row['ownerPhone']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Email</label>
                            <input type="text" name="email" class= "input" placeholder="Enter your email" value="<?php echo $row['ownerEmail']; ?>" disabled>
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Gender</label>
                            <input type="text" name="gender" class= "input" placeholder="Enter your gender" value="<?php echo $row['ownerGender']; ?>">     
                        </div>

                        <div class="input-field">
                            <label class="input-label">Age</label>
                            <input type="number" name="age" class= "input" placeholder="Enter your age" value="<?php echo $row['ownerAge']; ?>">
                        </div>
                    </div>

                    <br>

                    <button type="submit" name="submit" class="btn">Save</button>
                    <button type="back" class ="ca" formaction="OwnerSearch.php">Back</button>

                </form>
            </div>
        </div>
    </body>
</html>
