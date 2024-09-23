<?php

require ("../fpdf/fpdf.php");

include '../connection.php';

$visitor = array();    
   
$randomNumber = rand(1000, 9999);
$date = date('Y/m/d');
$reportNo = "10" . $randomNumber;
$count = 0;

$totalVisitorCount = 0;
$totalCondoVisitorCount = 0;
$totalCarparkYesCount = 0;
$totalCarparkNoCount = 0;
$totalPendingCount = 0;
$totalVisitedCount = 0;
$totalCanceledCount = 0;

$condoVisitorData = [];



if (isset($_POST['reportType'])) {
    $reportType = $_POST['reportType'];
    
    $companyQuery = "SELECT * FROM company WHERE companyStatus = 'Available'";
    $companyResult = mysqli_query($conn, $companyQuery);
    $company = mysqli_fetch_assoc($companyResult);
    
    
    if ($reportType == "Annual" && isset($_POST['reportYear'])) {
        $year = $_POST['reportYear'];
        $yearMonth = $_POST['reportYear'];
        
        
        $query = "SELECT COALESCE(o.condoID, t.condoID) AS condoID, c.condoName, COUNT(*) AS condoVisitorCount
                    FROM visitor v
                    LEFT JOIN owner o ON v.ownerID = o.ownerID
                    LEFT JOIN tenant t ON v.tenantID = t.tenantID
                    LEFT JOIN condominium c ON COALESCE(o.condoID, t.condoID) = c.condoID
                    WHERE YEAR(visitDate) = '$year' AND c.condoStatus != 'Removed'
                    GROUP BY condoID";
        $result = mysqli_query($conn, $query);
        
        $query1 = "SELECT *
                    FROM visitor
                    LEFT JOIN owner ON visitor.ownerID = owner.ownerID
                    LEFT JOIN tenant ON visitor.tenantID = tenant.tenantID
                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                    WHERE YEAR(visitDate) = '$year' AND condominium.condoStatus != 'Removed'
                    ORDER BY COALESCE(owner.condoID, tenant.condoID), visitDate;
                    ";
        $result1 = mysqli_query($conn, $query1);

        while ($data = mysqli_fetch_assoc($result1)) {
            $visitor[] = $data;
        }
        
        
        
    } elseif ($reportType == "Monthly" && isset($_POST['reportMonth'])) {
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
        
        $query = "SELECT COALESCE(o.condoID, t.condoID) AS condoID, c.condoName, COUNT(*) AS condoVisitorCount
                    FROM visitor v
                    LEFT JOIN owner o ON v.ownerID = o.ownerID
                    LEFT JOIN tenant t ON v.tenantID = t.tenantID
                    LEFT JOIN condominium c ON COALESCE(o.condoID, t.condoID) = c.condoID
                    WHERE MONTH(visitDate) = '$month' AND c.condoStatus != 'Removed'
                    GROUP BY condoID";
        $result = mysqli_query($conn, $query);
        
        $query1 = "SELECT *
                    FROM visitor
                    LEFT JOIN owner ON visitor.ownerID = owner.ownerID
                    LEFT JOIN tenant ON visitor.tenantID = tenant.tenantID
                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                    WHERE MONTH(visitDate) = '$month' AND condominium.condoStatus != 'Removed'
                    ORDER BY COALESCE(owner.condoID, tenant.condoID), visitDate;
                    ";
        $result1 = mysqli_query($conn, $query1);

        while ($data = mysqli_fetch_assoc($result1)) {
            $visitor[] = $data;
        }
        

    }
    
    
    while ($row = mysqli_fetch_assoc($result)) {
        $condoID = $row['condoID'];
        $condoName = $row['condoName'];
        $condoVisitorCount = $row['condoVisitorCount'];

        // Add to total counts
        $totalVisitorCount += $condoVisitorCount;
        $totalCondoVisitorCount += $condoVisitorCount;

        // Retrieve visitor data for the current condo
       $visitorQuery = "SELECT COUNT(*) AS count, c.condoID, c.condoName,
                        SUM(CASE WHEN v.visitorCarpark = 'Y' THEN 1 ELSE 0 END) AS carparkY,
                        SUM(CASE WHEN v.visitorCarpark = 'N' THEN 1 ELSE 0 END) AS carparkN,
                        SUM(CASE WHEN v.visitorStatus = 'Pending' THEN 1 ELSE 0 END) AS pendingCount,
                        SUM(CASE WHEN v.visitorStatus = 'Visited' THEN 1 ELSE 0 END) AS visitedCount,
                        SUM(CASE WHEN v.visitorStatus = 'Canceled' THEN 1 ELSE 0 END) AS canceledCount
                        FROM visitor v
                        LEFT JOIN owner o ON v.ownerID = o.ownerID
                        LEFT JOIN tenant t ON v.tenantID = t.tenantID
                        INNER JOIN condominium c ON COALESCE(o.condoID, t.condoID) = c.condoID
                        WHERE COALESCE(o.condoID, t.condoID) = $condoID AND c.condoStatus != 'Removed'
                        GROUP BY c.condoID, v.visitorCarpark";
        $visitorResult = mysqli_query($conn, $visitorQuery);

        $visitorData = [];

        while ($visitorRow = mysqli_fetch_assoc($visitorResult)) {

            $count = $visitorRow['count'];

            $carparkY = $visitorRow['carparkY'];
            $carparkN = $visitorRow['carparkN'];
            $pendingCount = $visitorRow['pendingCount'];
            $visitedCount = $visitorRow['visitedCount'];
            $canceledCount = $visitorRow['canceledCount'];

            $totalCarparkYesCount += $carparkY;
            $totalCarparkNoCount += $carparkN;
            $totalPendingCount += $pendingCount;
            $totalVisitedCount += $visitedCount;
            $totalCanceledCount += $canceledCount;


            $visitorData[] = [
                'cvCarparkY' => $carparkY,
                'cvCarparkN' => $carparkN,
                'pendingCount' => $pendingCount,
                'visitedCount' => $visitedCount,
                'canceledCount' => $canceledCount,
            ];
        }

        // Add condoData to the main array
        $condoVisitorData[] = [
            'condoID' => $condoID,
            'condoName' => $condoName,
            'condoVisitorCount' => $condoVisitorCount,
            'visitor' => $visitorData,
        ];
    }

}



$info = [
    "count" => $totalVisitorCount,
    "reportNo" => $reportNo,
    "reportDate" => $date,
    "visited" => $totalVisitedCount,
    "pending" => $totalPendingCount,
    "cancel" => $totalCanceledCount,
    "yes" => $totalCarparkYesCount,
    "no" => $totalCarparkNoCount,
    "condo" => $totalCondoVisitorCount,
    
];


class PDF extends FPDF {

    function Header() {
        
        
    }

    function body($info, $content, $company, $reportType, $yearMonth, $summaryData) {

        //Display Company Info
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(280, 5, $company['companyName'], 0, 1, "C");
        $this->SetFont('Arial', '', 9.5);
        $this->Cell(280, 15, $company['companyAddress'], 0, 1, "C");


        $this->SetFont('Arial', 'B', 18);
        $this->Cell(280, 10, "Visitor ".$reportType." Report"."_".$yearMonth, 0, 1, "C");

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
        $this->Cell(45, 9, "Visitor", 1, 0, "C");
        $this->Cell(27, 9, "Visit Date", 1, 0, "C");
        $this->Cell(25, 9, "Visit Time", 1, 0, "C");
        $this->Cell(20, 9, "Carpark", 1, 0, "C");
        $this->Cell(23, 9, "Car No", 1, 0, "C");
        $this->Cell(45, 9, "Owner", 1, 0, "C");
        $this->Cell(45, 9, "Tenant", 1, 1, "C");
        $this->SetFont('Arial', '', 12);
        
        //Display table product rows
        $no = 1;
        foreach ($content as $row) {
            $visitTime = strtotime($row['visitTime']);
            $time = date('H:i', $visitTime);
            $this->Cell(10, 9, $no, "LR", 0, "C");
            $this->Cell(40, 9, $row['condoName'], "R", 0, "C");
            $this->Cell(45, 9, $row['visitorName'], "R", 0, "C");
            $this->Cell(27, 9, $row['visitDate'], "R", 0, "C");
            $this->Cell(25, 9, $time, "R", 0, "C");
            $this->Cell(20, 9, $row['visitorCarpark'], "R", 0, "C");
            $this->Cell(23, 9, $row['visitorCarNo'], "R", 0, "C");
            $this->Cell(45, 9, $row['ownerFName']." ".$row['ownerLName'], "R", 0, "C");
            $this->Cell(45, 9, $row['tenantName'], "R", 1, "C");
            $no++;
        }
        $no--;
        //Display table empty rows
        for ($i = 0; $i < 6 - count($content); $i++) {
            $this->Cell(10, 9, "", "LR", 0);
            $this->Cell(40, 9, "", "R", 0, "R");
            $this->Cell(45, 9, "", "R", 0, "R");
            $this->Cell(27, 9, "", "R", 0, "R");
            $this->Cell(25, 9, "", "R", 0, "R");
            $this->Cell(20, 9, "", "R", 0, "R");
            $this->Cell(23, 9, "", "R", 0, "R");
            $this->Cell(45, 9, "", "R", 0, "R");
            $this->Cell(45, 9, "", "R", 1, "R");
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
        $this->Cell(170, 9, "Carpark", 1, 0, "C");
        $this->Cell(20, 9, "Count", 1, 1, "C");
        
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "YES", "LR", 0, "C");
        $this->Cell(20, 9, $info['yes'], "R", 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "NO", "LR", 0, "C");
        $this->Cell(20, 9, $info['no'], "R", 1, "C");
        
        
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Status", 1, 0, "C");
        $this->Cell(20, 9, "", 1, 1, "C");
        
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Pending", "LR", 0, "C");
        $this->Cell(20, 9, $info['pending'], "R", 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Visited", "LR", 0, "C");
        $this->Cell(20, 9, $info['visited'], "R", 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Canceled", "LR", 0, "C");
        $this->Cell(20, 9, $info['cancel'], "R", 1, "C");
        
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Condominium", 1, 0, "C");
        $this->Cell(20, 9, "", 1, 1, "C");

        foreach($summaryData as $cd){
            $this->Cell(40, 9, "", "", 0);
            $this->Cell(170, 9, $cd['condoName'], "LR", 0, "C");
            $this->Cell(20, 9, $cd['condoVisitorCount'], "R", 1, "C");
        }

        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Total Record ", 1, 0, "R");
        $this->Cell(20, 9, $info['count'], 1, 0, "C");
        
        
        foreach ($summaryData as $data) {
            $remainingSpace = $this->GetPageHeight() - $this->GetY();
            $spaceRequired = 180; // Adjust this value based on your table height

            if ($remainingSpace < $spaceRequired) {
                $this->AddPage(); // Start a new page
            }
            $this->Cell(280,40, "", 0, 1, "C");
            $this->Cell(40, 9, "", "", 0);
            $this->Cell(170, 9, $data['condoName'], 1, 0, "L");
            $this->Cell(20, 9, "Count", 1, 1, "C");

            foreach ($data['visitor'] as $vs) {
                if($vs['cvCarparkY'] != 0){
                    $this->Cell(40, 9, "", "", 0);
                    $this->Cell(170, 9, "Carpark : YES", 1, 0, "L");
                    $this->Cell(20, 9, $vs['cvCarparkY'], 1, 1, "C");
                }else {
                    $this->Cell(40, 9, "", "", 0);
                    $this->Cell(170, 9, "Carpark : NO", 1, 0, "L");
                    $this->Cell(20, 9, $vs['cvCarparkN'], 1, 1, "C");                    
                }

            $this->Cell(40, 9, "", "", 0);
            $this->Cell(170, 9, "Total Pending", "LR", 0, "C");
            $this->Cell(20, 9, $vs["pendingCount"], "R", 1, "C");
            
            $this->Cell(40, 9, "", "", 0);
            $this->Cell(170, 9, "Total Visited", "LR", 0, "C");
            $this->Cell(20, 9, $vs["visitedCount"], "R", 1, "C");
            
            $this->Cell(40, 9, "", "", 0);
            $this->Cell(170, 9, "Total Canceled", "LR", 0, "C");
            $this->Cell(20, 9, $vs["canceledCount"], "R", 1, "C");
            }
            
            $this->Cell(40, 9, "", "", 0);
            $this->Cell(170, 9, "Total Record ", 1, 0, "R");
            $this->Cell(20, 9, $data['condoVisitorCount'], 1, 0, "C");
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
$pdf->body($info, $visitor, $company, $reportType, $yearMonth, $condoVisitorData);
// your PDF generation code here
$pdf->Output(); // generate PDF output
?>