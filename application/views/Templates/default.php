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

        <base href="<?php echo base_url(); ?>">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/responsive.css" rel="stylesheet" />

        <script type="text/javascript">
            //Set common javascript variable
            var site_url = "<?php echo site_url() ?>";
            var base_url = "<?php echo base_url() ?>";
        </script>
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
        <script src="assets/js/jquery.validate.min.js"></script>
        <script src="assets/js/additional-methods.min.js"></script>
        <script src="assets/js/custom.js"></script>

    </head>
    <body>
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
                            <form method="post" id="login-form">
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
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                    <a href="">Forget your password?</a>
                                </div>
                                <div class="pup-btn">
                                    <button type="submit">LOG IN</button>
                                </div>
                                <div class="popup-or">
                                    <span>OR</span>
                                </div>
                                <div class="login-options">
                                    <a href=""><img src="assets/images/facebook-login.png" alt="" /></a>
                                    <a href=""><img src="assets/images/google-login.png" alt="" /></a>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="sign-up">
                            <form method="post" id="signup-form">
                                <div class="popup-input">
                                    <label>Email</label>
                                    <input type="text" name="email" placeholder="support@gmail.com" />
                                </div>
                                <div class="popup-input">
                                    <label>Password</label>
                                    <input type="password" id="password" name="password" placeholder="password" />
                                </div>
                                <div class="popup-input">
                                    <label>Confirm Password</label>
                                    <input type="password" name="con_password" placeholder="Confirm password" />
                                </div>
                                <div class="popup-input name-input">
                                    <label>Name</label>
                                    <input type="text" name="firstname" placeholder="Firt Name" />
                                    <input type="text" name="lastname" placeholder="Last Name" />
                                </div>

                                <div class="keep-me">
                                    <label class="custom-checkbox">Terms & condition
                                        <input type="checkbox" name="terms_condition" value="1">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="pup-btn">
                                    <button type="submit">Sign UP</button>
                                </div>
                                <div class="popup-or">
                                    <span>OR</span>
                                </div>
                                <div class="login-options">
                                    <a href=""><img src="assets/images/facebook-login.png" alt="" /></a>
                                    <a href=""><img src="assets/images/google-login.png" alt="" /></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>