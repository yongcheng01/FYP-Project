<?php 

  require ("../fpdf/fpdf.php");

  
    $paymentID = $_GET['printid'];
        

        $connect = mysqli_connect("localhost", "root", "", "condo");
        
        $testQuery = "SELECT * FROM payment WHERE paymentID = $paymentID";
        $resultTest = mysqli_query($connect, $testQuery);
        $getData = mysqli_fetch_assoc($resultTest);
        
        $tenantID = $getData['tenantID'];
        $ownerID = $getData['ownerID'];
        
        if (!isset($tenantID) || empty($tenantID)) {
        
        $query2 = "SELECT p.*, h.*, o.*, c.*, comp.*, ec.*, t.*
                    FROM payment p
                    LEFT JOIN house h ON p.houseID = h.houseID
                    LEFT JOIN owner o ON p.ownerID = o.ownerID
                    LEFT JOIN tenant t ON p.tenantID = t.tenantID
                    LEFT JOIN condominium c ON h.condoID = c.condoID
                    LEFT JOIN company comp ON c.companyID = comp.companyID
                    LEFT JOIN emergencycontact ec ON c.condoID = ec.condoID
                    WHERE p.paymentID = '$paymentID'";
        $result2 = mysqli_query($connect, $query2);
        $information = mysqli_fetch_assoc($result2);

        $condoName = $information['condoName'];
        $contactCondo = $information['ecWhatsapp'];
        $emailCondo = $information['ecEmail'];
        
        $name = $information['ownerFName'].' '.$information['ownerLName'];
        $contact = $information['ownerPhone'];
      
        $house = $information['block'].'-'.$information['floor'].'-'.$information['houseNumber'];
        $issueDate = $information['issueDate'];
        $dueDate = $information['dueDate'];
        $billType = $information['billType'];
        $printDate = date("Y-m-d");
        $amount = $information['amount'];
        
        } else if (!isset($ownerID) || empty($ownerID)) {
            
            $query2 = "SELECT p.*, h.*, o.*, c.*, comp.*, ec.*, t.*
                    FROM payment p
                    LEFT JOIN house h ON p.houseID = h.houseID
                    LEFT JOIN owner o ON p.ownerID = o.ownerID
                    LEFT JOIN tenant t ON p.tenantID = t.tenantID
                    LEFT JOIN condominium c ON h.condoID = c.condoID
                    LEFT JOIN company comp ON c.companyID = comp.companyID
                    LEFT JOIN emergencycontact ec ON c.condoID = ec.condoID
                    WHERE p.paymentID = '$paymentID'";
        $result2 = mysqli_query($connect, $query2);
        $information = mysqli_fetch_assoc($result2);
        
        $condoName = $information['condoName'];
        $contactCondo = $information['ecWhatsapp'];
        $emailCondo = $information['ecEmail'];
        
        $name = $information['tenantName'];
        $contact = $information['tenantPhone'];
        
        $house = $information['block'].'-'.$information['floor'].'-'.$information['houseNumber'];
        $issueDate = $information['issueDate'];
        $dueDate = $information['dueDate'];
        $billType = $information['billType'];
        $printDate = date("Y-m-d");
        $amount = $information['amount'];
        }



  //Data Detail
  $info = [
    "condoName" => $condoName,
    "condoContact" => $contactCondo,
    "emailCondo" => $emailCondo,
    "paymentID" => $paymentID,
    "dueDate" => $dueDate,
    "issuesDate" => $issueDate,
    "printDate" => $printDate,
    "name" => $name,
    "contact" => $contact,
    "house" => $house,
    "billType" => $billType,
    "amount" => $amount,
];

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
      $this->Cell(50,10,"BILLING",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($info){
      
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
     
      $this->SetFont('Arial','',12);
      $this->Cell(50,5,"Condominium: ".$info["condoName"],0,1);
      $this->Cell(50,5,"Contact          : ".$info["condoContact"],0,1);
      $this->Cell(50,5,"Email             : ".$info["emailCondo"],0,1);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Bill To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,5,"Name             : ".$info["name"],0,1);
      $this->Cell(50,5,"Contact          : ".$info["contact"],0,1);
      $this->Cell(50,5,"House            : ".$info["house"],0,1);

      
      //Display Invoice no
      $this->SetY(55);
      $this->SetX(-63);
      $this->Cell(50,5,"Billing No           : ".$info["paymentID"]);
      
      //Display Invoice Issues date
      $this->SetY(60);
      $this->SetX(-63);
      $this->Cell(50,5,"Bill Issues Date : ".$info["issuesDate"]);
      
      //Display Print date
      $this->SetY(65);
      $this->SetX(-63);
      $this->Cell(50,5,"Printed on          : ".$info["printDate"]);
      
      //Display Table headings
      $this->SetY(105);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(120,9,"BILL TYPE",1,0, "C");
      $this->Cell(70,9,"Amount",1,1,"C");
      $this->SetFont('Arial','',12);
      $this->Cell(120,9,$info["billType"],1,0, "C");
      $this->Cell(70,9,$info["amount"],1,1,"C");
      
      $this->SetY(125);
      $this->SetX(10); 
      $this->Cell(50,5,"PLEASE PAY THIS AMOUNT BY ".$info["dueDate"],0,1);
      
      $this->SetY(150);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,5,"Payment Options ",0,1);
      
      $this->SetY(165);
      $this->SetX(15);
      $this->SetFont('Arial','',11);
      $this->Cell(50,5,"PBB/Pbe-Bank Ref(1) :TUC220538929",0,1);
      $this->SetX(15);
      $this->Cell(50,5,"PBB/Pbe-Bank Ref(2) :2309N111223032710",0,1);
      $this->Image('../images/barCode.png', 20, 180, 50);
      
      $this->Image('../images/jomPay.png', 110, 165, 80);
      $this->SetY(182);
      $this->SetX(110);
      $this->SetFont('Arial','B',9);
      $this->Cell(50,2,"JomPay",0,0);
      $this->SetFont('Arial','',9);
      $this->SetX(123);
      $this->Cell(50,2,"online at Internet and Mobile Banking with your",0,1);
      $this->SetX(110);
      $this->Cell(50,5,"Cuurent or Saving Account",0,1);
    }
    function Footer(){
      
      //set footer position
      $this->SetY(290);
      //Display Footer Text
     $this->Cell(0,10,"This is a computer generated document. No signature is required.",0,1,"C");
      
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info);
// your PDF generation code here
  $pdf->Output(); // generate PDF output
?>