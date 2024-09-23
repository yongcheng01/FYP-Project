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
            $query = "SELECT f.*, o.*, c.*, h.*
                      FROM family f
                      INNER JOIN owner o ON f.ownerID = o.ownerID
                      INNER JOIN house h ON o.houseID = h.houseID
                      INNER JOIN condominium c ON o.condoID = c.condoID 
                      WHERE familyName LIKE '{$input}%' 
                      OR familyRelationship LIKE'{$input}%'
                      OR familyStatus LIKE '{$input}%'
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
                            <th>Relationship</th>
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
                                <td data-label="Name"><?= $row["familyName"] ?></td>
                                <td data-label="Phone"><?= $row["familyPhone"] ?></td>
                                <td data-label="Relationship"><?= $row["familyRelationship"] ?></td>
                                <td data-label="Status"><?= $row["familyStatus"] ?></td>
                                <td data-label="House"><?= $row["block"] . '-' . $row["floor"] . '-' . $row["houseNumber"] ?></td>
                                <td data-label="Condo Name"><?= $row["condoName"] ?></td>
                                <td data-label="">
                                    <?php echo'<button class="btnbtn"><a href="FamilyViewAdmin.php? viewid=' . $row["familyID"] . '">View</a></button>' ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["familyStatus"] === "Available") : ?>
                                    <?php echo'<button class="btnbtn"><a href="FamilyEditAdmin.php? editid=' . $row["familyID"] . '">Edit</a></button>' ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["familyStatus"] === "Available") : ?>
                                    <?php echo'<button class="btnbtn"><a href="FamilyDeleteAdmin.php? deleteid=' . $row["familyID"] . '">Delete</a></button>' ?>
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
