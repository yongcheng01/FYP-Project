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
            .pay {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }

            .payment-form {
                background: white;
                padding: 30px 30px;
                min-width: 400px;
                max-width: 450px;
            }
            
            h2 {
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
            input[type="text"]{
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
    <body>
        <?php
        date_default_timezone_set('Asia/Kuala_Lumpur');
        include'../BEHeader.php';
        include "../connection.php";
        $msg = "";
        $id = $_GET['payid'];
        $paymentDate = date("Y-m-d");
        $timestamp = time();
        $formattedTime = date("g:iA", $timestamp);
        $paymentStatus = "Paid";
        
        $sql ="SELECT *
                FROM payment
                WHERE payment.paymentID = '$id'";
        $result3 = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result3);
        
        $ownerID = $row['ownerID'];
        $tenantID = $row['tenantID'];

        if (isset($_POST['paymentMethod'])) {
            
            $paymentMethod = $_POST['paymentMethod'];
            if (isset($_POST["paymentMethod"]) && $_POST["paymentMethod"] == "0") {
                $msg = "<div class='alert alert-danger'>Please Select Payment Method</div>";
            }else{
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
            
                $query = "UPDATE payment SET paymentStatus='$paymentStatus' WHERE paymentID='$id'";
                $result = mysqli_query($conn, $query);

                $addReceipt = "INSERT INTO receipt(paymentID, ownerID, tenantID, paymentMethod, paymentDate, paymentTime, receiptStatus) VALUES
                            ('$id', '$ownerIDToInsert', '$tenantIDToInsert', '$paymentMethod', '$paymentDate', '$formattedTime', '$paymentStatus')";
                $result2 = mysqli_query($conn, $addReceipt);
                echo '<script>alert("The Bill Has Pay Successfully");</script>';
                        echo'<form id="message" action="PaymentSearch.php" method="post">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            
            }
        }
        ?>
        <div class ="pay">
            <div class="payment-form">
                <h2>Payment</h2>
                <hr>
                 <?php echo $msg; ?>
                <br>
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
                        <select id="payment-Method" name="paymentMethod">
                            <option value="0">Please Select Payment Method</option>
                            <option value="Cash"<?php echo (isset($_POST["paymentMethod"]) && $_POST["paymentMethod"] == 'PayPal') ? 'selected' : ''; ?>>Cash</option>
                        </select>
                    </div>

                    <button type="submit">Pay</button>
                    <button type="button" onclick="location.href='PaymentSearch.php'">Back</button>
                </form>
            </div>
        </div>

    </body>
</html>
