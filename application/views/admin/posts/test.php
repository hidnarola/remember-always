<html>
    <head>
        <link type="text/css" href="<?php echo base_url('assets/admin/css/fileinput.css') ?>">
        <link href="<?php echo base_url('assets/admin/css/bootstrap.css') ?>" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/core/libraries/jquery.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/core/libraries/bootstrap.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/fileinput.js') ?>"></script>
    </head>
    <body>
        <input type="file" name="image[]" id="image[]" class="image_file_upload file-input" multiple="multiple">
        <span class="help-block image_helper">Accepted formats:  png, jpg , jpeg. Max file size 700Kb</span>
        <script>
            $(".image_file_upload").fileinput({
                browseLabel: 'Browse',
                browseIcon: '<i class="icon-file-plus"></i>',
                showRemove: false,
                showUpload: false,
                layoutTemplates: {
                    icon: '<i class="icon-file-check"></i>',
                    actionDelete: '<button type="button" class="kv-file-remove btn btn-link btn-xs btn-icon" title=""><i class="icon-bin"></i></button>\n',
                },
                initialCaption: "Please select images",
                initialPreview: [],
                initialPreviewShowDelete: true,
                allowedFileExtensions: ["jpg", "jpeg", "png"],
                maxFileCount: $("#image_count").val(),
                dropZoneEnabled: false,
                overwriteInitial: false,
                fileActionSettings: {
                    removeIcon: '<i class="icon-bin"></i>',
                    removeClass: 'btn btn-link btn-xs btn-icon delete-post',
                    indicatorNew: '<i class="icon-file-plus text-slate"></i>',
                    indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
                    indicatorError: '<i class="icon-cross2 text-danger"></i>',
                    indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>',
                }
            });
        </script>
    </body>
    <html>