
<html>
    <head>
        <meta charset="UTF-8">
        <title>Reservation</title>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        
    </head>
    <body>

        <?php
        session_start();
        include '../connection.php';
        if(isset($_POST['reservationID']) && $_POST['reservationID'] > 0){
            date_default_timezone_set("Asia/Kuala_Lumpur");
            
            $id = $_POST['reservationID'];  
            
            $getData = "SELECT * FROM reservation
                        INNER JOIN owner ON reservation.ownerID = owner.ownerID 
                        INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID 
                        WHERE reservationID = $id[0]";
            $dataResult = mysqli_query($conn, $getData);
            $data = mysqli_fetch_assoc($dataResult);
            
            $rDate = $data['reservationDate']; 
            $rTime = $data['reservationStartTime']; 
            $pID = $data['paymentID'];
            
            $time = strtotime($rTime);
            $today = date("Y-m-d");
            $currentDateTime = new DateTime();
            $currentTimestamp = $currentDateTime->getTimestamp();
            
            $location = "";
            
            if(isset($_GET['user'])){
                $location = "reservationFunction.php";
            }else{
                $location = "reservationView.php";
            }
            
            
            if ($rDate < $today) {
                echo '<script>alert("Cancel Failed. Date has passed");</script>';
            }
            elseif($rDate == $today && $time < $currentTimestamp){
                echo '<script>alert("Cancel Failed. Time has passed.");</script>';
                
            }
            else {
                $query = "UPDATE reservation SET reservationStatus = 'Canceled' WHERE reservationID = $id[0]";
                mysqli_query($conn, $query);
                
                $query1 = "UPDATE payment SET paymentStatus = 'Canceled' WHERE paymentID = $pID";
                mysqli_query($conn, $query1);
                    
                
                echo'<script>alert("Cancel Reservation Successful")</script>';
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
