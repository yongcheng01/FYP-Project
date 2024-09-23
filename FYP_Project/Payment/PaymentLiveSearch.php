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
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $todays = date("Y-m-d");
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
        $status = "Pending";
        $overStatus = "Overdue";
        if (isset($_POST['input'])) {
            $input = $_POST['input'];
            $query = "SELECT * FROM payment 
                      WHERE " . $whereText . " = $userID AND (payment.paymentStatus = '$status' OR payment.paymentStatus = '$overStatus') AND (
                      billType LIKE '{$input}%'  
                      OR issueDate LIKE'{$input}%'
                      OR dueDate LIKE'{$input}%'
                      OR amount LIKE'{$input}%'
                      OR paymentStatus LIKE'{$input}%'
                      )";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bill Type</th>
                            <th>Issue Date</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
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
                                <td data-label="Bill Type"><?= $row["billType"] ?></td>
                                <td data-label="Issue Date"><?= $row["issueDate"] ?></td>
                                <td data-label="Due Date"><?= $row["dueDate"] ?></td>
                                <td data-label="Amount"><?= $row["amount"] ?></td>
                                <td data-label="Status"><?= $row["paymentStatus"] ?></td>
                                <td data-label="">
                                    <?php
                                    $dueDate = $row["dueDate"];
                                    if ($dueDate < $todays) {
                                    } else {
                                        echo '<button class="btnbtn"><a href="Pay.php?payid=' . $row["paymentID"] . '">Pay Online</a></button>';
                                    }
                                    ?>
                                </td>
                                <td data-label="">
                                    <?php
                                    $dueDate = $row["dueDate"];
                                    if ($dueDate < $todays) {

                                    } else {
                                        echo'<button class="btnbtn"><a href="PrintBilling.php?printid=' . $row["paymentID"] . '">Print Bills</a></button>';
                                    }
                                    ?>
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
