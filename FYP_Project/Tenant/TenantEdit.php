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
            h1 {
                margin: 10px 0;
                text-align: center;
                padding-left: 5px;
                color: black;
                margin-top: 10px;
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
                background: #00a8ff;
                padding: 10px 105px;
                color: white;
                border-radius: 5px;
                border: none;
                transition: 0.3s all ease;
                font-size:15px;
                margin-left: 30%;
            }
            .tenant .form .btn:hover{
                opacity: .7;
            }
             @media screen and (max-width: 600px) {
                .tenant {
                    min-width: 90%; /* Adjusted for smaller screens */
                }
                .tenant .form .input-field {
                    width: 100%; /* Adjusted for smaller screens */
                }

                .tenant .form .input-field .input {
                    width: 100%; /* Adjusted for smaller screens */
                }
                .tenant .form .btn {
                    padding: 10px 20px; /* Adjusted for smaller screens */
                    width: 100%; /* Adjusted for smaller screens */
                    margin: 10px 0; /* Adjusted for smaller screens */
                }
                .tenant {
                    padding: 10px; /* Adjusted for smaller screens */
                }
                .tenant .form .btn {
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
        <div class="menu-container" id="menuContainer">
            <a href="TenantRecord.php" class="menu-item" id="item1">Tenant</a>
            <a href="TenantAdd.php" class="menu-item" id="item2">Add Tenant</a>
            <span class="menu-item active" id="item3">Edit Tenant</span>
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
        
        <div class="editTenant">
            <div class="tenant">
                <h1>Edit Tenant</h1>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Name</label>
                            <input type="text" name="name" class= "input" placeholder="Enter your first name" value="<?php echo $row['tenantName']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Gender</label>
                            <input type="text" name="gender" class= "input" placeholder="Enter your gender" value="<?php echo $row['tenantGender']; ?>">
                        </div> 
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">IC:</label>
                            <input type="number" name="ic" class= "input" placeholder="111111111111" value="<?php echo $row['tenantIC']; ?>">
                        </div>

                        <div class="input-field">
                            <label class="input-label">Age</label>
                            <input type="number" name="age" class= "input" placeholder="Enter your age" value="<?php echo $row['tenantAge']; ?>">
                        </div>
                    </div>

                    <div class ="field">
                        <div class="input-field">
                            <label class="input-label">Phone Number</label>
                            <input type="number" name="phone" class= "input" placeholder="0110293092" value="<?php echo $row['tenantPhone']; ?>"> 
                        </div>

                        <div class="input-field">
                            <label class="input-label">Email</label>
                            <input type="text" name="email" class= "input" placeholder="Enter your email" value="<?php echo $row['tenantEmail']; ?>"> 
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

        <!-- jQery -->
        <script src="js/jquery-3.4.1.min.js"></script>
        <!-- popper js -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>
        <!-- owl slider -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <!-- nice select -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
        <!-- custom js -->
        <script src="js/custom.js"></script>
        <!-- Google Map -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
        <!-- End Google Map -->
    </body>
</html>