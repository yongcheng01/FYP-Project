<html>
    <?php
    session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <link rel="stylesheet" href="../style.css">
        <style>
             .maintenance{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-height: 100vh;
            }
            .addMaintenance {
               background: white;
                padding: 30px 30px;
                min-width: 400px;
                max-width: 450px;            
            }

            h2 {
                text-align: center;
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                margin-bottom: 2px;
                font-weight: 500;
                font-size: 15px;
            }

            input[type="text"],
            input[type="date"],
            input[type="number"],
            select,
            textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            textarea {
                resize: vertical;
            }

            button {
                display: block;
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                background-color: #00a8ff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-family: 'Poppins', sans-serif;
            }

            button:hover {
                opacity: .7;
            }
        </style>
    </head>
    <body>
        <?php
        include'../BEHeader.php';
        include "../connection.php";
        $msg = "";


            $id = $_GET['editid'];
            $sql2 = "SELECT * FROM payment WHERE paymentID='$id'";
            $result2 = mysqli_query($conn, $sql2);
            $row = mysqli_fetch_assoc($result2);


                if (isset($_POST['dueDate'])) {
                    $dueDate = $_POST['dueDate'];
                    if (empty($dueDate)) {
                        $msg = "<div class='alert alert-danger'>Please Select Due Date</div>";
                    } else {
                        $sql = "update payment set dueDate='$dueDate', paymentStatus = 'Pending' where paymentID=$id";
                        mysqli_query($conn, $sql);
                        echo '<script>alert("Edit Billing Successful!");</script>';
                        echo'<form id="message" action="PaymentSearch.php" method="post">
                    <input type="submit" value="Submit">
                    </form>
                    <script>document.querySelector("#message").submit();</script>';
                    }
                }

        ?>
        <div class ="maintenance">
            <div class="addMaintenance">
                <h2>Edit Billing</h2>
                <br>
                <?php echo $msg; ?>
                <form action="" method="post" class="form" autocomplete="off">
                    <div class="form-group">
                        <label for="billType">Billing Type:</label>
                        <input type="text" id="billType" name="maintenanceType" value="<?php echo $row['billType']; ?>"disabled>
                    </div>
                    <div class="form-group">
                        <label for="date">Issue Date:</label>
                        <input type="text" id="date" name="date" value="<?php echo isset($row['issueDate']) ? $row['issueDate'] : ''; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="dueDate">Due Date:</label>
                        <input type="date" id="dueDate" name="dueDate" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount" value="<?php echo $row['amount']; ?>"disabled>
                    </div>

                    <button type="submit">Edit Billing</button>
                    <button type="back" formaction="PaymentSearch.php">Back</button>
                </form>
            </div>
        </div>
    </body>
</html>
