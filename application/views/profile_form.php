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
                profile_image: {
                    required: true
                },
                firstname: {
                    required: true
                },
                lastname: {
                    required: true
                },
                date_of_birth: {
                    required: true
                },
                date_of_death: {
                    required: true
                }
            },

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
                <form action="" class="form-validate" method="post" enctype="multipart/form-data">
                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <h5 class="content-group">Remember Always</h5>
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
                        <div class="form-group">
                            <input type="file" class="form-control" placeholder="Profile Image" name="profile_image" required="required">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Firstname" name="firstname" required="required">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Lastname" name="lastname" required="required">
                        </div>
                        <div class="form-group">
                            <textarea name="tag_line" class="form-control" placeholder="Tag Line"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea name="fun_facts" class="form-control" placeholder="Fun Facts"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Date of Birth" name="date_of_birth" required="required">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Date of Death" name="date_of_death" required="required">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn bg-blue btn-block">Create <i class="icon-arrow-right14 position-right"></i></button>
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

