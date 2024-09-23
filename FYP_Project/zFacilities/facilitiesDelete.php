
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <title>Facilities</title>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        
    </head>
    <body>

        <?php
        include '../connection.php';
        
        if(isset($_POST['facilitiesID']) && $_POST['facilitiesID'] > 0){
                
                $id = $_POST['facilitiesID'];
                
                foreach ($id as $ids){
                    $query = "UPDATE facilities SET facilitiesStatus = 'Removed' WHERE facilitiesID = $ids";
                    mysqli_query($conn, $query);
                }
                echo'<script>alert("Delete Successful")</script>';
                
                echo'<form id="message" action="facilitiesFunction.php" method="post">
                    <input type="hidden" name="message" value="deleted">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
                
                
            }
        ?>
    </body>
</html>
