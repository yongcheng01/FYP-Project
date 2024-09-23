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
            $query = "SELECT m.*, o.*, h.*, c.*
                      FROM maintenance m
                      INNER JOIN owner o ON m.ownerID = o.ownerID
                      INNER JOIN house h ON o.houseID = h.houseID
                      INNER JOIN condominium c ON h.condoID = c.condoID
                      WHERE m.maintenanceType LIKE '{$input}%' 
                        OR o.ownerID LIKE '{$input}%'
                        OR m.maintenanceDate LIKE '{$input}%'
                        OR m.maintenanceStatus LIKE '{$input}%'
                        OR CONCAT(h.block,'-',h.floor,'-',h.houseNumber) LIKE '{$input}%'
                        OR c.condoName LIKE '{$input}%'";

            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Owner ID</th>
                            <th>Type</th>
                            <th>Date</th>
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
                                <td data-label="Owner ID"><?= $row["ownerID"] ?></td>
                                <td data-label="Type"><?= $row["maintenanceType"] ?></td>
                                <td data-label="Date"><?= $row["maintenanceDate"] ?></td>
                                <td data-label="Status"><?= $row["maintenanceStatus"] ?></td>
                                <td data-label="House"><?= $row["block"] . '-' . $row["floor"] . '-' . $row["houseNumber"] ?></td>
                                <td data-label="Condo Name"><?= $row["condoName"] ?></td>
                                <td data-label="">
                                    <?php echo'<button class="btnbtn"><a href="MaintenanceViewAdmin.php? viewid=' . $row["maintenanceID"] . '">View</a></button>' ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["maintenanceStatus"] === "Pending"): ?>
                                        <?php echo'<button class="btnbtn"><a href="MaintenanceSuccessful.php? approveid=' . $row["maintenanceID"] . '">Approve</a></button>' ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["maintenanceStatus"] === "Pending"): ?>
                                        <?php echo'<button class="btnbtn"><a href="MaintenanceCancelAdmin.php? cancelid=' . $row["maintenanceID"] . '">Cancel</a></button>' ?>
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
