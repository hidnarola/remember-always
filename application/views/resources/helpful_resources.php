<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Helpful Resources</h2>
        </div>
        <div class="main_box_c">
            <div class="box_l">
                <div class="profile-box fun-facts">
                    <h2 class="purple_h2">Funeral Planning Resources</h2>
                    <div class="profile-box-body profile-box-body-change">
                        <ul class="ul_list">
                            <li>
                                <h6><a href="<?php echo site_url('funeral_planning') ?>">Funeral Planning Checklist</a></h6>	
                                <p>Step by step guide to help you through the process.</p>
                            </li>
                            <li><h6><a href="">Tips for paying a funeral</a></h6></li>
                            <li><h6><a href="">Sharing funeral services information</a></h6></li>
                            <li><h6><a href="<?php echo site_url('blog/details/how-to-select-a-funeral-home-director')?>">Tips on how to Select a Funeral Home</a></h6></li>
                            <li>
                                <h6><a href="<?php echo site_url('service_provider') ?>">Service Providers Directory</a></h6>	
                                <p>Find service providers such as funeral homes, caterers, florists, and more.</p>
                            </li>
                            <li>
                                <h6><a href="<?php echo site_url('community') ?>">Online Support Community</a></h6>	
                                <p>Find information, ask questions, read previous answers or comments, get general support for funeral planning. Also, you can support others by sharing your knowledge and advice.</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="profile-box fun-facts">
                    <h2 class="green_h2">Grief Support</h2>
                    <div class="profile-box-body profile-box-body-change">
                        <ul class="ul_list">
                            <li><h6><a href="">Advice for dealing with grief</a></h6>	</li>
                            <li><h6><a href="https://www.amazon.com/s/ref=nb_sb_noss_1?url=search-alias%3Daps&field-keywords=dealing+with+grief&rh=i%3Aaps%2Ck%3Adealing+with+grief" target="_blank">Recommended Books</a></h6><p>Recommended books for dealing with grief</p></li>
                            <li><h6><a href="<?php echo site_url('service_provider') ?>">Service Providers Directory</a></h6>	
                                <p>Find grief counselors.</p></li>
                            <li><h6><a href="<?php echo site_url('community') ?>">Online Support Community</a></h6>	
                                <p>Ask for advice and get support from others for handling grief. Or help others with your</p></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="box_m">
                <div class="profile-box fun-facts">
                    <h2>Service Providers Directory</h2>
                    <div class="profile-box-body profile-box-body-change">
                        <ul class="ul_list">
                            <li>
                                <h6><a href="<?php echo site_url('service_provider') ?>">Service Providers Directory</a></h6>
                                <p>Find service providers in your area, such as, funeral homes, crematories, florists, caterers,
                                    attorneys, tax advisors, and more. <a href="<?php echo site_url('service_provider') ?>">Find Service Provider.</a></p></li>
                        </ul>
                    </div>
                </div>
                <div class="profile-box fun-facts">
                    <h2>Online Support Community</h2>
                    <div class="profile-box-body profile-box-body-change">
                        <ul class="ul_list">
                            <li>
                                <h6><a href="<?php echo site_url('community') ?>">Online Support Community</a></h6>
                                <p>A place where you can get and give support,advice and information from and to other community members. <a href="<?php echo site_url('community') ?>">Visit the Online Support Community.</a></p></li>
                        </ul>
                    </div>
                </div>
                <div class="profile-box fun-facts">
                    <h2>Blog</h2>
                    <div class="profile-box-body profile-box-body-change">
                        <ul class="ul_list">
                            <li>
                                <h6><a href="<?php echo site_url('blog') ?>">Blog</a></h6>
                                <p>Helpful and inspirational tips, articles, stories.<a href="<?php echo site_url('blog') ?>">Check out the Remember Always Blog.</a></p></li>
                        </ul>
                    </div>
                </div>
                <div class="profile-box fun-facts">
                    <h2>Remember Always Website Support</h2>
                    <div class="profile-box-body profile-box-body-change">
                        <ul class="ul_list">
                            <li><h6><a href="">How to create a Life Profile</a></h6></li>
                            <li><h6><a href="">How to create a Tribute Fundraiser</a></h6></li>
                            <li><h6><a href="">How to edit a Life Profile and Tribute Fundraiser</a></h6></li>
                            <li><h6><a href="">How to share funeral services information</a></h6></li>
                            <li><h6><a href="<?php echo site_url('pages/faqs') ?>">FAQs</a></h6></li>
                            <li><h6><a href="<?php echo site_url('pages/features') ?>">Site Features</a></h6></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="box_r">
                <div class="profile-box fun-facts">
                    <h2 class="light_grey_h2">Memorialize your loved ones</h2>
                    <div class="profile-box-body profile-box-body-change">
                        <ul class="ul_list">
                            <li>
                                <h6>
                                    <?php if ($this->is_user_loggedin) { ?>
                                        <a href="<?php echo site_url('profile/create') ?>">Create a Life Profile</a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0)" onclick="loginModal(this)" data-redirect="<?php echo site_url('profile/create'); ?>" >Create a Life Profile</a>
                                    <?php } ?>
                                </h6>
                                <p>Create a vivid, timeless memorial in honor of your loved one. <br>For more, see, <a href="<?php echo site_url('blog/details/why-create-a-life-profile-the-benefits-of-creating-an-online-memorial-on-remember-always') ?>">Benefits of creating a Life profile.</a></p></li>
                        </ul>
                    </div>
                </div>
                <div class="profile-box fun-facts">
                    <h2 class="light_grey_h2">Get the help you need</h2>
                    <div class="profile-box-body profile-box-body-change">
                        <ul class="ul_list">
                            <li>
                                <h6>
                                    <?php
                                    if ($this->is_user_loggedin) {
                                        if ($this->tribute_profile_count == 0) {
                                            ?>
                                            <a href="<?php echo site_url('profile/create') ?>">Create a Tribute Fundraiser</a>
                                        <?php } else if ($this->tribute_profile_count == 1) {
                                            ?>
                                            <a href="<?php echo site_url('profile/edit/' . $this->tribute_profile['slug'] . '?tribute=1') ?>">Create a Tribute Fundraiser</a>
                                        <?php } else { ?>
                                            <a href="<?php echo site_url('dashboard/profiles') ?>">Create a Tribute Fundraiser</a>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <a href="javascript:void(0)" onclick="loginModal(this)" data-redirect="<?php echo site_url('profile/create') ?>">Create a Tribute Fundraiser</a>
                                    <?php } ?>
                                </h6>
                                <p>Get help to cover funeral expenses and other unplanned expenses. 
                                    <br> For more, see 
                                    <a href="<?php echo site_url('blog/details/top-5-reasons-for-creating-a-tribute-fundraiser-memorial-fundraiser-in-honor-of-a-loved-one') ?>">Top 5 reasons for creating a Tribute Fundraiser.</a></p></li>
                        </ul>
                    </div>
                </div>
                <div class="profile-box fun-facts img_ad_custom">
                    <div class="adv_div"><img src="assets/images/blue_adv.png"></div>
                </div>
                <div class="profile-box fun-facts img_ad_custom">
                    <div class="adv_div"><img src="assets/images/add_blue.png"></div>
                </div>
            </div>
        </div>
    </div>
</div>