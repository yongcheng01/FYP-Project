<?php

require ("../fpdf/fpdf.php");

include '../connection.php';

$admin = array();    
   
$randomNumber = rand(1000, 9999);
$date = date('Y/m/d');
$reportNo = "10" . $randomNumber;
$count = 0;
$status = 0;


    
    $companyQuery = "SELECT * FROM company WHERE companyStatus = 'Available'";
    $companyResult = mysqli_query($conn, $companyQuery);
    $company = mysqli_fetch_assoc($companyResult);
    

        $query = "SELECT * FROM admin ORDER BY adminID";
        $result = mysqli_query($conn, $query);

        while ($data = mysqli_fetch_assoc($result)) {
            $admin[] = $data;
        }
    
    foreach($admin as $admins){
        $count++;
        if($admins['adminStatus'] == "Available"){
            $status++;
        }
}




$info = [
    "count" => $count,
    "reportNo" => $reportNo,
    "reportDate" => $date,
    "status" => $status,
    
];


class PDF extends FPDF {

    function Header() {
        
        
    }

    function body($info, $content, $company) {

        //Display Company Info
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(280, 5, $company['companyName'], 0, 1, "C");
        $this->SetFont('Arial', '', 9.5);
        $this->Cell(280, 15, $company['companyAddress'], 0, 1, "C");


        $this->SetFont('Arial', 'B', 18);
        $this->Cell(280, 10, "Employee Report", 0, 1, "C");

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
        $this->Cell(40, 9, "Name", 1, 0, "C");
        $this->Cell(32, 9, "Contact", 1, 0, "C");
        $this->Cell(30, 9, "Age", 1, 0, "C");
        $this->Cell(30, 9, "Position", 1, 0, "C");
        $this->Cell(75, 9, "Email", 1, 0, "C");
        $this->Cell(33, 9, "Gender", 1, 0, "C");
        $this->Cell(30, 9, "Status", 1, 1, "C");
        $this->SetFont('Arial', '', 12);
        
        //Display table product rows
        $no = 1;
        foreach ($content as $row) {
            $this->Cell(10, 9, $no, "LR", 0, "C");
            $this->Cell(40, 9, $row['adminFName']." ".$row['adminLName'], "R", 0, "C");
            $this->Cell(32, 9, $row['adminPhone'], "R", 0, "C");
            $this->Cell(30, 9, $row['adminAge'], "R", 0, "C");
            $this->Cell(30, 9, $row['adminPosition'], "R", 0, "C");
            $this->Cell(75, 9, $row['adminEmail'], "R", 0, "C");
            $this->Cell(33, 9, $row['adminGender'], "R", 0, "C");
            $this->Cell(30, 9, $row['adminStatus'], "R", 1, "C");
            $no++;
        }
        $no--;
        //Display table empty rows
        for ($i = 0; $i < 6 - count($content); $i++) {
            $this->Cell(10, 9, "", "LR", 0);
            $this->Cell(40, 9, "", "R", 0, "R");
            $this->Cell(32, 9, "", "R", 0, "R");
            $this->Cell(30, 9, "", "R", 0, "R");
            $this->Cell(30, 9, "", "R", 0, "R");
            $this->Cell(75, 9, "", "R", 0, "R");
            $this->Cell(33, 9, "", "R", 0, "R");
            $this->Cell(30, 9, "", "R", 1, "R");
        }

        //Display table total row
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(250, 9, "TOTAL RECORD ", 1, 0, "R");
        $this->Cell(30, 9, $info["count"], 1, 1, "C");

        $this->SetFont('Arial', 'B', 18);
        $this->Cell(280, 20, "", 0, 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 15, "Report  Summary", 0, 1, "L");

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Status", 1, 0, "C");
        $this->Cell(20, 9, "Count", 1, 1, "C");


        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Available", "LR", 0, "C");
        $this->Cell(20, 9, $info["status"], "R", 1, "C");
        $this->Cell(40, 9, "", "", 0);
        $this->Cell(170, 9, "Unavailable", "LR", 0, "C");
        $this->Cell(20, 9, $no - $info["status"], "R", 1, "C");

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
$pdf->body($info, $admin, $company);
// your PDF generation code here
$pdf->Output(); // generate PDF output
?>