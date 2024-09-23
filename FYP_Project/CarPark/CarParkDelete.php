<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include "../connection.php";
        if(isset($_GET['deleteid'])){
            $id=$_GET['deleteid'];
        $carParkStatus ="Available";
        $ownerID ="0";
        $carPlate = "-";
        $sql="Update carpark set carParkStatus='$carParkStatus', ownerID='$ownerID', carPlate='$carPlate' where carParkID='$id'";
        mysqli_query($conn, $sql);          
        header("Location: CarParkSearch.php?success=Deleted Car Park Successful!");
        exit();
        }
        ?>
    </body>
</html>
