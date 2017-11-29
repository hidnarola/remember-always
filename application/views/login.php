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
                label.addClass("validation-valid-label").text("Successfully")
            },
            rules: {
                password: {
                    minlength: 5
                }
            },
            messages: {
                email: "Enter your email",
                password: {
                    required: "Enter your password",
                    minlength: jQuery.validator.format("At least {0} characters required")
                }
            }
        });

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
                            <h5 class="content-group">Remember Always <small class="display-block">Your credentials</small></h5>
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
                            <input type="email" class="form-control" placeholder="Email" name="email" required="required">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group login-options">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="remember_me" class="styled" checked="checked" value="1">
                                        Remember
                                    </label>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <a href="<?php echo site_url('forgot_password') ?>">Forgot password?</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
                        </div>

                    </div>
                </form>
                <!-- /form with validation -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

