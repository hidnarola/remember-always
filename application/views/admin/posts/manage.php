<link type="text/css" href="assets/admin/css/fileinput.css">
<script type="text/javascript" src="assets/admin/js/fileinput.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-comment"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <?php if (isset($user_id)) { ?>
                <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users2"></i> Users</a></li>
                <li><a href="<?php echo site_url('admin/users/posts/' . $user_id); ?>"><i class="icon-comment position-left"></i> Posts</a></li>
            <?php } else { ?>
                <li><a href="<?php echo site_url('admin/posts'); ?>"><i class="icon-comment position-left"></i> Posts</a></li>
            <?php } ?>
            <li class="active"><i class="icon-book position-left"></i><?php echo $heading; ?></li>
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
                <form  method="post" id="user_form" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Posted by:</label>
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
                            <?php if (!isset($user_id)) { ?>
                                <div class="form-group">
                                    <label>User:</label>
                                    <select name="pf_user_id" id="pf_user_id" class="form-control">
                                        <option value="">-- Select User --</option>
                                        <?php
                                        if (isset($users) && !empty($users)) {
                                            foreach ($users as $key => $value) {
                                                $selected = '';
                                                if (isset($post_data) && $post_data['pf_user_id'] == $value['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('pf_user_id', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label>User Profile:</label>
                                <select name="profile_id" id="profile_id" class="form-control">
                                    <option value="">-- Select User Profile --</option>
                                    <?php
                                    if (isset($profiles) && !empty($profiles)) {
                                        foreach ($profiles as $key => $value) {
                                            $selected = '';
                                            if (isset($post_data) && $post_data['profile_id'] == $value['id']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>"  <?php echo $this->input->method() == 'post' ? set_select('profile_id', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Comment:</label>
                                <textarea name="comment" id="comment" rows="4" cols="4" class="form-control"><?php echo isset($post_data['comment']) ? $post_data['comment'] : set_value('comment'); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Image:</label>
                                <input type="file" name="image[]" id="image[]" class="image_file_upload file-input" multiple="multiple">
                                <span class="help-block image_helper">Accepted formats:  png, jpg , jpeg. Max file size 700Kb</span>
                                <?php if (isset($post_media) && !empty($post_media)) { ?>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="image_custom_preview">
                                                <?php
                                                $cnt = 0;
                                                foreach ($post_media as $key => $value) {
                                                    if ($value['type'] == 1) {
                                                        ?>
                                                        <div class="col-lg-2 col-sm-6 div_other_img">
                                                            <img src="<?php echo base_url(POST_IMAGES . $value['media']) ?>" alt="" style="height:120px;width:150px" class="img-thumbnail">
                                                            <input type="hidden" class="hidden_other_img" name="hidden_other_image_id[]" id="hidden_other_image<?php echo $cnt; ?>" value="<?php echo $value['id']; ?>">
                                                            <div class="text-center mt-1">
                                                                <span>
                                                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs remove_other_img" style="top-margin:5px !important">REMOVE</a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $cnt++;
                                                    }
                                                }
                                                ?>
                                                <input type="hidden" name="image_count" id="image_count" value="<?php echo 500 - $cnt; ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <input type="hidden" name="image_count" id="image_count" value="500">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label>Video:</label>


                                <input type="file" name="video[]" id="video[]" class="video_file_upload" multiple="multiple">
                                <span class="help-block video_helper">Accepted formats:  mp4. Max file size 100MB</span>
                                <?php if (isset($post_media) && !empty($post_media)) { ?>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="image_custom_preview">
                                                <?php
                                                $cnt = 0;
                                                foreach ($post_media as $key => $value) {
                                                    if ($value['type'] == 2) {
                                                        ?>
                                                        <div class="col-lg-2 col-sm-6 div_other_img">
                                                            <video width="175px" height="160px" controls="">
                                                                <source src="<?php echo base_url(POST_IMAGES . $value['media']) ?>" type="video/mp4">
                                                            </video>
                                                            <input type="hidden" class="hidden_other_video" name="hidden_other_video_id[]" id="hidden_other_image<?php echo $cnt; ?>" value="<?php echo $value['id']; ?>">
                                                            <div class="text-center mt-1">
                                                                <span>
                                                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs remove_other_video" style="top-margin:5px !important">REMOVE</a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $cnt++;
                                                    }
                                                }
                                                ?>
                                                <input type="hidden" name="video_count" id="image_count" value="<?php echo 50 - $cnt; ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <input type="hidden" name="video_count" id="video_count" value="50">
                                <?php } ?>
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
                user_id: {
                    required: true,
                },
                pf_user_id: {
                    required: true,
                },
                profile_id: {
                    required: true,
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "image[]") {
                    error.insertAfter($(".image_helper"));
                } else if (element.attr("name") == "video[]") {
                    error.insertAfter($(".video_helper"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                $('button[type="submit"]').attr('disabled', true);
                form.submit();
            },
        });
        $(".image_file_upload").fileinput({
            browseLabel: 'Browse',
            browseIcon: '<i class="icon-file-plus"></i>',
            showRemove: false,
            showUpload: false,
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
//                    actionDelete: '<button type="button" class="kv-file-remove {removeClass}" title="{removeTitle}"{dataUrl}{dataKey}>{removeIcon}</button>\n',
            },
            initialCaption: "Please select images",
            initialPreviewShowDelete: true,
            allowedFileExtensions: ["jpg", "jpeg", "png"],
            maxFileCount: $("#image_count").val(),
            dropZoneEnabled: false,
            overwriteInitial: false,
            fileActionSettings: {
                showDrag: false,
                showRemove: true,
                removeIcon: '<i class="icon-bin"></i>',
                removeClass: 'btn btn-link btn-xs btn-icon remove_other_img',
                indicatorNew: '<i class="icon-file-plus text-slate"></i>',
                indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
                indicatorError: '<i class="icon-cross2 text-danger"></i>',
//                    indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>',
            }
        });
        $(".video_file_upload").fileinput({
            browseLabel: 'Browse',
            browseIcon: '<i class="icon-file-plus"></i>',
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>'
            },
            initialCaption: "Please select videos",
            overwriteInitial: false,
            maxFileCount: $("#image_count").val(),
            allowedFileExtensions: ["mp4"],
        });
    });
    $(document).on('click', '.remove_other_img', function () {
        $(this).parents('.div_other_img').remove();
        var image_count = parseInt($("#image_count").val());
        image_count++;
        $("#image_count").val(image_count);
    });
    $(document).on('click', '.remove_other_video', function () {
        $(this).parents('.div_other_img').remove();
        var image_count = parseInt($("#video_count").val());
        image_count++;
        $("#video_count").val(image_count);
    });
    $(document).on('change', '#pf_user_id', function () {
        var user_id = $("#pf_user_id option:selected").val();
        $url = '<?php echo base_url() ?>' + 'admin/posts/get_user_profile';
        $.ajax({
            type: "POST",
            url: $url,
            data: {
                id: user_id,
            }
        }).done(function (data) {
            $("select#profile_id").html(data);
        });
    });
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-pink'
    });
</script>
