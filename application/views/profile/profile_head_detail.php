<div class="profile-head">
    <span class="profile-img">
        <?php
        if (isset($profile['cover_image']) && $profile['cover_image'] != '') {
            echo "<img class='cover_img profile-exif-img' src='" . PROFILE_IMAGES . $profile['cover_image'] . "' style='width:1120px;height:330px;'>";
        } else {
            echo "<img class='cover_img' src='assets/images/profile-pic.jpg' alt='' />";
        }
        if (isset($profile) && $this->user_id == $profile['user_id']) {
            ?>
            <div class="select-file">
                <div class="select-file-upload"> 
                    <span class="select-file_up_btn"><i class="fa fa-pencil"></i></span>
                    <input type="file" name="cover_image" id="cover_image" multiple="false">
                </div>
            </div>
        <?php } ?>
    </span>
    <div class="profile-title">
        <div class="profile-title-img">
            <?php
            if (isset($profile['profile_image']) && $profile['profile_image'] != '') {
                $img_url = PROFILE_IMAGES . $profile['profile_image'];
                $img_class = 'profile-exif-img';
            } else {
                $img_url = 'assets/images/profile-pic-01.jpg';
                $img_class = '';
            }
            ?>
            <img class='<?php echo $img_class ?>' src="<?php echo $img_url ?>" alt="<?php echo $profile['firstname'] . ' ' . $profile['lastname'] . ' Online Memorial Remember Always' ?>" title="<?php echo $profile['firstname'] . ' ' . $profile['lastname'] . ' Online Memorial Remember Always' ?>" style='width:170px;height:176px;'>
        </div>
        <div class="profile-title-body">
            <h4><?php
                if ($profile['middlename'] != '')
                    echo $profile['firstname'] . ' ' . $profile['middlename'] . ' ' . $profile['lastname'];
                else
                    echo $profile['firstname'] . ' ' . $profile['lastname'];
                if ($profile['nickname'] != '') {
                    echo ' (' . $profile['nickname'] . ')';
                }
                ?>
            </h4>
            <h5><?php echo isset($profile['date_of_birth']) && !is_null($profile['date_of_birth']) ? date('M d, Y', strtotime($profile['date_of_birth'])) : '3 Nov, 1988' ?> - <?php echo isset($profile['date_of_death']) && !is_null($profile['date_of_death']) ? date('M d, Y', strtotime($profile['date_of_death'])) : '3 Nov, 1989' ?></h5>
            <h6>
                <?php
                if ($profile['city'] != '')
                    echo $profile['city'] . ', ';
                if ($profile['state'] != '')
                    echo $profile['state'] . ', ';
                echo $profile['country']
                ?>
            </h6>
            <p><em>Created with love by</em> <?php echo isset($profile['u_fname']) ? $profile['u_fname'] . ' ' . $profile['u_lname'] : '-' ?> <?php if ($profile['created_by'] != '') echo " <em>on behalf of </em>  " . $profile['created_by'] . "" ?></p> 
            <div class="multi-btn">
                <?php if ($profile['type'] == 2 && $profile['is_published'] == 1 && !empty($fundraiser) && $fundraiser['wepay_account_id'] != '' && $fundraiser['wepay_access_token'] != '') { ?>
                    <a href="<?php echo site_url('donate/' . $profile['slug']) ?>" class="donate-btn">Donate</a>
                <?php } ?>
                <?php // if ($profile['slug'] == 'example-life-profile') { ?>
                <a href="<?php echo site_url('flowers') ?>" class="flowers-btn">Send Flowers</a>
                <?php // } ?>
                <!-- Edit profile and publish profile buttons if created profile is of logged in user-->
                <?php if ($profile['user_id'] == $this->user_id) { ?>
                    <a href="<?php echo site_url('profile/edit/' . $profile['slug']) ?>" class="edit-profile-btn">Edit</a>
                <?php } ?>
                <?php if ($profile['user_id'] == $this->user_id && $profile['is_published'] == 0 && (isset($user) && $user['is_verify'] == 1)) { ?>
                    <a href="javascript:void(0)" class="publish-profile-btn" onclick="$('#email_popup').modal('toggle')">Publish</a>
                <?php } ?>
            </div>
            <div class="profile-share">
                <h6>Share</h6>
                <a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo $url; ?>')" title="Facebook Share">
                    <svg version="1.1"id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 455.73 455.73" style="enable-background:new 0 0 455.73 455.73;" xml:space="preserve">
                        <path style="fill:#3A559F;" d="M0,0v455.73h242.704V279.691h-59.33v-71.864h59.33v-60.353c0-43.893,35.582-79.475,79.475-79.475
                              h62.025v64.622h-44.382c-13.947,0-25.254,11.307-25.254,25.254v49.953h68.521l-9.47,71.864h-59.051V455.73H455.73V0H0z"/>
                    </svg>
                </a>
                <!--<a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Profile Sharing'; ?>')" title="Linked-in Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"-->
                <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Profile Sharing'; ?>')" title="Linked-in Share">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 455.731 455.731" style="enable-background:new 0 0 455.731 455.731;" xml:space="preserve">
                        <rect x="0" y="0" style="fill:#0084B1;" width="455.731" height="455.731"/>
                        <path style="fill:#FFFFFF;" d="M107.255,69.215c20.873,0.017,38.088,17.257,38.043,38.234c-0.05,21.965-18.278,38.52-38.3,38.043
                              c-20.308,0.411-38.155-16.551-38.151-38.188C68.847,86.319,86.129,69.199,107.255,69.215z"/>
                        <path style="fill:#FFFFFF;" d="M129.431,386.471H84.71c-5.804,0-10.509-4.705-10.509-10.509V185.18
                              c0-5.804,4.705-10.509,10.509-10.509h44.721c5.804,0,10.509,4.705,10.509,10.509v190.783
                              C139.939,381.766,135.235,386.471,129.431,386.471z"/>
                        <path style="fill:#FFFFFF;" d="M386.884,241.682c0-39.996-32.423-72.42-72.42-72.42h-11.47c-21.882,0-41.214,10.918-52.842,27.606
                              c-1.268,1.819-2.442,3.708-3.52,5.658c-0.373-0.056-0.594-0.085-0.599-0.075v-23.418c0-2.409-1.953-4.363-4.363-4.363h-55.795
                              c-2.409,0-4.363,1.953-4.363,4.363V382.11c0,2.409,1.952,4.362,4.361,4.363l57.011,0.014c2.41,0.001,4.364-1.953,4.364-4.363
                              V264.801c0-20.28,16.175-37.119,36.454-37.348c10.352-0.117,19.737,4.031,26.501,10.799c6.675,6.671,10.802,15.895,10.802,26.079
                              v117.808c0,2.409,1.953,4.362,4.361,4.363l57.152,0.014c2.41,0.001,4.364-1.953,4.364-4.363V241.682z"/>
                    </svg>
                </a>
                <a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://twitter.com/share?url=<?php echo $url; ?>')" title="Twitter Share">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 455.731 455.731" style="enable-background:new 0 0 455.731 455.731;" xml:space="preserve">
                        <rect x="0" y="0" style="fill:#50ABF1;" width="455.731" height="455.731"/>
                        <path style="fill:#FFFFFF;" d="M60.377,337.822c30.33,19.236,66.308,30.368,104.875,30.368c108.349,0,196.18-87.841,196.18-196.18
                              c0-2.705-0.057-5.39-0.161-8.067c3.919-3.084,28.157-22.511,34.098-35c0,0-19.683,8.18-38.947,10.107
                              c-0.038,0-0.085,0.009-0.123,0.009c0,0,0.038-0.019,0.104-0.066c1.775-1.186,26.591-18.079,29.951-38.207
                              c0,0-13.922,7.431-33.415,13.932c-3.227,1.072-6.605,2.126-10.088,3.103c-12.565-13.41-30.425-21.78-50.25-21.78
                              c-38.027,0-68.841,30.805-68.841,68.803c0,5.362,0.617,10.581,1.784,15.592c-5.314-0.218-86.237-4.755-141.289-71.423
                              c0,0-32.902,44.917,19.607,91.105c0,0-15.962-0.636-29.733-8.864c0,0-5.058,54.416,54.407,68.329c0,0-11.701,4.432-30.368,1.272
                              c0,0,10.439,43.968,63.271,48.077c0,0-41.777,37.74-101.081,28.885L60.377,337.822z"/>
                    </svg>
                </a>
                <a href="javascript:void(0)"  onclick="javascript:genericSocialShare('https://plus.google.com/share?url=<?php echo $url; ?>')" title="Google Plus Share">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 455.73 455.73" style="enable-background:new 0 0 455.73 455.73;" xml:space="preserve">
                        <path style="fill:#DD4B39;" d="M0,0v455.73h455.73V0H0z M265.67,247.037c-7.793,51.194-45.961,80.543-95.376,80.543
                              c-55.531,0-100.552-45.021-100.552-100.552c0-55.517,45.021-100.538,100.552-100.538c26.862,0,50.399,9.586,67.531,26.226
                              l-28.857,28.857c-9.773-9.846-23.147-15.094-38.674-15.094c-32.688,0-59.189,27.874-59.189,60.548
                              c0,32.703,26.501,59.768,59.189,59.768c27.397,0,48.144-13.243,54.129-39.758h-54.129v-40.38h95.131
                              c1.142,6.506,1.72,13.315,1.72,20.37C267.144,234.025,266.638,240.69,265.67,247.037z M386.419,234.517h-35.233v35.218H326.16
                              v-35.218h-35.233v-25.041h35.233v-35.233h25.026v35.233h35.233V234.517z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>