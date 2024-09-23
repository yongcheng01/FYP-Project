<?php 

  require ("../fpdf/fpdf.php");

  
    $receiptID = $_GET['printid'];
     

        $connect = mysqli_connect("localhost", "root", "", "condo");
        
        $testQuery = "SELECT * FROM receipt WHERE receipt.receiptID = $receiptID";
        $resultTest = mysqli_query($connect, $testQuery);
        $getData = mysqli_fetch_assoc($resultTest);
        
        $tenantID = $getData['tenantID'];
        $ownerID = $getData['ownerID'];
        
        if (!isset($tenantID) || empty($tenantID)) {
            

        $query = "SELECT * FROM receipt 
          LEFT JOIN owner ON receipt.ownerID = owner.ownerID
          LEFT JOIN payment ON receipt.paymentID = payment.paymentID
          LEFT JOIN tenant ON payment.tenantID = tenant.tenantID
          WHERE receipt.receiptID = $receiptID";
        $result = mysqli_query($connect, $query);
        $receipt = mysqli_fetch_assoc($result);
        $Name = $receipt['ownerFName'].' '.$receipt['ownerLName'];
        $Contact = $receipt['ownerPhone'];
        $paymentMethod = $receipt['paymentMethod'];
        $paymentDate = $receipt['paymentDate'];
        $paymentTime = $receipt['paymentTime'];
        $amount = $receipt['amount'];
        $printDate = date("Y-m-d");
        
        } else if (!isset($ownerID) || empty($ownerID)) {
            $query = "SELECT * FROM receipt 
          LEFT JOIN owner ON receipt.ownerID = owner.ownerID
          LEFT JOIN payment ON receipt.paymentID = payment.paymentID
          LEFT JOIN tenant ON payment.tenantID = tenant.tenantID
          WHERE receipt.receiptID = $receiptID";
        $result = mysqli_query($connect, $query);
        $receipt = mysqli_fetch_assoc($result);
        $Name = $receipt['tenantName'];
        $Contact = $receipt['tenantPhone'];
        $paymentMethod = $receipt['paymentMethod'];
        $paymentDate = $receipt['paymentDate'];
        $paymentTime = $receipt['paymentTime'];
        $amount = $receipt['amount'];
        $printDate = date("Y-m-d");
        
        }

$info = [
    "Name" => $Name,
    "Contact" => $Contact,
    "paymentMethod" => $paymentMethod,
    "receiptID" => $receiptID,
    "paymentDate" => $paymentDate,
    "paymentTime" => $paymentTime,
    "printDate" => $printDate,
    "amount" => $amount,
            ];

  //Data Detail


class PDF extends FPDF
  {
    function Header(){
      
      //Display Company Info
      $this->SetFont('Arial','B',14);
      $this->Cell(50,10,'CondoMS',0,1);
      $this->SetFont('Arial','',14);
      $this->Cell(50,7,"No.19-3, 3rd Floor, Jalan Melati Utama 2,",0,1);
      $this->Cell(50,7,"Taman Melati Utama, Setapak",0,1);
      $this->Cell(50,7,"53100 Kuala Lumpur",0,1);
      
      //Display INVOICE text
      $this->SetY(15);
      $this->SetX(-40);
      $this->SetFont('Arial','B',18);
      $this->Cell(50,10,"RECEIPT",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($info){
      
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
     
      $this->SetFont('Arial','B',15);
      $this->Cell(50,10,"Receipt: ",0,1);

      $this->SetX(50);
      $this->SetFont('Arial','',12);
      $this->SetX(65);
      $this->Cell(95,10,"Receipt Number                :   ".$info["receiptID"],1,1);
      $this->SetX(65);
      $this->Cell(95,10,"Name                                 :   ".$info["Name"],1,1);
      $this->SetX(65);
      $this->Cell(95,10,"Contact                              :   ".$info["Contact"],1,1);
      $this->SetX(65);
      $this->Cell(95,10,"Payment Method               :   ".$info["paymentMethod"],1,1);
      $this->SetX(65);
      $this->Cell(95,10,"Amount                              :   ".$info["amount"],1,1);
      $this->SetX(65);
      $this->Cell(95,10,"Payment Date                    :   ".$info["paymentDate"],1,1);
      $this->SetX(65);
      $this->Cell(95,10,"Payment Time                   :   ".$info["paymentTime"],1,1);
      $this->SetX(65); 
      $this->Cell(95,10,"Printed on                          :   ".$info["printDate"],1,1);

      
      //Display Invoice no
      
    }
    function Footer(){
      
      //set footer position
      $this->SetY(290);
      //Display Footer Text
      $this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
      
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info);
// your PDF generation code here
  $pdf->Output(); // generate PDF output
?>