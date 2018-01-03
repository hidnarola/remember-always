<style type="text/css">.input-css.error{border:1px solid red;}</style>
<link href="assets/css/bootstrap-datepicker/bootstrap-datepicker3.min.css" rel="stylesheet"/>
<script src="assets/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<!-- /theme JS files -->
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

                    <div id="first-step" class="profile-steps">
                        <form method="post" enctype="multipart/form-data" id="create_profile_form">
                            <input type="hidden" name="profile_process" id="profile_process" value="0"/>
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
                                            <input type="text" name="date_of_birth" placeholder="Date of Birth" class="input-css date-picker" value="<?php echo (isset($profile)) ? date('m/d/Y', strtotime($profile['date_of_birth'])) : set_value('date_of_birth') ?>"/>
                                        </div>
                                        <div class="input-r">
                                            <input type="text" name="date_of_death" placeholder="Dath of Death" class="input-css date-picker" value="<?php echo (isset($profile)) ? date('m/d/Y', strtotime($profile['date_of_death'])) : set_value('date_of_death') ?>"/>
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
                        </form>
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
                            <div class="step-btm-btn">
                                <button class="back" onclick="return back_step()">Back</button>
                                <button class="skip" onclick="return skip_step()">Skip</button>
                                <button class="next" onclick="return proceed_step();">Next</button>
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
                                    <p>Favourite hobby</p>
                                    <p>Favourite saying</p>
                                </div>
                            </div>	
                            <div class="step-btm-btn">
                                <button class="back" onclick="return back_step()">Back</button>
                                <button class="skip" onclick="return skip_step()">Skip</button>
                                <button class="next" onclick="return proceed_step();">Next</button>
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
                                    <div id="selected-affiliation"></div>
                                </div>
                                <div class="step-03-m">
                                    <button type="button" onclick="$('#affiliation-modal').modal('show')">Add Affiliation</button>
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
                                <button class="next" onclick="return proceed_step();">Next</button>
                            </div>
                        </div>
                    </div>
                    <div id="forth-step" class="hide profile-steps">
                        <div class="step-title">
                            <h2>Life Timeline<small>(optional)</small> </h2>
                            <p>Enter information about important milestones in your loved ones life.</p>
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
                                                        <input type="text" name="title[]" placeholder="Title" class="input-css" value="<?php echo $value['title'] ?>">
                                                    </div>
                                                    <div class="input-wrap four-input">
                                                        <input type="text" name="date[]" placeholder="Date" class="input-css date-picker" value="<?php echo date('m/d/Y', strtotime($value['date'])) ?>"> <span>Or</span>
                                                        <input type="number" name="month[]" placeholder="Month" class="input-css" value="<?php echo $value['month'] ?>">
                                                        <input type="number" name="month_year[]" placeholder="Year" class="input-css" value="<?php echo $value['year'] ?>"><span>Or</span>
                                                        <input type="number" name="year[]" placeholder="Year" class="input-css" value="<?php echo $value['year'] ?>">
                                                        <p>You may enter a Year a, Month/Year, or a full date.</p>
                                                    </div>
                                                    <div class="input-wrap">
                                                        <textarea class="input-css textarea-css" name="details[]" placeholder="Details(optional)"><?php echo $value['details']; ?></textarea>
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
                                                    <input type="text" name="title[]" placeholder="Title" class="input-css">
                                                </div>
                                                <div class="input-wrap four-input">
                                                    <input type="text" name="date[]" placeholder="Date" class="input-css date-picker"> <span>Or</span>
                                                    <input type="number" name="month[]" placeholder="Month" class="input-css">
                                                    <input type="number" name="month_year[]" placeholder="Year" class="input-css"><span>Or</span>
                                                    <input type="number" name="year[]" placeholder="Year" class="input-css">
                                                    <p>You may enter a Year a, Month/Year, or a full date.</p>
                                                </div>
                                                <div class="input-wrap">
                                                    <textarea class="input-css textarea-css" name="details[]" placeholder="Details(optional)"></textarea>
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
                                <div class="step-btm-btn">
                                    <button class="back" onclick="return back_step()">Back</button>
                                    <button class="skip" onclick="return skip_step()">Skip</button>
                                    <button class="next" onclick="return proceed_step();">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="fifth-step" class="hide profile-steps">
                        <div class="step-title">
                            <h2>Add Funeral Services<small>(optional)</small> </h2>
                            <p>In necessary, enter funeral services information. You will be able to remove this information later.</p>
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
                                        <!--                                            <div class="input-wrap"><div class="input-three-l">
                                                                                        <select name="memorial_state" id="memorial_state" class="input-css service-state" placeholder="State">
                                                                                            <option value="">Select state</option>
                                        <?php
                                        foreach ($states as $state) {
                                            $selected = '';
                                            if (isset($memorial_service) && !empty($memorial_service)) {
                                                if ($state['id'] == $memorial_service['state'])
                                                    $selected = 'selected';
                                            }
                                            ?>
                                                                                                                    <option value="<?php echo $state['id'] ?>" <?php echo $selected ?>><?php echo $state['name'] ?></option>
                                        <?php }
                                        ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="input-three-m">
                                        <?php
                                        $cities_arr = $cities;
                                        if (isset($memorial_service) && !empty($memorial_service))
                                            $cities_arr = $memorial_cities;
                                        ?>
                                                                                        <select name="memorial_city" id="memorial_city" class="input-css" placeholder="State">
                                                                                            <option value="">Select City</option>
                                        <?php
                                        foreach ($cities_arr as $city) {
                                            $selected = '';
                                            if (isset($memorial_service) && !empty($memorial_service)) {
                                                if ($city['id'] == $memorial_service['city'])
                                                    $selected = 'selected';
                                            }
                                            ?>
                                                                                                                    <option value="<?php echo $city['id'] ?>" <?php echo $selected ?>><?php echo $city['name'] ?></option>
                                        <?php }
                                        ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="input-three-r">
                                                                                        <input type="text" name="memorial_zip" id="memorial_zip" placeholder="Zip" class="input-css" value="<?php if (isset($memorial_service) && !empty($memorial_service)) echo $memorial_service['zip'] ?>">
                                                                                    </div></div>-->
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
                                                    foreach ($states as $state) {
                                                        $selected = '';
                                                        if (isset($memorial_service) && !empty($memorial_service)) {
                                                            if ($state['id'] == $memorial_service['state'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $state['id'] ?>" <?php echo $selected ?>><?php echo $state['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <?php
                                                $cities_arr = $cities;
                                                if (isset($memorial_service) && !empty($memorial_service))
                                                    $cities_arr = $memorial_cities;
                                                ?>
                                                <select name="memorial_city" id="memorial_city" class="input-css" placeholder="State">
                                                    <option value="">Select City</option>
                                                    <?php
                                                    foreach ($cities_arr as $city) {
                                                        $selected = '';
                                                        if (isset($memorial_service) && !empty($memorial_service)) {
                                                            if ($city['id'] == $memorial_service['city'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $city['id'] ?>" <?php echo $selected ?>><?php echo $city['name'] ?></option>
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
                                                    foreach ($states as $state) {
                                                        $selected = '';
                                                        if (isset($funeral_service) && !empty($funeral_service)) {
                                                            if ($state['id'] == $funeral_service['state'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $state['id'] ?>" <?php echo $selected ?>><?php echo $state['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <?php
                                                $cities_arr = $cities;
                                                if (isset($funeral_service) && !empty($funeral_service))
                                                    $cities_arr = $funeral_cities;
                                                ?>
                                                <select name="funeral_city" id="funeral_city" class="input-css" placeholder="City">
                                                    <option value="">Select City</option>
                                                    <?php
                                                    foreach ($cities_arr as $city) {
                                                        $selected = '';
                                                        if (isset($memorial_service) && !empty($funeral_service)) {
                                                            if ($city['id'] == $funeral_service['city'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $city['id'] ?>" <?php echo $selected ?>><?php echo $city['name'] ?></option>
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
                                                <input type="text" name="burial_time" id="burial_time" placeholder="Time" class="input-css service-time" value="<?php if (isset($burial_service) && !empty($burial_service)) echo $burial_service['burial_time'] ?>">
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" name="burial_place" id="burial_place" placeholder="Name of place" class="input-css" value="<?php if (isset($burial_service) && !empty($burial_service)) echo $burial_service['burial_name'] ?>">
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
                                                    foreach ($states as $state) {
                                                        $selected = '';
                                                        if (isset($burial_service) && !empty($burial_service)) {
                                                            if ($state['id'] == $burial_service['state'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $state['id'] ?>" <?php echo $selected ?>><?php echo $state['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <?php
                                                $cities_arr = $cities;
                                                if (isset($funeral_service) && !empty($funeral_service))
                                                    $cities_arr = $burial_cities;
                                                ?>
                                                <select name="burial_city" id="burial_city" class="input-css" placeholder="City">
                                                    <option value="">Select City</option>
                                                    <?php
                                                    foreach ($cities_arr as $city) {
                                                        $selected = '';
                                                        if (isset($burial_service) && !empty($burial_service)) {
                                                            if ($city['id'] == $burial_service['city'])
                                                                $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $city['id'] ?>" <?php echo $selected ?>><?php echo $city['name'] ?></option>
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
                                <div class="step-btm-btn">
                                    <button class="back" onclick="return back_step()">Back</button>
                                    <button class="skip" onclick="return skip_step()">Skip</button>
                                    <button class="next" onclick="return proceed_step();">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>	
    <div class="create-profile-body hide profile-steps" id="sixth-step">
        <div class="container">
            <div class="create-profile-box step-06-wrap">
                <div class="step-title">
                    <h2>Create a Tribute Fundraiser<small>(optional)</small> </h2>
                    <p>If desired, create a Tribute Fundraiser in honor of your loved one.</p>
                </div>
                <div class="step-form">
                    <div class="step-06">
                        <form method="post" id="fundraiser_profile-form">
                            <div class="step-06-l">
                                <div class="input-wrap">
                                    <label class="label-css">Tribute Fundraiser Title.</label>
                                    <input type="text" name="fundraiser_title" id="fundraiser_title" placeholder="Provide a short descriptive title for the fundraiser" class="input-css" value="<?php if (isset($fundraiser)) echo $fundraiser['title'] ?>">
                                </div>
                                <div class="input-wrap">
                                    <div class="input-l">
                                        <input type="number" name="fundraiser_goal" id="fundraiser_goal" placeholder="Fundraising Goal ($)" class="input-css" min="0" value="<?php if (isset($fundraiser)) echo $fundraiser['goal'] ?>">
                                        <p>Leave empty for campaigns without a fundraising goal.</p>
                                    </div>
                                    <div class="input-r">
                                        <input type="text" name="fundraiser_enddate" id="fundraiser_enddate" placeholder="End Date" class="input-css" value="<?php if (isset($fundraiser)) echo date('m/d/Y', strtotime($fundraiser['end_date'])) ?>">
                                        <p>Leave empty ongoing fundraising campaigns.</p>
                                    </div>
                                </div>
                                <div class="input-wrap">
                                    <label class="label-css">Description</label>
                                    <textarea class="input-css textarea-css" name="fundraiser_details" id="fundraiser_details" placeholder="Describe your loved one and his or her relation to you;explain why you are running this fundraiser, what the funds will be used for, and when the funds are needed."><?php if (isset($fundraiser)) echo $fundraiser['details']; ?></textarea>
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
                                                            <!--                                                            <video style="width:100%;height:100%" controls>
                                                                                                                            <source src="">Your browser does not support HTML5 video.
                                                                                                                        </video>-->
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

                    <div class="step-btm-btn">
                        <button class="back" onclick="return back_step()">Back</button>
                        <button class="skip" onclick="return skip_step()">Skip</button>
                        <button class="next" onclick="return proceed_step();">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>	
    <div class="create-profile-body hide profile-steps" id="seventh-step" >
        <div class="container">
            <div class="create-profile-box step-finish step-06-wrap">
                <div class="step-title">
                    <h2>
                        <?php if (isset($profile) && $profile['is_published'] == 1) { ?>
                            <span id="profile_name"><?php echo $profile['firstname'] . ' ' . $profile['lastname'] . '\'s' ?></span> Life Profile is complete!
                        <?php } else { ?>
                            <span id="profile_name"><?php
                                if (isset($profile))
                                    echo $profile['firstname'] . ' ' . $profile['lastname'] . '\'s';
                                else
                                    echo "John's"
                                    ?></span> Life Profile is complete but not yet published.
                            <?php
                        }
                        ?>

                    </h2>
                    <p>You can click the back button below to make updates. <br/> Click the preview profile button to view and publish the profile.</p>
                </div>
                <div class="step-btm-btn">
                    <button class="back" onclick="return back_step()">Back</button>
                    <button class="next" onclick="return preview_profile(this);" data-href="" id="profile_slug">Preview Profile</button>
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

<script type="text/javascript">
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
</script>
<script src="assets/js/profile.js"></script>
