<style type="text/css">
    .input-css.error{border:1px solid red !important;}
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
<?php
$month_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
$day_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
?>
<div class="create-profile create-profile_wrappers"> 
    <div class="create-profile-top">
        <div class="container">
            <h2>
                <?php
                if (isset($profile))
                    echo "Edit a Life Profile.";
                else
                    echo "Create a Life Profile.";
                ?>
            </h2>
            <p>A great way to honor your loved one.</p>
        </div>
    </div>
    <div class="create-profile-body main-steps">
        <div class="container">
            <div class="create-profile-box create_pl">
                <?php
                $tribute_class = '';
                $profile_class = 'active';
                if ($this->input->get('tribute') == 1) {
                    $tribute_class = 'active';
                    $profile_class = '';
                }
                ?>
                <ul class="ul_tab_custom ul_tab_custom_new nav nav-tabs responsive" id="myTab">
                    <li class="steps-li <?php echo $profile_class ?>" id="first-step-li"><a href="#first-step">Basic Info</a></li>
                    <li class="steps-li" id="second-step-li"><a href="#second-step">Life Gallery</a></li>
                    <li class="steps-li" id="third-step-li"><a href="#third-step">Fun Facts</a></li>
                    <li class="steps-li" id="third1-step-li"><a href="#third1-step">Affiliations</a></li>
                    <li class="steps-li" id="forth-step-li"><a href="#forth-step">Life Timeline</a></li>
                    <li class="steps-li" id="fifth-step-li"><a href="#fifth-step">Funeral Services</a></li>
                    <li class="steps-li <?php echo $tribute_class ?>" id="sixth-step-li"><a href="#sixth-step">Tribute Fundraiser</a></li>
                    <li class="steps-li" id="seventh-step-li"><a href="#seventh-step">Share</a></li>
                </ul>

                <div class="step-form tab-content responsive">
                    <div id="first-step" class="profile-steps tab-pane <?php echo $profile_class ?>">
                        <form method="post" enctype="multipart/form-data" id="create_profile_form">
                            <input type="hidden" name="profile_process" id="profile_process" value="0"/>
                            <div class="step-01-l-wrap">
                                <div class="step-01-l">
                                    <div class="upload-btn"> 
                                        <span class="up_btn">
                                            <?php
                                            $profile_required = 'required';
                                            if (isset($profile) && $profile['profile_image'] != '') {
                                                $profile_required = '';
                                                echo "<img src='" . PROFILE_IMAGES . $profile['profile_image'] . "' style='width: 170px;'>";
                                            } else
                                                echo "Upload Profile Picture";
                                            ?>
                                        </span>
                                        <input type="file" name="profile_image" id="profile_image" multiple="false" onchange="readURL(this);" <?php echo $profile_required ?>> 
                                    </div>
                                </div>

                                <div class="step-01-m">
                                    <div class="input-wrap">
                                        <label class="label-css">Add Profile Details</label>
                                        <div class="input-l">
                                            <input type="text" id="firstname" name="firstname" placeholder="First Name" class="input-css" value="<?php echo (isset($profile)) ? $profile['firstname'] : set_value('firstname') ?>" />
                                        </div>
                                        <div class="input-r">
                                            <input type="text" id="lastname" name="lastname" placeholder="Last Name" class="input-css" value="<?php echo (isset($profile)) ? $profile['lastname'] : set_value('lastname') ?>"/>
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" name="nickname" placeholder="Nick Name" class="input-css" value="<?php echo (isset($profile)) ? $profile['nickname'] : set_value('nickname') ?>"/>
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-l">
                                            <input type="text" name="date_of_birth" placeholder="Date of Birth (mm/dd/yy)" class="input-css date-picker" value="<?php echo (isset($profile)) ? date('m/d/Y', strtotime($profile['date_of_birth'])) : set_value('date_of_birth') ?>"/>
                                        </div>
                                        <div class="input-r">
                                            <input type="text" name="date_of_death" placeholder="Date of Death (mm/dd/yy)" class="input-css date-picker" value="<?php echo (isset($profile)) ? date('m/d/Y', strtotime($profile['date_of_death'])) : set_value('date_of_death') ?>"/>
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <select name="country" id="country" class="input-css service-country" placeholder="Country">
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
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-l">
                                            <select name="state" id="state" class="input-css service-state" placeholder="State">
                                                <option value="">Select state</option>
                                                <?php
                                                foreach ($profile_states as $state) {
                                                    $selected = '';
                                                    if (isset($profile) && $profile['state'] == $state['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    $code = '';
                                                    if ($state['shortcode'] != '') {
                                                        $codes = explode('-', $state['shortcode']);
                                                        $code = $codes[1];
                                                    }
                                                    ?>
                                                    <option value="<?php echo $state['id'] ?>" <?php echo $selected ?>><?php echo $state['name'] ?><?php if ($code != '') echo ' (' . $code . ')' ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="input-r">
                                            <select name="city" id="city" class="input-css service-city" placeholder="City">
                                                <option value="">Select city</option>
                                                <?php
                                                foreach ($profile_cities as $city) {
                                                    $selected = '';
                                                    if (isset($profile) && $profile['city'] == $city['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $city['name'] ?>" <?php echo $selected ?>><?php echo $city['name'] ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-01-r">
                                    <div class="input-wrap">
                                        <label class="label-css">Create Life Bio</label>
                                        <textarea name="life_bio" id="life_bio" class="input-css textarea-css" placeholder="Write about Bio... "><?php echo (isset($profile)) ? $profile['life_bio'] : set_value('life_bio') ?></textarea>
                                        <label class="label-css"><a title="Introduce your loved one like a real person and Watch your word count" href="javascript:void(0)" data-toggle="tooltip" class="bio-tips">Tips for writing a Life Bio</a></label>
                                    </div>
                                </div>
                            </div>	
                        </form>
                        <div class="step-btm-btn">
                            <button class="next" id="firststep-proceed-btn" onclick="return proceed_step();">Save/Proceed</button>
                            <?php if (!isset($profile) || (isset($profile) && $profile['is_published'] == 0)) { ?>
                                <button class="back" onclick="return publish_profile()">Publish</button>
                            <?php } ?>
                            <button class="skip" onclick="return preview_profile()">Preview</button>
                            <button class="save_update" onclick="return save_finish();">Save and Finish Later</button>
                        </div>
                    </div>
                    <div id="second-step" class="profile-steps tab-pane">
                        <div class="step-title">
                            <h2>Create Life Gallery <small>(optional)</small> </h2>
                            <p>Add Photo/Video files of your loved one. <br/> You will be able to add more or remove previously uploaded files later.</p>
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
                                    <?php
                                    $image_count = $video_count = 0;
                                    if (isset($profile_gallery) && !empty($profile_gallery)) {
                                        foreach ($profile_gallery as $key => $value) {
                                            ?>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span>
                                                        <?php
                                                        if ($value['type'] == 1) {
                                                            $image_count++;
                                                            ?>
                                                            <a href="<?php echo PROFILE_IMAGES . $value['media'] ?>" class="fancybox" data-fancybox-type="image" rel="upload_gallery">
                                                                <img src="<?php echo PROFILE_IMAGES . $value['media'] ?>">
                                                            </a>
                                                            <?php
                                                        } else {
                                                            $video_count++;
                                                            ?>
                                                            <img src="<?php echo PROFILE_IMAGES . str_replace('mp4', 'jpg', $value['media']) ?>">
                                                            <span class="gallery-play-btn"><a href="<?php echo base_url(PROFILE_IMAGES . $value['media']) ?>" class="fancybox" data-fancybox-type="iframe" rel="upload_gallery"><img src="assets/images/play.png" alt=""></a></span>
                                                        <?php } ?>
                                                    </span>
                                                    <a href="javascript:void(0)" class="remove-video" onclick="delete_media(this, '<?php echo base64_encode($value['id']) ?>')"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                        <?php }
                                        ?>
                                    <?php } else { ?>
                                        <div id="default-preview">
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)" class="remove-video"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)" class="remove-video"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)" class="remove-video"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)" class="remove-video"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)" class="remove-video"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                            <li>
                                                <div class="upload-wrap">
                                                    <span></span>
                                                    <a href="javascript:void(0)" class="remove-video"><?php $this->load->view('delete_svg'); ?></a>	
                                                </div>
                                            </li>
                                        </div>
                                    <?php } ?>
                                    <div id="selected-preview"></div>
                                </ul>
                            </div>	
                            <div id="dvPreview"></div>
                        </div>
                        <div class="step-btm-btn">
                            <button class="next" onclick="return proceed_step();">Save/Proceed</button>
                            <?php if (!isset($profile) || (isset($profile) && $profile['is_published'] == 0)) { ?>
                                <button class="back" onclick="return publish_profile()">Publish</button>
                            <?php } ?>
                            <button class="skip" onclick="return preview_profile(this)">Preview</button>
                            <button class="save_update" onclick="return save_finish();">Save and Finish Later</button>
                        </div>
                    </div>
                    <div id="third-step" class="profile-steps tab-pane">
                        <div class="step-title">
                            <h2>Add A Fun Facts <small>(optional)</small> </h2>
                            <p>Add up to 10 fun facts about your loved one.<br/> You will be able to add more (up to 10) or remove previously entered ones later.</p>
                        </div>
                        <?php
                        $fact_class = 'default-fact-empty';
                        if (isset($fun_facts) && !empty($fun_facts))
                            $fact_class = '';
                        ?>
                        <div class="step-form <?php echo $fact_class ?>">
                            <div class="step-03">
                                <div class="step-03-l">
                                    <?php
                                    $facts_count = 0;
                                    if (isset($fun_facts) && !empty($fun_facts)) {
                                        foreach ($fun_facts as $key => $value) {
                                            $facts_count++;
                                            ?>
                                            <div class="input-wrap-div">
                                                <div class="input-css"><?php echo $value['facts'] ?></div>
                                                <a href="javascript:void(0)" onclick="delete_facts(this, '<?php echo base64_encode($value['id']) ?>')"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div id="default-facts">
                                            <div class="input-wrap-div">
                                                <div class="input-css">Text here</div>
                                                <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                            <div class="input-wrap-div">
                                                <div class="input-css">Text here</div>
                                                <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                            <div class="input-wrap-div">
                                                <div class="input-css">Text here</div>
                                                <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                            <div class="input-wrap-div">
                                                <div class="input-css">Text here</div>
                                                <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div id="selected-facts"></div>
                                </div>
                                <div class="step-03-m">
                                    <button type="button" onclick="$('#funfact-modal').modal('show')">Add a Fun Fact</button>
                                </div>
                                <div class="step-03-r">
                                    <h6>Fun facts can be anything fun or <br/>interesting about your loved one.</h6>
                                    <h5>Example Include things such as:</h5>
                                    <p>Place of birth or where they grew up.</p>
                                    <p>Family information</p>
                                    <p>School(s) Attended</p>
                                    <p>Favorite hobby</p>
                                    <p>Favorite saying</p>
                                </div>
                            </div>	
                        </div>
                        <div class="step-btm-btn">
                            <button class="next" onclick="return proceed_step();">Save/Proceed</button>
                            <?php if (!isset($profile) || (isset($profile) && $profile['is_published'] == 0)) { ?>
                                <button class="back" onclick="return publish_profile()">Publish</button>
                            <?php } ?>
                            <button class="skip" onclick="return preview_profile(this)">Preview</button>
                            <button class="save_update" onclick="return save_finish();">Save and Finish Later</button>
                        </div>
                    </div>
                    <div id="third1-step" class="profile-steps tab-pane">
                        <div class="step-title">
                            <h2>Add Affilliations <small>(optional)</small> </h2>
                            <p>Add up to 10fun Affiliations about your loved one. <br/> You will be able to add more (up to 10) or remove previously entered ones later.</p>
                        </div>
                        <?php
                        $affiliation_class = 'default-fact-empty';
                        if (isset($profile_affiliations) && !empty($profile_affiliations))
                            $affiliation_class = '';
                        ?>
                        <div class="step-form <?php echo $affiliation_class ?>">
                            <div class="step-03">
                                <div class="step-03-l">
                                    <div id="selected-affiliation"></div>
                                    <?php
                                    $affiliation_count = 0;
                                    if (isset($profile_affiliations) && !empty($profile_affiliations)) {
                                        foreach ($profile_affiliations as $key => $value) {
                                            $affiliation_count++;
                                            ?>
                                            <div class="input-wrap-div">
                                                <div class="input-css"><?php echo $value['name'] ?></div>
                                                <a href="javascript:void(0)" onclick="delete_affiliation(this, '<?php echo base64_encode($value['id']) ?>',<?php echo $value['free_text'] ?>)"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div id="default-affiliation">
                                            <div class="input-wrap-div">
                                                <div class="input-css">Text here</div>
                                                <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                            <div class="input-wrap-div">
                                                <div class="input-css">Text here</div>
                                                <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                            <div class="input-wrap-div">
                                                <div class="input-css">Text here</div>
                                                <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                            <div class="input-wrap-div">
                                                <div class="input-css">Text here</div>
                                                <a href="javascript:void(0)"><?php $this->load->view('delete_svg'); ?></a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="step-03-m">
                                    <button type="button" onclick="$('#affiliation-modal').modal('show')">Add Affiliation</button>
                                </div>
                                <div class="step-03-r">
                                    <h6>Affiliations are things your loved one was <br/> associated with and that were important to hm or her.</h6>
                                    <h5>Example Incluse things such as:</h5>
                                    <p>Schools attended</p>
                                    <p>Organizations and clubs</p>
                                    <p>Social Causes</p>
                                    <p>Professional Groups or Interests</p>
                                    <p>Sports Teams or involvement in sports</p>
                                </div>
                            </div>	
                        </div>
                        <div class="step-btm-btn">
                            <button class="next" onclick="return proceed_step();">Save/Proceed</button>
                            <?php if (!isset($profile) || (isset($profile) && $profile['is_published'] == 0)) { ?>
                                <button class="back" onclick="return publish_profile()">Publish</button>
                            <?php } ?>
                            <button class="skip" onclick="return preview_profile(this)">Preview</button>
                            <button class="save_update" onclick="return save_finish();">Save and Finish Later</button>
                        </div>
                    </div>
                    <div id="forth-step" class="profile-steps tab-pane">
                        <div class="step-title">
                            <h2>Life Timeline <small>(optional)</small> </h2>
                            <p>Enter information about important milestones in your loved one's life.</p>
                        </div>
                        <div class="step-form">
                            <form id="timeline-form">
                                <div class="timeline-div">
                                    <?php
                                    if (isset($timeline) && !empty($timeline)) {
                                        $timeline_count = count($timeline) - 1;
                                        foreach ($timeline as $key => $value) {
                                            ?>
                                            <input type="hidden" name="timelineid[]" value="<?php echo base64_encode($value['id']) ?>"/>
                                            <div class="step-06">
                                                <div class="step-06-l">
                                                    <div class="input-wrap">
                                                        <label class="label-css">Title</label>
                                                        <input type="text" name="title[]" placeholder="Life Event" class="input-css" value="<?php echo $value['title'] ?>">
                                                    </div>
                                                    <div class="input-wrap">
                                                        <div class="input-three-l">
                                                            <input type="number" name="year[]" placeholder="Year" class="input-css" value="<?php echo $value['year'] ?>">
                                                        </div>
                                                        <div class="input-three-m">
                                                            <select name="month[]" placeholder="Month" class="input-css">
                                                                <option value="">Select Month</option>
                                                                <?php
                                                                foreach ($month_arr as $month) {
                                                                    $selected = '';
                                                                    if ($month == $value['month'])
                                                                        $selected = 'selected';
                                                                    echo "<option value='" . $month . "' " . $selected . ">" . $month . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="input-three-r">
                                                            <select name="day[]" placeholder="Day" class="input-css">
                                                                <?php
                                                                foreach ($day_arr as $day) {
                                                                    $time_day = date('d', strtotime($value['date']));
                                                                    $selected = '';
                                                                    if ($day == $time_day)
                                                                        $selected = 'selected';
                                                                    echo "<option value='" . $day . "' $selected>" . $day . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="input-wrap">
                                                        <textarea class="input-css textarea-css" name="details[]" placeholder="Details (optional)"><?php echo $value['details']; ?></textarea>
                                                    </div>
                                                    <?php if ($key == $timeline_count) { ?>
                                                        <a class="add_timeline_btn label-css"><i class="fa fa-plus"></i> Add another life timeline entry.</a>
                                                    <?php } else { ?>
                                                        <a class="remove_org_timeline_btn text-danger mb-20 label-css" data-id='<?php echo base64_encode($value['id']) ?>'><i class="fa fa-trash"></i> Remove</a>
                                                    <?php } ?>
                                                </div>
                                                <div class="step-06-r">
                                                    <div class="select-file">
                                                        <div class="select-file-upload"> 
                                                            <span class="select-file_up_btn">
                                                                <?php
                                                                if ($value['timeline_media'] != '') {
                                                                    if ($value['media_type'] == 1) {
                                                                        ?>
                                                                        <img src="<?php echo PROFILE_IMAGES . $value['timeline_media'] ?>" style="width: 170px; border-radius: 2px;" alt="">
                                                                    <?php } else if ($value['media_type'] == 2) {
                                                                        ?>
                                                                        <video style="width:100%;" controls><source src="<?php echo PROFILE_IMAGES . $value['timeline_media'] ?>">Your browser does not support HTML5 video.</video>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    Upload Picture or Video? <span>Select</span>
                                                                <?php } ?>
                                                            </span>
                                                            <input type="file" name="life_pic[]" multiple="false" class="timeline-media"> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="step-06">
                                            <div class="step-06-l">
                                                <div class="input-wrap">
                                                    <label class="label-css">Title</label>
                                                    <input type="text" name="title[]" placeholder="Life Event" class="input-css">
                                                </div>
                                                <div class="input-wrap">
                                                    <div class="input-three-l">
                                                        <input type="number" name="year[]" placeholder="Year" class="input-css">
                                                    </div>
                                                    <div class="input-three-m">
                                                        <select name="month[]" placeholder="Month" class="input-css">
                                                            <option value="">Select Month</option>
                                                            <?php
                                                            foreach ($month_arr as $month) {
                                                                echo "<option value='" . $month . "'>" . $month . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="input-three-r">
                                                        <select name="day[]" placeholder="Day" class="input-css">
                                                            <option value="">Select Day</option>
                                                            <?php
                                                            foreach ($day_arr as $day) {
                                                                echo "<option value='" . $day . "'>" . $day . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-wrap">
                                                    <textarea class="input-css textarea-css" name="details[]" placeholder="Details (optional)"></textarea>
                                                </div>
                                                <a class="add_timeline_btn label-css"><i class="fa fa-plus"></i> Add another life timeline entry.</a>
                                            </div>
                                            <div class="step-06-r">
                                                <div class="select-file">
                                                    <div class="select-file-upload"> 
                                                        <span class="select-file_up_btn">Upload Picture or Video? <span>Select</span></span>
                                                        <input type="file" name="life_pic[]" multiple="false" class="timeline-media"> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                        <div class="step-btm-btn">
                            <button class="next" onclick="return proceed_step();">Save/Proceed</button>
                            <?php if (!isset($profile) || (isset($profile) && $profile['is_published'] == 0)) { ?>
                                <button class="back" onclick="return publish_profile()">Publish</button>
                            <?php } ?>
                            <button class="skip" onclick="return preview_profile(this)">Preview</button>
                            <button class="save_update" onclick="return save_finish();">Save and Finish Later</button>
                        </div>
                    </div>
                    <div id="fifth-step" class="profile-steps tab-pane">
                        <div class="step-title">
                            <h2>Add Funeral Services <small>(optional)</small> </h2>
                            <p>If necessary, enter funeral services information. You will be able to remove this information later.</p>
                        </div>
                        <form id="funeralservice-form" method="post">
                            <div class="step-form">
                                <div class="step-05">
                                    <div class="step-05-l">
                                        <div class="input-wrap">
                                            <label class="label-css">Memorial Services & Viewing Section.</label>
                                            <div class="input-l">
                                                <input type="text" name="memorial_date" id="memorial_date" placeholder="Date" class="input-css service-datepicker" value="<?php if (isset($memorial_service) && !empty($memorial_service)) echo date('m/d/Y', strtotime($memorial_service['date'])) ?>">
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="memorial_time" id="memorial_time" placeholder="Time" class="input-css service-time" value="<?php if (isset($memorial_service) && !empty($memorial_service)) echo date('h:i A', strtotime($memorial_service['time'])) ?>">
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="memorial_place" id="memorial_place" placeholder="Name of place" class="input-css" value="<?php if (isset($memorial_service) && !empty($memorial_service)) echo $memorial_service['place_name'] ?>">
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="memorial_address" id="memorial_address" placeholder="Address" class="input-css" value="<?php if (isset($memorial_service) && !empty($memorial_service)) echo $memorial_service['address'] ?>">
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <select name="memorial_country" id="memorial_country" class="input-css service-country" placeholder="Country">
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    foreach ($countries as $country) {
                                                        $selected = '';
                                                        if (isset($memorial_service) && !empty($memorial_service)) {
                                                            if ($country['id'] == $memorial_service['country'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $country['id'] ?>" <?php echo $selected ?>><?php echo $country['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="input-r">
                                                <select name="memorial_state" id="memorial_state" class="input-css service-state" placeholder="State">
                                                    <option value="">Select state</option>
                                                    <?php
                                                    foreach ($memorial_states as $state) {
                                                        $selected = '';
                                                        if (isset($memorial_service) && !empty($memorial_service)) {
                                                            if ($state['id'] == $memorial_service['state'])
                                                                $selected = 'selected';
                                                        }
                                                        $code = '';
                                                        if ($state['shortcode'] != '') {
                                                            $codes = explode('-', $state['shortcode']);
                                                            $code = $codes[1];
                                                        }
                                                        ?>
                                                        <option value="<?php echo $state['id'] ?>" <?php echo $selected ?>><?php echo $state['name'] ?><?php if ($code != '') echo ' (' . $code . ')'; ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <select name="memorial_city" id="memorial_city" class="input-css service-city" placeholder="State">
                                                    <option value="">Select City</option>
                                                    <?php
                                                    foreach ($memorial_cities as $city) {
                                                        $selected = '';
                                                        if (isset($memorial_service) && !empty($memorial_service)) {
                                                            if ($city['id'] == $memorial_service['city'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $city['name'] ?>" <?php echo $selected ?>><?php echo $city['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="memorial_zip" id="memorial_zip" placeholder="Zip" class="input-css" value="<?php if (isset($memorial_service) && !empty($memorial_service)) echo $memorial_service['zip'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="step-05-m">
                                        <div class="input-wrap">
                                            <label class="label-css">Funeral Services section</label>
                                            <div class="input-l">
                                                <input type="text" name="funeral_date" id="funeral_date" placeholder="Date" class="input-css service-datepicker" value="<?php if (isset($funeral_service) && !empty($funeral_service)) echo date('m/d/Y', strtotime($funeral_service['date'])) ?>">
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="funeral_time" id="funeral_time" placeholder="Time" class="input-css service-time" value="<?php if (isset($funeral_service) && !empty($funeral_service)) echo date('h:i A', strtotime($funeral_service['time'])) ?>">
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="funeral_place" id="funeral_place" placeholder="Name of place" class="input-css" value="<?php if (isset($funeral_service) && !empty($funeral_service)) echo $funeral_service['place_name'] ?>">
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="funeral_address" id="funeral_address" placeholder="Address" class="input-css" value="<?php if (isset($funeral_service) && !empty($funeral_service)) echo $funeral_service['address'] ?>">
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <select name="funeral_country" id="funeral_country" class="input-css service-country" placeholder="Country">
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    foreach ($countries as $country) {
                                                        $selected = '';
                                                        if (isset($funeral_service) && !empty($funeral_service)) {
                                                            if ($country['id'] == $funeral_service['country'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $country['id'] ?>" <?php echo $selected ?>><?php echo $country['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="input-r">
                                                <select name="funeral_state" id="funeral_state" class="input-css service-state" placeholder="State">
                                                    <option value="">Select state</option>
                                                    <?php
                                                    foreach ($funeral_states as $state) {
                                                        $selected = '';
                                                        if (isset($funeral_service) && !empty($funeral_service)) {
                                                            if ($state['id'] == $funeral_service['state'])
                                                                $selected = 'selected';
                                                        }
                                                        $code = '';
                                                        if ($state['shortcode'] != '') {
                                                            $codes = explode('-', $state['shortcode']);
                                                            $code = $codes[1];
                                                        }
                                                        ?>
                                                        <option value="<?php echo $state['id'] ?>" <?php echo $selected ?>><?php echo $state['name'] ?><?php if ($code != '') echo ' (' . $code . ')' ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <select name="funeral_city" id="funeral_city" class="input-css service-city" placeholder="City">
                                                    <option value="">Select City</option>
                                                    <?php
                                                    foreach ($funeral_cities as $city) {
                                                        $selected = '';
                                                        if (isset($memorial_service) && !empty($funeral_service)) {
                                                            if ($city['id'] == $funeral_service['city'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $city['name'] ?>" <?php echo $selected ?>><?php echo $city['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="funeral_zip" id="funeral_zip" placeholder="Zip" class="input-css" value="<?php if (isset($funeral_service) && !empty($funeral_service)) echo $funeral_service['zip'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="step-05-r">
                                        <div class="input-wrap">
                                            <label class="label-css">Burial Section</label>
                                            <div class="input-l">
                                                <input type="text" name="burial_date" id="burial_date" placeholder="Date" class="input-css service-datepicker" value="<?php if (isset($burial_service) && !empty($burial_service)) echo date('m/d/Y', strtotime($burial_service['date'])) ?>">
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="burial_time" id="burial_time" placeholder="Time" class="input-css service-time" value="<?php if (isset($burial_service) && !empty($burial_service)) echo $burial_service['time'] ?>">
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="burial_place" id="burial_place" placeholder="Name of place" class="input-css" value="<?php if (isset($burial_service) && !empty($burial_service)) echo $burial_service['place_name'] ?>">
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="burial_address" id="burial_address" placeholder="Address" class="input-css" value="<?php if (isset($burial_service) && !empty($burial_service)) echo $burial_service['address'] ?>">
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <select name="burial_country" id="burial_country" class="input-css service-country" placeholder="Country">
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    foreach ($countries as $country) {
                                                        $selected = '';
                                                        if (isset($burial_service) && !empty($burial_service)) {
                                                            if ($country['id'] == $burial_service['country'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $country['id'] ?>" <?php echo $selected ?>><?php echo $country['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="input-r">
                                                <select name="burial_state" id="burial_state" class="input-css service-state" placeholder="State">
                                                    <option value="">Select state</option>
                                                    <?php
                                                    foreach ($burial_states as $state) {
                                                        $selected = '';
                                                        if (isset($burial_service) && !empty($burial_service)) {
                                                            if ($state['id'] == $burial_service['state'])
                                                                $selected = 'selected';
                                                        }
                                                        $code = '';
                                                        if ($state['shortcode'] != '') {
                                                            $codes = explode('-', $state['shortcode']);
                                                            $code = $codes[1];
                                                        }
                                                        ?>
                                                        <option value="<?php echo $state['id'] ?>" <?php echo $selected ?>><?php echo $state['name'] ?><?php if ($code != '') echo ' (' . $code . ')' ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <select name="burial_city" id="burial_city" class="input-css service-city" placeholder="City">
                                                    <option value="">Select City</option>
                                                    <?php
                                                    foreach ($burial_cities as $city) {
                                                        $selected = '';
                                                        if (isset($burial_service) && !empty($burial_service)) {
                                                            if ($city['id'] == $burial_service['city'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $city['name'] ?>" <?php echo $selected ?>><?php echo $city['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="burial_zip" id="burial_zip" placeholder="Zip" class="input-css" value="<?php if (isset($burial_service) && !empty($burial_service)) echo $burial_service['zip'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="step-btm-btn">
                            <button class="next" onclick="return proceed_step();">Save/Proceed</button>
                            <?php if (!isset($profile) || (isset($profile) && $profile['is_published'] == 0)) { ?>
                                <button class="back" onclick="return publish_profile()">Publish</button>
                            <?php } ?>
                            <button class="skip" onclick="return preview_profile(this)">Preview</button>
                            <button class="save_update" onclick="return save_finish();">Save and Finish Later</button>
                        </div>
                    </div>
                    <div id="sixth-step" class="profile-steps tab-pane <?php echo $tribute_class ?>">
                        <div class="step-title">
                            <h2>Create a Tribute Fundraiser <small>(optional)</small> </h2>
                            <p>If desired, create a Tribute Fundraiser in honor of your loved one.</p>
                        </div>
                        <div class="step-form">
                            <div class="step-06">
                                <form method="post" id="fundraiser_profile-form">
                                    <div class="step-06-l">
                                        <div class="input-wrap">
                                            <label class="label-css">Tribute Fundraiser Title.</label>
                                            <input type="text" name="fundraiser_title" id="fundraiser_title" placeholder="Provide a short descriptive title for the fundraiser" class="input-css" value="<?php if (isset($fundraiser)) echo $fundraiser['title'] ?>" <?php if (isset($fundraiser) && !empty($fundraiser)) echo "required" ?>>
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <input type="number" name="fundraiser_goal" id="fundraiser_goal" placeholder="Fundraising Goal ($)" class="input-css" min="0" value="<?php if (isset($fundraiser)) echo $fundraiser['goal'] ?>" <?php if (isset($fundraiser) && !empty($fundraiser)) echo "required" ?>>
                                                <p>Minimum goal is $250.</p>
                                            </div>
                                            <!--                                            <div class="input-r">
                                                                                            <input type="text" name="fundraiser_enddate" id="fundraiser_enddate" placeholder="End Date" class="input-css" value="<?php if (isset($fundraiser)) echo date('m/d/Y', strtotime($fundraiser['end_date'])) ?>">
                                                                                            <p>Leave empty ongoing fundraising campaigns.</p>
                                                                                        </div>-->
                                        </div>
                                        <div class="input-wrap">
                                            <label class="label-css">Description</label>
                                            <textarea class="input-css textarea-css" name="fundraiser_details" id="fundraiser_details" placeholder="Describe your loved one and his or her relation to you;explain why you are running this fundraiser, what the funds will be used for, and when the funds are needed." <?php if (isset($fundraiser) && !empty($fundraiser)) echo "required" ?>><?php if (isset($fundraiser)) echo $fundraiser['details']; ?></textarea>
                                        </div>
                                        <div class="input-wrap">
                                            <label class="label-css">You need to create your Wepay account for collecting funds. Please click on below button to start</label>
                                            <?php
                                            $auth_btn_style = '';
                                            $success_msg_style = 'style="display:none"';
                                            $wepay_connected = 0;
                                            if (isset($fundraiser) && !empty($fundraiser) && $fundraiser['wepay_account_id'] != '' && $fundraiser['wepay_access_token'] != '') {
                                                $auth_btn_style = 'style="display:none"';
                                                $success_msg_style = '';
                                                $wepay_connected = 1;
                                            }
                                            ?>
                                            <div class="wepay_auth_btn" <?php echo $auth_btn_style ?>>
                                                <a id="start_oauth2">Click here to create your WePay account</a>
                                            </div>
                                            <div class="wepay_success_msg alert alert-success" <?php echo $success_msg_style ?>>
                                                You have successfully created WePay account for this profile. 
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="step-06-r">
                                        <div class="select-file">
                                            <div class="select-file-upload"> 
                                                <span class="select-file_up_btn">Upload images, Or Videos to fundraiser page <span>Select Files</span></span>
                                                <input type="file" name="fundraiser_media[]" id="fundraiser_media" multiple> 
                                            </div>
                                        </div>
                                        <ul class="select-gallery">
                                            <?php
                                            $fundimage_count = $fundvideo_count = 0;
                                            if (isset($fundraiser)) {
                                                foreach ($fundraiser_media as $key => $value) {
                                                    if ($value['type'] == 1) {
                                                        $fundimage_count++;
                                                        ?>
                                                        <li>
                                                            <div class="gallery-wrap">
                                                                <span><a href="<?php echo FUNDRAISER_IMAGES . $value['media'] ?>" class="fancybox" data-fancybox-type="image" rel="fundraiser"><img src="<?php echo base_url() . FUNDRAISER_IMAGES . $value['media']; ?>" alt="" style="width:100%"></a></span>
                                                                <a href="javascript:void(0)" class="remove-video" onclick="delete_fundajaxmedia(this, '<?php echo base64_encode($value['id']) ?>')"><?php $this->load->view('delete_svg'); ?></a>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    } else {
                                                        $fundvideo_count++;
                                                        ?>
                                                        <li>
                                                            <div class="gallery-wrap">
                                                                <span>
                                                                    <img src="<?php echo FUNDRAISER_IMAGES . str_replace('mp4', 'jpg', $value['media']) ?>" style="width:100%">
                                                                    <span class="gallery-play-btn"><a href="<?php echo FUNDRAISER_IMAGES . $value['media'] ?>" class="fancybox" data-fancybox-type="iframe" rel="fundraiser"><img src="assets/images/play.png" alt=""></a></span>
                                                                </span>
                                                                <a href="javascript:void(0)" class="remove-video" onclick="delete_fundajaxmedia(this, '<?php echo base64_encode($value['id']) ?>')"><?php $this->load->view('delete_svg'); ?></a>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            <div id="fundraiser_preview"></div>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="step-btm-btn">
                            <button class="next" onclick="return proceed_step();">Save/Proceed</button>
                            <?php if (!isset($profile) || (isset($profile) && $profile['is_published'] == 0)) { ?>
                                <button class="back" onclick="return publish_profile()">Publish</button>
                            <?php } ?>
                            <button class="skip" onclick="return preview_profile(this)">Preview</button>
                            <button class="save_update" onclick="return save_finish();">Save and Finish Later</button>
                        </div>
                    </div>
                    <div id="seventh-step" class="profile-steps tab-pane">
                        <div class="step-title">
                            <h2>
                                <?php if (isset($profile) && $profile['is_published'] == 1) { ?>
                                    <span id="profile_name"><?php echo $profile['firstname'] . ' ' . $profile['lastname'] . '\'s' ?></span> Life Profile is complete!
                                <?php } else { ?>
                                    <span id="profile_name"><?php
                                        if (isset($profile))
                                            echo $profile['firstname'] . ' ' . $profile['lastname'] . '\'s';
                                        ?></span> Life Profile is complete but not yet published.
                                    <?php
                                }
                                ?>

                            </h2>
                            <p>Click the preview profile button to view and publish the profile.</p>
                        </div>
                        <div class="step-btm-btn">
                            <?php if (!isset($profile) || (isset($profile) && $profile['is_published'] == 0)) { ?>
                                <button class="back" onclick="return publish_profile()">Publish</button>
                            <?php } ?>
                            <button class="skip" onclick="return preview_profile(this)">Preview</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>
<div class="modal fade" id="funfact-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="login-signup">
            <div class="mpopup-body">
                <form id="fun-fact-form">
                    <div class="popup-input">
                        <label>Fun Fact</label>
                        <input type="text" name="fun_fact" id="fun_fact" placeholder="Start Typing.." required>
                    </div>
                </form>
                <div class="pup-btn">
                    <button type="button" onclick="return add_funfact();" id="add-funfact-btn">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="affiliation-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="login-signup">
            <div class="mpopup-body">
                <form id="affiliation-form">
                    <div class="popup-input">
                        <label>Affiliation</label>
                        <select name="select_affiliation" id="select_affiliation" class="selectpicker">
                            <option value="">Select Affiliation</option>
                            <?php foreach ($affiliations as $af) { ?>
                                <option value="<?php echo $af['id'] ?>"><?php echo $af['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="text-center p-10">OR</div>
                        <input type="text" name="affiliation_text" id="affiliation_text" placeholder="Start Typing..">
                    </div>
                </form>
                <div class="pup-btn">
                    <button type="button" onclick="return add_affiliation();" id="add-funfact-btn">Add</button>
                    <a class="affiliation-btn" href="<?php echo site_url('affiliation') ?>" target="_blank">Go to Affiliations</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $wepay_endpoint = WEPAY_ENDPOINT ?>
<script type="text/javascript">
    var user_firstname = '<?php echo $this->session->userdata('remalways_user')['firstname'] ?>'
    var user_lastname = '<?php echo $this->session->userdata('remalways_user')['lastname'] ?>'
    var user_email = '<?php echo $this->session->userdata('remalways_user')['email'] ?>'
    var profile_id = '<?php echo (isset($profile)) ? base64_encode($profile['id']) : 0 ?>';
    var profile_slug = '<?php echo (isset($profile)) ? $profile['slug'] : "" ?>';
    max_images_count = <?php echo MAX_IMAGES_COUNT - $image_count ?>;
    max_videos_count = <?php echo MAX_VIDEOS_COUNT - $video_count ?>;
    max_fundimages_count = <?php echo MAX_IMAGES_COUNT - $fundimage_count ?>;
    max_fundvideos_count = <?php echo MAX_VIDEOS_COUNT - $fundvideo_count ?>;
    max_facts_count = max_affiliation_count = 10;
    delete_str = '<?php $this->load->view('delete_svg', true); ?>';
    facts_count = <?php echo (isset($profile)) ? $facts_count : 0 ?>;
    affiliation_count = <?php echo (isset($profile)) ? $affiliation_count : 0 ?>;
    create_profile_url = site_url + "profile/create";
    if (profile_id != 0) {
        create_profile_url = site_url + "profile/edit/" + profile_slug;
    }
    profile_images = '<?php echo PROFILE_IMAGES ?>';
    var bottom = $('#selected-preview').position().top + $('#selected-preview').outerHeight(true);
    currentTab = 'first-step';
    tributeClass = '<?php echo $tribute_class ?>';
    if (tributeClass != '') {
        currentTab = 'sixth-step';
    }
    curr_url = window.location.href;

    //-- wepay credentials initialize
    wepay_client_id = '<?php echo $wepay_client_id ?>';
    wepay_endpoint = '<?php echo $wepay_endpoint ?>';
    wepay_connected = <?php echo $wepay_connected ?>;
    $(".date-picker").mask("99/99/9999");
    $(".service-datepicker").mask("99/99/9999");
    
</script>
<script src="assets/js/profile.js"></script>

