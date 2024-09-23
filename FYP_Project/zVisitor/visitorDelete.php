
<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <title>Visitor</title>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="jsVisitor.js"></script>
        
    </head>
    <body>

        <?php
        include'../connection.php';
        
        if(isset($_POST['visitorID']) && $_POST['visitorID'] > 0){
            date_default_timezone_set("Asia/Kuala_Lumpur");    
            $id = $_POST['visitorID'];
            
            $getData = "SELECT * FROM visitor WHERE visitorID = $id[0]";
            $dataResult = mysqli_query($conn, $getData);
            $data = mysqli_fetch_assoc($dataResult);
            
            $status = $data['visitorStatus'];
            
            $vDate = $data['visitDate']; 
            $vTime = $data['visitTime']; 
            
            $time = strtotime($vTime);
            $today = date("Y-m-d");
            $currentDateTime = new DateTime();
            $currentTimestamp = $currentDateTime->getTimestamp();
           
            $location = "";
            if(isset($_GET['user'])){
                $location = "visitorFunction.php";
            }else {
                $location = "visitorView.php";
            }
                
            if ($vDate < $today) {
                echo '<script>alert("Delete Failed. Date has passed");</script>';
                
            }
            elseif($vDate == $today && $time < $currentTimestamp){
                echo '<script>alert("Delete Failed. Time has passed.");</script>';
            }
            elseif($status != "Pending"){
                echo '<script>alert("Update Status Failed. Visitor status is not pending.");</script>';
            }
            else {
                $query = "UPDATE visitor SET visitorStatus = 'Canceled' WHERE visitorID = $id[0]";
                mysqli_query($conn, $query);
                
                echo'<script>alert("Delete Visitor Successful")</script>';
                
            }
                
            echo'<form id="message" action="'.$location.'" method="post">
                    <input type="hidden" name="message" value="deleted">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';    
                
                                
        }
        ?>
    </body>
</html>
