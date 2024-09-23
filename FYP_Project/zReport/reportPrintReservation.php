<?php

require ("../fpdf/fpdf.php");

include '../connection.php';

date_default_timezone_set("Asia/Kuala_Lumpur");   

$reservation = array();    
$orderByFacilities = array();    

$randomNumber = rand(1000, 9999);
$date = date('Y/m/d');
$reportNo = "10" . $randomNumber;
$count = 0;
$totalReservationCount = 0;
$totalCondoCount = 0;
$totalPendingCount = 0;
$totalApprovedCount = 0;
$totalCanceledCount = 0;
$totalBBQCount = 0;
$totalBadmintonCount = 0;
$totalHallCount = 0;
$condoData = [];

if (isset($_POST['reportType'])) {
    $reportType = $_POST['reportType'];
    
    $companyQuery = "SELECT * FROM company WHERE companyStatus = 'Available'";
    $companyResult = mysqli_query($conn, $companyQuery);
    $company = mysqli_fetch_assoc($companyResult);
    
    
    if ($reportType == "Annual" && isset($_POST['reportYear'])) {
        $year = $_POST['reportYear'];
        $yearMonth = $_POST['reportYear'];
        
        $query = "SELECT c.condoID, c.condoName, COUNT(r.reservationID) AS reservationCount
          FROM condominium c
          LEFT JOIN facilities f ON c.condoID = f.condoID
          LEFT JOIN reservation r ON f.facilitiesID = r.facilitiesID
          WHERE YEAR(reservationDate) = '$year' AND c.condoStatus != 'Removed'
          GROUP BY c.condoID";
        $result = mysqli_query($conn, $query);
        
        $query1 = "SELECT *
                    FROM reservation
                    INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                    LEFT JOIN owner ON reservation.ownerID = owner.ownerID
                    LEFT JOIN tenant ON reservation.tenantID = tenant.tenantID
                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                    WHERE YEAR(reservationDate) = '$year' AND condominium.condoStatus != 'Removed'
                    ORDER BY COALESCE(owner.condoID, tenant.condoID), reservationDate;
                    ";
        $result1 = mysqli_query($conn, $query1);

        while ($data = mysqli_fetch_assoc($result1)) {
            $reservation[] = $data;
            $count++;
        }

    } elseif ($reportType == "Monthly" && isset($_POST['reportMonth'])) {
        $currentYear = date("Y");
        $month = $_POST['reportMonth'];
        $yearMonth = $_POST['reportMonth'];
        
        switch ($yearMonth) {
            case "01":
                $yearMonth = "January";
                break;
            case "02":
                $yearMonth = "February";
                break;
            case "03":
                $yearMonth = "March";
                break;
            case "04":
                $yearMonth = "April";
                break;
            case "05":
                $yearMonth = "May";
                break;
            case "06":
                $yearMonth = "June";
                break;
            case "07":
                $yearMonth = "July";
                break;
            case "08":
                $yearMonth = "August";
                break;
            case "09":
                $yearMonth = "September";
                break;
            case "10":
                $yearMonth = "October";
                break;
            case "11":
                $yearMonth = "November";
                break;
            case "12":
                $yearMonth = "December";
                break;
            default:
                // handle invalid month
                break;
        }
        
        
        $query = "SELECT c.condoID, c.condoName, r.*, COUNT(r.reservationID) AS reservationCount
          FROM condominium c
          LEFT JOIN facilities f ON c.condoID = f.condoID
          LEFT JOIN reservation r ON f.facilitiesID = r.facilitiesID
          WHERE MONTH(reservationDate) = '$month' AND YEAR(reservationDate) = '$currentYear' AND c.condoStatus != 'Removed'
          GROUP BY c.condoID";
        $result = mysqli_query($conn, $query);
        
        $query1 = "SELECT *
                    FROM reservation
                    INNER JOIN facilities ON reservation.facilitiesID = facilities.facilitiesID
                    LEFT JOIN owner ON reservation.ownerID = owner.ownerID
                    LEFT JOIN tenant ON reservation.tenantID = tenant.tenantID
                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                    WHERE MONTH(reservationDate) = '$month' AND YEAR(reservationDate) = '$currentYear' AND condominium.condoStatus != 'Removed'
                    ORDER BY COALESCE(owner.condoID, tenant.condoID), reservationDate;
                    ";
        $result1 = mysqli_query($conn, $query1);

        while ($data = mysqli_fetch_assoc($result1)) {
            $reservation[] = $data;
            $count++;
        }
    }
    
    
    while ($row = mysqli_fetch_assoc($result)) {
        $condoID = $row['condoID'];
        $condoName = $row['condoName'];
        $reservationCount = $row['reservationCount'];

        // Add to total counts
        $totalReservationCount += $reservationCount;
        $totalCondoCount++;

        if ($reportType == "Annual" && isset($_POST['reportYear'])) {
            $year = $_POST['reportYear'];
            $facilitiesQuery = "SELECT f.facilitiesType, COUNT(r.reservationID) AS facilityCount,
                                    SUM(CASE WHEN r.reservationStatus = 'Pending' THEN 1 ELSE 0 END) AS pendingCount,
                                    SUM(CASE WHEN r.reservationStatus = 'Approved' THEN 1 ELSE 0 END) AS approvedCount,
                                    SUM(CASE WHEN r.reservationStatus = 'Canceled' THEN 1 ELSE 0 END) AS canceledCount
                            FROM facilities f
                            LEFT JOIN reservation r ON f.facilitiesID = r.facilitiesID
                            LEFT JOIN condominium c ON f.condoID = c.condoID
                            WHERE f.condoID = '$condoID' AND f.facilitiesType != 'Swimming Pool' AND f.facilitiesType != 'Gym Room'  AND c.condoStatus != 'Removed' AND YEAR(r.reservationDate) = '$year'
                            GROUP BY f.facilitiesType";  
        }
        elseif($reportType == "Monthly" && isset($_POST['reportMonth'])) {
            $currentYear = date("Y");
            $month = $_POST['reportMonth'];

            $facilitiesQuery = "SELECT f.facilitiesType, COUNT(r.reservationID) AS facilityCount,
                                        SUM(CASE WHEN r.reservationStatus = 'Pending' THEN 1 ELSE 0 END) AS pendingCount,
                                        SUM(CASE WHEN r.reservationStatus = 'Approved' THEN 1 ELSE 0 END) AS approvedCount,
                                        SUM(CASE WHEN r.reservationStatus = 'Canceled' THEN 1 ELSE 0 END) AS canceledCount
                               FROM facilities f
                               LEFT JOIN reservation r ON f.facilitiesID = r.facilitiesID
                               LEFT JOIN condominium c ON f.condoID = c.condoID
                               WHERE f.condoID = '$condoID' AND f.facilitiesType != 'Swimming Pool' AND f.facilitiesType != 'Gym Room'  AND c.condoStatus != 'Removed' AND MONTH(r.reservationDate) = '$month' AND YEAR(r.reservationDate) = '$currentYear'
                               GROUP BY f.facilitiesType";
        }
        // Retrieve facilities data for the current condo
        

        $facilitiesResult = mysqli_query($conn, $facilitiesQuery);
        $facilitiesData = [];

        while ($facilityRow = mysqli_fetch_assoc($facilitiesResult)) {
            $facilitiesType = $facilityRow['facilitiesType'];
            $facilityCount = $facilityRow['facilityCount'];
            $pendingCount = $facilityRow['pendingCount'];
            $approvedCount = $facilityRow['approvedCount'];
            $canceledCount = $facilityRow['canceledCount'];

            // Add to total counts based on facility type
            switch ($facilitiesType) {
                case 'BBQ':
                    $totalBBQCount += $facilityCount;
                    break;
                case 'Badminton Court':
                    $totalBadmintonCount += $facilityCount;
                    break;
                case 'Hall':
                    $totalHallCount += $facilityCount;
                    break;
            }

            // Add to total counts for all facility types
            $totalPendingCount += $pendingCount;
            $totalApprovedCount += $approvedCount;
            $totalCanceledCount += $canceledCount;

            // Store facilities data in an array
            $facilitiesData[] = [
                'cfType' => $facilitiesType,
                'cfCount' => $facilityCount,
                'pendingCount' => $pendingCount,
                'approvedCount' => $approvedCount,
                'canceledCount' => $canceledCount,
            ];
        }

        // Store condo data in the main array
        $condoData[] = [
            'condoID' => $condoID,
            'condoName' => $condoName,
            'reservationCount' => $reservationCount,
            'facilities' => $facilitiesData,
        ];
    }

}


$info = [
    "count" => $count,
    "reportNo" => $reportNo,
    "reportDate" => $date,
    "approve" => $totalApprovedCount,
    "pending" => $totalPendingCount,
    "cancel" => $totalCanceledCount,
    "BBQ" => $totalBBQCount,
    "Badminton" => $totalBadmintonCount,
    "Hall" => $totalHallCount,
    
];


class PDF extends FPDF {

    function Header() {
        
    }

    function body($info, $content, $company, $reportType, $yearMonth, $condoData) {

        //Display Company Info
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(280, 5, $company['companyName'], 0, 1, "C");
        $this->SetFont('Arial', '', 9.5);
        $this->Cell(280, 15, $company['companyAddress'], 0, 1, "C");


        $this->SetFont('Arial', 'B', 18);
        $this->Cell(280, 10, "Reservation ".$reportType." Report"."_".$yearMonth, 0, 1, "C");

        //Display Horizontal line
        $this->Line(0, 40, 300, 40);
        $this->Cell(20, 9, "", "", 1, "");
        
        
        //Display Invoice no
        $this->SetY(5);
        $this->SetX(5);
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 7, "Report No  : " . $info["reportNo"]);

        //Display Invoice date
        $this->SetY(12);
        $this->SetX(5);
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 7, "Date           : " . $info["reportDate"]);

        //Display Invoice date
        $this->SetY(19);
        $this->SetX(5);
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 7, "Contact      : " . $company["companyContact"]);
        
        //Display Invoice date
        $this->SetY(26);
        $this->SetX(5);
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 7, "Email         : " . $company["companyEmail"]);
        
        //Display Table headings
        $this->SetY(55);
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(10, 9, "No", 1, 0, "C");
        $this->Cell(40, 9, "Condominium", 1, 0, "C");
        $this->Cell(40, 9, "Facilities", 1, 0, "C");
        $this->Cell(30, 9, "Date", 1, 0, "C");
        $this->Cell(30, 9, "Time", 1, 0, "C");
        $this->Cell(30, 9, "Status", 1, 0, "C");
        $this->Cell(50, 9, "Owner", 1, 0, "C");
        $this->Cell(50, 9, "Tenant", 1, 1, "C");
        $this->SetFont('Arial', '', 12);
        
        //Display table product rows
        $no = 1;
        foreach ($content as $row) {
            $startTime = strtotime($row['reservationStartTime']);
            $endTime = strtotime($row['reservationEndTime']);
            $time = date('H:i', $startTime) . '~' . date('H:i', $endTime);
            $this->Cell(10, 9, $no, "LR", 0, "C");
            $this->Cell(40, 9, $row['condoName'], "R", 0, "C");
            $this->Cell(40, 9, $row['facilitiesName'], "R", 0, "C");
            $this->Cell(30, 9, $row['reservationDate'], "R", 0, "C");
            $this->Cell(30, 9, $time, "R", 0, "C");
            $this->Cell(30, 9, $row['reservationStatus'], "R", 0, "C");
            $this->Cell(50, 9, $row['ownerFName']." ".$row['ownerLName'], "R", 0, "C");
            $this->Cell(50, 9, $row['tenantName'], "R", 1, "C");
            $no++;
        }
        $no--;
        //Display table empty rows
        for ($i = 0; $i < 6 - count($content); $i++) {
            $this->Cell(10, 9, "", "LR", 0);
            $this->Cell(40, 9, "", "R", 0, "R");
            $this->Cell(40, 9, "", "R", 0, "R");
            $this->Cell(30, 9, "", "R", 0, "R");
            $this->Cell(30, 9, "", "R", 0, "R");
            $this->Cell(30, 9, "", "R", 0, "R");
            $this->Cell(50, 9, "", "R", 0, "R");
            $this->Cell(50, 9, "", "R", 1, "R");
        }

        //Display table total row
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(250, 9, "TOTAL RECORD ", 1, 0, "R");
        $this->Cell(30, 9, $info["count"], 1, 1, "C");

        $remainingSpace = $this->GetPageHeight() - $this->GetY();
        $spaceRequired = 180; // Adjust this value based on your table height

        if ($remainingSpace < $spaceRequired) {
            $this->AddPage(); // Start a new page
        }
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(280, 20, "", 0, 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 15, "Report  Summary", 0, 1, "L");

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Reservation Status", 1, 0, "C");
        $this->Cell(20, 9, "Count", 1, 1, "C");


        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Total Pending", "LR", 0, "C");
        $this->Cell(20, 9, $info["pending"], "R", 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Total Approved", "LR", 0, "C");
        $this->Cell(20, 9, $info["approve"], "R", 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Total Canceled", "LR", 0, "C");
        $this->Cell(20, 9, $info["cancel"], "R", 1, "C");
        
        
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Facilities", 1, 0, "C");
        $this->Cell(20, 9, "Count", 1, 1, "C");
        
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "BBQ", "LR", 0, "C");
        $this->Cell(20, 9, $info["BBQ"], "R", 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Badminton", "LR", 0, "C");
        $this->Cell(20, 9, $info["Badminton"], "R", 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Hall", "LR", 0, "C");
        $this->Cell(20, 9, $info["Hall"], "R", 1, "C");
        
        
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Condo", 1, 0, "C");
        $this->Cell(20, 9, "Count", 1, 1, "C");
        foreach($condoData as $cd){
            $this->Cell(40, 9, "", "", 0);
            $this->Cell(170, 9, $cd['condoName'], "LR", 0, "C");
            $this->Cell(20, 9, $cd['reservationCount'], "R", 1, "C");
        }

        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Total Record ", 1, 0, "R");
        $this->Cell(20, 9, $info["count"], 1, 0, "C");
        
        foreach ($condoData as $cd){
            $remainingSpace = $this->GetPageHeight() - $this->GetY();
            $spaceRequired = 180; // Adjust this value based on your table height

            if ($remainingSpace < $spaceRequired) {
                $this->AddPage(); // Start a new page
            }
            $this->Cell(280,40, "", 0, 1, "C");
            $this->Cell(40, 9, "", "", 0);
            $this->Cell(170, 9, $cd['condoName'], 1, 0, "L");
            $this->Cell(20, 9, "Count", 1, 1, "C");
            
            foreach ($cd['facilities'] as $fs){
                $this->Cell(40, 9, "", "", 0);
                $this->Cell(170, 9, $fs['cfType'], 1, 0, "L");
                $this->Cell(20, 9, $fs['cfCount'], 1, 1, "C");
                
                $this->Cell(40, 9, "", "", 0);
                $this->Cell(170, 9, "Total Pending", "LR", 0, "C");
                $this->Cell(20, 9, $fs["pendingCount"], "R", 1, "C");
                $this->Cell(40, 9, "", "", 0);
                $this->Cell(170, 9, "Total Approved", "LR", 0, "C");
                $this->Cell(20, 9, $fs["approvedCount"], "R", 1, "C");
                $this->Cell(40, 9, "", "", 0);
                $this->Cell(170, 9, "Total Canceled", "LR", 0, "C");
                $this->Cell(20, 9, $fs["canceledCount"], "R", 1, "C");
            }
            
            $this->Cell(40, 9, "", "", 0);
            $this->Cell(170, 9, "Total Record ", 1, 0, "R");
            $this->Cell(20, 9, $cd['reservationCount'], 1, 0, "C");
        }

    }

    function Footer() {

        //Display Footer Text
        $this->SetY(-10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, "This is a computer generated report", 0, 1, "C");
    }

}


//Create A4 Page with Portrait 
$pdf = new PDF("P", "mm", "A3");
$pdf->AddPage();
$pdf->body($info, $reservation, $company, $reportType, $yearMonth, $condoData);
// your PDF generation code here
$pdf->Output(); // generate PDF output
?>