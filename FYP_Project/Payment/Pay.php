<html>
    <?php
    session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <link rel="stylesheet" href="../style.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://www.paypal.com/sdk/js?client-id=ATlUIaPduPGhbCjVQEvxSLXakjlVSG-Q6Sh8ftvnnk7KOlbB4sNqjTdgmjKT7KIc8GK_NTBozK0VcDrw&currency=MYR"></script>
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
            .pay {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 70vh;
            }

            .payment-form {
                background: white;
                padding: 30px 30px;
                min-width: 400px;
                max-width: 450px;
            }
            
            h1 {
                text-align: center;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
            
            label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }
            
            select,
            input[type="text"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            
            button {
                display: block;
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                background: #00a8ff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                opacity: .7;
            }
</style>
    </head>
    <body class="sub_page">
        <?php
        date_default_timezone_set('Asia/Kuala_Lumpur');
        include "../connection.php";
        include '../FEHeader.php';
        $msg = "";
        $id = $_GET['payid'];
        $paymentDate = date("Y-m-d");
        $timestamp = time();
        $formattedTime = date("g:iA", $timestamp);
        $paymentStatus = "Paid";
        
        $sql ="SELECT *
                FROM payment
                WHERE paymentID = '$id'";
        $result3 = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result3);
        
        $ownerID = $row['ownerID'];
        $tenantID = $row['tenantID'];
        

        if (isset($_POST['paymentMethod'])) {
            $paymentMethod = $_POST['paymentMethod'];
            if (isset($_POST["paymentMethod"]) && $_POST["paymentMethod"] == "PayPal") {
                $ids = $_POST['paymentID'];
                $query = "UPDATE payment SET paymentStatus='$paymentStatus' WHERE paymentID='$ids'";
                $result = mysqli_query($conn, $query);
                $sql ="SELECT *
                FROM payment
                WHERE paymentID = '$ids'";
                $result3 = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result3);

                $ownerID = $row['ownerID'];
                $tenantID = $row['tenantID'];
                $addReceipt = "INSERT INTO receipt(paymentID, ownerID, tenantID, paymentMethod, paymentDate, paymentTime, receiptStatus) VALUES
                            ('$ids', '$ownerID', '$tenantID', '$paymentMethod', '$paymentDate', '$formattedTime', '$paymentStatus')";
                $result2 = mysqli_query($conn, $addReceipt);
                $msg = "<div class='alert alert-success'>The Bill Has Pay Successfully</div>";
            
            } else if (isset($_POST["paymentMethod"]) && $_POST["paymentMethod"] == "Bank") {
                if (empty($tenantID)) {
                    $ownerIDToInsert = $ownerID;
                } else {
                    $ownerIDToInsert = 0;
                }

                if (empty($ownerID)) {
                    $tenantIDToInsert = $tenantID;
                } else {
                    $tenantIDToInsert = 0;
                }
                $bankType = $_POST['bankType'];
                if (isset($_POST["bankType"]) && $_POST["bankType"] != "0") {
                    $query = "UPDATE payment SET paymentStatus='$paymentStatus' WHERE paymentID='$id'";
                    $result = mysqli_query($conn, $query);

                    $addReceipt = "INSERT INTO receipt(paymentID, ownerID, tenantID, paymentMethod, bankType, paymentDate, paymentTime, receiptStatus) VALUES
                            ('$id', '$ownerIDToInsert', '$tenantIDToInsert', '$paymentMethod', '$bankType', '$paymentDate', '$formattedTime', '$paymentStatus')";
                    $result2 = mysqli_query($conn, $addReceipt);
                    echo '<script>alert("The Bill Has Pay Successfully");</script>';
                        echo'<form id="message" action="Payment.php" method="post">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
                
                } else {
                    $msg = "<div class='alert alert-danger'>Please Select Bank Type</div>";
                }
                
            } else {
                $msg = "<div class='alert alert-danger'>Please Select Payment Method</div>";
            }
            
        }else {
            $getPayment = "SELECT * FROM payment WHERE paymentID = $id";
            $getPResult = mysqli_query($conn, $getPayment);
            $paymentDetail = mysqli_fetch_assoc($getPResult);
        }
        ?>
        <div class="menu-container" id="menuContainer">
            <a href="Payment.php" class="menu-item" id="item1">Payment</a>
            <a href="PaymentHistory.php" class="menu-item" id="item2">History</a>
            <span class="menu-item active" id="item3">Pay Online</span>
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
        
        <div class ="pay">
            <div class="payment-form">
                <h1>Payment</h1>
                <hr>
                 <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class="form-group">
                        <label for="billType">Billing Type:</label>
                        <input type="text" id="billType" name="billType" value="<?php echo $row['billType']; ?>"disabled>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount">Total Amount:</label>
                        <input type="text" id="amount" name="amount" value="<?php echo $row['amount']; ?>"disabled>
                    </div>
                    
                    <div class="form-group">
                        <label for="payment-method">Select Payment Method:</label>
                        <select id="payment-Method" name="paymentMethod" onchange="toggleBankType()">
                            <option value="0">Please Select Payment Method</option>
                            <option value="PayPal"<?php echo (isset($_POST["paymentMethod"]) && $_POST["paymentMethod"] == 'PayPal') ? 'selected' : ''; ?>>PayPal</option>
                            <option value="Bank"<?php echo (isset($_POST["paymentMethod"]) && $_POST["paymentMethod"] == 'Bank') ? 'selected' : ''; ?>>Bank</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="bank-type" <?php echo (isset($_POST["paymentMethod"]) && $_POST["paymentMethod"] == 'Bank' && $_POST['bankType'] == '0') ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                        <label for="bankType">Select Bank Type:</label>
                        <select id="bankType" name="bankType">
                            <option value="0">Please Select Bank</option>
                            <option value="Public Bank" <?php echo (isset($_POST["bankType"]) && $_POST["bankType"] == 'Public Bank') ? 'selected' : ''; ?>>Public Bank</option>
                            <option value="HongLeong Bank" <?php echo (isset($_POST["bankType"]) && $_POST["bankType"] == 'HongLeong Bank') ? 'selected' : ''; ?>>Hong Leong Bank</option>
                        </select>
                    </div>

                    <button type="submit" id="submit">Pay</button>
                    <div id="paypal-button-container"></div>

                </form>
                
            </div>
        </div>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
    toggleBankType(); // Call the function on page load
});

function toggleBankType() {
    var paymentMethod = document.getElementById("payment-Method");
    var bankTypeDiv = document.getElementById("bank-type");
    var submitBtn = document.getElementById("submit");
    var paypalButtonContainer = document.getElementById('paypal-button-container');

    if (paymentMethod.value === "Bank") {
        bankTypeDiv.style.display = "block";
        submitBtn.style.display = "block";
        paypalButtonContainer.style.display = "none";
    }
    else if (paymentMethod.value === "PayPal") {
        bankTypeDiv.style.display = "none";
        submitBtn.style.display = "none";
        paypalButtonContainer.style.display = "block";
    } 
    else {
        paypalButtonContainer.style.display = "none";
        bankTypeDiv.style.display = "none";
    }
}

// Add an event listener to the payment method select to update bank type visibility
document.getElementById("payment-Method").addEventListener("change", function() {
    toggleBankType();
});

</script>

<script>
      paypal.Buttons({
          
        // Order is created on the server and the order id is returned
        createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                                amount: {

                                    value: '<?= $paymentDetail['amount']?>' 
                                }
                            }]
                    });
                },

        onApprove(data, actions) {

            return actions.order.capture().then(function (orderData) {
            console.log(orderData);
            const transaction = orderData.purchase_units[0].payments.captures[0];
            
            var paymentID = <?= $id ?>;

            var paymentMethod = "PayPal";
            
            $.ajax({
                type: "POST",
                url: "Pay.php",
                data: {paymentID: paymentID, paymentMethod: paymentMethod},
                success: function (response) {
                    setTimeout(function() {
                        alert('Payment Successful');
                    }, 1000);
                    setTimeout(function() {
                        window.location.href = "Payment.php"; //need change
                    }, 1000);
                    
                    
                }
            });
            
            });
        }
      }).render('#paypal-button-container');
    </script>
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
