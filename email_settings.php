<?php require_once("./main_components/header.php"); ?>

<?php
// Fetch existing email settings
$sql = "SELECT host, username, password, port, subject, body FROM email_setting LIMIT 1";
$result = $conn->query($sql);
$emailSettings = $result->fetch_assoc();
?>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <?php require_once("./main_components/sidebar.php"); ?>
            <div class="nk-wrap ">
                <?php require_once("./main_components/navbar.php"); ?>

                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="components-preview wide-md mx-auto">
                                    <div class="nk-block-head nk-block-head-lg wide-sm">
                                        <div class="nk-block-head-content">
                                            <div class="nk-block-head-sub">
                                                <a class="back-to" href="./">
                                                    <em class="icon ni ni-arrow-left"></em>
                                                    <span>Dashboard</span>
                                                </a>
                                            </div>
                                            <h2 class="nk-block-title fw-normal" style="font-size: 35px; padding-top: 20px; color: black;">
                                                Email Settings
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="nk-block nk-block-lg">
                                        <div class="card">
                                            <div class="card-inner">
                                                <form  method="post" class="form-validate is-alter">
                                                    <div class="row g-gs">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fva-full-name">Host</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="fva-full-name" name="host"
                                                                        value="<?php echo htmlspecialchars($emailSettings['host']); ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-phone">Username</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" name="username" placeholder="Username"
                                                                        class="form-control" value="<?php echo htmlspecialchars($emailSettings['username']); ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-phone">Password</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="password" name="password"
                                                                        class="form-control" value="<?php echo htmlspecialchars($emailSettings['password']); ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-phone">Port</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" name="port"
                                                                        class="form-control" value="<?php echo htmlspecialchars($emailSettings['port']); ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-phone">Subject</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" name="subject"
                                                                        class="form-control" value="<?php echo htmlspecialchars($emailSettings['subject']); ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-phone">Body</label>
                                                                <div class="form-control-wrap">
                                                                    <textarea name="body" class="form-control" required><?php echo htmlspecialchars($emailSettings['body']); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button type="submit" name="update_email_settings" class="btn btn-lg btn-primary">Save Changes</button>
                                                            </div>
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

                <?php require_once("./main_components/footer.php"); ?>
            </div>
        </div>
    </div>
</body>
