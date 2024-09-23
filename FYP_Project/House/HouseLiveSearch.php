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
            $query = "SELECT house.*, condominium.condoName, owner.ownerFName, owner.ownerLName
                      FROM house
                      INNER JOIN condominium ON house.condoID = condominium.condoID
                      LEFT JOIN owner ON house.houseID = owner.houseID
                      WHERE house.houseStatus LIKE '{$input}%' 
                      OR CONCAT(block,'-',floor,'-',houseNumber) LIKE '{$input}%' 
                      OR squareFeet LIKE'{$input}%'
                      OR condoName LIKE'{$input}%'
                      OR CONCAT(owner.ownerFName, ' ', owner.ownerLName) LIKE'{$input}%'";

            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                        <th>No</th>
                        <th>House</th>
                        <th>Square Feet</th>
                        <th>Status</th>
                        <th>Condo Name</th>
                        <th>Owner Name</th>
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
                            <td data-label="House"><?= $row["block"].'-'.$row["floor"].'-'.$row["houseNumber"] ?></td> 
                            <td data-label="Square Feet"><?= $row["squareFeet"] ?></td>  
                            <td data-label="Status"><?= $row["houseStatus"] ?></td> 
                            <td data-label="Condo Name"><?= $row["condoName"] ?></td> 
                            <td data-label="Owner Name"><?= $row["ownerFName"] . ' ' . $row["ownerLName"] ?></td>
                            <td data-label="">
                                <?php echo'<button class="btnbtn"><a href="HouseView.php? viewid=' . $row["houseID"] . '">View</a></button>' ?>
                            </td>
                            <td data-label="">
                                <?php if ($row["houseStatus"] === "Available") : ?>
                                <?php echo'<button class="btnbtn"><a href="HouseAssign.php? assignid=' . $row["houseID"] . '">Assign</a></button>' ?>

                                <?php elseif ($row["houseStatus"] === "Unavailable") : ?>
                                <?php echo'<button class="btnbtn"><a href="HouseDelete.php? deleteid=' . $row["houseID"] . '">Delete</a></button>' ?>
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
