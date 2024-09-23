<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
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

    $query = "SELECT condoBlock FROM condominium WHERE condoID = '$condoID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $condoBlock = $row['condoBlock'];

        $options = '<option value="0">Select Block</option>';
        for ($i = 1; $i <= $condoBlock; $i++) {
            $selected = (isset($_POST['block']) && $_POST['block'] == $i) ? 'selected' : '';
            $options .= '<option value="' . $i . '" ' . $selected . '>' . chr(64 + $i) . '</option>';
        }

        echo $options;
    } else {
        echo '<option value="0">Select Block</option>';
    }
} else {
    echo '<option value="0">Select Block</option>';
}
?>
    </body>
</html>
