<script type="text/javascript" src="assets/admin/js/plugins/forms/validation/validate.min.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-plus3"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/categories'); ?>"><i class="icon-stack position-left"></i> Service Categories</a></li>
            <li class="active"><i class="icon-pencil7 position-left"></i><?php echo $heading; ?></li>
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
        </div>
        <?php
    }
}
?>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate-jquery" id="category_from" method="POST" enctype="multipart/form-data">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="message alert alert-danger" style="display:none"></div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Description <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <textarea name="description" id="description" placeholder="Enter Description" class="form-control" rows="5"><?php echo (isset($slider['description'])) ? $slider['description'] : set_value('description'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Media</label>
                            <div class="col-lg-6">
                                <div class="media no-margin-top">
                                    <div class="media-left" id="image_preview_div">
                                        <?php
                                        $required = 'required';
                                        if (isset($guest_communication) && $guest_communication['media'] != '') {
                                            $required = '';
                                            if (preg_match("/\.(gif|png|jpg)$/", $guest_communication['media'])) {
                                                ?>
                                                <img src="<?php echo COMMUNICATION_IMAGES . $guest_communication['media']; ?>" style="width: 58px; height: 58px; border-radius: 2px;" alt="">
                                            <?php } else { ?>
                                                <a class="fancybox" target="_blank" href="<?php echo COMMUNICATION_IMAGES . $guest_communication['media']; ?>" data-fancybox-group="gallery" ><img src="assets/images/default_file.png" height="55px" width="55px" alt="" class="img-circle"/></a>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" style="width: 58px; height: 58px; border-radius: 2px;" alt="">
                                        <?php } ?>
                                    </div>

                                    <div class="media-body">
                                        <input type="file" name="image" id="image" class="file-styled">
                                        <span class="help-block">Accepted formats:  png, jpg , jpeg</span>
                                    </div>
                                    <span></span>
                                </div>
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
<script>


    $("#category_from").validate({
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
            //                console.log(element[0]['classList']);
            if (element[0]['id'] == "image") {
                error.insertAfter(element.parent().parent().next('span')); // select2
            } else {
                error.insertAfter(element)
            }
        },
        success: function (label) {
            label.addClass("validation-valid-label");
        },
        rules: {
            description: {
                required: true
            },
            image: {
                required: true,
            }
        },
    });
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-pink'
    });
    $(document).on('change', '#image', function (e) {
        $(this).rules('add', {
            filesize: 2,
        });
        ValidateSingleInput(this);
        readURL(this);
    })
    var _validFileExtensions = [".jpg", ".jpeg", ".png", ];
//    var _validFileExtensions_Video = [".mp4", ".webm", ".ogv", ".png",".MPG",".MPEG" ,".OGG",".ogg",".mpeg"];    
    function ValidateSingleInput(oInput) {
        if (oInput.type == "file") {

            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                var sizeValid = false;
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
    function readURL(input) {
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
        }
    }

</script>
