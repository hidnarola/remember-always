<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-stack"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/home_slider'); ?>"><i class="icon-stack position-left"></i> Home Slider List</a></li>
            <li class="active"><i class="icon-pencil7 position-left"></i><?php echo $heading; ?></li>
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
            <form class="form-horizontal form-validate-jquery" id="slider_image_form" method="POST" enctype="multipart/form-data">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="message alert alert-danger" style="display:none"></div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Description</label>
                            <div class="col-lg-6">
                                <textarea name="description" id="description" placeholder="Enter Description" class="form-control" rows="5"><?php echo (isset($slider['description'])) ? $slider['description'] : set_value('description'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Upload Image <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <div class="media no-margin-top">
                                    <div class="media-left" id="image_preview_div">
                                        <?php
                                        $required = 'required';
                                        if (isset($slider) && $slider['image'] != '') {
                                            $required = '';
                                            if (preg_match("/\.(png|jpg|jpeg)$/", $slider['image'])) {
                                                ?>
                                                <img src="<?php echo SLIDER_IMAGES . $slider['image']; ?>" style="width: 58px; height: 58px; border-radius: 2px;" alt="">
                                            <?php } else { ?>
                                                <a class="fancybox" target="_blank" href="<?php echo SLIDER_IMAGES . $slider['image']; ?>" data-fancybox-group="gallery" ><img src="assets/admin/images/placeholder.jpg" height="55px" width="55px" alt="" class="img-circle"/></a>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" style="width: 58px; height: 58px; border-radius: 2px;" alt="">
                                        <?php } ?>
                                    </div>

                                    <div class="media-body">
                                        <input type="file" name="image" id="image" class="file-styled" <?php echo $required ?>>
                                        <span class="help-block">Accepted formats:  png, jpg , jpeg. Max file size <?php echo MAX_IMAGE_SIZE ?>MB</span>
                                    </div>
                                    <span></span>
                                </div>
                                <div id="proper_image" class="validation-error-label"></div>
                                <?php
                                if (isset($media_validation))
                                    echo '<label id="logo-error" class="validation-error-label" for="logo">' . $media_validation . '</label>';
                                ?>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
<script>is_valid = false;</script>
<?php if (isset($slider)) { ?>
    <script>is_valid = true;</script>
<?php } ?>
<script>
    $("#slider_image_form").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        validClass: "validation-valid-label",
        errorPlacement: function (error, element) {
            if (element[0]['id'] == "image") {
                error.insertAfter(element.parent().parent().next('span')); // select2
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            image: {
                extension: "jpg|png|jpeg",
                maxFileSize: {
                    "unit": "MB",
                    "size": max_image_size
                }
            }
        },
        submitHandler: function (form) {
            if (is_valid == true) {
                $('button[type="submit"]').attr('disabled', true);
                form.submit();
            }
        },
    });
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-pink'
    });
    $(document).on('change', '#image', function (e) {
        readURL(this);
    })
    var _validFileExtensions = [".jpg", ".jpeg", ".png", ];
    function readURL(input) {
        var height = 700, width = 1920, img = '', file = '', val = '';
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var valid_extensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (typeof (input.files[0]) != 'undefined') {
                    if (valid_extensions.test(input.files[0].name)) {

                        var html = '<img src="' + e.target.result + '" style="width: 58px; height: 58px; border-radius: 2px;" alt="">';
                    } else {
                        var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" alt="">';
                    }
                } else {
                    var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" alt="">';
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
                        $('#proper_image').html('Photo should be ' + width + ' X ' + height + ' or more dimensions');
                    } else {
                        is_valid = true;
                        $('#proper_image').html('');
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        }
    }
</script>
