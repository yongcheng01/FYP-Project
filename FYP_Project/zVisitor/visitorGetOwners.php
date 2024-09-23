
<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $condoID = $_POST['condoID'];

    $query = "SELECT * FROM owner INNER JOIN house ON owner.houseID = house.houseID WHERE owner.condoID = $condoID";
    $result = mysqli_query($conn, $query);

    $owners = [];
    while ($data = mysqli_fetch_assoc($result)) {
        $owners[] = $data;
    }

    header('Content-Type: application/json');
    echo json_encode($owners);
    exit;
}
?>
