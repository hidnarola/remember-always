<link href="assets/css/bootstrap-datepicker/bootstrap-datepicker3.min.css" rel="stylesheet"/>
<script src="assets/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- /theme JS files -->
<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Edit Profile</h2>
        </div>
        <div class="common-body">
            <form method="post" enctype="multipart/form-data" id="edit_profile_form">
                <div class="edit-l">
                    <span class="edit-l-pic">
                        <?php
                        if (isset($user_data) && $user_data['profile_image'] != '') {
                            echo "<img src='" . USER_IMAGES . $user_data['profile_image'] . "'>";
                        } else
                            echo 'Upload Picture';
                        ?>
                    </span>
                    <div class="upload-btn"> 
                        <span class="up_btn">Edit Picture</span>
                        <input type="file" name="profile_image" id="profile_image" multiple="false" onchange="readURL(this);">
                    </div>

                </div>
                <div class="edit-r">
                    <div class="input-wrap">
                        <label class="label-css">Name</label>
                        <div class="input-l">
                            <input type="text" name="firstname" placeholder="First Name" class="input-css" value="<?php echo (isset($user_data)) ? $user_data['firstname'] : set_value('firstname') ?>" />
                            <?php
                            echo '<label id="firstname-error" class="error" for="firstname">' . form_error('firstname') . '</label>';
                            ?>
                        </div>
                        <div class="input-r">
                            <input type="text" name="lastname" placeholder="Last Name" class="input-css" value="<?php echo (isset($user_data)) ? $user_data['lastname'] : set_value('lastname') ?>"/>
                            <?php
                            echo '<label id="lastname-error" class="error" for="lastname">' . form_error('lastname') . '</label>';
                            ?>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-l">
                            <label class="label-css">E-mail</label>
                            <input type="text" name="email" placeholder="email" class="input-css" value="<?php echo (isset($user_data)) ? $user_data['email'] : set_value('email') ?>" readonly="" disabled="">
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-l">
                            <label class="label-css">Current Password</label>
                            <input type="password" name="old_password" id="old_password" placeholder="Current Password" class="input-css">
                            <?php
                            echo '<label id="old_password-error" class="error" for="old_password">' . form_error('old_password') . '</label>';
                            ?>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-l">
                            <label class="label-css">New Password</label>
                            <input type="password" name="new_password" id="new_password" placeholder="New Password" class="input-css">
                            <?php
                            echo '<label id="password-error" class="error" for="password">' . form_error('password') . '</label>';
                            ?>
                        </div>
                        <div class="input-r">
                            <label class="label-css">ReType Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="Re-Type Password" class="input-css">
                            <?php
                            echo '<label id="confirm_password-error" class="error" for="confirm_password">' . form_error('confirm_password') . '</label>';
                            ?>
                        </div>
                    </div>

                    <div class="edit-update step-btm-btn">
                        <button type="submit" class="next">Save</button>
                        <button type="reset" class="skip">Cancel</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>	

<script type="text/javascript">
    $(function () {
        // Setup validation
        $("#edit_profile_form").validate({
            rules: {
                profile_image: {
                    extension: "jpg|png|jpeg",
                    maxFileSize: {
                        "unit": "MB",
                        "size": max_image_size
                    }
                },
                firstname: {
                    required: true
                },
                lastname: {
                    required: true
                },
                new_password: {
                    minlength: 5
                },
                confirm_password: {
                    minlength: 5,
                    equalTo: "#new_password"
                },
            },
            messages: {
                new_password: {
                    minlength: "Your password must be at least 5 characters long."
                },
                confirm_password: {
                    minlength: "Your password must be at least 5 characters long.",
                    equalTo: "Please enter the same password as new password."
                },
            },
        });
    });
    $(document).on('blur', '#new_password', function () {
        if ($(this).val() != '') {
            $('#old_password').rules('add', {
                required: true,
            });
        }
    });
    // Display the preview of image on image upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var html = '<img src="' + e.target.result + '" alt="">';
                $('.edit-l-pic').html(html);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>