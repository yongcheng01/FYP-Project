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
            $query = "SELECT t.*, o.*, c.*, h.*
                      FROM tenant t
                      INNER JOIN owner o ON t.ownerID = o.ownerID
                      INNER JOIN house h ON o.houseID = h.houseID
                      INNER JOIN condominium c ON o.condoID = c.condoID 
                      WHERE tenantName LIKE '{$input}%' 
                      OR tenantPhone LIKE'{$input}%'
                      OR startDate LIKE'{$input}%'
                      OR endDate LIKE'{$input}%'
                      OR tenantStatus LIKE '{$input}%'
                      OR CONCAT(block,'-',floor,'-',houseNumber) LIKE'{$input}%'
                      OR condoName LIKE '{$input}%'";

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
                            <th>House</th>
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
                                <td data-label="Name"><?= $row["tenantName"] ?></td>
                                <td data-label="Phone"><?= $row["tenantPhone"] ?></td>
                                <td data-label="Start Date"><?= $row["startDate"] ?></td>
                                <td data-label="End Date"><?= $row["endDate"] ?></td>
                                <td data-label="Status"><?= $row["tenantStatus"] ?></td>
                                <td data-label="House"><?= $row["block"] . '-' . $row["floor"] . '-' . $row["houseNumber"] ?></td>
                                <td data-label="Condo Name"><?= $row["condoName"] ?></td>
                                <td data-label="">
                                    <?php echo'<button class="btnbtn"><a href="TenantViewAdmin.php? viewid=' . $row["tenantID"] . '">View</a></button>' ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["tenantStatus"] === "Available") : ?>
                                        <?php echo'<button class="btnbtn"><a href="TenantEditAdmin.php? editid=' . $row["tenantID"] . '">Edit</a></button>' ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["tenantStatus"] === "Available") : ?>
                                        <?php echo'<button class="btnbtn"><a href="TenantDeleteAdmin.php? deleteid=' . $row["tenantID"] . '">Delete</a></button>' ?>
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
