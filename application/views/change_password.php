<script src="assets/js/jquery.fancybox.js"></script>
<script src="assets/js/jquery.fancybox.pack.js"></script>
<link href="assets/css/bootstrap-datepicker/bootstrap-datepicker3.min.css" rel="stylesheet"/>
<script src="assets/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- /theme JS files -->
<div class="create-profile">
    <div class="create-profile-top">
        <div class="container">
            <h2>Change Password</h2>
        </div>
    </div>
    <div class="create-profile-body main-steps">
        <div class="container">
            <div class="create-profile-box">
                <div class="step-form">
                    <form method="post" enctype="multipart/form-data" id="change_password_form">
                        <div id="first-step" class="profile-steps">
                            <div class="step-01-l-wrap">
                                <div class="step-01-s">
                                    <div class="input-wrap">
                                        <div class="input-l">
                                            <input type="password" name="old_password" id="old_password" placeholder="Current Password" class="input-css" value="<?php echo set_value('old_password') ?>" />
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-l">
                                            <input type="password" name="password" id="password" placeholder="New Password" class="input-css" value="<?php echo set_value('password') ?>"/>
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-l">
                                            <input type="password" name="confirm_password" id="confirm_password" placeholder="Re-Type Password" class="input-css" value="<?php echo set_value('confirm_password') ?>"/>
                                        </div>
                                    </div>
                                </div>

                            </div>	
                            <div class="step-btm-btn">
                                <button class="next">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>	

</div>
<script type="text/javascript">
    $(function () {
        $("#change_password_form").validate({
            rules: {
                old_password: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
            },
            messages: {
                password: {
                    required: "Please enter a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirm_password: {
                    required: "Please enter a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
            },
        });
    });
</script>