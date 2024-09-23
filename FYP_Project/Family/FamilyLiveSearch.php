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
            $query = "SELECT * FROM family WHERE ownerID='$ownerID' AND (
                      familyName LIKE '{$input}%'  
                      OR familyPhone LIKE'{$input}%'
                      OR familyAge LIKE'{$input}%'
                      OR familyRelationship LIKE'{$input}%'
                      OR familyStatus LIKE '{$input}%'
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
                            <th>Age</th>
                            <th>Relationship</th>
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
                                <td data-label="Name"><?= $row["familyName"] ?></td>
                                <td data-label="Phone"><?= $row["familyPhone"] ?></td>
                                <td data-label="Age"><?= $row["familyAge"] ?></td>
                                <td data-label="Relationship"><?= $row["familyRelationship"] ?></td>
                                <td data-label="Status"><?= $row["familyStatus"] ?></td>
                                <td data-label="">
                                    <?php echo'<button class="btnbtn"><a href="FamilyView.php? viewid=' . $row["familyID"] . '">View</a></button>' ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["familyStatus"] === "Available") : ?>
                                    <?php echo'<button class="btnbtn"><a href="FamilyEdit.php? editid=' . $row["familyID"] . '">Edit</a></button>' ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="">
                                    <?php if ($row["familyStatus"] === "Available") : ?>
                                    <?php echo'<button class="btnbtn"><a href="FamilyDelete.php? deleteid=' . $row["familyID"] . '">Delete</a></button>' ?>
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
