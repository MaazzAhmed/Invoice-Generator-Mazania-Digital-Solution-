<div class="nk-header nk-header-fixed is-light">

    <div class="container-fluid">

        <div class="nk-header-wrap">

            <div class="nk-menu-trigger d-xl-none ms-n1"><a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a></div>

            <div class="nk-header-brand d-xl-none"><a href="index-2.php" class="logo-link"><img class="logo-light logo-img" src="images/logo-dark.png" alt="logo"><img class="logo-dark logo-img" src="images/logo-dark.png"  alt="logo-dark"></a></div>

            <div class="nk-header-search ms-3 ms-xl-0"></div>

            <div class="nk-header-tools">

                <ul class="nk-quick-nav">







                    <li class="dropdown user-dropdown"><a href="#" class="dropdown-toggle me-n1" data-bs-toggle="dropdown">

                            <div class="user-toggle">

                                <div class="user-avatar sm"><em class="icon ni ni-user-alt"></em></div>

                                <div class="user-info d-none d-xl-block">

                                    <div class="user-status user-status-verified">Online</div>

                                    <div class="user-name dropdown-indicator"><?php echo $_SESSION['user'] ?></div>

                                </div>

                            </div>

                        </a>

                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">

                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">

                                <div class="user-card">

                                    <div class="user-avatar"><span>





                                            <em class="icon ni ni-user-alt"></em>

                                        </span></div>

                                    <div class="user-info"><span class="lead-text"><?php echo $_SESSION['user'] ?></span><span class="sub-text"><?php echo $_SESSION['email'] ?></span></div>

                                </div>

                            </div>



                            <?php

$currentPage = basename($_SERVER['PHP_SELF']); 



if ($currentPage != 'create_invoice.php') {

?>

    <div class="dropdown-inner">

        <ul class="link-list">

            <li>

                <form id="logoutForm" action="" method="post">

                    <input type="hidden" name="access_token" value="123">

                    <button class="logbt" type="submit" name="logout_user">Log Out</button>

                </form>

            </li>

        </ul>

    </div>

<?php

}

?>



                        </div>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>