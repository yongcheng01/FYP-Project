
<style>
    .nodata {
        color: red;
        font-size: 20px;
        text-align: center;
        margin-top: 50px;
    }
</style>

<?php
session_start();
include("connection.php");

if (isset($_POST['announcement'])) {
    $announcement = $_POST['announcement'];
    $user = $_POST['user'];
    $queryOne = "";
    $queryTwo = "";
    $rowCount = "";
    $viewLocation = "";
    
    
    if ($user == "staff") {
        $viewLocation = "announcementView.php";
        $rowCount = $conn->query("SELECT * FROM announcement INNER JOIN condominium ON announcement.condoID = condominium.condoID")->num_rows;
        
        $queryOne = "SELECT * FROM announcement INNER JOIN condominium ON announcement.condoID = condominium.condoID 
                        WHERE announcementType LIKE '{$announcement}%' OR announcementTitle LIKE '{$announcement}%' OR announcementDate LIKE '{$announcement}%' OR condoName LIKE '{$announcement}%'";
        
        $queryTwo = "SELECT * FROM announcement INNER JOIN condominium ON announcement.condoID = condominium.condoID 
                        WHERE announcementType LIKE '{$announcement}%' OR announcementTitle LIKE '{$announcement}%' OR announcementDate LIKE '{$announcement}%' OR condoName LIKE '{$announcement}%'
                        ORDER BY announcementID DESC LIMIT ?,?";
        
    } elseif ($user == "owner") {
        $viewLocation = "announcementViewOwner.php";
        $condoID = "";
        if(isset($_SESSION['ownerEmail'])){
            $email = $_SESSION['ownerEmail'];
            $ownerSql = "SELECT * FROM owner WHERE ownerEmail='$email'";
            $ownerResult = mysqli_query($conn, $ownerSql);
            $ownerRow = mysqli_fetch_assoc($ownerResult);
            $condoID = $ownerRow['condoID'];
            
        }elseif(isset($_SESSION['tenantID'])){
            $id = $_SESSION['tenantID'];
            $tenantSql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID WHERE tenantID='$id'";
            $tenantResult = mysqli_query($conn, $tenantSql);
            $tenantRow = mysqli_fetch_assoc($tenantResult);
            $condoID = $tenantRow['condoID'];
        }
        
        $rowCount = $conn->query("SELECT * FROM announcement WHERE condoID = $condoID")->num_rows;
        $queryOne = "SELECT * FROM announcement WHERE condoID = $condoID 
                        AND announcementType LIKE '{$announcement}%' OR announcementTitle LIKE '{$announcement}%' OR announcementDate LIKE '{$announcement}%'";
        
        $queryTwo = "SELECT * FROM announcement WHERE condoID = $condoID 
                        AND announcementType LIKE '{$announcement}%' OR announcementTitle LIKE '{$announcement}%' OR announcementDate LIKE '{$announcement}%'
                        ORDER BY announcementID DESC LIMIT ?,?";
    }
    ?>
    <form method="post" id="announcement">
        <div class="row">
            <table>

                <thead>
                    <tr>
                        <?php if ($user == "staff") : ?>
                        <th></th>
                        <?php endif; ?>
                        <th colspan="4">Title</th>
                        <th>Type</th>
                        <th>Date</th>
                        <?php if ($user == "staff") : ?>
                        <th>Condominium</th>
                        <?php endif; ?>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    
                    $total_rows = $conn->query($queryOne)->num_rows;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                    $num_results_on_page = 5;
                    if ($stmt = $conn->prepare($queryTwo)) {
                        // Calculate the page to get the results we need from our table.
                        $calc_page = ($page - 1) * $num_results_on_page;
                        $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                        $stmt->execute();
                        // Get the results...
                        $result = $stmt->get_result();
                        // Loop through the data and output it in the table
                        if (mysqli_num_rows($result) > 0) {
                            while ($announcement = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <?php if ($user == "staff") : ?>
                                    <td data-label="Action"><input type="radio" name="announcementID[]" value="<?= $announcement['announcementID'] ?>"></td>
                                    <?php endif; ?>
                                    <td colspan="4" data-label="Title"><a href="<?= $viewLocation?>?aID=<?= $announcement['announcementID'] ?>&user='staff'"><?= $announcement['announcementTitle'] ?></a></td>
                                    <td data-label="Type"><?= $announcement['announcementType'] ?></td>
                                    <td data-label="Date"><?= $announcement['announcementDate'] ?></td>
                                    <?php if ($user == "staff") :?>
                                    <td data-label="Condominium"><?= $announcement['condoName'] ?></td>
                                    <?php endif;?>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='8' style='text-align:center' class='nodata'>No Data found</td></tr>";
                        }
                    } ?>
                </tbody>
            </table>

                <div class="rowPagination">
                    <?php if ($total_rows > $num_results_on_page): ?>
                        <div class="pagination">
                            <?php $total_pages = ceil($total_rows / $num_results_on_page); ?>
                            <?php if ($page > 1): ?>
                                <a href="?page=1">&laquo; </a>
                                <a href="?page=<?php echo $page - 1 ?>">&lsaquo; </a>
                            <?php endif; ?>

                            <?php
                            $start_page = max(1, min($page - 2, $total_pages - 4));
                            $end_page = min($start_page + 4, $total_pages);

                            for ($i = $start_page; $i <= $end_page; $i++):
                                ?>
                                <?php if ($i == $page): ?>
                                    <center><a href="#" class="current"><?php echo $i ?></a></center>
                                <?php else: ?>
                                    <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?php echo $page + 1 ?>"> &rsaquo;</a>
                                <a href="?page=<?php echo $total_pages ?>"> &raquo;</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>


            
        </div>
        <?php if($user == "staff"):?>
            <div class="rowbtn">
                <button class="update" formaction="announcementUpdate.php" onclick="chkUpdateSelect()">Update</button>
                <button class="delete" formaction="announcementDelete.php" onclick="confirmDelete()">Delete</button>
                <button class="add" formaction="announcementAdd.php">Add</button>
            </div>
        <?php endif;?>
    </form>
<?php
}
?>



<?php
if (isset($_POST['facilities'])) {
    $facilities = $_POST['facilities'];
        ?>

        <form method="post" id="facilities">
            <div class="row">
                <table>

                    <thead>
                        <tr>
                            <th></th>
                            <th>Facilities Name</th>
                            <th>Status</th>
                            <th>Condominium</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $rowCount = $conn->query("SELECT facilities.*, condominium.condoName FROM facilities INNER JOIN condominium ON facilities.condoID = condominium.condoID WHERE facilitiesStatus != 'Removed'")->num_rows;
                        $total_rows = $conn->query("SELECT facilities.*, condominium.condoName FROM facilities INNER JOIN condominium ON facilities.condoID = condominium.condoID WHERE facilitiesStatus != 'Removed' AND facilitiesName LIKE '{$facilities}%' OR facilitiesStatus LIKE '{$facilities}%' OR condoName LIKE '{$facilities}%'")->num_rows;
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                        $num_results_on_page = 5;
                        if ($stmt = $conn->prepare("SELECT facilities.*, condominium.condoName FROM facilities INNER JOIN condominium ON facilities.condoID = condominium.condoID WHERE facilitiesStatus != 'Removed' AND facilitiesName LIKE '{$facilities}%' OR facilitiesStatus LIKE '{$facilities}%' OR condoName LIKE '{$facilities}%' ORDER BY facilitiesID LIMIT ?,?")) {
                        // Calculate the page to get the results we need from our table.
                        $calc_page = ($page - 1) * $num_results_on_page;
                        $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                        $stmt->execute();
                        // Get the results...
                        $result = $stmt->get_result();
                        // Loop through the data and output it in the table
                        if (mysqli_num_rows($result) > 0) {
                        while ($facilities = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td data-label="Action"><input type="radio" name="facilitiesID[]" value="<?=$facilities['facilitiesID']?>"></td>
                            <td data-label="Facilities"><?= $facilities['facilitiesName'] ?></td>
                            <td data-label="Status"><?= $facilities['facilitiesStatus'] ?></td>
                            <td data-label="Condominium"><?= $facilities['condoName'] ?></td>
                        </tr>
                        <?php } } else{ echo "<tr><td colspan='8' style='text-align:center' class='nodata'>No Data found</td></tr>"; } } ?>
                    </tbody>

                </table>

                <div class="rowPagination">
                    <?php if ($total_rows > $num_results_on_page): ?>
                        <div class="pagination">
                            <?php $total_pages = ceil($total_rows / $num_results_on_page); ?>
                            <?php if ($page > 1): ?>
                                <a href="?page=1">&laquo; </a>
                                <a href="?page=<?php echo $page - 1 ?>">&lsaquo; </a>
                            <?php endif; ?>

                            <?php
                            $start_page = max(1, min($page - 2, $total_pages - 4));
                            $end_page = min($start_page + 4, $total_pages);

                            for ($i = $start_page; $i <= $end_page; $i++):
                                ?>
                                <?php if ($i == $page): ?>
                                    <center><a href="#" class="current"><?php echo $i ?></a></center>
                                <?php else: ?>
                                    <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?php echo $page + 1 ?>"> &rsaquo;</a>
                                <a href="?page=<?php echo $total_pages ?>"> &raquo;</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                
            </div>
                <div class="rowbtn">
                    <button class="update" formaction="facilitiesUpdate.php" onclick="chkUpdateSelect()">Update</button>
                    <button class="delete" formaction="facilitiesDelete.php" onclick="confirmDelete()">Delete</button>
                    <button class="add" formaction="facilitiesAdd.php">Add</button>
                </div>
        </form>

<?php
}
?>


<?php
if (isset($_POST['condo'])) {
    $condo = $_POST['condo'];
        ?>

        <form method="post" id="condo">
                    <div class="row">
                        <table>

                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Condominium</th>
                                    <th>Block</th>
                                    <th>Floor</th>
                                    <th>Unit Per Floor</th>
                                    <th>Carpark Floor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $rowCount = $conn->query("SELECT * FROM condominium")->num_rows;
                                $total_rows = $conn->query("SELECT * FROM condominium WHERE condoName LIKE '{$condo}%' OR condoBlock LIKE '{$condo}%' OR condoFloor LIKE '{$condo}%' OR roomPerFloor LIKE '{$condo}%' OR condoStatus LIKE '{$condo}%'")->num_rows;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 5;
                                if ($stmt = $conn->prepare("SELECT * FROM condominium WHERE condoName LIKE '{$condo}%' OR condoBlock LIKE '{$condo}%' OR condoFloor LIKE '{$condo}%' OR roomPerFloor LIKE '{$condo}%' OR condoStatus LIKE '{$condo}%' ORDER BY condoStatus, condoID LIMIT ?,?")) {
                                // Calculate the page to get the results we need from our table.
                                $calc_page = ($page - 1) * $num_results_on_page;
                                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                                $stmt->execute();
                                // Get the results...
                                $result = $stmt->get_result();
                                // Loop through the data and output it in the table
                                if (mysqli_num_rows($result) > 0) {
                                while ($condo = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td data-label="Action"><input type="radio" name="condoID[]" value="<?=$condo['condoID']?>"></td>
                                    <td data-label="Condominium"><?= $condo['condoName'] ?></td>
                                    <td data-label="Block"><?= $condo['condoBlock'] ?></td>
                                    <td data-label="Floor"><?= $condo['condoFloor'] ?></td>
                                    <td data-label="Unit Per Floor"><?= $condo['roomPerFloor'] ?></td>
                                    <td data-label="Carpark Floor"><?= $condo['condoCarParkFloor'] ?></td>
                                    <td data-label="Status"><?= $condo['condoStatus'] ?></td>
                                </tr>
                                <?php } } else{ echo "<tr><td colspan='8' style='text-align:center' class='nodata'>No Data found</td></tr>"; } } ?>
                            </tbody>

                        </table>

                        <div class="rowPagination">
                            <?php if ($total_rows > $num_results_on_page): ?>
                                <div class="pagination">
                                    <?php $total_pages = ceil($total_rows / $num_results_on_page); ?>
                                    <?php if ($page > 1): ?>
                                        <a href="?page=1">&laquo; </a>
                                        <a href="?page=<?php echo $page - 1 ?>">&lsaquo; </a>
                                    <?php endif; ?>

                                    <?php
                                    $start_page = max(1, min($page - 2, $total_pages - 4));
                                    $end_page = min($start_page + 4, $total_pages);

                                    for ($i = $start_page; $i <= $end_page; $i++):
                                        ?>
                                        <?php if ($i == $page): ?>
                                            <center><a href="#" class="current"><?php echo $i ?></a></center>
                                        <?php else: ?>
                                            <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <a href="?page=<?php echo $page + 1 ?>"> &rsaquo;</a>
                                        <a href="?page=<?php echo $total_pages ?>"> &raquo;</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>


                    </div>
                        
                        <div class="rowbtn">
                            <button class="update" formaction="condoUpdate.php" onclick="chkUpdateSelect()">Update</button>
                            <button class="delete" formaction="condoDelete.php" onclick="confirmDelete()">Delete</button>
                            <button class="add" formaction="condoAdd.php">Add</button>
                        </div>
                </form>

<?php
}
?>



<?php
if (isset($_POST['reservation'])) {
    $reservation = $_POST['reservation'];
    $user = $_POST['user'];
    $queryOne = "";
    $queryTwo = "";
    $rowCount = "";
    
    
    if ($user == "staff") {
        $rowCount = $conn->query("SELECT reservation.*, facilities.*, owner.*, condominium.*, tenant.*
                                    FROM reservation
                                    INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                                    LEFT JOIN owner ON reservation.ownerID = owner.ownerID
                                    LEFT JOIN tenant ON reservation.tenantID = tenant.tenantID
                                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID")->num_rows;
        
        $queryOne = "SELECT reservation.*, facilities.*, owner.*, condominium.*, tenant.*
                        FROM reservation
                        INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                        LEFT JOIN owner ON reservation.ownerID = owner.ownerID
                        LEFT JOIN tenant ON reservation.tenantID = tenant.tenantID
                        INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                        WHERE facilities.facilitiesName LIKE '{$reservation}%' OR reservation.reservationDate LIKE '{$reservation}%' OR reservation.reservationStatus LIKE '{$reservation}%' OR condominium.condoName LIKE '{$reservation}%'";
                        
        $queryTwo = "SELECT reservation.*, facilities.*, owner.*, condominium.*, tenant.*
                        FROM reservation
                        INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                        LEFT JOIN owner ON reservation.ownerID = owner.ownerID
                        LEFT JOIN tenant ON reservation.tenantID = tenant.tenantID
                        INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                        WHERE facilities.facilitiesName LIKE '{$reservation}%' OR reservation.reservationDate LIKE '{$reservation}%' OR reservation.reservationStatus LIKE '{$reservation}%' OR condominium.condoName LIKE '{$reservation}%'
                        ORDER BY reservationStatus DESC, facilities.condoID, facilities.facilitiesName, reservationDate DESC, reservationEndTime DESC LIMIT ?,?";
                        
    } elseif ($user == "owner") {
        $userID = "";
        $whereText = "";
        if(isset($_SESSION['ownerEmail'])){
            $email = $_SESSION['ownerEmail'];
            $ownerSql = "SELECT * FROM owner WHERE ownerEmail='$email'";
            $ownerResult = mysqli_query($conn, $ownerSql);
            $ownerRow = mysqli_fetch_assoc($ownerResult);
            $userID = $ownerRow['ownerID'];
            $whereText = "ownerID";
            
        }elseif(isset($_SESSION['tenantID'])){
            $id = $_SESSION['tenantID'];
            $tenantSql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID WHERE tenantID='$id'";
            $tenantResult = mysqli_query($conn, $tenantSql);
            $tenantRow = mysqli_fetch_assoc($tenantResult);
            $userID = $tenantRow['tenantID'];
            $whereText = "tenantID";

        }
        
        $rowCount = $conn->query("SELECT reservation.*, facilities.*
                                    FROM reservation
                                    INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                                    WHERE ".$whereText." = $userID")->num_rows;
        
        $queryOne = "SELECT reservation.*, facilities.*
                        FROM reservation
                        INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                        WHERE ".$whereText." = $userID AND facilities.facilitiesName LIKE '{$reservation}%' OR reservation.reservationDate LIKE '{$reservation}%' OR reservation.reservationStatus LIKE '{$reservation}%'";
                        
        $queryTwo = "SELECT reservation.*, facilities.*
                        FROM reservation
                        INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                        WHERE ".$whereText." = $userID AND facilities.facilitiesName LIKE '{$reservation}%' OR reservation.reservationDate LIKE '{$reservation}%' OR reservation.reservationStatus LIKE '{$reservation}%'
                        ORDER BY reservationStatus DESC, facilities.facilitiesName, reservationDate DESC, reservationEndTime DESC LIMIT ?,?";
        
    }
?>

        <form method="post" id="reservation">
                    <div class="row">
                        <table>

                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Facilities</th>
                                    <th>Reservation Date</th>
                                    <th>Time</th>
                                    <th>Reservation Status</th>
                                    <?php if($user == "staff") :?>
                                    <th>Owner</th>
                                    <th>Tenant</th>
                                    <th>Condominium</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>

                            
                            
                            <tbody>
                                <?php
                                $total_rows = $conn->query($queryOne)->num_rows;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 5;
                                if ($stmt = $conn->prepare($queryTwo)) {
                                // Calculate the page to get the results we need from our table.
                                $calc_page = ($page - 1) * $num_results_on_page;
                                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                                $stmt->execute();
                                // Get the results...
                                $result = $stmt->get_result();
                                // Loop through the data and output it in the table
                                if (mysqli_num_rows($result) > 0) {
                                while ($reservation = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <?php if ($reservation['reservationStatus'] == "Pending") :?>
                                    <td data-label="Action"><input type="radio" name="reservationID[]" value="<?=$reservation['reservationID']?>"></td>
                                    <?php else : ?>
                                    <td data-label="Action"></td>
                                    <?php endif; ?>
                                    
                                    <td data-label="Facilities"><?= $reservation['facilitiesName'] ?></td>
                                    <td data-label="Reservation Date"><?= $reservation['reservationDate'] ?></td>
                                    <?php 
                                    $startTime = strtotime($reservation['reservationStartTime']);
                                    $endTime = strtotime($reservation['reservationEndTime']);
                                    echo '<td data-label="Time">'.date('H:i', $startTime) . '~' . date('H:i', $endTime).'</td>';
                                    ?>
                                    <td data-label="Status"><?= $reservation['reservationStatus'] ?></td>
                                    <?php if($user == "staff") :?>
                                    <td data-label="Owner"><?php echo $reservation['ownerFName']." ".$reservation['ownerLName'] ?></td>
                                    <td data-label="Tenant"><?= $reservation['tenantName'] ?></td>
                                    <td data-label="Condominium"><?= $reservation['condoName'] ?></td>
                                    <?php endif; ?>
                                </tr>
                                <?php } } else{ echo "<tr><td colspan='8' style='text-align:center' class='nodata'>No Data found</td></tr>"; } } ?>
                            </tbody>

                        </table>

                        <div class="rowPagination">
                            <?php if ($total_rows > $num_results_on_page): ?>
                                <div class="pagination">
                                    <?php $total_pages = ceil($total_rows / $num_results_on_page); ?>
                                    <?php if ($page > 1): ?>
                                        <a href="?page=1">&laquo; </a>
                                        <a href="?page=<?php echo $page - 1 ?>">&lsaquo; </a>
                                    <?php endif; ?>

                                    <?php
                                    $start_page = max(1, min($page - 2, $total_pages - 4));
                                    $end_page = min($start_page + 4, $total_pages);

                                    for ($i = $start_page; $i <= $end_page; $i++):
                                        ?>
                                        <?php if ($i == $page): ?>
                                            <center><a href="#" class="current"><?php echo $i ?></a></center>
                                        <?php else: ?>
                                            <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <a href="?page=<?php echo $page + 1 ?>"> &rsaquo;</a>
                                        <a href="?page=<?php echo $total_pages ?>"> &raquo;</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>


                    </div>
                        <div class="rowbtn">
                            <button class="cancel" formaction="reservationCancel.php?user='Staff'" onclick="confirmCancellation()">Cancel</button>
                            <?php if($user == "owner"):?>
                            <button class="add" formaction="reservationAdd.php">Add</button>
                            <?php endif;?>
                        </div>
                </form>
<?php 
}
?>


<?php
if (isset($_POST['visitor'])) {
    $visitor = $_POST['visitor'];
    $user = $_POST['user'];
    $queryOne = "";
    $queryTwo = "";
    $rowCount = "";
    $detailLocation = "";
    
    if ($user == "staff") {
        $detailLocation = "visitorDetail.php";
        $rowCount = $conn->query("SELECT * 
                                    FROM visitor
                                    LEFT JOIN owner ON visitor.ownerID = owner.ownerID
                                    LEFT JOIN tenant ON visitor.tenantID = tenant.tenantID
                                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID")->num_rows;
        
        $queryOne = "SELECT * 
                        FROM visitor
                        LEFT JOIN owner ON visitor.ownerID = owner.ownerID
                        LEFT JOIN tenant ON visitor.tenantID = tenant.tenantID
                        INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                        WHERE visitorName LIKE '{$visitor}%' OR visitorContact LIKE '{$visitor}%' OR visitDate LIKE '{$visitor}%' OR visitorCarpark LIKE '{$visitor}%' OR visitorCarNo LIKE '{$visitor}%' OR condominium.condoName LIKE '{$visitor}%'";
        
        $queryTwo = "SELECT * 
                        FROM visitor
                        LEFT JOIN owner ON visitor.ownerID = owner.ownerID
                        LEFT JOIN tenant ON visitor.tenantID = tenant.tenantID
                        INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                        WHERE visitorName LIKE '{$visitor}%' OR visitorContact LIKE '{$visitor}%' OR visitDate LIKE '{$visitor}%' OR visitorCarpark LIKE '{$visitor}%' OR visitorCarNo LIKE '{$visitor}%' OR condominium.condoName LIKE '{$visitor}%'
                        ORDER BY CASE WHEN visitorStatus = 'Pending' THEN 1 ELSE 2 END, visitorStatus DESC, condominium.condoID, visitDate DESC LIMIT ?,?";
                        
    } elseif ($user == "owner") {
        $userID = "";
        $whereText = "";
        if(isset($_SESSION['ownerEmail'])){
            $email = $_SESSION['ownerEmail'];
            $ownerSql = "SELECT * FROM owner WHERE ownerEmail='$email'";
            $ownerResult = mysqli_query($conn, $ownerSql);
            $ownerRow = mysqli_fetch_assoc($ownerResult);
            $userID = $ownerRow['ownerID'];
            $whereText = "ownerID";
            
        }elseif(isset($_SESSION['tenantID'])){
            $id = $_SESSION['tenantID'];
            $tenantSql = "SELECT * FROM tenant INNER JOIN owner ON tenant.ownerID = owner.ownerID WHERE tenantID='$id'";
            $tenantResult = mysqli_query($conn, $tenantSql);
            $tenantRow = mysqli_fetch_assoc($tenantResult);
            $userID = $tenantRow['tenantID'];
            $whereText = "tenantID";

        }
        
        $rowCount = $conn->query("SELECT * FROM visitor WHERE ".$whereText." = $userID")->num_rows;
        
        $queryOne = "SELECT * FROM visitor WHERE ".$whereText." = $userID
                        AND visitorName LIKE '{$visitor}%' OR visitorContact LIKE '{$visitor}%' OR visitDate LIKE '{$visitor}%' OR visitorCarpark LIKE '{$visitor}%' OR visitorCarNo LIKE '{$visitor}%'";
        
        $queryTwo = "SELECT * FROM visitor WHERE ".$whereText." = $userID 
                        AND visitorName LIKE '{$visitor}%' OR visitorContact LIKE '{$visitor}%' OR visitDate LIKE '{$visitor}%' OR visitorCarpark LIKE '{$visitor}%' OR visitorCarNo LIKE '{$visitor}%'
                        ORDER BY CASE WHEN visitorStatus = 'Pending' THEN 1 ELSE 2 END, visitorStatus DESC LIMIT ?,?";
        
    }
        
        ?>

        <form method="post" id="visitor">
                    <div class="row">
                        <table>

                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Visitor Name</th>
                                    <th>Visit Date & Time</th>
                                    <th>Car Number</th>
                                    <th>Status</th>
                                    <?php if($user == "staff"):?>
                                    <th>Owner</th>
                                    <th>Tenant</th>
                                    <th>Condominium</th>
                                    <?php endif;?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $total_rows = $conn->query($queryOne)->num_rows;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 5;
                                if ($stmt = $conn->prepare($queryTwo)) {
                                // Calculate the page to get the results we need from our table.
                                $calc_page = ($page - 1) * $num_results_on_page;
                                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                                $stmt->execute();
                                // Get the results...
                                $result = $stmt->get_result();
                                // Loop through the data and output it in the table
                                if (mysqli_num_rows($result) > 0) {
                                while ($visitor = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <?php if ($visitor['visitorStatus'] == "Pending") :?>
                                    <td data-label="Action"><input type="radio" name="visitorID[]" value="<?=$visitor['visitorID']?>"></td>
                                    <?php else : ?>
                                    <td data-label="Action"></td>
                                    <?php endif; ?>
                                    
                                    <td data-label="Visitor Name"><a href="<?= $detailLocation?>?vID=<?= $visitor['visitorID'] ?>&user='staff'"><?= $visitor['visitorName'] ?></a></td>
                                    <?php $time = strtotime($visitor['visitTime']);?>
                                    <td data-label="Visit Date & Time"><?php echo $visitor['visitDate']." ".date( 'H:i', $time)  ?></td>
                                    <td data-label="Car Number"><?= $visitor['visitorCarNo'] ?></td>
                                    <td data-label="Status"><?= $visitor['visitorStatus'] ?></td>
                                    <?php if($user == "staff"):?>
                                    <td data-label="Owner"><?php echo $visitor['ownerFName']." ".$visitor['ownerLName'] ?></td>
                                    <td data-label="Tenant"><?= $visitor['tenantName'] ?></td>
                                    <td data-label="Condominium"><?= $visitor['condoName'] ?></td>
                                    <?php endif;?>
                                    
                                </tr>
                                <?php } } else{ echo "<tr><td colspan='10' style='text-align:center' class='nodata'>No Data found</td></tr>"; } } ?>
                            </tbody>

                        </table>

                        <div class="rowPagination">
                        <?php if ($total_rows > $num_results_on_page): ?>

                            <div class="pagination">
                                <?php $total_pages = ceil($total_rows / $num_results_on_page); ?>
                                <?php if ($page > 1): ?>

                                    <a href="?page=1">&laquo; First</a>
                                    <a href="?page=<?php echo $page - 1 ?>">&lsaquo; Prev</a>

                                <?php endif; ?>
                                <?php for ($i = max(1, $page - 5); $i <= min($page + 5, $total_pages); $i++): ?>
                                    <?php if ($i == $page): ?>
                                        <center>
                                            <a href="#" class="current"><?php echo $i ?></a>
                                        </center>
                                    <?php else: ?>

                                        <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>

                                    <?php endif; ?>
                                <?php endfor; ?>
                                <?php if ($page < $total_pages): ?>

                                    <a href="?page=<?php echo $page + 1 ?>">Next &rsaquo;</a>
                                    <a href="?page=<?php echo $total_pages ?>">Last &raquo;</a>

                                <?php endif; ?>

                            <?php endif; ?>
                            </div>
                        </div>


                    </div>
                    
                    <div class="rowbtn">
                        <?php if($user == "staff"):?>
                        <button class="add" formaction="visitorRegStaff.php">Register</button>
                        <?php endif?>
                        <button class="update" formaction="visitorStatusToVisited.php" onclick="chkUpdateSelect()">Visited</button>
                        <button class="delete" formaction="visitorDelete.php?user='staff'" onclick="confirmDelete()">Delete</button>
                    </div>
        </form>
<?php
}
?>


<?php
if (isset($_POST['ec'])) {
    $ec = $_POST['ec'];
    
    $query = "SELECT * FROM condominium WHERE condoStatus = 'Available'";
    $resultCondo = mysqli_query($conn, $query);
    $condo = array();

    while($data = mysqli_fetch_assoc($resultCondo)){
        $condo[] = $data;
    }

    $countCondo = mysqli_num_rows($resultCondo);    
        ?>

        <form method="post" id="ec">
                    <div class="row">
                        <table>

                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Whatsapp</th>
                                    <th>Guard House Contact</th>
                                    <th>Email</th>
                                    <th colspan="4">Address</th>
                                    <th>Condominium</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $rowCount = $conn->query("SELECT * FROM emergencyContact 
                                                            INNER JOIN condominium ON emergencyContact.condoID = condominium.condoID
                                                            WHERE condominium.condoStatus = 'Available'")->num_rows;
                                
                                $total_rows = $conn->query("SELECT * FROM emergencyContact 
                                                            INNER JOIN condominium ON emergencyContact.condoID = condominium.condoID
                                                            WHERE condominium.condoStatus = 'Available' 
                                                            AND condominium.condoName LIKE '{$ec}%' OR emergencyContact.ecWhatsapp LIKE '{$ec}%' OR emergencyContact.ecSecurity LIKE '{$ec}%' OR emergencyContact.ecEmail LIKE '{$ec}%'")->num_rows;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 5;
                                if ($stmt = $conn->prepare("SELECT * FROM emergencyContact 
                                                            INNER JOIN condominium ON emergencyContact.condoID = condominium.condoID 
                                                            WHERE condominium.condoStatus = 'Available'
                                                            AND condominium.condoName LIKE '{$ec}%' OR emergencyContact.ecWhatsapp LIKE '{$ec}%' OR emergencyContact.ecSecurity LIKE '{$ec}%' OR emergencyContact.ecEmail LIKE '{$ec}%'
                                                            ORDER BY ecID LIMIT ?,?")) {
                                // Calculate the page to get the results we need from our table.
                                $calc_page = ($page - 1) * $num_results_on_page;
                                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                                $stmt->execute();
                                // Get the results...
                                $result = $stmt->get_result();
                                // Loop through the data and output it in the table
                                if (mysqli_num_rows($result) > 0) {
                                while ($ec = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td data-label="Action"><input type="radio" name="ecID[]" value="<?=$ec['ecID']?>"></td>
                                    <td data-label="Whastapp"><?= $ec['ecWhatsapp'] ?></td>
                                    <td data-label="Guard House Contact"><?= $ec['ecSecurity'] ?></td>
                                    <td data-label="Email"><?= $ec['ecEmail'] ?></td>
                                    <td colspan="4" data-label="Address"><?= $ec['ecAddress'] ?></td>
                                    <td data-label="Condominium"><?= $ec['condoName'] ?></td>
                                </tr>
                                <?php } } else{ echo "<tr><td colspan='12' style='text-align:center' class='nodata'>No Data found</td></tr>"; } } ?>
                            </tbody>

                        </table>

                        <div class="rowPagination">
                            <?php if ($total_rows > $num_results_on_page): ?>
                                <div class="pagination">
                                    <?php $total_pages = ceil($total_rows / $num_results_on_page); ?>
                                    <?php if ($page > 1): ?>
                                        <a href="?page=1">&laquo; </a>
                                        <a href="?page=<?php echo $page - 1 ?>">&lsaquo; </a>
                                    <?php endif; ?>

                                    <?php
                                    $start_page = max(1, min($page - 2, $total_pages - 4));
                                    $end_page = min($start_page + 4, $total_pages);

                                    for ($i = $start_page; $i <= $end_page; $i++):
                                        ?>
                                        <?php if ($i == $page): ?>
                                            <center><a href="#" class="current"><?php echo $i ?></a></center>
                                        <?php else: ?>
                                            <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <a href="?page=<?php echo $page + 1 ?>"> &rsaquo;</a>
                                        <a href="?page=<?php echo $total_pages ?>"> &raquo;</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>


                    </div>
                        <div class="rowbtn">
                            <?php if($countCondo == mysqli_num_rows($result)) :?>
                            <?php else :?>
                            <button class="add" formaction="eContactAdd.php">Add</button>
                            <?php endif;?>
                            <button class="update" formaction="eContactEdit.php" onclick="chkUpdateSelect()">Edit</button>
                            <button class="delete" formaction="eContactDelete.php" onclick="confirmDelete()">Delete</button>
                        </div>
                </form>
<?php
   
}
?>