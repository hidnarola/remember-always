<script type="text/javascript" src="assets/admin/js/plugins/uploaders/fileinput.min.js"></script>
<script type="text/javascript" src="assets/admin/js/pages/uploader_bootstrap.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-comment"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/posts'); ?>"><i class="icon-comment position-left"></i> Posts</a></li>
            <li class="active"><i class="icon-book position-left"></i><?php echo $heading; ?></li>
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
                                    <label>User:</label>
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
                                    <input type="file" name="image[]" id="image[]" class="image_file_upload" multiple="multiple">
                                    <span class="help-block image_helper">Accepted formats:  png, jpg , jpeg. Max file size 700Kb</span>
                                </div>
                                <div class="form-group">
                                    <label>Video:</label>
                                    <input type="file" name="video[]" id="video[]" class="video_file_upload" multiple="multiple">
                                    <span class="help-block video_helper">Accepted formats:  mp4. Max file size 100MB</span>
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
                    profile_id: {
                        required: true,
                    },
//                    comment: {
//                        atleast_one: ['image[]','video[]'],
//                    },
//                    'image[]': {
//                        required: true,
//                    }

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
            $(".video_file_upload").fileinput({
                browseLabel: 'Browse',
                browseIcon: '<i class="icon-file-plus"></i>',
                //                removeFromPreviewOnError: true,
                //                uploadIcon: '<i class="icon-file-upload2"></i>',
                //                removeIcon: '<i class="icon-cross3"></i>',
                layoutTemplates: {
                    icon: '<i class="icon-file-check"></i>'
                },
                initialCaption: "Please select videos",
                //                initialPreview: [
                //                    "<img src='assets/images/placeholder.jpg' class='file-preview-image' alt=''>",
                //                    "<img src='assets/images/placeholder.jpg' class='file-preview-image' alt=''>",
                //                ],
                overwriteInitial: false,
                allowedFileExtensions: ["mp4"],
                //                fileActionSettings: {
                //                    removeIcon: '<i class="icon-bin"></i>',
                //                    removeClass: 'btn btn-link btn-xs btn-icon',
                //                    uploadIcon: '<i class="icon-upload"></i>',
                //                    uploadClass: 'btn btn-link btn-xs btn-icon',
                //                    indicatorNew: '<i class="icon-file-plus text-slate"></i>',
                //                    indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
                //                    indicatorError: '<i class="icon-cross2 text-danger"></i>',
                //                    indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>',
                //                },
                //maxFileSize: 100
            });
            $(".image_file_upload").fileinput({
                browseLabel: 'Browse',
                browseIcon: '<i class="icon-file-plus"></i>',
                //                removeFromPreviewOnError: true,
                //                uploadIcon: '<i class="icon-file-upload2"></i>',
                //                removeIcon: '<i class="icon-cross3"></i>',
                layoutTemplates: {
                    icon: '<i class="icon-file-check"></i>'
                },
                initialCaption: "Please select images",
                //                initialPreview: [
                //                    "<img src='assets/images/placeholder.jpg' class='file-preview-image' alt=''>",
                //                    "<img src='assets/images/placeholder.jpg' class='file-preview-image' alt=''>",
                //                ],
                overwriteInitial: false,
                allowedFileExtensions: ["jpg", "jpeg", "png"],
                //                fileActionSettings: {
                //                    removeIcon: '<i class="icon-bin"></i>',
                //                    removeClass: 'btn btn-link btn-xs btn-icon',
                //                    uploadIcon: '<i class="icon-upload"></i>',
                //                    uploadClass: 'btn btn-link btn-xs btn-icon',
                //                    indicatorNew: '<i class="icon-file-plus text-slate"></i>',
                //                    indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
                //                    indicatorError: '<i class="icon-cross2 text-danger"></i>',
                //                    indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>',
                //                },
                //maxFileSize: 100
            });
        });
        $(document).on('change', '#user_id', function () {
            var user_id = $("#user_id option:selected").val();
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
