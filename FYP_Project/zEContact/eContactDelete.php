
<html>
    <head>
        <meta charset="UTF-8">
        <title>Emergency Contact</title>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="jsEmergencyContact.js"></script>
 
    </head>
    <body>
        
        <?php
        session_start();
        include'../connection.php';
        
        
        if (isset($_POST['ecID'])) {
            
            $ecID = $_POST['ecID'];

            $query = "DELETE FROM emergencyContact WHERE ecID = $ecID[0]";
            mysqli_query($conn, $query);
            
            echo '<script>alert("Delete Emergency Contact Successful");</script>';
            
            echo'<form id="message" action="eContactFunction.php" method="post">
                    <input type="hidden" name="message" value="updated">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
            
        }
                
        ?>
        
    </body>
</html>
