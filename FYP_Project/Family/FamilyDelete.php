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
        $familyStatus ="Unavailable";
        $endDate = date("Y-m-d");
        $sql="Update family set familyStatus='$familyStatus' where familyID='$id'";
        mysqli_query($conn, $sql);          
        header("Location: FamilyRecord.php?success=Deleted Family Successful!");
        exit();

        }
        ?>
    </body>
</html>
