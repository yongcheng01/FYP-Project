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
        $adminStatus ="Unavailable";
        $sql="update admin set adminStatus='$adminStatus' where adminID=$id";
        mysqli_query($conn, $sql);
                    
        header("Location: AdminSearch.php?success=Admin Deleted Successfully!");

        }
        ?>
    </body>
</html>
