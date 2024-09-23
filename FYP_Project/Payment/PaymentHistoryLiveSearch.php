<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            h3 {
              margin-top: 10px;
              text-align: center;
              margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <?php
        session_start();
        include "../connection.php";
        $userID = "";
        $whereText = "";
        if(isset($_SESSION['ownerEmail'])){
            $email = $_SESSION['ownerEmail'];
            $ownerSql = "SELECT * FROM owner WHERE ownerEmail='$email'";
            $ownerResult = mysqli_query($conn, $ownerSql);
            $ownerRow = mysqli_fetch_assoc($ownerResult);
            $userID = $ownerRow['ownerID'];
            $whereText = "ownerID";
            
        }elseif(isset($_SESSION['tenantID'])){
            $id = $_SESSION['tenantID'];
            $tenantSql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID WHERE tenantID='$id'";
            $tenantResult = mysqli_query($conn, $tenantSql);
            $tenantRow = mysqli_fetch_assoc($tenantResult);
            $userID = $tenantRow['tenantID'];
            $whereText = "tenantID";

        }
        $status = "Paid";
        if (isset($_POST['input'])) {
            $input = $_POST['input'];
            $query = "SELECT payment.*, receipt.*
                      FROM payment
                      INNER JOIN receipt ON payment.paymentID = receipt.paymentID
                      WHERE (payment.ownerID = '$userID' OR payment.tenantID = '$userID') AND payment.paymentStatus = '$status'   AND (
                      receiptID LIKE '{$input}%' 
                      OR billType LIKE '{$input}%'  
                      OR paymentMethod LIKE'{$input}%'
                      OR paymentDate LIKE'{$input}%'
                      OR amount LIKE'{$input}%'
                      OR paymentTime LIKE'{$input}%'
                      )";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Receipt ID</th>
                            <th>Bill Type</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Payment Date</th>
                            <th>Payment Time</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {                          
                            ?>
                            <tr>
                                <td data-label="No"><?php echo $no ?></td>
                                <td data-label="Receipt ID"><?= $row["receiptID"] ?></td>
                                <td data-label="Bill Type"><?= $row["billType"]?></td>
                                <td data-label="Amount"><?= $row["amount"] ?></td>
                                <td data-label="Payment Method"><?= $row["paymentMethod"] ?></td>
                                <td data-label="Payment Date"><?= $row["paymentDate"] ?></td> 
                                <td data-label="Payment Time"><?= $row["paymentTime"] ?></td> 
                                <td data-label="">
                                    <?php echo'<button class="btnbtn"><a href="PrintReceipt.php?printid=' . $row["receiptID"] . '">Print Receipt</a></button>' ?>
                                </td> 
                            </tr>
                            <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<h3 class='text-danger text-center mt-3'>No data Found</h3>";
            }
        }
        ?>
    </body>
</html>
