<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $title; ?></title>

        <!-- Bootstrap -->
        <link href="https://fonts.googleapis.com/css?family=Oswald:300,700|Roboto:400,500|Rubik:300,400,500,700,900" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"  rel="stylesheet">
        <base href="<?php echo base_url(); ?>">

        <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico" >
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="assets/css/owl.carousel.css" rel="stylesheet" />
        <link href="assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
        <link href="assets/css/sweetalert2.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/responsive.css" rel="stylesheet" />
        <link href="assets/css/developer.css" rel="stylesheet" />
        <link href="assets/css/responsive.css" rel="stylesheet" />
        <link href="assets/css/pnotify.custom.min.css" rel="stylesheet" />
        <link href="assets/css/jquery.fancybox.css" rel="stylesheet" />
        <script type="text/javascript">
            //Set common javascript variable
            var site_url = "<?php echo site_url() ?>";
            var google_map_key = "<?php echo GOOGLE_MAP_KEY ?>";
            var base_url = "<?php echo base_url() ?>";
            var current_dir = '<?php echo $this->router->fetch_directory() ?>';
            var s_msg = "<?php echo $this->session->flashdata('success') ?>";
            var e_msg = "<?php echo $this->session->flashdata('error') ?>";
            var reset_pwd = 0;
            var max_image_size = <?php echo MAX_IMAGE_SIZE ?>;
            var max_video_size = <?php echo MAX_VIDEO_SIZE ?>;
            var max_images_count = <?php echo MAX_IMAGES_COUNT ?>;
            var max_videos_count = <?php echo MAX_VIDEOS_COUNT ?>;
        </script>
        <?php if (isset($reset_password)) { ?>
            <script>reset_pwd = 1;</script>
        <?php } ?>
        <noscript>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=js_disabled">
        </noscript>    

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/bootstrap-select.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/jquery.validate.min.js"></script>
        <script src="assets/js/additional-methods.min.js"></script>
        <script src="assets/js/pnotify.custom.min.js"></script> 
        <script src="assets/js/jquery.fancybox.js"></script>
        <script src="assets/js/jquery.fancybox.pack.js"></script>
        <script type="text/javascript" src="assets/js/sweetalert2.all.min.js"></script>
        <script src="assets/js/jquery.mCustomScrollbar.js"></script>
        <script src="assets/js/typeahead.bundle.js"></script>
        <script src="assets/js/custom.js"></script> 

    </head>
    <?php
    $body_class = '';
    if ($this->controller != 'home') {
        $body_class = 'inr-pages';
    }
    ?>
    <body class="<?php echo $body_class ?>">
        <?php
        $this->load->view('Templates/default_header');
        echo $body;
        $this->load->view('Templates/default_footer');
        ?>
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="login-signup">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#log-in" aria-controls="home" role="tab" data-toggle="tab">Log IN</a></li>
                        <li role="presentation"><a href="#sign-up" aria-controls="profile" role="tab" data-toggle="tab">Sign up</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="log-in">
                            <form method="post" id="login-form" action="<?php echo site_url('login') ?>">
                                <div class="popup-input">
                                    <label>Email</label>
                                    <input type="text" name="email" placeholder="support@gmail.com" />
                                </div>
                                <div class="popup-input">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="password" />
                                </div>
                                <div class="keep-me">
                                    <label class="custom-checkbox">keep me signed in
                                        <input type="checkbox" name="remember_me" value="1">
                                        <span class="checkmark"></span>
                                    </label>
                                    <!--<a data-target="#forgot-pwdmodal" data-toggle="modal">Forget your password?</a>-->
                                    <a href="javascript:void(0)" onclick="showForgotModal()">Forget your password?</a>
                                </div>
                                <div class="pup-btn">
                                    <button type="submit" id="login_form_btn">LOG IN</button>
                                </div>
                                <div class="popup-or">
                                    <span>OR</span>
                                </div>
                                <div class="login-options">
                                    <a href="<?php echo site_url('facebook') ?>"><img src="assets/images/facebook-login.png" alt="" /></a>
                                    <a href="<?php echo site_url('google') ?>"><img src="assets/images/google-login.png" alt="" /></a>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="sign-up">
                            <form method="post" id="signup-form" action="<?php echo site_url('signup') ?>">
                                <div class="popup-input">
                                    <label>Email</label>
                                    <input type="text" name="email" placeholder="support@gmail.com" />
                                </div>
                                <div class="popup-input">
                                    <label>Password</label>
                                    <input type="password" name="password" id="password" placeholder="Password" />
                                </div>
                                <div class="popup-input">
                                    <label>Confirm Password</label>
                                    <input type="password" name="con_password" placeholder="Confirm password" />
                                </div>
                                <div class="popup-input name-input">
                                    <label>Name</label>
                                    <div class="first-last">
                                        <input type="text" name="firstname" placeholder="First Name" />
                                    </div>
                                    <div class="last-first">
                                        <input type="text" name="lastname" placeholder="Last Name" />
                                    </div>
                                </div>

                                <div class="keep-me">
                                    <label class="custom-checkbox">Terms & condition
                                        <input type="checkbox" name="terms_condition" value="1">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="pup-btn">
                                    <button type="submit" id="signup_form_btn">Sign UP</button>
                                </div>
                                <div class="popup-or">
                                    <span>OR</span>
                                </div>
                                <div class="login-options">
                                    <a href="<?php echo site_url('facebook') ?>"><img src="assets/images/facebook-login.png" alt="" /></a>
                                    <a href="<?php echo site_url('google') ?>"><img src="assets/images/google-login.png" alt="" /></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="forgot-pwdmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="login-signup">
                    <div class="mpopup-header">
                        Password recovery
                    </div>
                    <div class="mpopup-body">
                        <form method="post" id="forgot_password_form" action="<?php echo site_url('forgot_password') ?>">
                            <div class="popup-input">
                                <label>Email</label>
                                <input type="text" name="email" id="email" placeholder="Your email" />
                            </div>
                            <div class="keep-me">
                                <a href="javascript:void(0)" onclick="loginforgetModal()">Back to login?</a>
                            </div>
                            <div class="pup-btn">
                                <button type="submit" id="reset_password_btn">RESET PASSWORD</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="resetpwd-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="login-signup">
                    <div class="mpopup-header">
                        Change Password
                    </div>
                    <div class="mpopup-body">
                        <?php
                        $reset_pwd_code = '';
                        if (isset($reset_password_code)) {
                            $reset_pwd_code = $reset_password_code;
                        }
                        ?>
                        <form method="post" id="reset_password_form" action="<?php echo site_url('reset_password?code=' . $reset_pwd_code) ?>">
                            <div class="popup-input">
                                <label>Password</label>
                                <input type="password" name="password" id="reset_password" placeholder="Password" />
                            </div>
                            <div class="popup-input">
                                <label>Confirm Password</label>
                                <input type="password" name="con_password" id="con_password" placeholder="Confirm Password" />
                            </div>
                            <div class="keep-me">
                                <a href="javascript:void(0)" onclick="loginrestModal()">Back to login?</a>
                            </div>
                            <div class="pup-btn">
                                <button type="submit" id="change_password_btn">CHANGE PASSWORD</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade post-modal" id="post-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="login-signup">
                     <div class="mpopup-body">
                         <p>Post is Empty. Please enter post comment or slect image or video file for post.</p>
                         <button type="button" onclick="$('#post-modal').modal('toggle')" class="fa fa-close"></button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>