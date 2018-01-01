<style>
    label.error {
        color: #D8000C;
    }
</style>
<script type="text/javascript" src="assets/admin/ckeditor/ckeditor.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-magazine"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/pages'); ?>"><i class="icon-magazine position-left"></i> Pages</a></li>
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
                    <form  method="post" id="page_info" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                        <div class="panel panel-flat">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Navigation Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="navigation_name" id="navigation_name" class="form-control" value="<?php echo isset($page_data['navigation_name']) ? $page_data['navigation_name'] : set_value('navigation_name'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Page Title: <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" value="<?php echo isset($page_data['title']) ? $page_data['title'] : set_value('title'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Description: <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" rows="4" cols="4">
                                        <?php echo isset($page_data['description']) ? $page_data['description'] : set_value('description'); ?>
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Banner Image:</label>
                                    <div class="row">
                                        <div class="col-md-3" id="image_preview_div">
                                            <?php
                                            if (isset($page_data['banner_image'])) {
                                                ?>
                                                <img heigth="100" width="170" src="<?php echo base_url(PAGE_BANNER . '/' . $page_data['banner_image']) ?>" alt="">
                                                <button class="btn btn-danger delete_image" type="button" onclick="delete_media('<?php echo base64_encode($page_data['id']) ?>')"><i class="icon-trash"></i> Remove</button>
                                            <?php } else {
                                                ?>
                                                <img heigth="100" width="170" src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" alt="">
                                            <?php }
                                            ?>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="media-body">
                                                <input type="file" name="banner_image" id="banner_image" class="file-styled">
                                                <span class="help-block">Accepted formats:  png, jpg , jpeg. Max file size <?php echo MAX_IMAGE_SIZE ?>MB</span>
                                            </div>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div id="proper_image" class="validation-error-label"></div>
                                    <?php
                                    if (isset($media_validation))
                                        echo '<label id="logo-error" class="validation-error-label" for="logo">' . $media_validation . '</label>';
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label>SEO Meta title: <span class="text-danger">*</span></label>
                                    <input type="text" name="meta_title" id="meta_title" class="form-control" value="<?php echo isset($page_data['meta_title']) ? $page_data['meta_title'] : set_value('meta_title'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>SEO Meta keyword: <span class="text-danger">*</span></label>
                                    <input type="text" name="meta_keyword" id="meta_keyword" class="form-control" value="<?php echo isset($page_data['meta_keyword']) ? $page_data['meta_keyword'] : set_value('meta_keyword'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>SEO Meta Description: <span class="text-danger">*</span></label>
                                    <input type="text" name="meta_description" id="meta_description" class="form-control" value="<?php echo isset($page_data['meta_description']) ? $page_data['meta_description'] : set_value('meta_description'); ?>">
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
            CKEDITOR.replace('description', {
                height: '400px'
            });
            for (var i in CKEDITOR.instances) {
                CKEDITOR.instances[i].on('change', function () {
                    $('#description').valid();
                });
            }
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
                    navigation_name: {
                        required: true,
                    },
                    title: {
                        required: true,
                    },
                    description: {
                        required: function (textarea) {
                            CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                            return editorcontent.length === 0;
                        }
                    },
                    meta_title: {
                        required: true
                    },
                    meta_description: {
                        required: true,
                    },
                    meta_keyword: {
                        required: true,
                    },
                    banner_image: {
                        // required: true,
                        extension: "jpg|png|jpeg",
                        maxFileSize: {
                            "unit": "MB",
                            "size": max_image_size
                        }
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "banner_image") {
                        error.insertAfter($(".#proper_image"));
                    } else if (element.attr("name") == "description") {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    $('button[type="submit"]').attr('disabled', true);
                    form.submit();
                },
            });
        });
        $(".file-styled").uniform({
            fileButtonClass: 'action btn bg-pink'
        });
        $(document).on('change', '#description', function () {
            $(this).valid();
        });
        $(document).on('change', '#banner_image', function (e) {
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
                            var html = '<img src="' + e.target.result + '" style="width: 170px; height: 100px; border-radius: 2px;" alt="">';
                        } else {
                            var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 170px; height: 100px; border-radius: 2px;" alt="">';
                        }
                    } else {
                        var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 170px; height: 100px; border-radius: 2px;" alt="">';
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

        function delete_media(data) {
            $.ajax({
                url: site_url + "admin/pages/delete_image",
                type: "POST",
                data: {'image': data},
                dataType: "json",
                success: function (data) {
                    if (data.success == true) {
                        var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 170px; height: 100px; border-radius: 2px;" alt="">';
                        $('#image_preview_div').html(html);
                        $('.delete_image').addClass('hide');
                    } else {
//                    showErrorMSg(data.error);
                    }
                }
            });
        }
    </script>