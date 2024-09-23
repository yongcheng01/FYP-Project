
<html>
    <?php session_start();?>
    <head>
        <meta charset="UTF-8">
        <title>Announcement</title>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        
    </head>
    <body>

        <?php
        
        include '../connection.php';
        
        if(isset($_POST['announcementID']) && $_POST['announcementID'] > 0){
                
                $id = $_POST['announcementID'];
                
                foreach ($id as $ids){
                    $query = "DELETE FROM announcement WHERE announcementID = $ids";
                    mysqli_query($conn, $query);
                }
                echo'<script>alert("Delete Announcement Successful")</script>';
                
                echo'<form id="message" action="announcementFunction.php" method="post">
                    <input type="hidden" name="message" value="deleted">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
                
                
            }
        ?>
    </body>
</html>
