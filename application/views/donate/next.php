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
                        <form id="donate_form" method="post" action="<?php echo site_url('donate/payment/' . $fundraiser['slug']) ?>">
                            <div class="input-wrap input_enter_dn">
                                <span class="donation_enter">Enter your donation:</span>
                                <input type="number" name="donate_amount" id="donate_amount" placeholder="Donation Amount" class="input-css">
                                <span class="donation_enter_span">Minimum donation is $5</span>
                            </div>
                            <div class="input-wrap textarea_small">
                                <textarea name="donation_message" id="donation_message" class="input-css textarea-css" placeholder="Enter message here for donation"></textarea>
                            </div>
<!--                            <div class="keep-me">
                                <label class="custom-checkbox">Do you want to display your name?
                                    <input type="checkbox" name="display_name" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </div>-->
                        </form>
                        <!--                        <div class="input-wrap code">
                                                    <input type="text" name="" placeholder="Name" class="input-css">
                                                </div>
                                                <div class="input-wrap">
                                                    <input type="text" name="" placeholder="Card Number*" class="input-css">
                                                </div>
                                                <div class="input-wrap input_exp">
                                                    <select class="mm">
                                                        <option value="volvo">--MM--</option>
                                                        <option value="saab">1</option>
                                                        <option value="mercedes">2</option>
                                                        <option value="audi">3</option>
                                                        <option value="audi">4</option>
                                                        <option value="audi">5</option>
                                                        <option value="audi">6</option>
                                                        <option value="audi">7</option>
                                                        <option value="audi">8</option>
                                                        <option value="audi">9</option>
                                                        <option value="audi">10</option>
                                                        <option value="audi">11</option>
                                                        <option value="audi">12</option>
                                                    </select>
                                                    <select class="yy">
                                                        <option value="volvo">--YYYY--</option>
                                                        <option value="saab">1</option>
                                                        <option value="mercedes">2</option>
                                                        <option value="audi">3</option>
                                                        <option value="audi">4</option>
                                                        <option value="audi">5</option>
                                                        <option value="audi">6</option>
                                                        <option value="audi">7</option>
                                                        <option value="audi">8</option>
                                                        <option value="audi">9</option>
                                                        <option value="audi">10</option>
                                                        <option value="audi">11</option>
                                                        <option value="audi">12</option>
                                                    </select>
                                                </div>
                                                <div class="input-wrap code">
                                                    <input type="text" name="" placeholder="cvv" class="input-css">
                                                </div>
                                                <div class="input-wrap input_exp col_left_in_all">
                                                    <div class="col_left_in">
                                                        <input type="text" name="" placeholder="Address 1" class="input-css">
                                                    </div>
                                                    <div class="col_right_in">
                                                        <input type="text" name="" placeholder="Address 2" class="input-css">
                                                    </div>
                                                </div>
                                                <div class="input-wrap input_exp three_left_in_all">
                                                    <div class="three_left_in">
                                                        <input type="text" name="" placeholder="City" class="input-css">
                                                    </div>
                                                    <div class="three_middle_in">
                                                        <input type="text" name="" placeholder="State" class="input-css">
                                                    </div>
                                                    <div class="three_right_in">
                                                        <input type="text" name="" placeholder="Zip" class="input-css">
                                                    </div>
                                                </div>
                                                <div class="input-wrap textarea_small">
                                                    <textarea name="life_bio" id="life_bio" class="input-css textarea-css" placeholder="Enter text here"></textarea>
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
                <div class="next_step_dontaion pull-left">
                    <a href="javascript:void(0)" onclick="makeDonation('<?php echo $fundraiser['slug'] ?>')">Donate</a>
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
    $("#donate_form").validate({
        rules: {
            donate_amount: {
                required: true,
                min: 5,
            },
        }
    });
    function makeDonation(slug) {
        if ($('#donate_form').valid()) {
            $('#donate_form').submit();
        }
    }
</script>