<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include "../connection.php";

if (isset($_POST['condoID'])) {
    $condoID = $_POST['condoID'];

    $options = '<option value="0">Select House ID</option>';
    $options .= '<option value="Select All">Select All</option>';

    // Use $condoID in your SQL query to fetch houses specific to the selected Condominium
    $query = "SELECT h.*
                FROM house h
                JOIN owner o ON h.houseID = o.houseID
                WHERE o.condoID = $condoID
                ORDER BY h.houseID ASC";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        // Build the options for the House ID dropdown
        $houseID = $row['block'] . '-' . $row['floor'] . '-0' . $row['houseNumber'];
        $options .= '<option value="' . $row['houseID'] . '">' . $houseID . '</option>';
    }

    echo $options;
}


?>
    </body>
</html>
