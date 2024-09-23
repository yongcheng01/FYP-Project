
<html>
    <?php session_start(); ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Report</title>
        <style>
            body {
                background-color: #fff; /* White background color for the body */
                font-family: Arial, sans-serif; /* Choose an appropriate font */
                margin: 0;
                padding: 0;
            }

            .title {
                background-color: #333;
                color: #fff; 
                padding: 15px;
                text-align: center;
                font-size: 24px;
                margin-top: 3.5%; 
                margin-bottom: 5%; 
            }

            .button {
                display: flex;
                flex-direction: column;
                align-items: center; 
                margin-top: 20px;
            }

            .ca {
                display: block;
                text-align: center;
                text-decoration: none;
                padding: 15px 30px;
                background-color: #3498db; 
                color: #fff;
                border-radius: 5px;
                margin-bottom: 10px; 
                transition: background-color 0.3s ease;
                min-width: 400px;
                min-height: 40px;
                
            }

            .ca:hover {
                background-color: #2980b9;
            }

            .fa {
                margin-right: 10px;
            }
            
            @media only screen and (max-width: 600px) {
             
                .ca {
                    min-width: 250px;
                }
            }


        </style>
    </head>
    <body>
        <?php
        
        include '../BEHeader.php';
        ?>

        <div class="title">Report Menu</div>

        <div class="button">

            <a href="reportVisitor.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Visitor Report</a>
            <a href="reportReservation.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Reservation Report</a>
            <a href="ReportPrintOwner.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Owner Report</a>
            <a href="ReportPrintAdmin.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Admin Report</a>
            <a href="ReportPrintHouse.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>House Report</a>
            <a href="ReportTenant.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Tenant Report</a>
            <a href="ReportPrintFamily.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Family Report</a>
            <a href="ReportPayment.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Payment Report</a>
            <a href="ReportMaintenance.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Maintenance Report</a>

        </div>

    </body>
</html>
