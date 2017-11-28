<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Remember Always - 404</title>
        <base href="<?php echo base_url() ?>">

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="assets/admin/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="assets/admin/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="assets/admin/css/core.css" rel="stylesheet" type="text/css">
        <link href="assets/admin/css/components.css" rel="stylesheet" type="text/css">
        <link href="assets/admin/css/colors.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="assets/admin/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="assets/admin/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="assets/admin/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/admin/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="assets/admin/js/core/app.js"></script>
        <!-- /theme JS files -->
    </head>

    <body class="login-container">

        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo site_url() ?>">Remember Always</a>

                <ul class="nav navbar-nav pull-right visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <?php if ($this->session->userdata('remalways_admin')['id'] != '') { ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown dropdown-user">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <?php if ($this->session->userdata('remalways_admin')['profile_image'] != '') { ?>
                                        <!--<img src="<?php echo base_url(USER_IMAGES . $this->session->userdata('remalways_admin')['profile_image']) ?>" alt="">-->
                                <?php } else { ?>
                                    <img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" alt="">
                                <?php } ?>
                                <span><?php echo $this->session->userdata('remalways_admin')['firstname'] . ' ' . $this->session->userdata('remalways_admin')['lastname'] ?></span>
                                <i class="caret"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="<?php echo site_url('admin/profile') ?>"><i class="icon-cog5"></i> Account settings</a></li>
                                <li><a href="<?php echo site_url('admin/logout'); ?>"><i class="icon-switch2"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main content -->
                <div class="content-wrapper">
                    <!-- Content area -->
                    <div class="content">
                        <!-- Error title -->
                        <div class="text-center content-group">
                            <h1 class="error-title">404</h1>
                            <h5>Oops, an error has occurred. Page not found!</h5>
                        </div>
                        <!-- /error title -->
                        <!-- Error content -->
                        <div class="row">
                            <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
                                <form action="#" class="main-search">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <a href="<?php echo site_url('home') ?>" class="btn btn-primary btn-block content-group"><i class="icon-circle-left2 position-left"></i> Go to dashboard</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /error wrapper -->
                        <!-- Footer -->
                        <div class="footer text-muted text-center">
                            &copy; 2017. <a href="<?php echo site_url()?>">Remember Always</a>, All Rights Reserved
                        </div>
                        <!-- /footer -->
                    </div>
                    <!-- /content area -->
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
</html>
