<link type="text/css" href="assets/admin/css/fileinput.css">
<script type="text/javascript" src="assets/admin/js/fileinput.js"></script>
<script type="text/javascript" src="assets/admin/ckeditor/ckeditor.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-books"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/blog_post'); ?>"><i class="icon-books position-left"></i> Blog Posts</a></li>
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
            <div class="col-md-12">
                <!-- Basic layout-->
                <form  method="post" id="blogpost_form" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Posted by: <span class="text-danger">*</span></label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">-- Select User --</option>
                                    <?php
                                    if (isset($users) && !empty($users)) {
                                        foreach ($users as $key => $value) {
                                            $selected = '';
                                            if (isset($post_data) && $post_data['user_id'] == $value['id']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('user_id', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title: <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title"  class="form-control" value="<?php echo isset($post_data['title']) ? $post_data['title'] : set_value('title'); ?>" />                            </div>
                            <div class="form-group">
                                <label>Description: <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="4" cols="4" class="form-control"><?php echo isset($post_data['description']) ? $post_data['description'] : set_value('description'); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Image: <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-3" id="image_preview_div">
                                        <?php
                                        $required = 'required="true"';
                                        if (isset($post_data['image'])) {
                                            $required = '';
                                            ?>
                                            <img heigth="100" width="170" src="<?php echo base_url(BLOG_POST_IMAGES . '/' . $post_data['image']) ?>" alt="">
                                        <?php } else {
                                            ?>
                                            <img heigth="100" width="170" src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" alt="">
                                        <?php }
                                        ?>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="media-body">
                                            <input type="file" name="image" id="image" class="file-styled" <?php echo $required; ?> >
                                            <span class="help-block">Accepted formats:  png, jpg , jpeg. Max file size <?php echo MAX_IMAGE_SIZE; ?> MB</span>
                                        </div>
                                        <span></span>

                                    </div>
                                </div>
                                <div id="proper_image" class="validation-error-label"></div>
                                <?php
                                if (isset($media_validation))
                                    echo '<label id="image-error" class="validation-error-label" for="image">' . $media_validation . '</label>';
                                ?>
                            </div>
                            <?php
                            $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()
                            );
                            ?>
                            <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />

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
<script>is_valid = false;</script>
<?php if (isset($post_data)) { ?>
    <script>is_valid = true;</script>
<?php } ?>
<script type="text/javascript">
    $('document').ready(function () {
        CKEDITOR.replace('description', {
            height: '400px'
        });
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].on('change', function (e) {
                if ($('#description').val() != '') {
                    $('#description').valid();
                }
            });
        }
        $(".file-styled").uniform({
            fileButtonClass: 'action btn bg-pink'
        });

        $("#blogpost_form").validate({
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
                user_id: {
                    required: true,
                },
                title: {
                    required: true,
                },
                description: {
                    required: true,
                },
                image: {
//                    required: true,
                    extension: "jpg|png|jpeg",
                    maxFileSize: {
                        "unit": "MB",
                        "size": max_image_size
                    }
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "image") {
                    error.insertAfter($("#proper_image"));
                } else if (element.attr("name") == "description") {
                    error.insertAfter(element.parent());
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
    $(document).on('change', '#image', function (e) {
        readURL(this);
    })
    var _validFileExtensions = [".jpg", ".jpeg", ".png", ];
    function readURL(input) {
        var height = 215, width = 345, img = '', file = '', val = '';
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var valid_extensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (typeof (input.files[0]) != 'undefined') {
                    if (valid_extensions.test(input.files[0].name)) {
                        var html = '<img src="' + e.target.result + '" style="width: 100px; height: 100px; border-radius: 2px;" alt="">';
                    } else {
                        var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 100px; height: 100px; border-radius: 2px;" alt="">';
                    }
                } else {
                    var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 100px; height: 100px; border-radius: 2px;" alt="">';
                }
                $('#image_preview_div').html(html);
            }
            reader.readAsDataURL(input.files[0]);
            // check slider image dimension
            var _URL = window.URL || window.webkitURL;
            if ((file = input.files[0])) {
                img = new Image();
                img.onload = function () {
                    if (this.width < width || this.height < height) {
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
