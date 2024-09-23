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
        if (isset($_POST['input'])) {
            $input = $_POST['input'];
            $query = "SELECT * FROM tenant WHERE ownerID='$ownerID' AND (
                      tenantName LIKE '{$input}%'  
                      OR tenantPhone LIKE'{$input}%'
                      OR startDate LIKE'{$input}%'
                      OR endDate LIKE'{$input}%'
                      OR tenantStatus LIKE '{$input}%'
                      )";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
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
                                <td data-label="Name"><?= $row["tenantName"] ?></td>
                                <td data-label="Phone"><?= $row["tenantPhone"] ?></td>
                                <td data-label="Start Date"><?= $row["startDate"] ?></td>
                                <td data-label="End Date"><?= $row["endDate"] ?></td>
                                <td data-label="Status"><?= $row["tenantStatus"] ?></td>
                                <td data-label="">
                                    <?php echo'<button class="btnbtn"><a href="TenantView.php? viewid=' . $row["tenantID"] . '">View</a></button>' ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["tenantStatus"] === "Available") : ?>
                                    <?php echo'<button class="btnbtn"><a href="TenantEdit.php? editid=' . $row["tenantID"] . '">Edit</a></button>' ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["tenantStatus"] === "Available") : ?>
                                        <?php echo'<button class="btnbtn"><a href="TenantDelete.php? deleteid=' . $row["tenantID"] . '">Delete</a></button>' ?>
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
