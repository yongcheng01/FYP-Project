<html>
    <?php session_start()?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium Management System</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }
            body{
                width: 100%;
                height: 100%;
            }
            .wholePage {
               background-color: #fff;
            }
            .page {
                margin-left: 8%;
                width: 85%;
                padding: 20px;
                overflow: auto;
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
             .search {
                display: flex;
                align-items: center;
            }

            .search input[type="text"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
            }
            .refresh:hover {
                color: #0056b3;
            }
            .refresh{
                display: block;
                text-align: center;
                margin-top: 10px;
                color: #007bff;
                text-decoration: none;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
            }

            th, td {
                padding: 10px;
                text-align: center;
                border-bottom: 1px solid #ddd;
            }
            
            th {
                background-color: #007bff;
                color: #fff;
            }

            .rowPagination {
                display: flex;
                justify-content: center;
                margin-top: 20px;
            }

            .pagination {
                display: flex;
                justify-content: center;
                margin-top: 20px;
            }
            .pagination a {
                display: inline-block;
                padding: 8px 16px;
                text-decoration: none;
                background-color: #007bff;
                border-radius: 5px;
                margin: 0 5px;
                font-weight: bold;
            }

            .pagination a.current {
                background-color: lightcyan;
                color: black;
            }

            .pagination a:hover {
                background-color: #0069d9;
            }
             .btnbtn, .btn {
                background: #00a8ff;
                border: 2px solid #00a8ff;
                padding: 10px;
                color: white;
                font-size: 15px;
                font-family: 'Poppins', sans-serif;
                transition: 0.3s all ease;     
                text-decoration: none; 
            }
            .btnbtn:hover, .btn:hover{
                opacity: .7;
            }
            .btnbtn{
                width: 85%;
            }

            .success {
                background: #4cd137;
                color: white;
                text-align:center;
                font-size: 15px;
                padding: 10px;
            }
            @media only screen and (max-width: 600px) {
             
               .title {
                   margin-top: 15%;
               }
               
                .page {
                    margin: 0; 
                    width: 100%; 
                    box-sizing: border-box;
                    padding: 10px; 
                    margin-top: 30px; 
                }
                
                table {
                  border: 0;
                }
                table caption {
                  font-size: 1.3em;
                }

                table thead {
                  display: none;
               }

                 table tr {
                  border-bottom: 3px solid blue;
                  display: block;
                  margin-bottom:0.625em;
                }
                table td {
                  border-bottom: 1px solid green;
                  display: block;
                  font-size: .8em;
                  text-align: right;
                  min-height: 40px;
                }
                table td:before {

                  content: attr(data-label);
                  float: left;
                  font-weight: bold;
                  text-transform: uppercase;
                }
                
                .btnbtn{
                    width: 35%;
                    padding: 8px;
                    font-size: 10px;
                }
            }
        </style>
    </head>
    <body>
        <?php
        include'../connection.php';
        include'../BEHeader.php';
        ?>
        <div class="title">Family Management Function</div>
        <div class="wholePage">
            <div class="page">
                <div class="row">
                    <div class="search">
                        <input type="text" class="form-control" id="live-search" autocomplete="off" placeholder="Search...">
                    </div>
                    <a href="FamilySearch.php"><label class="refresh">if no data click here refresh</label></a>
                </div>

                <script type="text/javascript">
                $(document).ready(function() {
                    $("#live-search").keyup(function() {
                        var input = $(this).val();
                        if (input != "") {
                            $.ajax({
                                url: "FamilyLiveSearchAdmin.php",
                                method: "POST",
                                data: {input: input},
                                success: function(data) {
                                    $("#searchresult").html(data).show();
                                }
                            });
                        } else {
                            $("#searchresult").hide();
                        }
                    });
                });
                </script>
                <form method="post">                    
                    <button class="btn" formaction="FamilyAddAdmin.php">Add Family</button>       
                </form>  
                <br>
                <div id="searchresult">
                    <div class="row">
                        <?php if (isset($_GET['error'])) { ?>
                            <p class="error"><?php echo $_GET['error']; ?></p>
                        <?php } ?>
                        <?php if (isset($_GET['success'])) { ?>
                            <p class="success"><?php echo $_GET['success']; ?></p>
                        <?php } ?>
                        <table class="table table-hover table-bordered">
                            <thead style="background-color: #90aef0;">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Relationship</th>
                                    <th>Status</th>
                                    <th>House</th>
                                    <th>Condo Name</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $total_rows = $conn->query('SELECT f.*, o.*, c.*, h.*
                                                    FROM family f
                                                    INNER JOIN owner o ON f.ownerID = o.ownerID
                                                    INNER JOIN house h ON o.houseID = h.houseID
                                                    INNER JOIN condominium c ON o.condoID = c.condoID 
                                                    ORDER BY familyStatus'
                                        )->num_rows;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 5;
                                if ($stmt = $conn->prepare('SELECT f.*, o.*, c.*, h.*
                                                    FROM family f
                                                    INNER JOIN owner o ON f.ownerID = o.ownerID
                                                    INNER JOIN house h ON o.houseID = h.houseID
                                                    INNER JOIN condominium c ON o.condoID = c.condoID 
                                                    ORDER BY familyStatus 
                                                    LIMIT ?,?')) {
                                    // Calculate the page to get the results we need from our table.
                                    $calc_page = ($page - 1) * $num_results_on_page;
                                    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                                    $stmt->execute();
                                    // Get the results...
                                    $result = $stmt->get_result();
                                    // Loop through the data and output it in the table
                                    if (mysqli_num_rows($result) > 0) {
                                        $no = ($page - 1) * $num_results_on_page + 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td data-label="No"><?php echo $no ?></td>
                                                <td data-label="Name"><?= $row["familyName"] ?></td>
                                                <td data-label="Phone"><?= $row["familyPhone"] ?></td>
                                                <td data-label="Relationship"><?= $row["familyRelationship"] ?></td>
                                                <td data-label="Status"><?= $row["familyStatus"] ?></td>
                                                <td data-label="House"><?= $row["block"] . '-' . $row["floor"] . '-' . $row["houseNumber"] ?></td>
                                                <td data-label="Condo Name"><?= $row["condoName"] ?></td>
                                                <td data-label="">
                                                    <?php echo'<button class="btnbtn"><a href="FamilyViewAdmin.php? viewid=' . $row["familyID"] . '">View</a></button>' ?>
                                                </td>
                                                <td data-label="">
                                                    <?php if ($row["familyStatus"] === "Available") : ?>
                                                        <?php echo'<button class="btnbtn"><a href="FamilyEditAdmin.php? editid=' . $row["familyID"] . '">Edit</a></button>' ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td data-label="">
                                                    <?php if ($row["familyStatus"] === "Available") : ?>
                                                        <?php echo'<button class="btnbtn"><a href="FamilyDeleteAdmin.php? deleteid=' . $row["familyID"] . '">Delete</a></button>' ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $no++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='8'>No Family record found</td></tr>";
                                    }
                                }
                                ?>
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

                </div>
            </div>
        </div>
    </body>
</html>
