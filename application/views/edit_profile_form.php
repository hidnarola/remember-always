<link href="assets/css/bootstrap-datepicker/bootstrap-datepicker3.min.css" rel="stylesheet"/>
<script src="assets/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- /theme JS files -->
<div class="create-profile">
    <div class="create-profile-top">
        <div class="container">
            <h2>Edit Profile.</h2>
        </div>
    </div>
    <div class="create-profile-body main-steps">
        <div class="container">
            <div class="create-profile-box">
                <div class="step-form">
                    <form method="post" enctype="multipart/form-data" id="edit_profile_form">
                        <div id="first-step" class="profile-steps">
                            <div class="step-01-l-wrap">
                                <div class="step-01-l">
                                    <div class="upload-btn"> 
                                        <span class="up_btn">
                                            <?php
                                            if (isset($user_data) && $user_data['profile_image'] != '') {
                                                echo "<img src='" . USER_IMAGES . $user_data['profile_image'] . "' style='width: 170px;'>";
                                            } else
                                                echo "Upload Profile Picture";
                                            ?>
                                        </span>
                                        <input type="file" name="profile_image" id="profile_image" multiple="false" onchange="readURL(this);"> 
                                    </div>
                                </div>

                                <div class="step-01-s">
                                    <div class="input-wrap">
                                        <label class="label-css">Edit Profile Details</label>
                                        <div class="input-l">
                                            <input type="text" name="firstname" placeholder="First Name" class="input-css" value="<?php echo (isset($user_data)) ? $user_data['firstname'] : set_value('firstname') ?>" />
                                        </div>
                                        <div class="input-l">
                                            <input type="text" name="lastname" placeholder="Last Name" class="input-css" value="<?php echo (isset($user_data)) ? $user_data['lastname'] : set_value('lastname') ?>"/>
                                        </div>
                                        <div class="input-l">
                                            <input type="text" name="email" placeholder="Email" class="input-css" value="<?php echo (isset($user_data)) ? $user_data['email'] : set_value('email') ?>" readonly="" disabled=""/>
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
            },

        });
    });
    // Display the preview of image on image upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var html = '<img src="' + e.target.result + '" style="width: 170px; border-radius: 2px;" alt="">';
                $('.up_btn').html(html);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>