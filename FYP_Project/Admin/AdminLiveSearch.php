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
            $query = "SELECT * FROM admin WHERE adminPhone LIKE '{$input}%' 
                      OR CONCAT(adminFName, ' ', adminLName) LIKE '{$input}%' 
                      OR adminPosition LIKE '{$input}%' 
                      OR adminGender LIKE'{$input}%'
                      OR adminAge LIKE'{$input}%'
                      OR adminStatus LIKE '{$input}%'";

            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Phone Number</th>
                            <th>Gender</th>
                            <th>Age</th>
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
                                <td data-label="Name"><?= $row["adminFName"] . ' ' . $row["adminLName"] ?></td>
                                <td data-label="Position"><?= $row["adminPosition"] ?></td>
                                <td data-label="Phone"><?= $row["adminPhone"] ?></td>
                                <td data-label="Gender"><?= $row["adminGender"] ?></td>
                                <td data-label="Age"><?= $row["adminAge"] ?></td>
                                <td data-label="Status"><?= $row["adminStatus"] ?></td>
                                <td data-label="">
                                    <?php if ($row["adminPosition"] !== "Admin") : ?>
                                    <?php echo'<button class="btnbtn"><a href="AdminView.php? viewid=' . $row["adminID"] . '">View</a></button>' ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["adminPosition"] !== "Admin" && $row["adminStatus"] !== "Unavailable") : ?>
                                    <?php echo'<button class="btnbtn"><a href="AdminEdit.php? editid=' . $row["adminID"] . '">Edit</a></button>' ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["adminPosition"] !== "Admin" && $row["adminStatus"] !== "Unavailable") : ?>
                                    <?php echo'<button class="btnbtn"><a href="AdminDelete.php? deleteid=' . $row["adminID"] . '">Delete</a></button>' ?>
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
