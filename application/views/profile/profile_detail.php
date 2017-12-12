<div class="create-profile">
    <div class="container">
        <div class="create-profile-box create-profile-body">
            <div class="profile-head">
                <span>
                    <?php
                    if (isset($profile['cover_image']) && $profile['cover_image'] != '') {
                        echo "<img src='" . PROFILE_IMAGES . $profile['cover_image'] . "' style='width:1150px;height:339px;'>";
                    } else {
                        echo "<img src='assets/images/profile-pic.jpg' alt='' />";
                    }
                    ?>

                </span>
                <div class="profile-title">
                    <div class="profile-title-img">
                        <?php
                        if (isset($profile['profile_image']) && $profile['profile_image'] != '') {
                            echo "<img src='" . PROFILE_IMAGES . $profile['profile_image'] . "' style='width:170px;height:176px;'>";
                        } else {
                            echo "<img src='assets/images/profile-pic-01.jpg' alt='' />";
                        }
                        ?>
                    </div>
                    <h4><?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Popularised in the the release of' ?> <small> 
                            <!--<i class="fa fa-map-marker"></i> Galley of type and, Scrambled-->
                            Born: <?php echo isset($profile['date_of_birth']) && !is_null($profile['date_of_birth']) ? date('d M, Y', strtotime($profile['date_of_birth'])) : '3 Nov, 1988' ?> 
                            - Death: <?php echo isset($profile['date_of_death']) && !is_null($profile['date_of_death']) ? date('d M, Y', strtotime($profile['date_of_death'])) : '3 Nov, 1989' ?></small> </h4>
                    <a href="" class="donate-btn">Donate</a>
                    <a href="" class="flowers-btn">Send Flowers</a>
                    <div class="profile-share">
                        <h6>Share</h6>
                        <a href="" class="fa fa-facebook"></a>
                        <a href="" class="fa fa-twitter"></a>
                        <a href="" class="fa fa-pinterest"></a>
                        <a href="" class="fa fa-instagram"></a>
                    </div>
                </div>
            </div>

            <div class="profile-body">
                <div class="profile-body-l">
                    <div class="profile-box">
                        <h2>Funeral Services</h2>
                        <div class="profile-box-body according-tab">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> When an unknown printer</a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <h5>Start Time (5nov, 2010)</h5>
                                            <p class="general-text"> It was popularised in the with the release sheets containing and more recently with desktop publishing software a aldus pop pageMaker including versions.</p>
                                            <h5>End Time (5nov, 2010)</h5>
                                            <p class="general-text"> It was popularised in the with the release sheets containing and more recently with desktop publishing software a aldus pop pageMaker including versions.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Galley of type and </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            <h5>Start Time (5nov, 2010)</h5>
                                            <p class="general-text">Has been the industry's standard dummy text ever since the is simply dummy text of the printing and typesetting industry been the industry's standard dummy text eversince thehas survived not only five centuries but also the leap into electronic typesettwas popularised in the was. </p>
                                            <h5>End Time (5nov, 2010)</h5>
                                            <p class="general-text"> Popularised in the with the release of etraset sheets containing and more recently with desktop publishing software like aldus pageMaker including versions hen an unknown printer took a galley of type and scrambled it to make a type specimen book has survived not only five centuries but also the leap into electronic typesetting remaining essentially unchanged.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Scrambled it to make a type.</a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <h5>Start Time (5nov, 2010)</h5>
                                            <p class="general-text">Has been the industry's standard dummy text ever since the is simply dummy text of the printing and typesetting industry been the industry's standard dummy text eversince thehas survived not only five centuries but also the leap into electronic typesettwas popularised in the was. </p>
                                            <h5>End Time (5nov, 2010)</h5>
                                            <p class="general-text"> Popularised in the with the release of etraset sheets containing and more recently with desktop publishing software like aldus pageMaker including versions hen an unknown printer took a galley of type and scrambled it to make a type specimen book has survived not only five centuries but also the leap into electronic typesetting remaining essentially unchanged.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingfour">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#headingfour" aria-expanded="false" aria-controls="headingfour">Specimen book has survived.</a>
                                        </h4>
                                    </div>
                                    <div id="headingfour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">
                                        <div class="panel-body">
                                            <h5>Start Time (5nov, 2010)</h5>
                                            <p class="general-text">Has been the industry's standard dummy text ever since the is simply dummy text of the printing and typesetting industry been the industry's standard dummy text eversince thehas survived not only five centuries but also the leap into electronic typesettwas popularised in the was. </p>
                                            <h5>End Time (5nov, 2010)</h5>
                                            <p class="general-text"> Popularised in the with the release of etraset sheets containing and more recently with desktop publishing software like aldus pageMaker including versions hen an unknown printer took a galley of type and scrambled it to make a type specimen book has survived not only five centuries but also the leap into electronic typesetting remaining essentially unchanged.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingfive">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#headingfive" aria-expanded="false" aria-controls="headingfive">Mot only five centuries</a>
                                        </h4>
                                    </div>
                                    <div id="headingfive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfive">
                                        <div class="panel-body">
                                            <h5>Start Time (5nov, 2010)</h5>
                                            <p class="general-text">Has been the industry's standard dummy text ever since the is simply dummy text of the printing and typesetting industry been the industry's standard dummy text eversince thehas survived not only five centuries but also the leap into electronic typesettwas popularised in the was. </p>
                                            <h5>End Time (5nov, 2010)</h5>
                                            <p class="general-text"> Popularised in the with the release of etraset sheets containing and more recently with desktop publishing software like aldus pageMaker including versions hen an unknown printer took a galley of type and scrambled it to make a type specimen book has survived not only five centuries but also the leap into electronic typesetting remaining essentially unchanged.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="profile-box lifetime-line">
                        <h2>Life Time Line</h2>
                        <div class="profile-box-body">
                            <span><img src="assets/images/helpful-img.jpg" alt="" /></span>
                            <ul>
                                <li>
                                    <div class="lifetime-box">
                                        <h3><a href="">2002</a></h3>
                                        <p>Was popularised the release sheets containing more recently desktop publishing software a aldus pop pageMaker including.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="lifetime-box">
                                        <h3><a href="">2004</a></h3>
                                        <p>Was popularised the release sheets containing more recently desktop publishing software a aldus pop pageMaker including.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="lifetime-box">
                                        <h3><a href="">2006</a></h3>
                                        <p>Was popularised the release sheets containing more recently desktop publishing software a aldus pop pageMaker including.</p>
                                    </div>
                                </li>
                            </ul>
                            <a href="" class="btn-btm-01">View More</a>
                        </div>
                    </div>
                </div>
                <div class="profile-body-m">
                    <div class="profile-box life-bio">
                        <h2>The Life Bio</h2>
                        <div class="profile-box-body">
                            <p><?php echo isset($profile['life_bio']) && !is_null($profile['life_bio']) ? $profile['life_bio'] : 'Life bio not available for this profile.' ?></p>
                            <!--<p>Release sheets containing  recently desktop publishing software a aldus pop pageMaker including	.</p>-->
                        </div>

                        <div class="post-comment">
                            <textarea placeholder="Add some comment, Images, Video etc..."></textarea>
                            <div class="comment-btm">
                                <a href=""><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                width="612px" height="612px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">
                                    <g>
                                    <g id="_x33__8_">
                                    <g>
                                    <path d="M573.75,267.75L459,344.25c0-23.218-10.557-43.758-26.89-57.796c38.881-23.428,65.14-65.637,65.14-114.329
                                          c0-73.938-59.938-133.875-133.875-133.875c-73.937,0-133.875,59.938-133.875,133.875c0,37.504,15.51,71.317,40.373,95.625
                                          h-70.151c18.322-20.33,29.778-46.971,29.778-76.5c0-63.38-51.37-114.75-114.75-114.75S0,127.87,0,191.25
                                          c0,34.578,15.625,65.216,39.818,86.254C16.199,290.528,0,315.371,0,344.25v153c0,42.247,34.253,76.5,76.5,76.5h306
                                          c42.247,0,76.5-34.253,76.5-76.5v-19.125l114.75,95.625c21.133,0,38.25-17.117,38.25-38.25V306
                                          C612,284.867,594.883,267.75,573.75,267.75z M38.25,191.25c0-42.247,34.253-76.5,76.5-76.5s76.5,34.253,76.5,76.5
                                          s-34.253,76.5-76.5,76.5S38.25,233.497,38.25,191.25z M420.75,497.25c0,21.114-17.117,38.25-38.25,38.25h-306
                                          c-21.133,0-38.25-17.117-38.25-38.25v-153c0-21.133,17.117-38.25,38.25-38.25h306c21.133,0,38.25,17.117,38.25,38.25V497.25z
                                          M363.375,267.96c-52.938,0-95.835-42.917-95.835-95.835c0-52.938,42.917-95.835,95.835-95.835s95.835,42.897,95.835,95.835
                                          S416.312,267.96,363.375,267.96z M573.75,535.5L459,439.875V382.5L573.75,306V535.5z"/>
                                    </g>
                                    </g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    </svg></a>
                                <a href=""><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 489.4 489.4" style="enable-background:new 0 0 489.4 489.4;" xml:space="preserve">
                                    <g>
                                    <g>
                                    <path d="M0,437.8c0,28.5,23.2,51.6,51.6,51.6h386.2c28.5,0,51.6-23.2,51.6-51.6V51.6c0-28.5-23.2-51.6-51.6-51.6H51.6
                                          C23.1,0,0,23.2,0,51.6C0,51.6,0,437.8,0,437.8z M437.8,464.9H51.6c-14.9,0-27.1-12.2-27.1-27.1v-64.5l92.8-92.8l79.3,79.3
                                          c4.8,4.8,12.5,4.8,17.3,0l143.2-143.2l107.8,107.8v113.4C464.9,452.7,452.7,464.9,437.8,464.9z M51.6,24.5h386.2
                                          c14.9,0,27.1,12.2,27.1,27.1v238.1l-99.2-99.1c-4.8-4.8-12.5-4.8-17.3,0L205.2,333.8l-79.3-79.3c-4.8-4.8-12.5-4.8-17.3,0
                                          l-84.1,84.1v-287C24.5,36.7,36.7,24.5,51.6,24.5z"/>
                                    <path d="M151.7,196.1c34.4,0,62.3-28,62.3-62.3s-28-62.3-62.3-62.3s-62.3,28-62.3,62.3S117.3,196.1,151.7,196.1z M151.7,96
                                          c20.9,0,37.8,17,37.8,37.8s-17,37.8-37.8,37.8s-37.8-17-37.8-37.8S130.8,96,151.7,96z"/>
                                    </g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    </svg></a>
                                <button type="submit">Post</button>
                            </div>
                        </div>
                        <div class="comments-div">
                            <?php if (isset($posts) && !empty($posts)) { ?>
                                <ul>
                                    <?php
                                    foreach ($posts as $key => $val) {
                                        $from_date = date_create($val['created_at']);
                                        $to_date = date_create(date('Y-m-d H:i:s'));
                                        $days_diff = date_diff($from_date, $to_date);
                                        ?>
                                        <li>
                                            <div class="comments-div-wrap">
                                                <span></span>
                                                <h3><?php echo $val['firstname'] . ' ' . $val['lastname'] ?><small><?php echo (($days_diff->y > 0) ? $days_diff->y . ' Year' . ($days_diff->y > 1 ? 's' : '') : '') . (($days_diff->m > 0) ? $days_diff->m . ' Month' . ($days_diff->m > 1 ? 's' : '') : '') . (($days_diff->d > 0) ? $days_diff->d . ' Day' . ($days_diff->d > 1 ? 's' : '') : '') ?> Ago</small></h3>
                                                <p><?php echo $val['comment'] ?></p>
                                                <?php if (isset($val['media']) && isset($val['media'][1])) { ?>
                                                    <ul class="post-images">
                                                        <?php foreach ($val['media'][1] as $k => $v) {
                                                            ?>
                                                            <li><a href=""><img src="<?php echo base_url(POST_IMAGES . $v) ?>"></a></li>

                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                                <?php if (isset($val['media']) && isset($val['media'][2])) { ?>
                                                    <ul class="post-video">
                                                        <?php foreach ($val['media'][2] as $k => $v) {
                                                            ?>
                                                            <li><a href=""></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul><?php } else { ?>
                                No post comments available for this profile.
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <div class="profile-body-r">
                    <?php if (isset($profil['type']) && $profile['type'] == 2) { ?>
                        <div class="profile-box fundraiser">
                            <h2>Tribute Fundraiser</h2>
                            <div class="profile-box-body">
                                <span>Donated <big>86%</big></span>
                                <h6>$9.00.000 <small>Raised of</small></h6>
                                <h6>10.00.000 <small>Goal</small></h6>
                                <a href="">Donation</a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="profile-box life-gallery">
                        <h2>Life Gallery</h2>
                        <div class="profile-box-body">
                            <ul>
                                <li><a href=""></a></li>
                                <li><a href=""></a></li>
                                <li><a href=""></a></li>
                                <li><a href=""></a></li>
                                <li><a href=""></a></li>
                                <li><a href=""></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="profile-box fun-facts">
                        <h2>Fun Facts</h2>
                        <div class="profile-box-body">
                            <?php
                            if (isset($fun_facts) && !empty($fun_facts)) {
                                foreach ($fun_facts as $key => $val) {
                                    ?>
                                    <p><?php echo $val['facts'] ?></p>
                                    <?php
                                }
                            } else {
                                ?>
                                <p>Fun Facts are not available for this profile.</p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="profile-box affiliations">
                        <h2>Affiliations</h2>
                        <div class="profile-box-body">
                            <ul>
                                <li><a href="">Sheets containing</a></li>
                                <li><a href="">More and recently with </a></li>
                                <li><a href="">Desktop publishing software</a></li>
                                <li><a href="">Like aldus page</a></li>
                                <li><a href="">Maker including versions</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="profile-box ad">
                        <a href=""><img src="assets/images/ad.jpg" alt="" /></a>
                    </div>

                </div>
            </div>
        </div>
    </div>	
</div>
