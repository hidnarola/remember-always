<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
<script src="assets/js/bootstrap/bootstrap-select.min.js" type="text/javascript"></script>
<link href="assets/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
<div class="main-inner">
    <div class="content">
        <div class="mt-150">
            <div class="hero-image">
                <div style="background-image: url('<?php echo PAGE_BANNER . '/DSCF1584-Edit.jpg' ?>');" class="hero-image-inner">
                    <div class="hero-image-content">
                        <div class="container">
                            <h1><?php echo $page_title ?></h1>
                            <p>You may use the form below to reach us for any questions, support and feed back</p>
                        </div><!-- /.container -->
                    </div><!-- /.hero-image-content -->
                </div><!-- /.hero-image-inner -->
            </div>
        </div>
        <div class="container">
            <div class="content">
                <div class="contact-form-wrapper clearfix background-white p30">
                    <form action="" method="post" class="contact-form" id="feedback-form" enctype="multipart/form-data">
                        <div class="row">
                            <?php if (isset($error) && $error != '') { ?>
                                <div class="alert alert-danger alert-dismissable" role="alert">
                                    <button type="button" class="close alert_close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $error ?>
                                </div>
                            <?php } ?>
                            <?php
                            if ($this->session->flashdata('message')) {
                                $message = $this->session->flashdata('message');
                                ?>
                                <div class="alert <?php echo $message['class']; ?> alert-dismissable" role="alert">
                                    <button type="button" class="close alert_close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $message['msg']; ?> 
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact-form-name">Name <span>*</span></label>
                                    <input type="text" class="form-control" id="contact-form-name" name="name">
                                </div><!-- /.form-group -->
                            </div><!-- /.col-* -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact-form-email">E-mail <span>*</span></label>
                                    <input type="text" class="form-control" id="contact-form-email" name="email" value="<?php echo ($this->session->userdata('user')['email_id'] != '') ? $this->session->userdata('user')['email_id'] : ''; ?>">
                                </div><!-- /.form-group -->
                            </div><!-- /.col-* -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact-form-email">Inquiry Type <span>*</span></label>
                                    <select id="inquiry_type" name="inquiry_type" class="form-control bs-select-hidden" title="Category">
                                        <option selected="selected" value="General inquiry">General inquiry</option>
                                        <option value="Feedback / comment">Feedback / comment</option>
                                        <option value="Support and technical questions">Support and technical questions</option>
                                        <option class="frm_other_trigger" value="Other">Other</option>
                                    </select>
                                </div><!-- /.form-group -->
                            </div><!-- /.col-* -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">File Upload:</label>
                                    <input type="file" id="cover_photo" name="cover_photo">
                                    <label for="description" style="color:red;" class="" id="proper_image"></label>
                                </div>
                            </div>
                        </div><!-- /.row -->
                        <div class="form-group">
                            <label for="contact-form-message">Message <span>*</span></label>
                            <textarea rows="6" id="message" name="message" class="form-control"></textarea><div class="textarea-resize"></div>
                        </div><!-- /.form-group -->
                        <div class="g-recaptcha" data-sitekey="<?php echo GOOGLE_SITE_KEY ?>"></div>
                        <button class="btn btn-primary pull-right" id="post" type="button">Post Message</button>
                    </form><!-- /.contact-form -->
                </div><!-- /.contact-form-wrapper -->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#inquiry_type').selectpicker({
            size: 5
        });
        setTimeout(function () {
            $(".alert").hide()
        }, 5000);
    });
    $(document).on('click', '#post', function () {
        if ($('#feedback-form').valid()) {
            $('.loading').show();
            $('#feedback-form').submit();
        }
    })
    $("#feedback-form").validate({
        ignore: ':not(select:hidden, input:visible, textarea:visible)',
        rules: {
            name: {
                required: true
            },
            email: {
                first_email: true,
                email: true,
                required: true
            },
            message: {
                required: true,
                wordMin: ['20'],
                // wordMax : ['50']
            },
            cover_photo: {
                extension: "jpg|png|jpeg",
                maxFileSize: {
                    "unit": "KB",
                    "size": 700
                }
            }
        },
        messages: {
            "message": {
                wordMin: 'Your description is too short. Please enter more description.',
                wordMax: 'Your description is too long. Please enter short description.'
            }
        },
    });
</script>