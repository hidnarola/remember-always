<!-- Page container -->
<div class="container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Password recovery -->
                <form action="" method="post" id="reset_password_form">
                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
                            <h5 class="content-group">Change Password </h5>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            <div class="form-control-feedback">
                                <i class="icon-key text-muted"></i>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" name="con_password" class="form-control" placeholder="Confirm Password">
                            <div class="form-control-feedback">
                                <i class="icon-key text-muted"></i>
                            </div>
                        </div>
                        <div class="form-group login-options">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="<?php echo site_url('login') ?>">Back to Login</a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn bg-blue btn-block" id="change_password">Change password <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </form>
                <!-- /password recovery -->
            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

</body>
<script type="text/javascript">
    $("#reset_password_form").validate({
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
            password: {
                required: true,
                minlength: 5
            },
            con_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long"
            },
            con_password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
        },
        submitHandler: function (form) {
            $('#change_password').attr('disabled', true);
            form.submit();
        }
    });

</script>
