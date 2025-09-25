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
                                <div class="components-preview wide-md mx-auto">
                                    <div class="nk-block-head nk-block-head-lg wide-sm">
                                        <div class="nk-block-head-content">
                                            <div class="nk-block-head-sub"><a class="back-to" href="./"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                                            <h2 class="nk-block-title fw-normal" style="font-size: 35px; padding-top: 20px; color: black;">Update client</h2>

                                        </div>
                                    </div>

                                    <div class="nk-block nk-block-lg">

                                        <div class="card">
                                            <div class="card-inner">



                                                <?php
                                                if (isset($_POST['edit_client'])) {
                                                    $clientemail = mysqli_real_escape_string($conn, $_POST['clientemail']);
                                                    $query2 = "SELECT * FROM invoices WHERE client_email = '$clientemail' limit 1";
                                                    $employee_edit_fetch = $conn->query($query2);

                                                    // Check if the query was successful and if a record was found
                                                    if ($employee_edit_fetch && $employee_edit_fetch->num_rows === 1) {
                                                        $row = $employee_edit_fetch->fetch_assoc();
                                                        $id = $row['id'];
                                                        $username = $row['client_name'];
                                                        $email = $row['client_email'];



                                                ?>



                                                        <form action="main_components/global.php" method="post" class="form-validate is-alter">
                                                            <div class="row g-gs">
                                                                <!-- Hidden Input for Original Email -->
                                                                <input type="hidden" name="clientemail" value="<?php echo $email; ?>">

                                                                <!-- Input for Client Name -->
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="fva-full-name">Client Name</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control" value="<?php echo $username; ?>" id="fva-full-name" name="clientname" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Input for New Email -->
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="fv-email">Client Email</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="email" class="form-control" id="fv-email" name="email" placeholder="abc@example.com" value="<?php echo $email; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Submit Button -->
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button type="submit" name="update_client" class="btn btn-lg btn-primary">Update User</button>
                                                                    </div>
                                                                </div>
                                                            </div>




                                                    <?php } else {
                                                        // Handle the case where the employee record was not found
                                                        echo "Client not found.";
                                                    }
                                                } ?>

                                                        </form>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php require_once("./main_components/footer.php") ?>