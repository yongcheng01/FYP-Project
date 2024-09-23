<html>
    <?php
    session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <style>
            .menu-container {
                position: fixed;
                top: 110px;
                left: -150px;
                width: 150px;
                height: 15vh;
                display: flex;
                flex-direction: column;
                background-color: white;
                transition: left 0.3s;
            }

            .menu-item {
                padding: 15px;
                color: black;
                text-align: center;
                cursor: pointer;
                transition: background-color 0.3s, color 0.3s;
            }

            .menu-item:hover,
            .menu-item.active {
                background-color: #555;
                color: #fff;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }


            a {
                text-decoration: none;
                color: inherit;
            }

            .menu-item {
                border-bottom: 1px solid #444;
            }

            .menu-item:last-child {
                border-bottom: none;
            }

            .menu-toggle {
                position: fixed;
                top: 80px;
                left: 10px;
                cursor: pointer;
                z-index: 2;
                background-color: transparent;
                border: none;
            }

            .menu-toggle .las {
                font-size: 24px;
                color: #000;
            }
            .editFamily {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }    
            .family {
                background: white;
                padding: 25px;
                min-width: 700px;
                max-width: 700px;
            }
            h1 {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
            }
            
            .family .form {
                margin: 10px 0;
            }
            
            .family .field {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .family .form .input-field{
                display: flex;
                width: calc(100%/2 - 15px);
                flex-direction: column;
                margin: 10px 0;
            }
            .family .form .input-field .input{
                font-size: 15px;
                border: 1px solid #ccc;
                padding: 10px;
                outline: none;
                height: 42px;
                margin: 8px 0;
            }
            .family .form .input-field .input-label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
           
            .family .form .input-field .input:focus {
                border-color: #00a8ff;
            }
            
            .family .form .btn {
                background: #00a8ff;
                padding: 10px 105px;
                color: white;
                border-radius: 5px;
                border: none;
                transition: 0.3s all ease;
                font-size:15px;
                margin-left: 30%;
            }
            .family .form .btn:hover{
                opacity: .7;
            }
            @media screen and (max-width: 600px) {
                .family {
                    min-width: 90%; /* Adjusted for smaller screens */
                }
                .family .form .input-field {
                    width: 100%; /* Adjusted for smaller screens */
                }

                .family .form .input-field .input {
                    width: 100%; /* Adjusted for smaller screens */
                }
                .family .form .btn {
                    padding: 10px 20px; /* Adjusted for smaller screens */
                    width: 100%; /* Adjusted for smaller screens */
                    margin: 10px 0; /* Adjusted for smaller screens */
                }
                .family {
                    padding: 10px; /* Adjusted for smaller screens */
                }
                .family .form .btn {
                    padding: 10px 15px; /* Adjusted for smaller screens */
                }
            }
        </style>
    </head>
    <body class="sub_page">
        <?php
        include "../connection.php";
        include '../FEHeader.php';
        $msg = "";
        $id = $_GET['editid'];
        $sql = "SELECT * FROM family WHERE familyID='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        if (isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['ic']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['age']) && isset($_POST['relationship'])) {

            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $ic = $_POST['ic'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $relationship = $_POST['relationship'];

            $namepattern = '/^[A-Za-z\s]+$/';
            $emailpattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
            $icpattern = '/^[0-9]{6}[0-9]{2}[0-9]{4}$/';
            $phonepattern = '/^[0-9]{10}/';

            if (empty($name)) {
                $msg = "<div class='alert alert-danger'>Please Enter Your Name</div>";
            } elseif (!preg_match($namepattern, $name)) {
                $msg = "<div class='alert alert-danger'>Name only letters and spaces are allowed.</div>";
            } elseif (strlen($name) < 2) {
                $msg = "<div class='alert alert-danger'>Your name must be at least 2 characters</div>";
            } else if (empty($gender)) {
                $msg = "<div class='alert alert-danger'>Please Select Gender</div>";
            } elseif (empty($ic)) {
                $msg = "<div class='alert alert-danger'>Please Enter IC</div>";
            } else if (!preg_match($icpattern, $ic)) {
                $msg = "<div class='alert alert-danger'>IC must have 12 numeric.</div>";
            } else if (empty($age)) {
                $msg = "<div class='alert alert-danger'>Please Enter Age</div>";
            }  elseif (empty($relationship)) {
                $msg = "<div class='alert alert-danger'>Please Enter Relationship</div>";        
            }else {
                $query = "UPDATE family SET familyName='$name', familyGender='$gender', familyIC='$ic', familyAge='$age', familyPhone='$phone', familyEmail='$email', familyRelationship='$relationship' WHERE familyID='$id'";
                $result = mysqli_query($conn, $query);               
                $msg = "<div class='alert alert-success'>Family Edited Successfully</div>";
                    $sql = "SELECT * FROM family WHERE familyID='$id'";
                    $result1 = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result1);
            }
        }
        ?>
        
        <div class="menu-container" id="menuContainer">
            <a href="FamilyRecord.php" class="menu-item" id="item1">Family</a>
            <a href="FamilyAdd.php" class="menu-item" id="item2">Add Family</a>
            <span class="menu-item active" id="item3">Edit Family</span>
        </div>
        <div class="menu-toggle" id="menuToggle">
            <span class="las la-bars" id="menuIcon"></span>
        </div>        
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const menuContainer = document.getElementById("menuContainer");
                const menuToggle = document.getElementById("menuToggle");

                document.addEventListener("click", function (event) {
                    const target = event.target;

                    if (target.id === "menuToggle" || target.id === "menuIcon") {

                        menuContainer.style.left = menuContainer.style.left === "0px" ? "-150px" : "0";
                    }
                });
            });
        </script>
        
        <div class="editFamily">
            <div class="family">
                <h1>Edit Family</h1>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Name</label>
                            <input type="text" name="name" class= "input" placeholder="Enter your first name" value="<?php echo $row['familyName']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Gender</label>
                            <input type="text" name="gender" class= "input" placeholder="Enter your gender" value="<?php echo $row['familyGender']; ?>">
                        </div> 
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">IC:</label>
                            <input type="number" name="ic" class= "input" placeholder="111111111111" value="<?php echo $row['familyIC']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Age</label>
                            <input type="number" name="age" class= "input" placeholder="Enter your age" value="<?php echo $row['familyAge']; ?>">
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Phone Number</label>
                            <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php echo $row['familyPhone']; ?>"> 
                        </div>

                        <div class="input-field">
                            <label class="input-label">Email</label>
                            <input type="text" name="email" class= "input" placeholder="Enter your email" value="<?php echo $row['familyEmail']; ?>"> 
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Relationship</label>
                            <input type="text" name="relationship" class= "input" placeholder="Enter your family relationship" value="<?php echo $row['familyRelationship']; ?>"> 
                        </div>
                    </div>

                    <br>

                    <button type="submit" name="submit" class="btn">Save</button>
                </form>
            </div>
        </div>
        <?php
        include '../FEFooter.php';
        ?>
        
 <!-- footer section -->
        <footer class="footer_section">
            <div class="container">
                <p>
                    &copy; <span id="displayYear"></span> 
                    <a href="https://html.design/"></a>
                </p>
            </div>
        </footer>
        <!-- footer section -->
    </body>
</html>
