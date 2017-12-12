<link href="assets/css/bootstrap-datepicker/bootstrap-datepicker3.min.css" rel="stylesheet"/>
<script src="assets/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- /theme JS files -->
<div class="create-profile">
    <div class="create-profile-top">
        <div class="container">
            <h2>Create a Life Profile.</h2>
            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur auto edit.</p>
            <a href="javascript:void(0)" onclick="$('#create_profile_form').valid()">Save and Finish Later</a>
        </div>
    </div>
    <div class="create-profile-body main-steps">
        <div class="container">
            <div class="create-profile-box">
                <div class="process-step">
                    <ul>
                        <li class="active steps-li" id="first-step-li"><a href="javascript:void(0);">01</a></li>
                        <li class="steps-li" id="second-step-li"><a href="javascript:void(0);">02</a></li>
                        <li class="steps-li" id="third-step-li"><a href="javascript:void(0);">03</a></li>
                        <li class="steps-li" id="forth-step-li"><a href="javascript:void(0);">04</a></li>
                        <li class="steps-li" id="fifth-step-li"><a href="javascript:void(0);">05</a></li>
                    </ul>
                    <a href="javascript:void(0)" class="save-draft" onclick="$('#create_profile_form').valid()">Save as draft</a>
                </div>

                <div class="step-form">
                    <form method="post" enctype="multipart/form-data" id="create_profile_form">
                        <div id="first-step" class="profile-steps">
                            <div class="step-01-l-wrap">
                                <div class="step-01-l">
                                    <div class="upload-btn"> 
                                        <span class="up_btn">
                                            <?php
                                            if (isset($profile) && $profile['profile_image'] != '') {
                                                echo "<img src='" . PROFILE_IMAGES . $profile['profile_image'] . "' style='width: 170px;'>";
                                            } else
                                                echo "Upload Profile Picture";
                                            ?>
                                        </span>
                                        <input type="file" name="profile_image" id="profile_image" multiple="false" onchange="readURL(this);"> 
                                    </div>
                                </div>

                                <div class="step-01-m">
                                    <div class="input-wrap">
                                        <label class="label-css">Add Profile Details</label>
                                        <div class="input-l">
                                            <input type="text" name="firstname" placeholder="First Name" class="input-css" value="<?php echo (isset($profile)) ? $profile['firstname'] : set_value('firstname') ?>" />
                                        </div>
                                        <div class="input-r">
                                            <input type="text" name="lastname" placeholder="Last Name" class="input-css" value="<?php echo (isset($profile)) ? $profile['lastname'] : set_value('lastname') ?>"/>
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" name="nickname" placeholder="Nick Name" class="input-css" value="<?php echo (isset($profile)) ? $profile['nickname'] : set_value('nickname') ?>"/>
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-l">
                                            <input type="text" name="date_of_birth" placeholder="Date of Birth" class="input-css date-picker" value="<?php echo (isset($profile)) ? date('d-m-Y', strtotime($profile['date_of_birth'])) : set_value('date_of_birth') ?>"/>
                                        </div>
                                        <div class="input-r">
                                            <input type="text" name="date_of_death" placeholder="Dath of Death" class="input-css date-picker" value="<?php echo (isset($profile)) ? date('d-m-Y', strtotime($profile['date_of_death'])) : set_value('date_of_death') ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-01-r">
                                    <div class="input-wrap">
                                        <label class="label-css">Create Life Bio</label>
                                        <textarea name="life_bio" id="life_bio" class="input-css textarea-css" placeholder="Write about Bio... "><?php echo (isset($profile)) ? $profile['life_bio'] : set_value('life_bio') ?></textarea>
                                        <label class="label-css">Tips for writing a Life Bio</label>
                                    </div>
                                </div>
                            </div>	
                            <div class="step-btm-btn">
                                <button class="next" onclick="return submit_form();">Next</button>
                            </div>
                        </div>
                        <div id="second-step" class="hide profile-steps">
                            <div class="step-title">
                                <h2>Create Life Gallery<small>(optional)</small> </h2>
                                <p>Add Photo/Video files of your loved one. <br/> You will be able to add more or remove previously uploaded files late.</p>
                            </div>

                            <div class="step-form">
                                <div class="step-02">
                                    <ul class="step-02-ul gallery-media">
                                        <li>
                                            <div class="gallery-upload-wrap">
                                                <div class="gallery-upload"> 
                                                    <span class="gallery_up_btn">Upload Life Gallery</span>
                                                    <input type="file" name="gallery[]" id="gallery" multiple> 
                                                </div>
                                            </div>
                                        </li>
                                        <div id="default-preview">
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                        </div>
                                        <div id="selected-preview"></div>
                                    </ul>
                                </div>	
                                <div id="dvPreview"></div>
                                <div class="step-btm-btn">
                                    <button class="back" onclick="return back_step()">Back</button>
                                    <button class="skip" onclick="return skip_step()">Skip</button>
                                    <button class="next" onclick="return false;">Next</button>
                                </div>
                            </div>
                        </div>
                        <div id="third-step" class="hide profile-steps">
                            <div class="step-title">
                                <h2>Add A Fun Facts<small>(optional)</small> </h2>
                                <p>Add up to 10fun facts about your loved one.<br/> You will be able to add more (up to 10) or remove previously entered ones later.</p>
                            </div>

                            <div class="step-form">
                                <div class="step-03">
                                    <div class="step-03-l">
                                        <div class="input-wrap-div">
                                            <input type="text" name="" placeholder="Text here" class="input-css" />
                                            <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                        </div>
                                        <div class="input-wrap-div">
                                            <input type="text" name="" placeholder="Text here" class="input-css" />
                                            <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                        </div>
                                        <div class="input-wrap-div">
                                            <input type="text" name="" placeholder="Text here" class="input-css" />
                                            <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                        </div>
                                        <div class="input-wrap-div">
                                            <input type="text" name="" placeholder="Text here" class="input-css" />
                                            <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                        </div>
                                    </div>
                                    <div class="step-03-m">
                                        <button type="submit">Add a Fun Fact</button>
                                    </div>
                                    <div class="step-03-r">
                                        <h6>Fun facts can be anything fun or <br/>interesting about your loved one.</h6>
                                        <h5>Example Incluse things sucg as:</h5>
                                        <p>Place of birth or where they grew up.</p>
                                        <p>Family information</p>
                                        <p>School(s) Attended</p>
                                        <p>Favourite hobby</p>
                                        <p>Favourite saying</p>
                                    </div>
                                </div>	
                                <div class="step-btm-btn">
                                    <button class="back" onclick="return back_step()">Back</button>
                                    <button class="skip" onclick="return skip_step()">Skip</button>
                                    <button class="next" onclick="return false;">Next</button>
                                </div>
                            </div>
                        </div>
                        <div id="third1-step" class="hide profile-steps">
                            <div class="step-title">
                                <h2>Add Affilliations<small>(optional)</small> </h2>
                                <p>Add up to 10fun Affiliations about your loved one. <br/> You will be able to add more (up to 10) or remove previously entered ones later.</p>
                            </div>

                            <div class="step-form">
                                <div class="step-03">
                                    <div class="step-03-l">
                                        <div class="input-wrap-div">
                                            <input type="text" name="" placeholder="Text here" class="input-css" />
                                            <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                        </div>
                                        <div class="input-wrap-div">
                                            <input type="text" name="" placeholder="Text here" class="input-css" />
                                            <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                        </div>
                                        <div class="input-wrap-div">
                                            <input type="text" name="" placeholder="Text here" class="input-css" />
                                            <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                        </div>
                                        <div class="input-wrap-div">
                                            <input type="text" name="" placeholder="Text here" class="input-css" />
                                            <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                        </div>
                                    </div>
                                    <div class="step-03-m">
                                        <button type="submit">Add a Affiliations</button>
                                    </div>
                                    <div class="step-03-r">
                                        <h6>Affiliations are things your loved on was <br/> associated with and that were important to hm or her.</h6>
                                        <h5>Example Incluse things such as:</h5>
                                        <p>Schools attended</p>
                                        <p>Organizations and clubs</p>
                                        <p>Social Causes</p>
                                        <p>Professional Groups or Interests</p>
                                        <p>Sports Teams or involvement in sports</p>
                                    </div>
                                </div>	
                                <div class="step-btm-btn">
                                    <button class="back" onclick="return back_step()">Back</button>
                                    <button class="skip" onclick="return skip_step()">Skip</button>
                                    <button class="next" onclick="return false;">Next</button>
                                </div>
                            </div>
                        </div>
                        <div id="forth-step" class="hide profile-steps">
                            <div class="step-title">
                                <h2>Life Timeline<small>(optional)</small> </h2>
                                <p>Enter information about important milestones in your loved ones life.</p>
                            </div>
                            <div class="step-form">
                                <div class="step-06">
                                    <div class="step-06-l">
                                        <div class="input-wrap">
                                            <label class="label-css">Title</label>
                                            <input type="text" name="" placeholder="Title" class="input-css">
                                        </div>
                                        <div class="input-wrap four-input">
                                            <input type="text" name="" placeholder="Date" class="input-css"> <span>Or</span>
                                            <input type="text" name="" placeholder="Month" class="input-css">
                                            <input type="text" name="" placeholder="Year" class="input-css"><span>Or</span>
                                            <input type="text" name="" placeholder="Year" class="input-css">
                                            <p>You may enter a Year a, Month/Year, or a full date.</p>
                                        </div>
                                        <div class="input-wrap">
                                            <textarea class="input-css textarea-css" placeholder="Quod omittam vulputate quo ex."></textarea>
                                            <label class="label-css"><i class="fa fa-plus"></i> Add another life timeline entry.</label>
                                        </div>
                                    </div>
                                    <div class="step-06-r">
                                        <div class="select-file">
                                            <div class="select-file-upload"> 
                                                <span class="select-file_up_btn">Upload images, Or Videos to fundraiser page <span>Select Files</span></span>
                                                <input type="file" name="my_doc_upload" id="my_doc_upload" multiple="false"> 
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="step-btm-btn">
                                    <button class="back" onclick="return back_step()">Back</button>
                                    <button class="skip" onclick="return skip_step()">Skip</button>
                                    <button class="next" onclick="return false;">Next</button>
                                </div>
                            </div>
                        </div>
                        <div id="fifth-step" class="hide profile-steps">
                            <div class="step-title">
                                <h2>Add Funeral Services<small>(optional)</small> </h2>
                                <p>In necessary, enter funeral services information. You will be able to remove this information later.</p>
                            </div>
                            <div class="step-form">
                                <div class="step-05">
                                    <div class="step-05-l">
                                        <div class="input-wrap">
                                            <label class="label-css">Memorial Services & Viewing Section.</label>
                                            <div class="input-l">
                                                <input type="text" name="" placeholder="Date" class="input-css">
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="" placeholder="Time" class="input-css">
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="" placeholder="Name fo place" class="input-css">
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="" placeholder="Address" class="input-css">
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-three-l">
                                                <input type="text" name="" placeholder="City" class="input-css">
                                            </div>
                                            <div class="input-three-m">
                                                <input type="text" name="" placeholder="State" class="input-css">
                                            </div>
                                            <div class="input-three-r">
                                                <input type="text" name="" placeholder="Zip" class="input-css">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="step-05-m">
                                        <div class="input-wrap">
                                            <label class="label-css">Funeral Services section</label>
                                            <div class="input-l">
                                                <input type="text" name="" placeholder="Date" class="input-css">
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="" placeholder="Time" class="input-css">
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="" placeholder="Name fo place" class="input-css">
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="" placeholder="Address" class="input-css">
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-three-l">
                                                <input type="text" name="" placeholder="City" class="input-css">
                                            </div>
                                            <div class="input-three-m">
                                                <input type="text" name="" placeholder="State" class="input-css">
                                            </div>
                                            <div class="input-three-r">
                                                <input type="text" name="" placeholder="Zip" class="input-css">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="step-05-r">
                                        <div class="input-wrap">
                                            <label class="label-css">Burial Section</label>
                                            <div class="input-l">
                                                <input type="text" name="" placeholder="Date" class="input-css">
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="" placeholder="Time" class="input-css">
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="" placeholder="Name fo place" class="input-css">
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="" placeholder="Address" class="input-css">
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-three-l">
                                                <input type="text" name="" placeholder="City" class="input-css">
                                            </div>
                                            <div class="input-three-m">
                                                <input type="text" name="" placeholder="State" class="input-css">
                                            </div>
                                            <div class="input-three-r">
                                                <input type="text" name="" placeholder="Zip" class="input-css">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-btm-btn">
                                    <button class="back" onclick="return back_step()">Back</button>
                                    <button class="skip" onclick="return skip_step()">Skip</button>
                                    <button class="next" onclick="return false;">Next</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="profile_process" id="profile_process" value="0"/>
                    </form>
                </div>

            </div>
        </div>
    </div>	
    <div class="create-profile-body hide profile-steps"  id="sixth-step">
        <div class="container">
            <div class="create-profile-box step-06-wrap">
                <div class="step-title">
                    <h2>Create a Tribute Fundraiser<small>(optional)</small> </h2>
                    <p>In necessary, enter funeral services information. You will be able to remove this information later.</p>
                </div>

                <div class="step-form">
                    <div class="step-06">
                        <div class="step-06-l">
                            <div class="input-wrap">
                                <label class="label-css">Memorial Services & Viewing Section.</label>
                                <input type="text" name="" placeholder="Date" class="input-css">
                            </div>
                            <div class="input-wrap">
                                <div class="input-l">
                                    <input type="text" name="" placeholder="Fundraising Goal ($)" class="input-css">
                                    <p>Leave emply for campaigns without a fundraising goal.</p>
                                </div>
                                <div class="input-r">
                                    <input type="text" name="" placeholder="End Date" class="input-css">
                                    <p>Leave emply ongoing fundraising campaigns.</p>
                                </div>
                            </div>
                            <div class="input-wrap">
                                <textarea class="input-css textarea-css" placeholder="Quod omittam vulputate quo ex."></textarea>
                            </div>
                        </div>
                        <div class="step-06-r">
                            <div class="select-file">
                                <div class="select-file-upload"> 
                                    <span class="select-file_up_btn">Upload images, Or Videos to fundraiser page <span>Select Files</span></span>
                                    <input type="file" name="my_doc_upload" id="my_doc_upload" multiple="false"> 
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="step-btm-btn">
                        <button class="back" onclick="return back_step()">Back</button>
                        <button class="skip" onclick="return skip_step()">Skip</button>
                        <button class="next" onclick="return false;">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>	
    <div class="create-profile-body hide profile-steps" id="seventh-step" >
        <div class="container">
            <div class="create-profile-box step-finish step-06-wrap">
                <div class="step-title">
                    <h2>John's Life Profile is complete but not yet published.</h2>
                    <p>You can click the back button below to make updates. <br/> Click the preview profile button to view and publish the profile.</p>
                </div>
                <div class="step-btm-btn">
                    <button class="back" onclick="return back_step()">Back</button>
                    <button class="next" onclick="return false;">Preview Profile</button>
                </div>
            </div>
        </div>
    </div>	
</div>
<script type="text/javascript">
    var profile_id = '<?php echo (isset($profile)) ? base64_encode($profile['id']) : 0 ?>';
    console.log('profile_id', profile_id);
    $(function () {
        //-- Initialize datepicker
        $('.date-picker').datepicker({
            format: "dd/mm/yyyy",
            endDate: "date()"
        });
        // Setup validation
        $("#create_profile_form").validate({
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
                date_of_birth: {
                    required: true
                },
                date_of_death: {
                    required: true
                }
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
    // Validate form and submit data
    function submit_form() {
        var profile_process = $('#profile_process').val();
        if (profile_process == 0) {
            if ($('#create_profile_form').valid()) {
                $('#profile_process').val(1);
                fd = new FormData(document.getElementById("create_profile_form"));
                $.ajax({
                    url: site_url + "profile/create",
                    type: "POST",
                    data: fd,
                    dataType: "json",
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function (data) {
                        if (data.success == true) {
                            console.log(data.data);
                            profile_id = btoa(data.data.id);
                            console.log('after profile is updated', profile_id);
                            profile_steps('second-step');
                        } else {
                            $('#profile_process').val(0);
                            showErrorMSg(data.error);
                        }
                    }
                });
            } else {
                console.log('form not valid');
            }
        }
        return false;
    }
    //-- Hide show steps based on step id
    function profile_steps(obj) {
        $('.profile-steps').addClass('hide');
        $('.steps-li').removeClass('active');
        $('.steps-li').removeClass('process-done');
        $('#' + obj + '-li').addClass('active');

        if (obj == 'first-step') {
            $('.main-steps').removeClass('hide');
            $('#' + obj).removeClass('hide');
        } else if (obj == 'second-step') {
            $('.main-steps').removeClass('hide');
            $('#' + obj).removeClass('hide');
            $('#first-step-li').addClass('process-done');
        } else if (obj == 'third1-step') {
            $('.main-steps').removeClass('hide');
            $('#third-step-li').addClass('active');
            $('#' + obj).removeClass('hide');
            $('#first-step-li,#second-step-li').addClass('process-done');
        } else if (obj == 'third-step') {
            $('.main-steps').removeClass('hide');
            $('#' + obj).removeClass('hide');
            $('#first-step-li,#second-step-li').addClass('process-done');
        } else if (obj == 'forth-step') {
            $('.main-steps').removeClass('hide');
            $('#' + obj).removeClass('hide');
            $('#first-step-li,#second-step-li,#third-step-li').addClass('process-done');
        } else if (obj == 'fifth-step') {
            $('.main-steps').removeClass('hide');
            $('#' + obj).removeClass('hide');
            $('#first-step-li,#second-step-li,#third-step-li,#forth-step-li').addClass('process-done');
        } else if (obj == 'sixth-step') {
            $('.main-steps').addClass('hide');
            $('#' + obj).removeClass('hide');
            $('#first-step-li,#second-step-li,#third-step-li,#forth-step-li').addClass('process-done');
        } else if (obj == 'seventh-step') {
            $('.main-steps').addClass('hide');
            $('#' + obj).removeClass('hide');
            $('#first-step-li,#second-step-li,#third-step-li,#forth-step-li').addClass('process-done');
        }
    }
    function back_step() {
        var profile_process = $('#profile_process').val();
        if (profile_process == 1) {
            $('#profile_process').val(0);
            profile_steps('first-step');
        } else if (profile_process == 2) {
            $('#profile_process').val(1);
            profile_steps('second-step');
        } else if (profile_process == 3) {
            if (!$('#third1-step').hasClass('hide')) {
                $('#profile_process').val(3);
                profile_steps('third-step');
            } else {
                $('#profile_process').val(2);
                profile_steps('second-step');
            }
        } else if (profile_process == 4) {
            $('#profile_process').val(3);
            profile_steps('third1-step');
        } else if (profile_process == 5) {
            $('#profile_process').val(4);
            profile_steps('forth-step');
        } else if (profile_process == 6) {
            $('#profile_process').val(5);
            profile_steps('fifth-step');
        } else if (profile_process == 7) {
            $('#profile_process').val(6);
            profile_steps('sixth-step');
        }

        return false;
    }
    function skip_step() {
        var profile_process = $('#profile_process').val();
        if (profile_process == 1) {
            $('#profile_process').val(2);
            profile_steps('third-step');
        } else if (profile_process == 2) {
            $('#profile_process').val(3);
            if ($('#third-step').hasClass('hide')) {
                profile_steps('third-step');
            } else {
                profile_steps('third1-step');
            }
        } else if (profile_process == 3) {
            if (!$('#third-step').hasClass('hide')) {
                profile_steps('third1-step');
            } else {
                $('#profile_process').val(4);
                profile_steps('forth-step');
            }
        } else if (profile_process == 4) {
            $('#profile_process').val(5);
            profile_steps('fifth-step');
        } else if (profile_process == 5) {
            $('#profile_process').val(6);
            profile_steps('sixth-step');
        } else if (profile_process == 6) {
            $('#profile_process').val(7);
            profile_steps('seventh-step');
        }
        return false;
    }

    var image_count = 0, video_count = 0;
    $("#gallery").change(function () {
        var dvPreview = $("#selected-preview");
        if (typeof (FileReader) != "undefined") {
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            var regex_video = /^([a-zA-Z0-9\s_\\.\-:])+(.mp4)$/;
            $($(this)[0].files).each(function (index) {
                var file = $(this);
                str = '';
                if (regex.test(file[0].name.toLowerCase())) {
                    image_count++;
                    //-- check image and video count
                    if (image_count <= max_images_count) {
                        //-- Remove default preview div
                        $('#default-preview').remove();
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            str += '<li><div class="upload-wrap"><span>';
                            str += '<img src="' + e.target.result + '" style="width:100%">';
                            str += '</span><a href="javascript:void(0)" onclick="delete_media(' + index + ')">';
                            str += '<?php $this->load->view('delete_svg', true); ?>';
                            str += '</a></div></li>';
                            dvPreview.append(str);
                        }
                        // upload image
                        $.ajax({
                            url: site_url + "profile/create",
                            type: "POST",
                            data: fd,
                            dataType: "json",
                            processData: false, // tell jQuery not to process the data
                            contentType: false, // tell jQuery not to set contentType
                            success: function (data) {
                                if (data.success == true) {
                                    console.log(data.data);
                                    profile_id = btoa(data.data.id);
                                    console.log('after profile is updated', profile_id);
                                    profile_steps('second-step');
                                } else {
                                    $('#profile_process').val(0);
                                    showErrorMSg(data.error);
                                }
                            }
                        });
                        reader.readAsDataURL(file[0]);
                    } else {
                        showErrorMSg("Limit is exceeded to upload images");
                    }
                } else if (regex_video.test(file[0].name.toLowerCase())) {
                    video_count++;
                    if (video_count <= max_videos_count) {
                        $('#default-preview').remove();
                        str += '<li><div class="upload-wrap"><span>';
                        str += '<video style="width:100%;height:100%" controls><source src="' + URL.createObjectURL(file[0]) + '" id="video_here">Your browser does not support HTML5 video.</video>';
                        str += '</span><a href="javascript:void(0)" onclick="delete_media(' + index + ')">';
                        str += '<?php $this->load->view('delete_svg', true); ?>';
                        str += '</a></div></li>';
                        dvPreview.append(str);

                    } else {
                        showErrorMSg("Limit is exceeded to upload videos");
                    }
                } else {
                    showErrorMSg(file[0].name + " is not a valid image/video file.");
                }
            });
        } else {
            showErrorMSg("This browser does not support HTML5 FileReader.");
        }
    });
    function delete_media(index) {

    }
</script>