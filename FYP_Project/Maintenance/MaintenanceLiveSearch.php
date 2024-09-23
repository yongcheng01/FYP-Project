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
        $ownerID = $_SESSION['ownerID'];
        include "../connection.php";
        $status = "Pending";
        if (isset($_POST['input'])) {
            $input = $_POST['input'];
            $query = "SELECT * FROM maintenance WHERE ownerID='$ownerID' and maintenanceStatus = '$status' AND (
                      maintenanceType LIKE '{$input}%'  
                      OR maintenanceDate LIKE'{$input}%'
                      OR maintenanceTime LIKE'{$input}%'
                      OR maintenanceStatus LIKE'{$input}%'
                      )";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Time</th>
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
                                <td data-label="Type"><?= $row["maintenanceType"] ?></td>
                                <td data-label="Date"><?= $row["maintenanceDate"] ?></td>
                                <td data-label="Time"><?= $row["maintenanceTime"] ?></td>
                                <td data-label="Status"><?= $row["maintenanceStatus"] ?></td>
                                <td data-label="">
                                    <?php echo'<button class="btnbtn"><a href="MaintenanceView.php? viewid='.$row["maintenanceID"].'">View</a></button>'?>
                                </td>
                                <td data-label="">
                                    <?php echo'<button class="btnbtn"><a href="MaintenanceCancel.php? cancelid='.$row["maintenanceID"].'">Cancel</a></button>'?>
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
