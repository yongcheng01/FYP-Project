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
            .editTenant {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }    
            .tenant {
                background: white;
                padding: 25px;
                min-width: 700px;
                max-width: 700px;
            }
            .tenant .title {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                font-size: 25px;
            }
            
            .tenant .form {
                margin: 10px 0;
            }
            
            .tenant .field {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .tenant .form .input-field{
                display: flex;
                width: calc(100%/2 - 15px);
                flex-direction: column;
                margin: 10px 0;
            }
            .tenant .form .input-field .input{
                font-size: 15px;
                border: 1px solid #ccc;
                padding: 10px;
                outline: none;
                height: 42px;
                margin: 8px 0;
            }
            .tenant .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
           
            .tenant .form .input-field .input:focus {
                border-color: #00a8ff;
            }
            
            .tenant .form .btn {
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
            .tenant .form .btn:hover{
                opacity: .7;
            }
            .tenant .form .ca{
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
            .tenant .form .ca:hover {
                opacity: .7;
            }
            @media only screen and (max-width: 600px) {
                .tenant .title {
                    margin: 50px 0;
                    text-align: center;
                    padding-left: 5px;
                    color: black;
                    font-size: 25px;
                }
                .tenant {
                    min-width: 100%; /* Adjusted for smaller screens */
                }
                .tenant .form .input-field {
                    display: flex;
                    width: 100%; /* Full width on smaller screens */
                    flex-direction: column;
                    margin: 10px 0;
                }
                .tenant .form .btn {
                    width: 100%;
                    margin-bottom: 10px;
                }
                .tenant .form .ca{
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
        $sql = "SELECT * FROM tenant WHERE tenantID='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        if (isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['ic']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['age'])) {

            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $ic = $_POST['ic'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $age = $_POST['age'];

            $namepattern = '/^[A-Za-z\s]+$/';
            $emailpattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
            $icpattern = '/^[0-9]{6}[0-9]{2}[0-9]{4}$/';
            $phonepattern = '/^[0-9]{10}/';

            if (empty($name)) {
                $msg = "<div class='alert alert-danger'>Please Enter Your Name</div>";
            } elseif (!preg_match($namepattern, $name)) {
                $msg = "<div class='alert alert-danger'>First Name only letters and spaces are allowed.</div>";
            } elseif (strlen($name) < 2) {
                $msg = "<div class='alert alert-danger'>Your first name must be at least 2 characters</div>";
            } else if (empty($gender)) {
                $msg = "<div class='alert alert-danger'>Please Select Gender</div>";
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
            } elseif (empty($email)) {
                $msg = "<div class='alert alert-danger'>Please Enter Email</div>";
            } else if (!preg_match($emailpattern, $email)) {
                $msg = "<div class='alert alert-danger'>Enter a valid email with @.</div>";
            }  else {
                $query = "UPDATE tenant SET tenantName='$name', tenantGender='$gender', tenantIC='$ic', tenantAge='$age', tenantPhone='$phone', tenantEmail='$email' WHERE tenantID='$id'";
                $result = mysqli_query($conn, $query);               
                $msg = "<div class='alert alert-success'>Tenant Edited Successfully</div>";
                    $sql = "SELECT * FROM tenant WHERE tenantID='$id'";
                    $result1 = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result1);
            }
        }
        ?>
        <div class="editTenant">
            <div class="tenant">
                <div class="title">Edit Tenant</div>
                <?php echo $msg; ?>
                    <form action="" method="post" class="form" autocomplete="off">

                        <div class ="field">
                            <div class="input-field">
                                <label class="input-label">Name</label>
                                <input type="text" name="name" class= "input" placeholder="Enter your first name" value="<?php echo $row['tenantName'];  ?>">
                            </div>

                            <div class="input-field">
                                <label class="input-label">Gender</label>
                                    <input type="text" name="gender" class= "input" placeholder="Enter your gender" value="<?php echo $row['tenantGender'];  ?>">
                            </div> 
                        </div>

                        <div class ="field">
                            <div class="input-field">
                                <label class="input-label">IC:</label>
                                <input type="number" name="ic" class= "input" placeholder="111111111111" value="<?php echo $row['tenantIC'];  ?>">
                            </div>

                            <div class="input-field">
                                <label class="input-label">Age</label>
                                <input type="number" name="age" class= "input" placeholder="Enter your age" value="<?php echo $row['tenantAge'];  ?>">
                            </div>
                        </div>

                        <div class ="field">
                            <div class="input-field">
                                <label class="input-label">Phone Number</label>
                                <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php echo $row['tenantPhone'];  ?>"> 
                            </div>

                            <div class="input-field">
                                <label class="input-label">Email</label>
                                <input type="text" name="email" class= "input" placeholder="Enter your email" value="<?php echo $row['tenantEmail'];  ?>"> 
                            </div>
                        </div>

                        <br>

                        <button type="submit" name="submit" class="btn">Save</button>
                        <a href="TenantSearch.php" class="ca">Back</a>
                    </form>
            </div>
        </div>
    </body>
</html>
