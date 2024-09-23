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
        $tenantStatus ="Unavailable";
        $endDate = date("Y-m-d");
        $sql="Update tenant set tenantStatus='$tenantStatus', endDate='$endDate' where tenantID='$id'";
        mysqli_query($conn, $sql);          
        header("Location: TenantSearch.php?success=Deleted Tenant Successful!");
        exit();

        }
        ?>
    </body>
</html>
