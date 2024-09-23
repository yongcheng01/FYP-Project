<?php

require ("../fpdf/fpdf.php");

include '../connection.php';

$payment = array();    
   
$randomNumber = rand(1000, 9999);
$date = date('Y/m/d');
$reportNo = "10" . $randomNumber;
$count = 0;
$carpark = 0;
$condoID = "";
$condoData = array();

if (isset($_POST['reportType'])) {
    $reportType = $_POST['reportType'];
    
    $companyQuery = "SELECT * FROM company WHERE companyStatus = 'Available'";
    $companyResult = mysqli_query($conn, $companyQuery);
    $company = mysqli_fetch_assoc($companyResult);
    
    
    if ($reportType == "Annual" && isset($_POST['reportYear']) && isset($_POST['reportStatus'])) {
        $year = $_POST['reportYear'];
        $yearMonth = $_POST['reportYear'];
        $reportStatus = $_POST['reportStatus'];
        $query = "SELECT * FROM payment
                    LEFT JOIN owner ON payment.ownerID = owner.ownerID
                    LEFT JOIN tenant ON payment.tenantID = tenant.tenantID
                    LEFT JOIN house ON payment.houseID = house.houseID
                    LEFT JOIN receipt ON payment.paymentID = receipt.paymentID
                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                    WHERE YEAR(payment.dueDate) = $year AND payment.paymentStatus = '$reportStatus' AND condominium.condoStatus = 'Available'
                    ORDER BY condominium.condoID, tenant.tenantName";
        $result = mysqli_query($conn, $query);

        while ($data = mysqli_fetch_assoc($result)) {
            $payment[] = $data;
        }
        
        $query2 = "SELECT SUM(payment.amount) AS totalAmount
                    FROM payment
                    LEFT JOIN owner ON payment.ownerID = owner.ownerID
                    LEFT JOIN tenant ON payment.tenantID = tenant.tenantID
                    LEFT JOIN house ON payment.houseID = house.houseID
                    LEFT JOIN receipt ON payment.paymentID = receipt.paymentID
                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                    WHERE YEAR(payment.dueDate) = $year AND payment.paymentStatus = '$reportStatus' AND condominium.condoStatus = 'Available'" ;
        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_assoc($result2);
        $totalAmount = $row2['totalAmount'];

    } elseif ($reportType == "Monthly" && isset($_POST['reportMonth']) && isset($_POST['reportStatus'])) {
        $month = $_POST['reportMonth'];
        $yearMonth = $_POST['reportMonth'];
        $reportStatus = $_POST['reportStatus'];
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
        
        
        $query = "SELECT * FROM payment
                    LEFT JOIN owner ON payment.ownerID = owner.ownerID
                    LEFT JOIN tenant ON payment.tenantID = tenant.tenantID
                    LEFT JOIN house ON payment.houseID = house.houseID
                    LEFT JOIN receipt ON payment.paymentID = receipt.paymentID
                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                    WHERE MONTH(dueDate) = $month and payment.paymentStatus = '$reportStatus' AND condominium.condoStatus = 'Available'
                    ORDER BY condominium.condoID, tenant.tenantName";
        $result = mysqli_query($conn, $query);

        while ($data = mysqli_fetch_assoc($result)) {
            $payment[] = $data;
        }
        
        $query2 = "SELECT SUM(payment.amount) AS totalAmount
                   FROM payment
                    LEFT JOIN owner ON payment.ownerID = owner.ownerID
                    LEFT JOIN tenant ON payment.tenantID = tenant.tenantID
                    LEFT JOIN house ON payment.houseID = house.houseID
                    LEFT JOIN receipt ON payment.paymentID = receipt.paymentID
                    INNER JOIN condominium ON COALESCE(owner.condoID, tenant.condoID) = condominium.condoID
                    WHERE MONTH(dueDate) = $month AND payment.paymentStatus = '$reportStatus' AND condominium.condoStatus = 'Available'";
        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_assoc($result2);
        $totalAmount = $row2['totalAmount'];
    }
    
    
    
    
    foreach($payment as $payments){
        $count++;
        if ($payments['condoID'] != $condoID) {
            // If $condoID is not empty, it means we are moving to a new condominium
            if (!empty($condoID)) {
                $condoData[] = array(
                    'condoName' => $condoName,
                    'paymentCount' => $condoCount
                );
            }

            // Reset counters for the new condominium
            $condoID = $payments['condoID'];
            $condoName = $payments['condoName'];
            $condoCount = 1;
        } else {
            // If $condoID is the same, increment the visitor count
            $condoCount++;
        }
        
    }
    if (!empty($condoID)) {
    $condoData[] = array(
        'condoName' => $condoName,
        'paymentCount' => $condoCount
    );
}
}



$info = [
    "count" => $count,
    "reportNo" => $reportNo,
    "reportDate" => $date,
    "amount" => $totalAmount,
];


class PDF extends FPDF {

    function Header() {
        
        
    }

    function body($info, $content, $company, $reportType, $yearMonth,$reportStatus, $condo) {

        //Display Company Info
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(280, 5, $company['companyName'], 0, 1, "C");
        $this->SetFont('Arial', '', 9.5);
        $this->Cell(280, 15, $company['companyAddress'], 0, 1, "C");


        $this->SetFont('Arial', 'B', 18);
        $this->Cell(280, 10, "Payment ".$reportType." Report"."_".$yearMonth." Status ".$reportStatus, 0, 1, "C");

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
        $this->Cell(30, 9, "Condominium", 1, 0, "C");
        $this->Cell(40, 9, "Owner Name", 1, 0, "C");
        $this->Cell(40, 9, "Tenant Name", 1, 0, "C");
        $this->Cell(55, 9, "Bill Type", 1, 0, "C");
        $this->Cell(28, 9, "Issue Date", 1, 0, "C");
        $this->Cell(27, 9, "Payment", 1, 0, "C");
        $this->Cell(20, 9, "House", 1, 0, "C");
        $this->Cell(30, 9, "amount", 1, 1, "C");
        $this->SetFont('Arial', '', 12);
        
        //Display table product rows
        $no = 1;
        foreach ($content as $row) {
            $this->Cell(10, 9, $no, "LR", 0, "C");
            $this->Cell(30, 9, $row['condoName'], "R", 0, "C");
            $this->Cell(40, 9, $row['ownerFName']." ".$row['ownerLName'], "R", 0, "C");
            $this->Cell(40, 9, $row['tenantName'], "R", 0, "C");
            $this->Cell(55, 9, $row['billType'], "R", 0, "C");
            $this->Cell(28, 9, $row['issueDate'], "R", 0, "C");
            $this->Cell(27, 9, $row['paymentMethod'], "R", 0, "C");
            $this->Cell(20, 9, $row['block'].'-'.$row['floor'].'-'.$row['houseNumber'], "R", 0, "C");
            $this->Cell(30, 9, $row['amount'], "R", 1, "C");
            $no++;
        }
        $no--;
        //Display table empty rows
        for ($i = 0; $i < 6 - count($content); $i++) {
            $this->Cell(10, 9, "", "LR", 0);
            $this->Cell(30, 9, "", "R", 0, "R");
            $this->Cell(40, 9, "", "R", 0, "R");
            $this->Cell(40, 9, "", "R", 0, "R");
            $this->Cell(55, 9, "", "R", 0, "R");
            $this->Cell(28, 9, "", "R", 0, "R");
            $this->Cell(27, 9, "", "R", 0, "R");
            $this->Cell(20, 9, "", "R", 0, "R");
            $this->Cell(30, 9, "", "R", 1, "R");
        }

        //Display table total row
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(250, 9, "TOTAL RECORD ", 1, 0, "R");
        $this->Cell(30, 9, $info["count"], 1, 1, "C");
        $this->Cell(250, 9, "TOTAL AMOUNT(RM) ", 1, 0, "R");
        $this->Cell(30, 9, $info["amount"], 1, 1, "C");

        $this->SetFont('Arial', 'B', 18);
        $this->Cell(280, 20, "", 0, 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 15, "Report  Summary", 0, 1, "L");

        $this->SetFont('Arial', 'B', 12);

        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Condominium", 1, 0, "C");
        $this->Cell(20, 9, "Count", 1, 1, "C");
        foreach($condo as $condos){
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, $condos['condoName'], "LR", 0, "C");
        $this->Cell(20, 9, $condos['paymentCount'], "R", 1, "C");
        }

        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Total Record ", 1, 0, "R");
        $this->Cell(20, 9, $no, 1, 0, "C");

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
$pdf->body($info, $payment, $company, $reportType, $yearMonth, $reportStatus, $condoData);
// your PDF generation code here
$pdf->Output(); // generate PDF output
?>