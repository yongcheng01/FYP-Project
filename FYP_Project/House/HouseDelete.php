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
        $ownerStatus ="Pending";    
        $HouseStatus ="Available";
        $ownerID ="0";
        $owner = "UPDATE owner SET houseID = 0, ownerStatus = '$ownerStatus' WHERE houseID = '$id'";
        mysqli_query($conn, $owner);
        $sql="Update house set houseStatus='$HouseStatus' where houseID='$id'";
        mysqli_query($conn, $sql);          
        header("Location: HouseSearch.php?success=Deleted House Successful!");
        exit();
        }
        ?>
    </body>
</html>
