<script type="text/javascript" src="assets/admin/ckeditor/ckeditor.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-users2"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users2"></i> Users</a></li>
            <li class="active"><i class="icon-pencil7 position-left"></i> <?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<?php
if ($this->session->flashdata('success')) {
    ?>
    <div class="content pt0 flashmsg">
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert">X</a>
            <strong><?= $this->session->flashdata('success') ?></strong>
        </div>
    </div>
    <?php
    $this->session->set_flashdata('success', false);
} else if ($this->session->flashdata('error')) {
    ?>
    <div class="content pt0 flashmsg">
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert">X</a>
            <strong><?= $this->session->flashdata('error') ?></strong>
        </div>
    </div>
    <?php
    $this->session->set_flashdata('error', false);
} else {
    if (!empty(validation_errors())) {
        ?>
        <div class="content pt0 flashmsg">
            <div class = "alert alert-danger">
                <a class="close" data-dismiss="alert">X</a>
                <strong><?php echo validation_errors(); ?></strong>       
            </div>
            <?php
        }
    }
    ?>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <!-- Basic layout-->
                    <form  method="post" id="user_form" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                        <div class="panel panel-flat">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>First Name:</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($user_data['firstname']) ? $user_data['firstname'] : set_value('firstname'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Last Name:</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($user_data['lastname']) ? $user_data['lastname'] : set_value('lastname'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="text" name="email" id="email" class="form-control" value="<?php echo isset($user_data['email']) ? $user_data['email'] : set_value('email'); ?>">
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /basic layout -->
                </div>
            </div>
        </div>
        <?php $this->load->view('Templates/admin_footer'); ?>
    </div>
    <script type="text/javascript">
        $('document').ready(function () {

//            jQuery.validator.addMethod("check_email_exists", function (value, element) {
//                $.ajax({
//                    url: base_url + '/admin/users/email_validation',
//                    method: 'post',
//                    data: {email : value},
//                    success: function (response) {
//                        console.log(response);
//                    }
//                });
            $("#user_form").validate({
                ignore: [],
                errorClass: 'validation-error-label',
                successClass: 'validation-valid-label',
                highlight: function (element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                unhighlight: function (element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                validClass: "validation-valid-label",
                rules: {
                    firstname: {
                        required: true,
                    },
                    lastname: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    }

                },
                errorPlacement: function (error, element) {
//                    if (element.attr("name") == "banner_image") {
//                        error.insertAfter($(".uploader"));
//                    } else if (element.attr("name") == "description") {
//                        error.insertAfter(element.parent());
//                    } else {
                    error.insertAfter(element);
//                    }
                },
                submitHandler: function (form) {
                    $('button[type="submit"]').attr('disabled', true);
                    form.submit();
                },
            });
        }
        );
        $(".file-styled").uniform({
            fileButtonClass: 'action btn bg-pink'
        });
    </script>
