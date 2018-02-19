<script type="text/javascript" src="https://www.wepay.com/min/js/iframe.wepay.js"></script>
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
                                <?php
                                $progress_width = round(($fundraiser['total_donation'] * 100) / $fundraiser['goal']);
                                if ($progress_width > 100) {
                                    $progress_width = 100;
                                }
                                ?>
                                <div class="rang_fill" style="width: <?php echo $progress_width . '%' ?>"></div>
                            </div>
                        </div>
                        <!--<div class="pro_btn"><a href="#">Donate</a></div>-->
                    </div>
                    <div class="delivery_r">
                        <div id="wepay_checkout"></div>
                        <!--                        <div class="input-wrap input_enter_dn">
                                                    <span class="donation_enter">Total amount to charge:</span><input type="number" name="" placeholder="$50" class="input-css input-css_center">
                                                </div>
                                                <div class="input-wrap code">
                                                    <input type="text" name="" placeholder="Name" class="input-css">
                                                </div>
                                                <div class="input-wrap">
                                                    <input type="text" name="" placeholder="xxxx-xxxx-xxxx-2563" class="input-css">
                                                </div>-->

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
                                                <a href="<?php echo base_url(FUNDRAISER_IMAGES . $media['media']) ?>" class="fancybox" data-fancybox-type="image"  rel="gallery">
                                                    <img src="<?php echo base_url(FUNDRAISER_IMAGES . $media['media']) ?>" alt="" class="mCS_img_loaded">
                                                </a>
                                            </span>
                                        <?php } else if ($media['type'] == 2) { ?>
                                            <span class="gallery-video-img">
                                                <img src="<?php echo base_url(FUNDRAISER_IMAGES . str_replace('mp4', 'jpg', $media['media'])) ?>" alt="">
                                            </span>
                                            <span class="gallery-play-btn">
                                                <a href="<?php echo base_url(FUNDRAISER_IMAGES . $media['media']) ?>" class="fancybox" data-fancybox-type="iframe" rel="gallery"><img src="assets/images/play.png" alt=""></a>
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
                <!--<div class="next_step_dontaion"><a href="#">Confirm</a></div>-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    WePay.iframe_checkout("wepay_checkout", "<?php echo $checkout_uri ?>");
</script>