<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php
        $this->load->view('Templates/admin_header');
        ?>
        <script type="text/javascript">
            //-- Set common javascript vairable
            var site_url = "<?php echo site_url() ?>";
            var base_url = "<?php echo base_url() ?>";
            var max_image_size = <?php echo MAX_IMAGE_SIZE ?>;
<?php
$Path = $_SERVER['PATH_INFO'];
?>
        </script>
        <noscript>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=js_disabled">
        </noscript>    
    </head>
    <body>
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo site_url('admin/dashboard'); ?>">
                    <!--<img src="assets/images/logo_light.png" alt="">-->
                    Remember Always
                </a>
                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>
            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <?php if ($this->session->userdata('remalways_admin')['profile_image'] != '') { ?>
                                <img src="<?php echo base_url(USER_IMAGES . $this->session->userdata('remalways_admin')['profile_image']) ?>" alt="">
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
            </div>
        </div>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main sidebar -->
                <div class="sidebar sidebar-main">
                    <div class="sidebar-content">
                        <!-- User menu -->
                        <div class="sidebar-user">
                            <div class="category-content">
                                <div class="media">
                                    <a href="#" class="media-left">
                                        <?php if ($this->session->userdata('remalways_admin')['profile_image'] != '') { ?>
                                            <img src="<?php echo base_url(USER_IMAGES . $this->session->userdata('remalways_admin')['profile_image']) ?>" class="img-circle img-sm" alt="">
                                        <?php } else { ?>
                                            <img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" class="img-circle img-sm" alt="">
                                        <?php } ?>
                                    </a>
                                    <div class="media-body">
                                        <span class="media-heading text-semibold">Remember Always</span>
                                        <div class="text-size-mini text-muted">
                                            <i class="icon-user"></i> &nbsp;<?php echo ($this->session->userdata('remalways_admin')['role'] == 'admin') ? 'admin' : 'user'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /user menu -->
                        <!-- Main navigation -->
                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <ul class="navigation navigation-main navigation-accordion">
                                    <li <?php echo strtolower($this->controller) == 'dashboard' ? 'class="active"' : '' ?>><a href="<?php echo site_url('admin/dashboard') ?>"><i class="icon-home2"></i><span>Dashboard</span></a></li>
                                    <li <?php echo strtolower($this->controller) == 'pages' ? 'class="active"' : '' ?>><a href="<?php echo site_url('admin/pages') ?>"><i class="icon-magazine"></i><span>Manage Pages</span></a></li>
                                    <li <?php echo strtolower($this->controller) == 'home_slider' ? 'class="active"' : '' ?>><a href="<?php echo site_url('admin/home_slider') ?>"><i class="icon-stack"></i><span>Home Slider</span></a></li>
                                    <li <?php echo strtolower($this->controller) == 'categories' || strtolower($this->controller) == 'affiliations' ? 'class="active"' : '' ?>>
                                        <a href="#" class="has-ul"><i class="icon-grid"></i> <span>Categories</span></a>
                                        <ul class="hidden-ul" style="<?php echo strtolower($this->controller) == 'categories' || strtolower($this->controller) == 'affiliation_categories' ? 'display:block' : '' ?>">
                                            <li <?php echo strtolower($this->controller) == 'categories' ? 'class="active"' : '' ?>><a href="<?php echo site_url('admin/categories') ?>"><i class="icon-list-unordered"></i><span>Service</span></a></li>
                                            <li <?php echo strtolower($this->controller) == 'affiliation_categories' ? 'class="active"' : '' ?>><a href="<?php echo site_url('admin/affiliation_categories') ?>"><i class="icon-list-unordered"></i><span>Affiliation</span></a></li>
                                        </ul>
                                    </li>
                                    <li <?php echo strtolower($this->controller) == 'providers' ? 'class="active"' : '' ?>><a href="<?php echo site_url('admin/providers') ?>"><i class="icon-hammer-wrench"></i><span>Service Providers</span></a></li>
                                    <li <?php echo strtolower($this->controller) == 'posts' && !preg_match("/\/users\//i", $Path) ? 'class="active"' : '' ?>><a href="<?php echo site_url('admin/posts') ?>"><i class="icon-comment"></i><span>Posts</span></a></li>
                                    <li <?php echo strtolower($this->controller) == 'users' || preg_match("/\/users\//i", $Path) ? 'class="active"' : '' ?>><a href="<?php echo site_url('admin/users') ?>"><i class="icon-users2"></i><span>Users</span></a></li>
                                    <li class=""><a href="<?php echo site_url('logout') ?>"><i class="icon-switch2"></i> <span>Logout</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /main navigation -->
                    </div>
                </div>
                <!-- /main sidebar -->
                <!-- Main content -->
                <div class="content-wrapper">
                    <!-- Page header -->
                    <?php echo $body; ?>
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
    <script>
    </script>
    <style>
        .fancybox-close:after {display: none;}
        .fancybox-nav span:after {display: none;}
    </style>
    <script type="text/javascript">
        $(document).keypress(
                function (event) {
                    if (event.which == '13') {
                        event.preventDefault();
                    }
                });
    </script>
</html>
