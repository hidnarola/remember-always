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
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            if ($this->session->flashdata('success')) {
                ?>
                <div class="alert alert-success hide-msg">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <strong><?php echo $this->session->flashdata('success') ?></strong>
                </div>
                <?php
            } else if ($this->session->flashdata('error')) {
                ?>
                <div class="alert alert-danger hide-msg">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <strong><?php echo $this->session->flashdata('error') ?></strong>
                </div>

            <?php } elseif (!empty(validation_errors())) {
                ?>
                <div class="alert alert-danger hide-msg">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <strong><?php echo validation_errors() ?></strong>
                </div>
            <?php }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <!-- Basic layout-->
                <form  method="post" id="user_form" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>First Name: <span class="text-danger">*</span></label>
                                        <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($user_data['firstname']) ? $user_data['firstname'] : set_value('firstname'); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Last Name: <span class="text-danger">*</span></label>
                                        <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($user_data['lastname']) ? $user_data['lastname'] : set_value('lastname'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email: <span class="text-danger">*</span></label>
                                <input type="text" name="email" id="email" class="form-control" value="<?php echo isset($user_data['email']) ? $user_data['email'] : set_value('email'); ?>">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="label-css">Address 1 <span class="text-danger">*</span></label>
                                        <input type="text" name="address1" class="form-control" value="<?php echo (isset($user_data['address1'])) ? $user_data['address1'] : set_value('address1') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="label-css">Address 2 </label>
                                        <input type="text" name="address2"  class="form-control" value="<?php echo (isset($user_data['address2'])) ? $user_data['address2'] : set_value('address2') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Country: <span class="text-danger">*</span></label>
                                        <select name="country" id="country" class="form-control selectpicker">
                                            <option value="">-- Select Country --</option>
                                            <?php
                                            if (isset($countries) && !empty($countries)) {
                                                foreach ($countries as $key => $value) {
                                                    $selected = '';
                                                    if (isset($user_data['country']) && $user_data['country'] == $value['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('state', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>State: <span class="text-danger">*</span></label>
                                        <select name="state" id="state" class="form-control selectpicker">
                                            <option value="">-- Select State --</option>
                                            <?php
                                            if (isset($states) && !empty($states)) {
                                                foreach ($states as $key => $value) {
                                                    $selected = '';
                                                    if (isset($user_data['state']) && $user_data['state'] == $value['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('state', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>City: <span class="text-danger">*</span></label>
                                        <!--<input type="text" name="city" id="city" class="form-control" value="<?php // echo isset($affiliation['city']) ? $affiliation['city'] : set_value('city');                                           ?>">-->
                                        <select name="city" id="city" class="form-control selectpicker">
                                            <option value="">-- Select City --</option>
                                            <?php
                                            if (isset($cities) && !empty($cities)) {
                                                foreach ($cities as $key => $value) {
                                                    $selected = '';
                                                    if (isset($user_data['city']) && $user_data['city'] == $value['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('city', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Zipcode: <span class="text-danger">*</span></label>
                                <input type="text" name="zipcode" class="form-control" value="<?php echo (isset($user_data['zipcode'])) ? $user_data['zipcode'] : set_value('zipcode') ?>">
                            </div>
                            <div class="form-group">
                                <label>Phone: <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" value="<?php echo (isset($user_data['phone'])) ? $user_data['phone'] : set_value('phone') ?>">
                            </div>
                            <?php if (isset($user_data) && $user_data['facebook_id'] == '' && $user_data['google_id'] == '') { ?>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Profile</label>
                                        <div class="media no-margin-top">
                                            <div class="media-left" id="image_preview_div">
                                                <?php
                                                if ($user_data['profile_image'] != '') {
                                                    ?>
                                                    <img src="<?php echo USER_IMAGES . $user_data['profile_image']; ?>" style="width: 58px; height: 58px; border-radius: 2px;" alt="">
                                                <?php } else {
                                                    ?>
                                                    <img src="assets/admin/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="media-body">
                                                <input type="file" name="profile_image" id="profile_image" class="file-styled" onchange="readURL(this);ValidateSingleInput(this);">
                                                <span class="help-block">Accepted formats: png, jpg.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
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
<div id="validation_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-teal-400">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"></h6>
            </div>
            <div class="modal-body panel-body validation_alert">
                <label></label>
            </div>
        </div>
    </div>
</div>
<style>
    .hide {
        display: none;
    }
</style>
<script type="text/javascript">
    $('document').ready(function () {
        $('#country').selectpicker({
            liveSearch: true,
            size: 5
        });
        $('#state').selectpicker({
            liveSearch: true,
            size: 5
        });
        $('#city').selectpicker({
            liveSearch: true,
            size: 5
        });
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
                },
                phone: {
                    required: true,
                    phoneUS: true
                },
                address1: {
                    required: true,
                },
                country: {
                    required: true,
                },
                state: {
                    required: true,
                },
                city: {
                    required: true,
                },
                zipcode: {
                    required: true,
                    customzipcode: true
                },

            },
            errorPlacement: function (error, element) {
                if (element.hasClass('selectpicker')) {
                    error.insertAfter(element.parent().find('.bootstrap-select'));
                } else {
                    error.insertAfter(element);
                }
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

    $(document).on('change', '#country', function () {
        var country_id = $("#country option:selected").val();
        $url = '<?php echo base_url() ?>' + 'admin/users/get_data';
        $.ajax({
            type: "POST",
            url: $url,
            data: {
                id: country_id,
                type: 'state',
            }
        }).done(function (data) {
            if (data != '') {
                $("select#state").html(data);
                $("select#state").selectpicker('refresh');
            }
        });
    });
    $(document).on('change', '#state', function () {
        var state_id = $("#state option:selected").val();
        $url = '<?php echo base_url() ?>' + 'admin/users/get_data';
        $.ajax({
            type: "POST",
            url: $url,
            data: {
                id: state_id,
                type: 'city',
            }
        }).done(function (data) {
            if (data != '') {
                $("select#city").html(data);
                $("select#city").selectpicker('refresh');
            }
        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var valid_extensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (typeof (input.files[0]) != 'undefined') {
                    if (valid_extensions.test(input.files[0].name)) {
                        var html = '<img src="' + e.target.result + '" style="width: 58px; height: 58px; border-radius: 2px;" alt="">';
                    } else {
                        var html = '<img src="assets/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" alt="">';
                    }
                } else {
                    var html = '<img src="assets/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" alt="">';
                }
                $('#image_preview_div').html(html);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


    var _validFileExtensions = [".jpg", ".jpeg", ".png"];
//    var _validFileExtensions_Video = [".mp4", ".webm", ".ogv", ".png",".MPG",".MPEG" ,".OGG",".ogg",".mpeg"];    
    function ValidateSingleInput(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                if (!blnValid) {
                    $(".validation_alert label").text("Sorry, invalid file, allowed extensions are: " + _validFileExtensions.join(", "));
                    $("#validation_modal").modal();
                    oInput.value = "";
                    return false;
                }
            }
        }
        return true;
    }
</script>
