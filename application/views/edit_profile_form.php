<script src="assets/js/jquery.fancybox.js"></script>
<script src="assets/js/jquery.fancybox.pack.js"></script>
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
                            $img_url = USER_IMAGES . $user_data['profile_image'];
                            if ($user_data['facebook_id'] != '' || $user_data['google_id'] != '') {
                                $img_url = $user_data['profile_image'];
                            }
                            echo "<img src='" . $img_url . "'>";
                        } else
                            echo 'Upload Picture';
                        ?>
                    </span>
                    <?php if ($user_data['facebook_id'] == '' && $user_data['google_id'] == '') { ?>
                        <div class="upload-btn"> 
                            <span class="up_btn">Edit Picture</span>
                            <input type="file" name="profile_image" id="profile_image" multiple="false" onchange="readURL(this);">
                            <?php
                            if (isset($image_error) && !empty($image_error)) {
                                echo '<label id="profile_image-error" class="error" for="profile_image">' . $image_error . '</label>';
                            }
                            ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="edit-r">
                    <div class="input-wrap">
                        <label class="label-css">Name</label>
                        <div class="input-l">
                            <input type="text" name="firstname" placeholder="First Name" class="input-css" value="<?php echo (isset($user_data)) ? $user_data['firstname'] : set_value('firstname') ?>" />
                            <?php
                            if (form_error('firstname') != '')
                                echo '<label id="firstname-error" class="error" for="firstname">' . form_error('firstname') . '</label>';
                            ?>
                        </div>
                        <div class="input-r">
                            <input type="text" name="lastname" placeholder="Last Name" class="input-css" value="<?php echo (isset($user_data)) ? $user_data['lastname'] : set_value('lastname') ?>"/>
                            <?php
                            if (form_error('lastname') != '')
                                echo '<label id="lastname-error" class="error" for="lastname">' . form_error('lastname') . '</label>';
                            ?>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-l">
                            <label class="label-css">E-mail</label>
                            <input type="text" name="email" placeholder="email" class="input-css" value="<?php echo (isset($user_data)) ? $user_data['email'] : set_value('email') ?>" readonly="" disabled="">
                        </div>
                        <div class="input-r">
                            <label class="label-css">Phone Number</label>
                            <input type="text" name="phone" placeholder="phone (000) 000-0000" class="input-css" value="<?php echo (isset($user_data['phone'])) ? $user_data['phone'] : set_value('phone') ?>">
                            <?php
                            if (form_error('phone') != '')
                                echo '<label id="phone-error" class="error" for="phone">' . form_error('phone') . '</label>';
                            ?>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-l">
                            <label class="label-css">Address 1</label>
                            <input type="text" name="address1" placeholder="address1" class="input-css" value="<?php echo (isset($user_data['address1'])) ? $user_data['address1'] : set_value('address1') ?>">
                            <?php
                            if (form_error('address1') != '')
                                echo '<label id="address1-error" class="error" for="address1">' . form_error('address1') . '</label>';
                            ?>
                        </div>
                        <div class="input-r">
                            <label class="label-css">Address 2</label>
                            <input type="text" name="address2" placeholder="address2" class="input-css" value="<?php echo (isset($user_data['address2'])) ? $user_data['address2'] : set_value('address2') ?>">
                            <?php
                            if (form_error('address2') != '')
                                echo '<label id="address2-error" class="error" for="address2">' . form_error('address2') . '</label>';
                            ?>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-l">
                            <label class="label-css">Country</label>
                            <select name="country" id="country" class="selectpicker">
                                <option value="">-- Select Country --</option>
                                <?php
                                if (isset($countries) && !empty($countries)) {
                                    foreach ($countries as $key => $value) {
                                        $selected = '';
                                        if (isset($user_data['country']) && $user_data['country'] == $value['id']) {
                                            $selected = 'selected';
                                        }
                                        ?>
                                        <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>"  <?php echo $this->input->method() == 'post' ? set_select('country', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <?php
                            if (form_error('country') != '')
                                echo '<label id="country-error" class="error" for="country">' . form_error('country') . '</label>';
                            ?>
                        </div>
                        <div class="input-r">
                            <label class="label-css">State</label>
                            <!--<input type="text" name="state" placeholder="state" class="input-css" value="<?php echo (isset($user_data['state'])) ? $user_data['state'] : set_value('state') ?>">-->
                            <select name="state" id="state" class="selectpicker">
                                <option value="">-- Select State --</option>
                                <?php
                                if (isset($states) && !empty($states)) {
                                    foreach ($states as $key => $value) {
                                        $selected = '';
                                        if (isset($user_data['state']) && $user_data['state'] == $value['id']) {
                                            $selected = 'selected';
                                        }
                                        ?>
                                        <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('state', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <?php
                            if (form_error('state') != '')
                                echo '<label id="state-error" class="error" for="state">' . form_error('state') . '</label>';
                            ?>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-l">
                            <label class="label-css">City</label>
                            <select name="city" id="city" class="selectpicker">
                                <option value="">-- Select City --</option>
                                <?php
                                if (isset($cities) && !empty($cities)) {
                                    foreach ($cities as $key => $value) {
                                        $selected = '';
                                        if (isset($user_data['city']) && $user_data['city'] == $value['id']) {
                                            $selected = 'selected';
                                        }
                                        ?>
                                        <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>"  <?php echo $this->input->method() == 'post' ? set_select('city', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <?php
                            if (form_error('city') != '')
                                echo '<label id="city-error" class="error" for="city">' . form_error('city') . '</label>';
                            ?>
                        </div>
                        <div class="input-r">
                            <label class="label-css">Zipcode</label>
                            <input type="text" name="zipcode" placeholder="zipcode" class="input-css" value="<?php echo (isset($user_data['zipcode'])) ? $user_data['zipcode'] : set_value('zipcode') ?>">
                            <?php
                            if (form_error('zipcode') != '')
                                echo '<label id="zipcode-error" class="error" for="zipcode">' . form_error('zipcode') . '</label>';
                            ?>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-l">
                            <label class="label-css">Current Password</label>
                            <input type="password" name="old_password" id="old_password" placeholder="Current Password" class="input-css">
                            <?php
                            if (form_error('old_password') != '')
                                echo '<label id="old_password-error" class="error" for="old_password">' . form_error('old_password') . '</label>';
                            ?>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-l">
                            <label class="label-css">New Password</label>
                            <input type="password" name="new_password" id="new_password" placeholder="New Password" class="input-css">
                            <?php
                            if (form_error('new_password') != '')
                                echo '<label id="new_password-error" class="error" for="new_password">' . form_error('new_password') . '</label>';
                            ?>
                        </div>
                        <div class="input-r">
                            <label class="label-css">ReType Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="Re-Type Password" class="input-css">
                            <?php
                            if (form_error('confirm_password') != '')
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
        $('#country').selectpicker({
            liveSearch: true,
            size: 5
        });
        $('#city').selectpicker({
            liveSearch: true,
            size: 5
        });
        $('#state').selectpicker({
            liveSearch: true,
            size: 5
        });
        // Setup validation
        $("#edit_profile_form").validate({
            ignore: ['select:hidden'],
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
                phone: {
//                    required: true,
                    phoneUS: true
                },
                address1: {
//                    required: true,
                },
                country: {
//                    required: true,
                },
                state: {
//                    required: true,
                },
                city: {
//                    required: true,
                },
                zipcode: {
//                    required: true,
                    custom_zipcode: true
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
            errorPlacement: function (error, element) {
                if (element.hasClass('selectpicker')) {
                    error.insertAfter(element.parent().find('.bootstrap-select'));
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
    $(document).on('change', '#country', function () {
        var country_id = $("#country option:selected").val();
        $url = '<?php echo base_url() ?>' + 'users/get_data';
        $.ajax({
            type: "POST",
            url: $url,
            data: {
                id: country_id,
                type: 'state',
            }
        }).done(function (data) {
            if (data != '') {
                $("select#state").html(data);
                $("select#state").selectpicker('refresh');
            }
        });
    });
    $(document).on('change', '#state', function () {
        var state_id = $("#state option:selected").val();
        $url = '<?php echo base_url() ?>' + 'users/get_data';
        $.ajax({
            type: "POST",
            url: $url,
            data: {
                id: state_id,
                type: 'city',
            }
        }).done(function (data) {
            if (data != '') {
                $("select#city").html(data);
                $("select#city").selectpicker('refresh');
            }
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