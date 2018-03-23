<script type="text/javascript" src="assets/admin/ckeditor/ckeditor.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-office"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/affiliations'); ?>"><i class="icon-office"></i> Affiliations</a></li>
            <li class="active"><i class="icon-pencil7 position-left"></i> <?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($this->session->flashdata('success')) {
                ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
                <?php
            } else if ($this->session->flashdata('error')) {
                ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
                <?php
            } else {
                if (!empty(validation_errors())) {
                    ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo validation_errors(); ?></strong>       
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <!-- Basic layout-->
                <form method="post" id="page_info" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Select Affiliation Category: <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-control selectpicker">
                                    <option value="">-- Select Category --</option>
                                    <?php
                                    if (isset($categories) && !empty($categories)) {
                                        foreach ($categories as $key => $value) {
                                            $selected = '';
                                            if (isset($affiliation['category_id']) && $affiliation['category_id'] == $value['id']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>"><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Name: <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($affiliation['name']) ? $affiliation['name'] : set_value('name'); ?>" placeholder="Please enter name">
                            </div>
                            <div class="form-group">
                                <label>Description: <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="4" cols="4" class="form-control"><?php echo isset($affiliation['description']) ? $affiliation['description'] : set_value('description'); ?></textarea>
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
                                                    if (isset($affiliation) && $affiliation['country'] == $value['id']) {
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
                                                    if (isset($affiliation) && $affiliation['state'] == $value['id']) {
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
                                        <select name="city" id="city" class="form-control selectpicker">
                                            <option value="">-- Select City --</option>
                                            <?php
                                            if (isset($cities) && !empty($cities)) {
                                                foreach ($cities as $key => $value) {
                                                    $selected = '';
                                                    if (isset($affiliation) && $affiliation['city'] == $value['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option <?php echo $selected; ?> value="<?php echo $value['name'] ?>" <?php echo $this->input->method() == 'post' ? set_select('city', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <label id="city-error" class="validation-error-label" for="city"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Image: <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="media-left col-md-2" id="image_preview_div">
                                        <?php
                                        $required = 'required';
                                        if (isset($affiliation) && $affiliation['image'] != '') {
                                            $required = '';
                                            if (preg_match("/\.(png|jpg|jpeg)$/", $affiliation['image'])) {
                                                ?>
                                                <img src="<?php echo AFFILIATION_IMAGE . $affiliation['image']; ?>" style="width: 110px; height: 90px; border-radius: 2px;" alt="">
                                            <?php } else { ?>
                                                <a class="fancybox" target="_blank" href="<?php echo AFFILIATION_IMAGE . $affiliation['image']; ?>" data-fancybox-group="gallery" ><img src="assets/admin/images/placeholder.jpg" height="90px" width="110px" alt="" class="img-circle"/></a>
                                            <?php } ?>
    <!--<button class="btn btn-danger delete_image" type="button" onclick="delete_media('<?php // echo base64_encode($affiliation['id'])                   ?>')"><i class="icon-trash"></i> Remove</button>-->
                                        <?php } else {
                                            ?>
                                            <img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" style="width: 110px; height: 90px; border-radius: 2px;" alt="">
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="media-body">
                                            <input type="file" name="image" id="image" class="file-styled" <?php echo $required ?>>
                                            <span class="help-block">Accepted formats:  png, jpg , jpeg. Max file size <?php echo MAX_IMAGE_SIZE ?>MB</span>
                                        </div>
                                        <div class="proper_image validation-error-label"></div>
                                    </div>
                                </div>
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
<?php if (isset($affiliation)) { ?>
        is_valid = true;
<?php } else { ?>
        is_valid = false;
<?php } ?>
    $('.fancybox').fancybox();
    $('#category_id,#country,#state').selectpicker({
        liveSearch: true,
        size: 5
    });
    $("#city").select2({
        tags: true,
        theme: "bootstrap"
    });

    $('document').ready(function () {
        $("#page_info").validate({
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
                category_id: {
                    required: true,
                },
                name: {
                    required: true,
                },
                description: {
                    required: true,
                },
                country: {
                    required: true,
                },
                image: {
//                    required: true,
                    extension: "jpg|png|jpeg",
                    maxFileSize: {
                        "unit": "MB",
                        "size": max_image_size
                    }
                }
            },
            messages: {
                phone: {
                    phoneUS: "Please specify valid us phone number."
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "image") {
                    error.insertAfter($(".uploader"));
                } else if (element.hasClass('selectpicker')) {
                    error.insertAfter(element.parent().find('.bootstrap-select'));
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function (form) {
                if (is_valid == true) {
                    $('button[type="submit"]').attr('disabled', true);
                    form.submit();
                }
            },
        });
    });

    $(document).on('change', '#country', function () {
        var country_id = $("#country option:selected").val();
        $url = '<?php echo base_url() ?>' + 'admin/affiliations/get_data';
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
        $url = '<?php echo base_url() ?>' + 'admin/affiliations/get_data';
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
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-pink'
    });
    $(document).on('change', '#image', function (e) {
        readURL(this);
    });
    var _validFileExtensions = [".jpg", ".jpeg", ".png", ];
    function readURL(input) {
        var height = 110, width = 110, img = '', file = '', val = '';
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var valid_extensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (typeof (input.files[0]) != 'undefined') {
                    if (valid_extensions.test(input.files[0].name)) {

                        var html = '<img src="' + e.target.result + '" style="width: 110px; height: 90px; border-radius: 2px;" alt="">';
                    } else {
                        var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 110px; height: 90px; border-radius: 2px;" alt="">';
                    }
                } else {
                    var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 110px; height: 90px; border-radius: 2px;" alt="">';
                }
                $('#image_preview_div').html(html);
            }
            reader.readAsDataURL(input.files[0]);
            // check slider image dimension
            var _URL = window.URL || window.webkitURL;
            if ((file = input.files[0])) {
                img = new Image();
                img.onload = function () {
                    if (this.width < width && this.height < height) {
                        is_valid = false;
                        $('.proper_image').html('Photo should be ' + width + ' X ' + height + ' or more dimensions');
                    } else {
                        is_valid = true;
                        $('.proper_image').html('');
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        }
    }

    function delete_media(data) {
        $.ajax({
            url: site_url + "admin/affiliations/delete_image",
            type: "POST",
            data: {'image': data},
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 110px; height: 90px; border-radius: 2px;" alt="">';
                    $('#image_preview_div').html(html);
                    $('.delete_image').addClass('hide');
                } else {
//                    showErrorMSg(data.error);
                }
            }
        });
    }
</script>
<style>
    .hide {
        display: none;
    }
</style>