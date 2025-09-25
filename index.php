<?php require_once("./main_components/header.php") ?>


<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <?php require_once("./main_components/sidebar.php") ?>

            <div class="nk-wrap ">
                <?php require_once("./main_components/navbar.php") ?>

                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Dashboard</h3>
                                        </div>

                                    </div>
                                </div>
                                <div class="nk-block">
                                    <div class="row g-gs">

                                            <div class="col-xxl-3 col-sm-6">
                                                <div class="card">
                                                    <div class="nk-ecwg nk-ecwg6">
                                                        <div class="card-inner">
                                                            <div class="card-title-group">
                                                                <div class="card-title">
                                                                    <h6 class="title">Total System Users</h6>
                                                                </div>
                                                            </div>
                                                            <div class="data">
                                                                <div class="data-group">
                                                                    <div class="amount">

                                                                        <?php $query = "SELECT COUNT(*) as total_rows FROM users";
                                                                        $result = $conn->query($query);
                                                                        if ($result->num_rows == 1) {
                                                                            // Fetch the count value
                                                                            $row = $result->fetch_assoc();
                                                                            $totalRows = $row['total_rows'];
                                                                            // Print the total count
                                                                            echo $totalRows;
                                                                        } else {
                                                                            echo "No records found.";
                                                                        }
                                                                        // Close the database connection
                                                                        ?>

                                                                    </div>
                                                                    <div class="nk-ecwg6-ck"><canvas
                                                                            class="ecommerce-line-chart-s3"
                                                                            id="todayOrders"></canvas></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xxl-3 col-sm-6">
                                                <div class="card">
                                                    <div class="nk-ecwg nk-ecwg6">
                                                        <div class="card-inner">
                                                            <div class="card-title-group">
                                                                <div class="card-title">
                                                                    <h6 class="title">Total Invoice</h6>
                                                                </div>
                                                            </div>
                                                            <div class="data">
                                                                <div class="data-group">
                                                                    <div class="amount">
                                                                    <?php $query2 = "SELECT COUNT(*) as total_rows FROM invoices";
                                                                        $result2 = $conn->query($query2);
                                                                        if ($result2->num_rows == 1) {
                                                                            // Fetch the count value
                                                                            $row2 = $result2->fetch_assoc();
                                                                            $totalRows2 = $row2['total_rows'];
                                                                            // Print the total count
                                                                            echo $totalRows2;
                                                                        } else {
                                                                            echo "No records found.";
                                                                        }
                                                                        // Close the database connection
                                                                        ?>
                                                                    </div>
                                                                    <div class="nk-ecwg6-ck"><canvas
                                                                            class="ecommerce-line-chart-s3"
                                                                            id="todayCustomers"></canvas></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php require_once("./main_components/footer.php") ?>