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
                                            <div class="nk-block-head-sub"><a class="back-to" href="./"><em
                                                        class="icon ni ni-arrow-left"></em><span>Dashboard</span></a>
                                            </div>
                                            <h2 class="nk-block-title fw-normal"
                                                style="font-size: 35px; padding-top: 20px; color: black;">Add New User
                                            </h2>

                                        </div>
                                    </div>

                                    <div class="nk-block nk-block-lg">

                                        <div class="card">
                                            <div class="card-inner">
                                                <form action="main_components/global.php" method="post"
                                                    class="form-validate is-alter">
                                                    <div class="row g-gs">
                                                        <div class="col-md-12">
                                                            <div class="form-group"><label class="form-label"
                                                                    for="fva-full-name">Full Name</label>
                                                                <div class="form-control-wrap"><input type="text"
                                                                        class="form-control" id="fva-full-name"
                                                                        name="full_name" required></div>
                                                            </div>
                                                        </div>



                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-phone">User
                                                                    Email</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"></div>
                                                                        <input type="email" name="email"
                                                                            placeholder="abc@example.com"
                                                                            class="form-control" required>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-phone">User
                                                                    Password</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"></div>
                                                                        <input type="password" name="password"
                                                                            placeholder="abc@example.com"
                                                                            class="form-control" required>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        


                                                        <div class="col-md-12">
                                                            <div class="form-group"><button type="submit" name="add_user" class="btn btn-lg btn-primary">Add User</button></div>
                                                        </div>
                                                    </div>
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