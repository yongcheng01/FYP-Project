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
        $accountStatus ="Deleted";
        $sql2 = "SELECT * FROM owner WHERE ownerID='$id'";

		$result2 = mysqli_query($conn, $sql2);

			$row = mysqli_fetch_assoc($result2);

        $sql="update owner set accountStatus='$accountStatus' where ownerID=$id";
        mysqli_query($conn, $sql);
                    
                    header("Location: OwnerSearch.php?success=Owner Deleted Successfully!");

        }
        ?>
    </body>
</html>
