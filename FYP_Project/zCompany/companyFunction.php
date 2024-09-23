<html>
    <?php session_start();?>
    <head>
        <meta charset="UTF-8">
        <title>Company</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
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
        
        include'../BEHeader.php';
        include'../connection.php';
        
        $company = array();
        $query = "SELECT * FROM company WHERE companyStatus = 'Available'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
          $company[] = $row;  
        }
        
        ?>
        
        <div class="title">Company Function</div>

        <div class="button">
            <a href="companyView.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>View Company Profile</a>
            <?php if(count($company)>0) :?>
            <a href="companyEdit.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Edit Company Profile</a>    
            <a href="companyDelete.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Delete Company Profile</a>    
            <?php else :?>
            <a href="companyAdd.php" class="ca" ><i class="fa fa-first-order" aria-hidden="true"></i>Add Company Profile</a>    
            <?php endif;?>  
            
        </div>

    </body>
</html>
