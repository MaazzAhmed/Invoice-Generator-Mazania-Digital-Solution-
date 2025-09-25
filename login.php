<?php require_once("./main_components/global.php"); ?>
<!DOCTYPE html>

<html lang="zxx" class="js">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />



<head>

    <meta charset="utf-8">

    <meta name="author" content="Softnio">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description"

        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">

    <link rel="shortcut icon" href="images/favicon.png">

    <title>Invoice Generator | Powered By Mazania</title>

    <link rel="stylesheet" href="assets/css/dashlite324d.css?ver=3.1.0">

    <link id="skin-default" rel="stylesheet" href="assets/css/theme324d.css?ver=3.1.0">



</head>



<body class="nk-body bg-white npc-default pg-auth">




    <div class="nk-app-root">

        <div class="nk-main ">

            <div class="nk-wrap nk-wrap-nosidebar">

                <div class="nk-content ">

                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">

                        <div class="brand-logo pb-4 text-center"><a href="index-2.html" class="logo-link"><img

                                    class="logo-light logo-img logo-img-lg" src="images/logo.png"

                                     alt="logo"><img

                                    class="logo-dark logo-img logo-img-lg" src="images/logo-dark.png" alt="logo-dark"></a></div>

                        <div class="card">

                            <div class="card-inner card-inner-lg">

                                <div class="nk-block-head">

                                    <div class="nk-block-head-content">

                                        <h4 class="nk-block-title">Sign-In</h4>

                                        <div class="nk-block-des">

                                            <p>Access the Dashlite panel using your email and passcode.</p>

                                        </div>

                                    </div>

                                </div>



                                <?php if (!empty($error)): ?>

                                    <div class="alert alert-danger alert-icon"><em class="icon ni ni-cross-circle"></em>

                                        <strong>Unable to Login </strong>

                                        <?php echo $error; ?>

                                    </div>



                                <?php endif; ?>

                                <form action="" method="post">

                                    <div class="form-group">

                                        <div class="form-label-group"><label class="form-label"

                                                for="default-01">Email</label></div>

                                        <div class="form-control-wrap">

                                            <input type="text" class="form-control form-control-lg" name="email"

                                                placeholder="Enter your Email Address">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <div class="form-control-wrap"><a href="#"

                                                class="form-icon form-icon-right passcode-switch lg"

                                                data-target="password"><em

                                                    class="passcode-icon icon-show icon ni ni-eye"></em><em

                                                    class="passcode-icon icon-hide icon ni ni-eye-off"></em></a>

                                            <input type="password" class="form-control form-control-lg" name="password"

                                                placeholder="Enter your Password">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <button class="btn btn-lg btn-primary btn-block" name="login"

                                            type="submit">Login</button>

                                    </div>

                                </form>





                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>









    <?php require_once("./main_components/footer.php") ?>



</html>