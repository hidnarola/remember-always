<div class="common-page">
    <div class="container">
        <div class="common-body common-body_donation">
            <div class="full_div_d">
                <div class="dontaion_l">
                    <div class="input-wrap">
                        <label class="label-css label_big"><?php echo $fundraiser['title'] ?></label>
                        <?php echo $fundraiser['details']; ?>
                    </div>
                    <div class="progress_wrapper">
                        <div class="progress_bar_custom">
                            <p class="goal_text">$<?php echo $fundraiser['total_donation'] ?> of $<?php echo $fundraiser['goal'] ?> Goal<span>Goal $<?php echo $fundraiser['goal'] ?></span></p>	
                            <div class="range_slider_custom">
                                <div class="rang_fill" style="width: <?php echo round(($fundraiser['total_donation'] * 100) / $fundraiser['goal']) . '%' ?>"></div>
                            </div>
                        </div>
                        <div class="pro_btn"><a href="javascript:void(0)">Donate</a></div>
                    </div>
                    <div class="donate_detail">
                        <h2>Donations</h2>	
                        <ul class="ul_donate_detail">
                            <li>
                                <div class="listing_img"><img src="assets/images/helpful-img.jpg" alt="" class=""></div>
                                <h6>Kirti kirti<span class="span_rs">$ 350</span></h6>
                                <p class="p_date">5th Jan, 2017</p>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an</p>
                            </li>
                            <li>
                                <div class="listing_img"><img src="assets/images/helpful-img.jpg" alt="" class=""></div>
                                <h6>Kirti kirti<span class="span_rs">$ 350</span></h6>
                                <p class="p_date">12th Dec, 2017</p>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an</p>
                            </li>
                            <li>
                                <div class="listing_img"><img src="assets/images/helpful-img.jpg" alt="" class=""></div>
                                <h6>Kirti kirti<span class="span_rs">$ 350</span></h6>
                                <p class="p_date">1th Feb, 2017</p>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an</p>
                            </li>
                            <li>
                                <div class="listing_img"><img src="assets/images/helpful-img.jpg" alt="" class=""></div>
                                <h6>Kirti kirti<span class="span_rs">$ 350</span></h6>
                                <p class="p_date">30th Mar, 2017</p>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="dontaion_r">
                    <div class="comoon-ul-li list-02">
                        <ul>
                            <?php foreach ($fundraiser_media as $media) { ?>
                                <li>
                                    <div class="gallery-wrap">
                                        <?php if ($media['type'] == 1) { ?>
                                            <span class="gallery-video-img">
                                                <img src="<?php echo base_url() . FUNDRAISER_IMAGES . $media['media'] ?>" alt="" class="mCS_img_loaded">
                                            </span>
                                        <?php } ?>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>