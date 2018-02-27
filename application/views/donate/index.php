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
                        <div class="pro_btn"><a href="<?php echo site_url('donate/next/' . $fundraiser['slug']) ?>">Donate</a></div>
                    </div>
                    <div class="donate_detail">
                        <h2>Donations</h2>	
                        <ul class="ul_donate_detail">
                            <?php
                            if (!empty($donations)) {
                                foreach ($donations as $donation) {
                                    ?>
                                    <li>
                                        <div class="listing_img">
                                            <?php if ($donation['facebook_id'] != '' || $donation['google_id'] != '') { ?>
                                                <img src="<?php echo $donation['profile_image'] ?>" alt="" class="">
                                                <?php
                                            } else if ($donation['profile_image'] != '') {
                                                if ($donation['payer_name'] == 'Anonymous') {
                                                    ?>
                                                    <img src="assets/images/no_image.png" alt="" class="">
                                                <?php } else { ?>
                                                    <img src="<?php echo USER_IMAGES . $donation['profile_image'] ?>" alt="" class="">
                                                <?php } ?>
                                            <?php } else { ?>
                                                <img src="assets/images/no_image.png" alt="no image" class="">
                                            <?php }
                                            ?>
                                        </div>
                                        <h6>
                                            <?php
//                                            if ($donation['user_id'] != '') {
//                                                echo $donation['firstname'] . ' ' . $donation['lastname'];
//                                            } 
                                            if ($donation['payer_name'] != '') {
                                                echo $donation['payer_name'];
                                            } else {
                                                echo 'Guest';
                                            }
                                            ?>
                                            <span class="span_rs">$ <?php echo $donation['amount'] ?></span>
                                        </h6>
                                        <p class="p_date"><?php echo date('M d, Y', strtotime($donation['created_at'])) ?></p>
                                        <p><?php echo $donation['details'] ?></p>
                                    </li>
                                    <?php
                                }
                            } else {
                                echo "No donations yet!";
                            }
                            ?>
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
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".fancybox").fancybox({
            openEffect: 'none',
            closeEffect: 'none',
            nextEffect: 'none',
            prevEffect: 'none',
            padding: 0,
        });
    });
</script>