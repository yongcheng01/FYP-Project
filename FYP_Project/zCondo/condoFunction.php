
<html>
    <?php session_start();?>
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="../images/houseIcon.png" type="image/x-icon">
        <title>Condominium</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="jsCondo.js"></script>

        <style>
           body {
               margin: 0;
               padding: 0;
               font-family: Arial, sans-serif;
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

           .wholePage {
               background-color: #fff;
           }

           .page {
               margin-left: 20%;
               width: 60%;
               padding: 20px;
               overflow: auto;
           }

           .row {
               margin-bottom: 15px;
           }

           .search {
               text-align: center;
               margin-bottom: 15px;
           }
           #live-search {
               width: 100%;
               padding: 8px;
               border: 1px solid #ccc;
               border-radius: 3px;
           }
           .refresh {
               display: block;
               text-align: center;
               margin-top: 10px;
               color: #007bff;
               text-decoration: none;
           }
           .refresh:hover {
               color: #0056b3;
           }

           table {
               width: 100%;
               border-collapse: collapse;
               margin-bottom: 15px;
           }
           th {
               background-color: #007bff;
               color: #fff;
           }
           th, td {
                padding: 12px;
                text-align: center;
                border-bottom: 1px solid #ddd;
           }
           tbody tr:hover {
                background-color: #f5f5f5;
            }

           .rowPagination {
               display: flex;
               justify-content: center;
               align-items: center; 
               flex-wrap: wrap;
               margin-top: 20px;
           }
           .pagination {
               display: flex;
               justify-content: center;
               align-items: center; 
           }
           .pagination a, .pagination .current {
               display: inline-block;
               padding: 8px;
               margin: 0 4px;
               color: #333;
               text-decoration: none;
               border: 1px solid #ddd;
               border-radius: 4px;
               transition: background-color 0.3s;
           }
           .pagination a:hover {
               background-color: #007bff;
               color: #fff;
           }
           .pagination a:not(:last-child), .pagination .current:not(:last-child) {
               margin-right: 4px;
           }
           .pagination .current {
                background-color: #007bff;
                color: #fff;
                pointer-events: none; 
            }

           .rowbtn {
               text-align: center;
               margin-top: 20px;
           }
           .rowbtn button {
               background-color: #007bff;
               color: #fff;
               border: none;
               padding: 10px 20px;
               border-radius: 5px;
               cursor: pointer;
               margin: 0 5px;
               transition: background-color 0.3s;
           }
           .rowbtn button:hover {
               background-color: #0056b3;
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
            }
        </style>

        
        
    </head>
    <body>
        <?php
            include'../BEHeader.php';
            include '../connection.php';
            
        ?>
        
        <div class="title">Condominium Management Function</div>
        <div class="wholePage">
            <div class="page">
                
                <div class="row">
                    <div class="search">
                        <input type="text" class="form-control" id="live-search" autocomplete="off" placeholder="Search...">
                    </div>
                    <a href="condoFunction.php"><label class="refresh">if no data click here refresh</label></a>
                </div>

                <script type="text/javascript">
                $(document).ready(function () {
                    $("#live-search").keyup(function () {
                        var input = $(this).val();
                        if (input != "") {
                            $.ajax({
                                url: "../FYPLiveSearchFunction.php",
                                method: "POST",
                                data: {condo: input},
                                success: function (data) {
                                    $("#searchresult").html(data).show();
                                }
                            });
                        } else {
                            $("#searchresult").hide();
                        }
                    });
                });
            </script>

                <div id="searchresult">
                    <form method="post" id="condo">
                    <div class="row">
                        <table>

                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Condominium</th>
                                    <th>Block</th>
                                    <th>Floor</th>
                                    <th>Unit Per Floor</th>
                                    <th>Carpark Floor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $total_rows = $conn->query('SELECT * FROM condominium')->num_rows;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 5;
                                if ($stmt = $conn->prepare('SELECT * FROM condominium ORDER BY condoStatus, condoID LIMIT ?,?')) {
                                // Calculate the page to get the results we need from our table.
                                $calc_page = ($page - 1) * $num_results_on_page;
                                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                                $stmt->execute();
                                // Get the results...
                                $result = $stmt->get_result();
                                // Loop through the data and output it in the table
                                if (mysqli_num_rows($result) > 0) {
                                while ($condo = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td data-label="Action"><input type="radio" name="condoID[]" value="<?=$condo['condoID']?>"></td>
                                    <td data-label="Condominium"><?= $condo['condoName'] ?></td>
                                    <td data-label="Block"><?= $condo['condoBlock'] ?></td>
                                    <td data-label="Floor"><?= $condo['condoFloor'] ?></td>
                                    <td data-label="Unit Per Floor"><?= $condo['roomPerFloor'] ?></td>
                                    <td data-label="Carpark Floor"><?= $condo['condoCarParkFloor'] ?></td>
                                    <td data-label="Status"><?= $condo['condoStatus'] ?></td>
                                </tr>
                                <?php } } else{ echo "<tr><td colspan='8' style='text-align:center'>No Data found</td></tr>"; } } ?>
                            </tbody>

                        </table>

                        <div class="rowPagination">
                            <?php if ($total_rows > $num_results_on_page): ?>
                                <div class="pagination">
                                    <?php $total_pages = ceil($total_rows / $num_results_on_page); ?>
                                    <?php if ($page > 1): ?>
                                        <a href="?page=1">&laquo; </a>
                                        <a href="?page=<?php echo $page - 1 ?>">&lsaquo; </a>
                                    <?php endif; ?>

                                    <?php
                                    $start_page = max(1, min($page - 2, $total_pages - 4));
                                    $end_page = min($start_page + 4, $total_pages);

                                    for ($i = $start_page; $i <= $end_page; $i++):
                                        ?>
                                        <?php if ($i == $page): ?>
                                            <center><a href="#" class="current"><?php echo $i ?></a></center>
                                        <?php else: ?>
                                            <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <a href="?page=<?php echo $page + 1 ?>"> &rsaquo;</a>
                                        <a href="?page=<?php echo $total_pages ?>"> &raquo;</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>


                    </div>

                    <div class="rowbtn">
                        <button class="update" formaction="condoUpdate.php" onclick="chkUpdateSelect()">Update</button>
                        <button class="delete" formaction="condoDelete.php" onclick="confirmDelete()">Delete</button>
                        <button class="add" formaction="condoAdd.php">Add</button>
                    </div>
                        
                </form>
                </div>
            </div>
        </div>
    </body>
</html>
