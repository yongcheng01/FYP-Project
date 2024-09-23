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
            $query = "SELECT owner.*, house.*, condominium.*
                      FROM owner
                      INNER JOIN house ON owner.houseID = house.houseID
                      INNER JOIN condominium ON owner.condoID = condominium.condoID 
                      WHERE ownerID LIKE '{$input}%' 
                      OR CONCAT(ownerFName, ' ', ownerLName) LIKE '{$input}%' 
                      OR ownerPhone LIKE '{$input}%' 
                      OR ownerGender LIKE'{$input}%'
                      OR accountStatus LIKE'{$input}%'
                      OR CONCAT(block,'-',floor,'-',houseNumber) LIKE '{$input}%'
                      OR condoName LIKE'{$input}%'";
                      
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Account Status</th>
                            <th>House</th>
                            <th>Condo Name</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {                          
                            ?>
                            <tr>
                                <td data-label="ID"><?= $row["ownerID"] ?></td>
                                <td data-label="Name"><?= $row["ownerFName"] . ' ' . $row["ownerLName"] ?></td>
                                <td data-label="Phone"><?= $row["ownerPhone"] ?></td>
                                <td data-label="Gender"><?= $row["ownerGender"] ?></td>
                                <td data-label="Account Status"><?= $row["accountStatus"] ?></td>
                                <td data-label="House"><?= $row["block"] . '-' . $row["floor"] . '-' . $row["houseNumber"] ?></td>
                                <td data-label="Condo Name"><?= $row["condoName"] ?></td>
                                <td data-label="">
                                    <?php echo'<button class="btnbtn"><a href="OwnerView.php? viewid=' . $row["ownerID"] . '">View</a></button>' ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["accountStatus"] === "Deleted") : ?>  
                                    <?php else: ?>
                                        <?php echo'<button class="btnbtn"><a href="OwnerEdit.php? editid=' . $row["ownerID"] . '">Edit</a></button>' ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["accountStatus"] === "Deleted") : ?>  
                                    <?php else: ?>
                                        <?php echo'<button class="btnbtn"><a href="OwnerDelete.php? deleteid=' . $row["ownerID"] . '">Delete</a></button>' ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
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
