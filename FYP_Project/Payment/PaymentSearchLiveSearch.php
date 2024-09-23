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
        include "../connection.php";
        if (isset($_POST['input'])) {
            $input = $_POST['input'];
            $query = "SELECT * FROM payment
                      LEFT JOIN owner ON payment.ownerID = owner.ownerID
                      LEFT JOIN tenant ON payment.tenantID = tenant.tenantID
                      LEFT JOIN house ON payment.houseID = house.houseID
                      INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                      WHERE CONCAT(ownerFName, ' ', ownerLName) LIKE '{$input}%' 
                      OR tenantName LIKE'{$input}%'
                      OR billType LIKE'{$input}%'
                      OR amount LIKE'{$input}%'
                      OR dueDate LIKE'{$input}%'
                      OR CONCAT(block,'-',floor,'-',houseNumber) LIKE'{$input}%'
                      OR paymentStatus LIKE'{$input}%'
                      OR condoName LIKE'{$input}%'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Owner Name</th>
                            <th>Tenant Name</th>
                            <th>Bill Type</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>House</th>
                            <th>Status</th>
                            <th>Condo Name</th>
                            <th></th>
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
                                <td data-label="Owner Name"><?= $row["ownerFName"] . ' ' . $row["ownerLName"] ?></td>
                                <td data-label="TenantName"><?= $row["tenantName"] ?></td>
                                <td data-label="Bill Type"><?= $row["billType"] ?></td>
                                <td data-label="Amount"><?= $row["amount"] ?></td>
                                <td data-label="Due Date"><?= $row["dueDate"] ?></td>
                                <td data-label="House"><?= $row["block"] . '-' . $row["floor"] . '-' . $row["houseNumber"] ?></td>
                                <td data-label="Status"><?= $row["paymentStatus"] ?></td>
                                <td data-label="Condo Name"><?= $row["condoName"] ?></td>
                                <td data-label="">
                                    <?php
                                    $dueDate = $row["dueDate"];
                                    date_default_timezone_set("Asia/Kuala_Lumpur");
                                    $today = date("Y-m-d");
                                    if ($dueDate >= $today && $row["paymentStatus"] === 'Pending') {
                                        echo '<button class="btnbtn"><a href="PayAdmin.php?payid=' . $row["paymentID"] . '">Pay</a></button>';
                                    }else {           
                                    }
                                    ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["paymentStatus"] === "Overdue"): ?>
                                        <?php echo'<button class="btnbtn"><a href="PaymentEdit.php? editid=' . $row["paymentID"] . '">Edit</a></button>' ?>
                                        <?php elseif ($row["paymentStatus"] === "Pending"): ?>
                                        <?php echo '<button class="btnbtn"><a href="PrintBilling.php?printid=' . $row["paymentID"] . '">Print Bill</a></button>' ?>
                                    <?php endif; ?>
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
