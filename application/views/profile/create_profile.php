<style type="text/css">
    .select2.error{border:1px solid red !important;}
</style>
<link href="assets/css/bootstrap-datepicker/bootstrap-datepicker3.min.css" rel="stylesheet"/>
<script src="assets/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<!-- /theme JS files -->
<!-- Select2  files -->
<link href="assets/css/select2/select2.min.css" rel="stylesheet" />
<link href="assets/css/select2/select2-bootstrap.min.css" rel="stylesheet" />
<script src="assets/js/select2/select2.full.min.js"></script>
<!-- Select2  files -->
<!-- WePay js file -->
<script src="https://static.wepay.com/min/js/wepay.v2.js" type="text/javascript"></script>
<!-- /WePay js file -->
<!-- Jquery mask js file -->
<script src="assets/js/jquery.mask.min.js" type="text/javascript"></script>
<!-- /Jquery mask js file -->
<div class="create-profile create-profile_wrappers "> 
    <form method="post" enctype="multipart/form-data" id="create_profile_form">
        <div class="create-profile-body main-steps">
            <div class="container">
                <div class="new-profiletitle">
                    <h1>Create a beautiful memorial Life Profile.</h1>
                    <p>A great honor and a wonderful way to preserve memories. It’s free.</p>
                </div>
                <div class="new-step">
                    <h2>Who would you like to remember always?</h2>
                    <p>Enter some basic information about your loved one that passed away. <br/> You will be able to add more details later.</p>    
                    <div class="step-form">
                        <h4><a>Basic Info</a></li></h4>
                        <div id="first-step">
                            <div class="step-01-l-wrap">
                                <div class="step-01-l">
                                    <div class="upload-btn"> 
                                        <span class="up_btn" id="profile-img-spn">
                                            Upload Profile Picture
                                        </span>
                                        <input type="file" name="profile_image" id="profile_image" multiple="false" onchange="readURL(this);" required> 
                                    </div>
                                    <label id="profile_image-error" class="error" for="profile_image"><?php echo (isset($profile_error)) ? $profile_error : form_error('profile_image') ?></label>
                                </div>
                                <div class="step-01-m">
                                    <label class="label-css">Add Profile Details</label>
                                    <div class="input-wrap">
                                        <input type="text" id="firstname" name="firstname" placeholder="First Name" class="input-css" value="<?php echo set_value('firstname') ?>" required/>
                                        <!--<label id="firstname-error" class="error" for="firstname"><?php echo form_error('firstname') ?></label>-->
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" id="middlename" name="middlename" placeholder="Middle Name" class="input-css" value="<?php echo set_value('middlename') ?>" />
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" id="lastname" name="lastname" placeholder="Last Name" class="input-css" value="<?php echo set_value('lastname') ?>" required/>
                                        <!--<label id="lastname-error" class="error" for="lastname"><?php echo form_error('lastname') ?></label>-->
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" name="nickname" id="nickname" placeholder="Nick Name" class="input-css" value="<?php echo set_value('nickname') ?>"/>
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-l">
                                            <input type="text" name="date_of_birth" id="date_of_birth" placeholder="Date of Birth (mm/dd/yy)" class="input-css date-picker" value="<?php echo set_value('date_of_birth') ?>" required/>
                                            <label id="date_of_birth-error" class="error" for="date_of_birth"><?php echo (isset($date_error)) ? $date_error : form_error('date_of_birth') ?></label>
                                        </div>
                                        <div class="input-r">
                                            <input type="text" name="date_of_death" id="date_of_death" placeholder="Date of Death (mm/dd/yy)" class="input-css date-picker" value="<?php echo set_value('date_of_death') ?>" required/>
                                            <label id="date_of_death-error" class="error" for="date_of_death"><?php echo form_error('date_of_death') ?></label>
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <select name="country" id="country" class="input-css service-country" placeholder="Country" required>
                                            <option value="">Select Country</option>
                                            <?php
                                            foreach ($countries as $country) {
                                                $selected = '';
                                                if (isset($profile) && $profile['country'] == $country['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?php echo $country['id'] ?>" <?php echo $selected ?>><?php echo $country['name'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                        <label id="country-error" class="error" for="country"><?php echo form_error('country') ?></label>
                                    </div>
                                    <div class="input-wrap">
                                        <select name="state" id="state" class="input-css service-state" placeholder="State">
                                            <option value="">Select state</option>
                                        </select>
                                    </div>
                                    <div class="input-wrap">
                                        <select name="city" id="city" class="input-css service-city" placeholder="City">
                                            <option value="">Select city</option>
                                        </select>
                                    </div>
                                    <div class="input-wrap creating-this">
                                        <p>Are you creating this profile on behalf of a person(s), family or families, or group(s)? You can enter that here. If not, leave it blank.</p>
                                        <label class="label-css">Created with love by [you] on behalf of  </label>
                                        <input type="text" id="created_by" name="created_by" placeholder="(optional) Enter the name of the person, family or group" class="input-css" value="<?php echo (isset($profile)) ? $profile['created_by'] : set_value('created_by') ?>"/>
                                    </div>
                                </div>
                                <div class="step-01-r">
                                    <div class="input-wrap">
                                        <label class="label-css">Life Bio (obituary)</label>
                                        <textarea name="life_bio" id="life_bio" class="input-css textarea-css" placeholder="Describe your loved one's life. You can write as much as you like, but you need at least one sentence. You will be able to easily add more or update it later."><?php echo (isset($profile)) ? $profile['life_bio'] : set_value('life_bio') ?></textarea>
                                    </div>
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!$this->is_user_loggedin) { ?>
            <div class="container">
                <div class="signup-wrap">
                    <div class="sign-up-div">
                        <h2>
                            Create your account
                        </h2>
                        <p>Enter your account details that you will use to log in and manage the memorial Life Profile.<br/>
                            Having an account will allow you to also post to other Life Profiles on the site. </p>
                    </div>
                    <div class='login-signup-div'>
                        <div class='login-signup-l'>
                            <div class="upload-btn"> 
                                <span class="up_btn" id="sign-img-spn">Add Your profile photo<br/>(optional)</span>
                                <input type="file" name="sign_profile_image" id="sign_profile_image" multiple="false" onchange="readIMG(this);">
                                <label id="sign_profile_image-error" class="error" for="sign_profile_image"><?php echo form_error('sign_profile_image') ?></label>
                            </div>
                            <div class="login-inr-r">
                                <div class="popup-input">
                                    <input type="text" name="sign_email" id="sign_email" placeholder="Your email ID" value="<?php echo set_value('sign_email') ?>"/>
                                    <label id="sign_email-error" class="error" for="sign_email"><?php echo form_error('sign_email') ?></label>
                                </div>
                                <div class="popup-input name-input">
                                    <div class="first-last">
                                        <input type="text" name="sign_firstname" id="sign_firstname" placeholder="Your first name" value="<?php echo set_value('sign_firstname') ?>"/>
                                        <label id="sign_firstname-error" class="error" for="sign_firstname"><?php echo form_error('sign_firstname') ?></label>
                                    </div>
                                    <div class="last-first">
                                        <input type="text" name="sign_lastname" id="sign_lastname" placeholder="Your last name" value="<?php echo set_value('sign_lastname') ?>"/>
                                        <label id="sign_lastname-error" class="error" for="sign_lastname"><?php echo form_error('sign_lastname') ?></label>
                                    </div>
                                </div>
                                <div class="popup-input">
                                    <input type="password" name="sign_password" id="sign_password" placeholder="Enter Password"/>
                                    <label id="sign_password-error" class="error" for="sign_password"><?php echo form_error('sign_password') ?></label>
                                </div>
                                <div class="popup-input">
                                    <input type="password" name="sign_con_password" id="sign_con_password"  placeholder="Confirm password" />
                                    <label id="sign_con_password-error" class="error" for="sign_con_password"><?php echo form_error('sign_con_password') ?></label>
                                </div>

                                <div class="keep-me">
                                    <label class="custom-checkbox">I agree to <a href="<?php echo site_url('pages/terms-of-service') ?>">Terms of Service</a>
                                        <input type="checkbox" name="terms_condition" id="terms_condition">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label id="terms_condition-error" class="error" for="terms_condition"><?php echo form_error('terms_condition') ?></label>
                                </div>
                            </div> 
                        </div>
                        <div class='login-signup-r'>
                            <h5> Or sign in if you already have an account </h5>
                            <div class="popup-input">
                                <input type="text" name="login_email" id="login_email" placeholder="Your email ID" value="<?php echo set_value('login_email') ?>"/>
                                <label id="login_email-error" class="error" for="login_email"><?php echo form_error('login_email') ?></label>
                            </div>
                            <div class="popup-input">
                                <input type="password" name="login_password" id="login_password" placeholder="Enter Password" />
                                <label id="login_password-error" class="error" for="login_password"><?php echo form_error('login_password') ?></label>
                            </div>
                            <div class="popup-input social-btn">
                                <a href="javascript:void(0)" class="social-btns" data-type="facebook" data-href="<?php echo site_url('facebook') ?>"><img src="assets/images/facebook-login.png" alt="" /></a>
                                <a href="javascript:void(0)" class="social-btns" data-type="google" data-href="<?php echo site_url('google') ?>"><img src="assets/images/google-login.png" alt="" /></a>
                            </div>
                        </div> 
                    </div>
                </div>
            </div> 
        <?php } ?>
        <div class="memoriallife-btn">
            <button type="submit" class="create-memoriallife-profile" id="create-profile-btn">Create memorial Life Profile</button>
        </div>
    </form>
</div>
<?php $wepay_endpoint = WEPAY_ENDPOINT ?>
<script type="text/javascript">
    $(document).on('click', '.social-btns', function () {
        var social_type = $(this).attr('data-type');
        //-- Check create profile page fields are valid or not
        if (!$('#profile_image').valid()) {
            $('#profile_image').focus();
        } else if (!$('#firstname').valid()) {
            $('#firstname').focus();
        } else if (!$('#lastname').valid()) {
            $('#lastname').focus();
        } else if (!$('#date_of_birth').valid()) {
            $('#date_of_birth').focus();
        } else if (!$('#date_of_death').valid()) {
            $('#date_of_death').focus();
        } else if (!$('#country').valid()) {
            $('#country').focus();
        } else {
            var form_data = new FormData(document.getElementById('create_profile_form'));
            form_data.append('social_type', social_type);
            $('.loader').show();
            $.ajax({
                url: site_url + "profile/sociallogin",
                type: "POST",
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.loader').hide();
                    if (data.success == true) {
                        window.location.href = site_url + social_type;
                    } else {
                        showErrorMSg(data.error);
                    }
                }
            });
        }
    });

    $("#create_profile_form").validate({
        ignore: [],
        rules: {
            profile_image: {
                required: true,
                extension: "jpg|png|jpeg",
                maxFileSize: {
                    "unit": "MB",
                    "size": max_image_size
                }
            },
            sign_profile_image: {
                extension: "jpg|png|jpeg",
                maxFileSize: {
                    "unit": "MB",
                    "size": max_image_size
                }
            },
            sign_email: {
                remote: site_url + 'signup/check_signemail',
                required: function () {
                    if ($("#login_email").val().length <= 0)
                        return true;
                    else
                        return false;
                },
                email: true,
            },
            sign_firstname: {
                required: function () {
                    if ($("#login_email").val().length <= 0)
                        return true;
                    else
                        return false;
                }
            },
            sign_lastname: {
                required: function () {
                    if ($("#login_email").val().length <= 0)
                        return true;
                    else
                        return false;
                }
            },
            sign_password: {
                minlength: 5,
                required: function () {
                    if ($("#login_email").val().length <= 0)
                        return true;
                    else
                        return false;
                }
            },
            sign_con_password: {
                minlength: 5,
                equalTo: "#sign_password",
                required: function () {
                    if ($("#login_email").val().length <= 0)
                        return true;
                    else
                        return false;
                }
            },
            terms_condition: {
                required: function () {
                    if ($("#login_email").val().length <= 0)
                        return true;
                    else
                        return false;
                }
            },
//            login_email: {
//                email: true,
//                required: function () {
//                    if ($("#sign_email").val().length <= 0)
//                        return true;
//                    else
//                        return false;
//                }
//            },
//            login_password: {
//                required: function () {
//                    if ($("#sign_email").val().length <= 0)
//                        return true;
//                    else
//                        return false;
//                }
//            },
        },
        messages: {
            sign_email: {
                remote: jQuery.validator.format("Email already exist!")
            },
        },
        submitHandler: function (form) {
            $('#create-profile-btn').attr('disabled', true);
            form.submit();
        }
    });

    //-- Initialize datepicker
    $('.date-picker').datepicker({
        format: "mm/dd/yyyy",
        endDate: "date()",
        autoclose: true,
    });

    // country dropdown change event
    $(document).on('change', '#country', function () {
        $(this).valid();
        $(this).siblings('.select2').removeClass('error');
        country_val = $(this).val();
        $('#state').val('');
        $('#city').val('');
        if (country_val != '') {
            $('.loader').show();
            $.ajax({
                url: site_url + "profile/get_states",
                type: "POST",
                data: {country: country_val},
                dataType: "json",
                success: function (data) {
                    $('.loader').hide();
                    var options = "<option value=''>Select state</option>";
                    for (var i = 0; i < data.length; i++) {
                        code = data[i].shortcode;
                        if (code != null) {
                            codes = code.split('-');
                            code = codes[1];
                        }
                        options += '<option value=' + data[i].id + '>' + data[i].name;
                        if (code != null) {
                            options += ' (' + code + ')';
                        }
                        options += '</option>';
                    }
                    $('#state').empty().append(options);
                }
            });
        }
    });

    $(document).on('change', '#state', function () {
        $(this).valid();
        $(this).siblings('.select2').removeClass('error');
        state_val = $(this).val();
        $('#city').val('');
        if (state_val != '') {
            $('.loader').show();
            $.ajax({
                url: site_url + "profile/get_cities",
                type: "POST",
                data: {state: state_val},
                dataType: "json",
                success: function (data) {
                    $('.loader').hide();
                    var options = "<option value=''>Select City</option>";
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].name + '">' + data[i].name + '</option>';
                    }
                    $('#city').empty().append(options);
                }
            });
        }
    });
    //-- Make city2 dropdown as select2 tags
    $("#country,#state").select2({
        theme: "bootstrap"
    });

    $("#city").select2({
        tags: true,
        theme: "bootstrap"
    });
    // Display the preview of image on image upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var html = '<img src="' + e.target.result + '" style="width: 170px; border-radius: 2px;" alt="" class="profile-exif-img">';
                $('#profile-img-spn').html(html);
                var img = $('#profile-img-spn').find('.profile-exif-img');
                fixExifOrientation(img);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    // Display the preview of image on image upload
    function readIMG(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var html = '<img src="' + e.target.result + '" style="width: 170px; border-radius: 2px;" alt="" class="profile-exif-img">';
                $('#sign-img-spn').html(html);
                var img = $('#sign-img-spn').find('.profile-exif-img');
                fixExifOrientation(img);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


