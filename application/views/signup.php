<script type="text/javascript">
    $(function () {

        // Setup validation
        $(".form-validate").validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-error-label',
            successClass: 'validation-valid-label',
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },

            // Different components require proper error label placement
            errorPlacement: function (error, element) {

                // Styled checkboxes, radios, bootstrap switch
                if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container')) {
                    if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                        error.appendTo(element.parent().parent().parent().parent());
                    } else {
                        error.appendTo(element.parent().parent().parent().parent().parent());
                    }
                }

                // Unstyled checkboxes, radios
                else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                    error.appendTo(element.parent().parent().parent());
                }

                // Input with icons and Select2
                else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                    error.appendTo(element.parent());
                }

                // Inline checkboxes, radios
                else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo(element.parent().parent());
                }

                // Input group, styled file input
                else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                    error.appendTo(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
            validClass: "validation-valid-label",
            success: function (label) {
                label.addClass("validation-valid-label")
            },
            rules: {
                email: {
                    email: true,
                    required: true,
                    remote: '<?php echo site_url('signup/check_email') ?>'
                },
                firstname: {
                    required: true,
                },
                lastname: {
                    required: true,
                },
                password: {
                    minlength: 5
                }
            },
            messages: {
                email: {
                    remote: jQuery.validator.format("Email already exist!")
                },
                firstname: {
                    required: "Firstname is required",
                },
                lastname: {
                    required: "Lastname is required",
                },
                password: {
                    required: "Enter your password",
                    minlength: jQuery.validator.format("At least {0} characters required")
                }
            }
        });

    });

</script>

<script>
    function checkLoginState() {
        FB.getLoginStatus(function (response) {
            statusChangeCallback(response);
        });
    }
    window.fbAsyncInit = function () {
        FB.init({
            appId: '131151487573446',
            cookie: true,
            xfbml: true,
            version: '{latest-api-version}'
        });

        FB.AppEvents.logPageView();

    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    FB.getLoginStatus(function (response) {
        statusChangeCallback(response);
    });
</script>
<!-- /theme JS files -->
<!-- Page container -->
<div class="container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content pb-20">
                <!-- Form with validation -->
                <form action="" class="form-validate" method="post">
                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <h5 class="content-group">Remember Always </h5>
                        </div>
                        <?php
                        if (isset($error) && !empty($error)) {
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                        if ($this->session->flashdata('success')) {
                            echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                        }
                        if ($this->session->flashdata('error')) {
                            echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                        }
                        ?>
                        <div class="form-group has-feedback has-feedback-left">
                            <input type="email" class="form-control" placeholder="Email" name="email" id="email" required="required" value="<?php echo set_value('email') ?>">
                            <?php echo '<label id="email-error" class="validation-error-label" for="email">' . form_error('email') . '</label>'; ?>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" class="form-control" placeholder="Firstname" name="firstname" id="firstname" required="required" value="<?php echo set_value('firstname') ?>">
                            <?php echo '<label id="firstname-error" class="validation-error-label" for="firstname">' . form_error('firstname') . '</label>'; ?>
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" class="form-control" placeholder="Lastname" name="lastname" required="required" value="<?php echo set_value('lastname') ?>">
                            <?php echo '<label id="lastname-error" class="validation-error-label" for="lastname">' . form_error('lastname') . '</label>'; ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn bg-blue btn-block">Create Account <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </form>
                <div class="form-group">
                    <div class="col-md-12">
                        <fb:login-button 
                            scope="public_profile,email"
                            onlogin="checkLoginState();">
                        </fb:login-button>
                        <a href="<?php echo site_url('/facebook') ?>" class="btn btn-primary">Sign up with Facebook</a>
                        &nbsp;<a href="<?php echo site_url('/google') ?>" class="btn btn-danger">Sign up with Google</a>
                    </div>
                </div>
                <!-- /form with validation -->
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->

