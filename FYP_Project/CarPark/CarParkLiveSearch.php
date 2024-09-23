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
            $query = "SELECT carpark.*, condominium.condoName, owner.*
                      FROM carpark
                      INNER JOIN condominium ON carpark.condoID = condominium.condoID
                      LEFT JOIN owner ON carpark.ownerID = owner.ownerID
                      WHERE carParkID LIKE '{$input}%' 
                      OR CONCAT(carBlock,'-',carFloor,'-',number) LIKE '{$input}%' 
                      OR condoName LIKE'{$input}%'
                      OR carParkStatus LIKE'{$input}%'
                      OR CONCAT(ownerFName,' ',ownerLName) LIKE'{$input}%'
                      OR carPlate LIKE '{$input}%'";

            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                        <th>No</th>
                        <th>Car Park</th>
                        <th>Condo Name</th>
                        <th>Status</th>
                        <th>Owner Name</th>
                        <th>Car Plate</th>
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
                                        <td data-label="Car Park"><?= $row["carBlock"].'-'.$row["carFloor"].'-'.$row["number"] ?></td>
                                        <td data-label="Condo Name"><?= $row["condoName"] ?></td>
                                        <td data-label="Status"><?= $row["carParkStatus"] ?></td>
                                        <td data-label="Owner Name"><?= $row["ownerFName"] . ' ' . $row["ownerLName"] ?></td>
                                        <td data-label="Car Plate"><?= $row["carPlate"] ?></td>
                                        <td data-label="">
                                            <?php if ($row["carParkStatus"] === "Available") : ?>
                                                <?php echo'<button class="btnbtn"><a href="CarParkAssign.php? editid=' . $row["carParkID"] . '">Assign</a></button>' ?>

                                            <?php elseif ($row["carParkStatus"] === "Unavailable") : ?>
                                                <?php echo'<button class="btnbtn"><a href="CarParkDelete.php? deleteid=' . $row["carParkID"] . '">Delete</a></button>' ?>
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
