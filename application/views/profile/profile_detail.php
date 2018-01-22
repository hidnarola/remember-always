<div class="create-profile">
    <div class="container">
        <div class="create-profile-box create-profile-body">
            <div class="profile-head">
                <span class="profile-img">
                    <?php
                    if (isset($profile['cover_image']) && $profile['cover_image'] != '') {
                        echo "<img class='cover_img' src='" . PROFILE_IMAGES . $profile['cover_image'] . "' style='width:1120px;height:330px;'>";
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
                            echo "<img src='" . PROFILE_IMAGES . $profile['profile_image'] . "' style='width:170px;height:176px;'>";
                        } else {
                            echo "<img src='assets/images/profile-pic-01.jpg' alt='' />";
                        }
                        ?>
                    </div>
                    <h4><?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Popularised in the the release of' ?> 
                        <small> 
                            <?php echo isset($profile['date_of_birth']) && !is_null($profile['date_of_birth']) ? date('M d, Y', strtotime($profile['date_of_birth'])) : '3 Nov, 1988' ?> - <?php echo isset($profile['date_of_death']) && !is_null($profile['date_of_death']) ? date('M d, Y', strtotime($profile['date_of_death'])) : '3 Nov, 1989' ?>
                        </small>
                        <small><i class="fa fa-map-marker"></i><?php echo $profile['country'] . ', ' . $profile['state'] . ', ' . $profile['city'] ?></small>
                        <small>Created with love by: <?php echo isset($profile['u_fname']) ? $profile['u_fname'] . ' ' . $profile['u_lname'] : '-' ?></small> </h4>
                    <?php if (isset($profile['type']) && $profile['type'] == 2 && !empty($fundraiser)) { ?>
                        <a href="<?php echo site_url('donate/' . $profile['slug']) ?>" class="donate-btn">Donate</a>
                    <?php } ?>
                    <a href="<?php echo site_url('flowers') ?>" class="flowers-btn">Send Flowers</a>
                    <!-- Edit profile and publish profile buttons if created profile is of logged in user-->
                    <?php if ($profile['user_id'] == $this->user_id) { ?>
                        <a href="<?php echo site_url('profile/edit/' . $profile['slug']) ?>" class="edit-profile-btn">Edit</a>
                    <?php } ?>
                    <?php if ($profile['user_id'] == $this->user_id && $profile['is_published'] == 0) { ?>
                        <a href="javascript:void(0)" class="publish-profile-btn" onclick="$('#email_popup').modal('toggle')">Publish</a>
                    <?php } ?>
                    <div class="profile-share">
                        <h6>Share</h6>
                        <a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo $url; ?>')" title="Facebook Share">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 112.196 112.196" style="enable-background:new 0 0 112.196 112.196;" xml:space="preserve">
                                <g>
                                    <circle style="fill:#3B5998;" cx="56.098" cy="56.098" r="56.098"/>
                                    <path style="fill:#FFFFFF;" d="M70.201,58.294h-10.01v36.672H45.025V58.294h-7.213V45.406h7.213v-8.34
                                          c0-5.964,2.833-15.303,15.301-15.303L71.56,21.81v12.51h-8.151c-1.337,0-3.217,0.668-3.217,3.513v7.585h11.334L70.201,58.294z"/>
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
                            </svg>
                        </a>
                        <!--<a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Profile Sharing'; ?>')" title="Linked-in Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"-->
                        <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Profile Sharing'; ?>')" title="Linked-in Share">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 291.319 291.319" style="enable-background:new 0 0 291.319 291.319;" xml:space="preserve">
                                <g>
                                    <path style="fill:#0E76A8;" d="M145.659,0c80.45,0,145.66,65.219,145.66,145.66s-65.21,145.659-145.66,145.659S0,226.1,0,145.66
                                          S65.21,0,145.659,0z"/>
                                    <path style="fill:#FFFFFF;" d="M82.079,200.136h27.275v-90.91H82.079V200.136z M188.338,106.077
                                          c-13.237,0-25.081,4.834-33.483,15.504v-12.654H127.48v91.21h27.375v-49.324c0-10.424,9.55-20.593,21.512-20.593
                                          s14.912,10.169,14.912,20.338v49.57h27.275v-51.6C218.553,112.686,201.584,106.077,188.338,106.077z M95.589,100.141
                                          c7.538,0,13.656-6.118,13.656-13.656S103.127,72.83,95.589,72.83s-13.656,6.118-13.656,13.656S88.051,100.141,95.589,100.141z"/>
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
                            </svg>
                        </a>
                        <a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://twitter.com/share?url=<?php echo $url; ?>')" title="Twitter Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                                                                                                            viewBox="0 0 112.197 112.197" style="enable-background:new 0 0 112.197 112.197;" xml:space="preserve">
                                <g>
                                    <circle style="fill:#55ACEE;" cx="56.099" cy="56.098" r="56.098"/>
                                    <g>
                                        <path style="fill:#F1F2F2;" d="M90.461,40.316c-2.404,1.066-4.99,1.787-7.702,2.109c2.769-1.659,4.894-4.284,5.897-7.417
                                              c-2.591,1.537-5.462,2.652-8.515,3.253c-2.446-2.605-5.931-4.233-9.79-4.233c-7.404,0-13.409,6.005-13.409,13.409
                                              c0,1.051,0.119,2.074,0.349,3.056c-11.144-0.559-21.025-5.897-27.639-14.012c-1.154,1.98-1.816,4.285-1.816,6.742
                                              c0,4.651,2.369,8.757,5.965,11.161c-2.197-0.069-4.266-0.672-6.073-1.679c-0.001,0.057-0.001,0.114-0.001,0.17
                                              c0,6.497,4.624,11.916,10.757,13.147c-1.124,0.308-2.311,0.471-3.532,0.471c-0.866,0-1.705-0.083-2.523-0.239
                                              c1.706,5.326,6.657,9.203,12.526,9.312c-4.59,3.597-10.371,5.74-16.655,5.74c-1.08,0-2.15-0.063-3.197-0.188
                                              c5.931,3.806,12.981,6.025,20.553,6.025c24.664,0,38.152-20.432,38.152-38.153c0-0.581-0.013-1.16-0.039-1.734
                                              C86.391,45.366,88.664,43.005,90.461,40.316L90.461,40.316z"/>
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
                        <a href="javascript:void(0)"  onclick="javascript:genericSocialShare('https://plus.google.com/share?url=<?php echo $url; ?>')" title="Google Plus Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                                                                                                                      viewBox="0 0 112.196 112.196" style="enable-background:new 0 0 112.196 112.196;" xml:space="preserve">
                                <g>
                                    <g>
                                        <circle id="XMLID_30_" style="fill:#DC4E41;" cx="56.098" cy="56.097" r="56.098"/>
                                    </g>
                                    <g>
                                        <path style="fill:#DC4E41;" d="M19.531,58.608c-0.199,9.652,6.449,18.863,15.594,21.867c8.614,2.894,19.205,0.729,24.937-6.648
                                              c4.185-5.169,5.136-12.06,4.683-18.498c-7.377-0.066-14.754-0.044-22.12-0.033c-0.012,2.628,0,5.246,0.011,7.874
                                              c4.417,0.122,8.835,0.066,13.252,0.155c-1.115,3.821-3.655,7.377-7.51,8.757c-7.443,3.28-16.94-1.005-19.282-8.813
                                              c-2.827-7.477,1.801-16.5,9.442-18.675c4.738-1.667,9.619,0.21,13.673,2.673c2.054-1.922,3.976-3.976,5.864-6.052
                                              c-4.606-3.854-10.525-6.217-16.61-5.698C29.526,35.659,19.078,46.681,19.531,58.608z"/>
                                        <path style="fill:#DC4E41;" d="M79.102,48.668c-0.022,2.198-0.045,4.407-0.056,6.604c-2.209,0.022-4.406,0.033-6.604,0.044
                                              c0,2.198,0,4.384,0,6.582c2.198,0.011,4.407,0.022,6.604,0.045c0.022,2.198,0.022,4.395,0.044,6.604c2.187,0,4.385-0.011,6.582,0
                                              c0.012-2.209,0.022-4.406,0.045-6.615c2.197-0.011,4.406-0.022,6.604-0.033c0-2.198,0-4.384,0-6.582
                                              c-2.197-0.011-4.406-0.022-6.604-0.044c-0.012-2.198-0.033-4.407-0.045-6.604C83.475,48.668,81.288,48.668,79.102,48.668z"/>
                                        <g>
                                            <path style="fill:#FFFFFF;" d="M19.531,58.608c-0.453-11.927,9.994-22.949,21.933-23.092c6.085-0.519,12.005,1.844,16.61,5.698
                                                  c-1.889,2.077-3.811,4.13-5.864,6.052c-4.054-2.463-8.935-4.34-13.673-2.673c-7.642,2.176-12.27,11.199-9.442,18.675
                                                  c2.342,7.808,11.839,12.093,19.282,8.813c3.854-1.38,6.395-4.936,7.51-8.757c-4.417-0.088-8.835-0.033-13.252-0.155
                                                  c-0.011-2.628-0.022-5.246-0.011-7.874c7.366-0.011,14.743-0.033,22.12,0.033c0.453,6.439-0.497,13.33-4.683,18.498
                                                  c-5.732,7.377-16.322,9.542-24.937,6.648C25.981,77.471,19.332,68.26,19.531,58.608z"/>
                                            <path style="fill:#FFFFFF;" d="M79.102,48.668c2.187,0,4.373,0,6.57,0c0.012,2.198,0.033,4.407,0.045,6.604
                                                  c2.197,0.022,4.406,0.033,6.604,0.044c0,2.198,0,4.384,0,6.582c-2.197,0.011-4.406,0.022-6.604,0.033
                                                  c-0.022,2.209-0.033,4.406-0.045,6.615c-2.197-0.011-4.396,0-6.582,0c-0.021-2.209-0.021-4.406-0.044-6.604
                                                  c-2.197-0.023-4.406-0.033-6.604-0.045c0-2.198,0-4.384,0-6.582c2.198-0.011,4.396-0.022,6.604-0.044
                                                  C79.057,53.075,79.079,50.866,79.102,48.668z"/>
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
                    </div>
                </div>
            </div>
            <div class="profile-body">
                <div class="profile-body-l">
                    <?php if (!empty($funnel_services['Memorial']) || !empty($funnel_services['Funeral']) || !empty($funnel_services['Burial'])) { ?>
                        <div class="profile-box">
                            <h2>Funeral Services</h2>
                            <div class="profile-box-body according-tab">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Memorial Service & Viewing Section</a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <?php if (isset($funnel_services['Memorial']) && !empty($funnel_services['Memorial'])) { ?>
                                                    <h5><?php echo $funnel_services['Memorial']['place_name'] ?></h5>
                                                    <p><strong>Time:</strong> <?php echo isset($funnel_services['Memorial']['time']) && !is_null($funnel_services['Memorial']['time']) ? date('h:i A', strtotime($funnel_services['Memorial']['time'])) : '00:00 AM' ?></p>
                                                    <p><strong>Date:</strong> (<?php echo isset($funnel_services['Memorial']['date']) && !is_null($funnel_services['Memorial']['date']) ? date('M d, Y', strtotime($funnel_services['Memorial']['date'])) : '3 Nov, 1988' ?>)</p>
                                                    <p><strong>Address:</strong> <?php echo $funnel_services['Memorial']['address'] ?></p>
                                                    <p><strong>City:</strong> <?php echo $funnel_services['Memorial']['city_name'] ?></p>
                                                    <p><strong>State:</strong> <?php echo $funnel_services['Memorial']['state_name'] ?></p>
                                                    <p><strong>Zipcode:</strong> <?php echo $funnel_services['Memorial']['zip'] ?></p>
                                                <?php } else { ?>
                                                    <p class="general-text">Memorial service not available.</p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Funeral Service Section</a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                            <div class="panel-body">
                                                <?php if (isset($funnel_services['Funeral']) && !empty($funnel_services['Funeral'])) { ?>
                                                    <h5><?php echo $funnel_services['Funeral']['place_name'] ?></h5>
                                                    <p><strong>Time:</strong> <?php echo isset($funnel_services['Funeral']['time']) && !is_null($funnel_services['Funeral']['time']) ? date('h:i A', strtotime($funnel_services['Funeral']['time'])) : '00:00 AM' ?></p>
                                                    <p><strong>Date: </strong> (<?php echo isset($funnel_services['Funeral']['date']) && !is_null($funnel_services['Funeral']['date']) ? date('M d, Y', strtotime($funnel_services['Funeral']['date'])) : '3 Nov, 1988' ?>)</p>
                                                    <p><strong>Address: </strong> <?php echo $funnel_services['Funeral']['address'] ?></p>
                                                    <p><strong>City: </strong> <?php echo $funnel_services['Funeral']['city_name'] ?></p>
                                                    <p><strong>State: </strong> <?php echo $funnel_services['Funeral']['state_name'] ?></p>
                                                    <p><strong>Zipcode: </strong> <?php echo $funnel_services['Funeral']['zip'] ?></p>
                                                <?php } else { ?>
                                                    <p class="general-text">Funeral service not available.</p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Burial Section</a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                            <div class="panel-body">
                                                <?php if (isset($funnel_services['Burial']) && !empty($funnel_services['Burial'])) { ?>
                                                    <h5><?php echo $funnel_services['Burial']['place_name'] ?></h5>
                                                    <p><strong>Time:</strong> <?php echo isset($funnel_services['Burial']['time']) && !is_null($funnel_services['Burial']['time']) ? date('h:i A', strtotime($funnel_services['Burial']['time'])) : '00:00 AM' ?></p>
                                                    <p><strong>Date:</strong> (<?php echo isset($funnel_services['Burial']['date']) && !is_null($funnel_services['Burial']['date']) ? date('M d, Y', strtotime($funnel_services['Burial']['date'])) : '3 Nov, 1988' ?>)</p>
                                                    <p><strong>Address: </strong> <?php echo $funnel_services['Burial']['address'] ?></p>
                                                    <p><strong>City:</strong> <?php echo $funnel_services['Burial']['city_name'] ?></p>
                                                    <p><strong>State:</strong> <?php echo $funnel_services['Burial']['state_name'] ?></p>
                                                    <p><strong>Zipcode: </strong> <?php echo $funnel_services['Burial']['zip'] ?></p>
                                                <?php } else { ?>
                                                    <p class="general-text">Burial service not available.</p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="profile-box lifetime-line">
                        <h2>Life Timeline</h2>
                        <div class="profile-box-body">
                            <?php
                            $count = 0;
                            $total_count = 0;
                            if (isset($life_timeline) && !empty($life_timeline)) {
                                ?>
                                <span>
                                    <?php
                                    if (isset($profile['profile_image']) && $profile['profile_image'] != '') {
                                        echo "<img src='" . PROFILE_IMAGES . $profile['profile_image'] . "''>";
                                    } else {
                                        echo "<img src='assets/images/profile-pic-01.jpg' alt='' />";
                                    }
                                    ?>
                                </span>
                                <ul class="timeline_ul">
                                    <?php
                                    $total_count = $life_timeline['total_count'];
                                    $timeline = $life_timeline['timeline_data'];
                                    foreach ($timeline as $k => $v) {
                                        ?>
                                        <li>
                                            <div class="lifetime-box">
                                                <h3>
                                                    <?php
                                                    if ($v['date'] != null) {
                                                        $lifetimeline_date = custom_format_date($v['date'], 'date');
                                                    } else if ($v['month'] != null) {
                                                        $lifetimeline_date = custom_format_date($v['month'], 'month') . ' , ' . $v['year'];
                                                    } else {
                                                        $lifetimeline_date = $v['year'];
                                                    }
                                                    ?>
                                                    <?php if ($v['timeline_media'] != null && $v['media_type'] == 1) { ?>
                                                        <a href="javascript:void(0)" class="timeline" data-timeline="<?php echo base64_encode($v['id']) ?>"><?php echo $lifetimeline_date ?></a>
                                                    <?php } else if ($v['timeline_media'] != null && $v['media_type'] == 2) { ?>
                                                        <a href="javascript:void(0)" class="timeline" data-timeline="<?php echo base64_encode($v['id']) ?>"><?php echo $lifetimeline_date ?></a>
                                                    <?php } else { ?>
                                                        <a href="javascript:void(0)" class="timeline" data-timeline="<?php echo base64_encode($v['id']) ?>"><?php echo $lifetimeline_date ?></a>
                                                    <?php } ?>
                                                </h3>
                                                <p><?php echo $v['title']; ?></p>
                                                <?php if ($v['timeline_media'] != null && $v['media_type'] == 1) { ?>
                                                    <h6><a href="javascript:void(0)" class="timeline fa fa-image" data-timeline="<?php echo base64_encode($v['id']) ?>"></a></h6>
                                                <?php } else if ($v['timeline_media'] != null && $v['media_type'] == 2) { ?>
                                                    <h6><a href="javascript:void(0)" class="timeline fa fa-play-circle-o" data-timeline="<?php echo base64_encode($v['id']) ?>"></a></h6>
                                                <?php } else { ?>
                                                    <h6><a href="javascript:void(0)" class="timeline fa fa-circle-o" data-timeline="<?php echo base64_encode($v['id']) ?>"></a></h6>
                                                <?php } ?>
                                            </div>
                                        </li>
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </ul>
                            <?php } else { ?>
                                <p class="no-data">No timeline added.</p>
                            <?php } ?>
                            <?php if ($total_count != $count) { ?>
                                <a href="javascript:void(0)" class="btn-btm-01 view_more_timeline">View More</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="profile-body-m">
                    <div class="profile-box life-bio">
                        <h2>Life Bio</h2>
                        <div class="profile-box-body">
                            <p><?php echo isset($profile['life_bio']) && !is_null($profile['life_bio']) ? $profile['life_bio'] : 'Life bio not available for this profile.' ?></p>
                        </div>

                        <div class="post-comment">
                            <form method="post" enctype="multipart/form-data" name="post_form" id="post_form">
                                <textarea name="comment" id="comment" placeholder="Add some comment, Images, Video etc..."> </textarea>
                                <div class="comoon-ul-li list-04">
                                    <ul>
                                    </ul>
                                </div>
                                <div class="comment-btm">
                                    <div class="select-file video-upload">
                                        <div class="select-file-upload"> 
                                            <span class="select-file_up_btn">
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
                                                </svg>
                                            </span>
                                            <input type="file" name="video_post[]" id="video_post" class="post_gallery_upload" data-type="video" multiple="true"> 
                                        </div>
                                    </div>

                                    <div class="select-file img-upload">
                                        <div class="select-file-upload"> 
                                            <span class="select-file_up_btn">
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
                                                </svg>
                                            </span>
                                            <input type="file" name="images_post[]" id="images_post" class="post_gallery_upload" data-type="image" multiple="true"> 
                                        </div>
                                    </div>
                                    <!--<input type="hidden" name="post_data" id="post_data"/>-->
                                    <button type="submit" name="post_btn" id="post_btn" class="purple_btn">Post</button>
                                </div>
                            </form>
                        </div>
                        <div class="comments-div"  id="content-8">
                            <?php if (isset($posts) && !empty($posts)) { ?>
                                <ul class="post_ul post_ul_responsive_view">
                                    <?php
                                    foreach ($posts as $key => $val) {
                                        $from_date = date_create($val['created_at']);
                                        $to_date = date_create(date('Y-m-d H:i:s'));
                                        $days_diff = date_diff($from_date, $to_date);
//                                        $equal = (date('Y-m-d'strtotime($val['created_at']) != strtotime(date('Y-m-d H:i:s'))) ? true: false;
                                        ?>
                                        <li>
                                            <div class="comments-div-wrap">
                                                <span class="commmnet-postted-img">
                                                    <?php
                                                    if (isset($val['profile_image']) && !is_null($val['profile_image'])) {
                                                        if (!preg_match("/https:\/\//i", $val['profile_image'])) {
                                                            ?>
                                                            <img src="<?php echo USER_IMAGES . $val['profile_image'] ?>"/>
                                                        <?php } else { ?>
                                                            <img src="<?php echo $val['profile_image'] ?>"/>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </span>
                                                <h3><?php echo $val['firstname'] . ' ' . $val['lastname'] ?>
                                                    <?php $day_diff_str = format_days($days_diff); ?>
                                                    <small>
                                                        <?php
                                                        echo $day_diff_str;
                                                        if ($day_diff_str != 'Just Now')
                                                            echo ' Ago';
                                                        ?>
                                                    </small>
                                                </h3>
                                                <p><?php echo $val['comment'] ?></p>
                                                <?php if (isset($val['media'])) { ?>
                                                    <div class="comoon-ul-li list-02">
                                                        <ul>
                                                            <?php if (isset($val['media']) && isset($val['media'][1])) { ?>
                                                                <?php foreach ($val['media'][1] as $k => $v) {
                                                                    ?>
                                                                    <li>
                                                                        <div class="gallery-wrap">
                                                                            <span class="gallery-video-img">
                                                                                <a class="fancybox" href="<?php echo base_url(POST_IMAGES . $v) ?>" data-fancybox-type="image" rel="post_group_<?php echo $val['id'] ?>"><img src="<?php echo base_url(POST_IMAGES . $v) ?>"></a>
                                                                            </span>
                                                                        </div>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                            if (isset($val['media']) && isset($val['media'][2])) {
                                                                ?>
                                                                <?php foreach ($val['media'][2] as $k => $v) {
                                                                    ?>
                                                                    <li>
                                                                        <div class="gallery-wrap">
                                                                            <span class="gallery-video-img">
                                                                                <!--                                                                                <video  width="100%" height="150px" controls="">
                                                                                                                                                                    <source src="<?php // echo base_url(POST_IMAGES . $v)                                                                ?>" type="video/mp4">
                                                                                                                                                                </video>-->
                                                                                <img src="<?php echo base_url(POST_IMAGES . str_replace('mp4', 'jpg', $v)) ?>">
                                                                            </span>
                                                                            <span class="gallery-play-btn"><a href="<?php echo base_url(POST_IMAGES . $v) ?>" class="fancybox" data-fancybox-type="iframe" rel="post_group_<?php echo $val['id'] ?>"><img src="assets/images/play.png" alt=""></a></span>
                                                                        </div>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul><?php } else { ?>
                                <p class="no-data">No post comments available for this profile.</p>
                            <?php } ?>
                        </div>


                    </div>
                </div>
                <div class="profile-body-r">
                    <?php if ($profile['type'] == 2 && $profile['is_published'] == 1 && !empty($fundraiser)) { ?>
                        <div class="profile-box fundraiser">
                            <h2>Tribute Fundraiser</h2>
                            <div class="profile-box-body">
                                <span>Donated <big><?php echo round(($fundraiser['total_donation'] * 100) / $fundraiser['goal']) ?>%</big></span>
                                <h6>$<?php echo $fundraiser['total_donation'] ?> <small>Raised of</small></h6>
                                <h6>$<?php echo $fundraiser['goal'] ?> <small>Goal</small></h6>
                                <a href="<?php echo site_url('donate/' . $profile['slug']) ?>">Donate</a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="profile-box life-gallery">
                        <h2>Life Gallery</h2>
                        <div class="profile-box-body">
                            <ul>
                                <?php
                                if (isset($life_gallery) && !empty($life_gallery)) {
                                    foreach ($life_gallery as $key => $val) {
                                        if ($val['type'] == 1) {
                                            ?>
                                            <li>
                                                <div class="gallery-wrap">
                                                    <span class="gallery-video-img">
                                                        <a class="fancybox" href="<?php echo base_url(PROFILE_IMAGES . $val['media']) ?>" data-fancybox-type="image" rel="gallery"><img src="<?php echo base_url(PROFILE_IMAGES . $val['media']) ?>" width="100%" height="100%"></a>
                                                    </span>
                                                </div>
                                            </li>
                                        <?php } else if ($val['type'] == 2) {
                                            ?>
                                            <li>
                                                <div class="gallery-wrap">
                                                    <span class="gallery-video-img">
                                                        <img src="<?php echo base_url(PROFILE_IMAGES . str_replace('mp4', 'jpg', $val['media'])) ?>" width="100%" height="100%">
                                                    </span>
                                                    <span class="gallery-play-btn"><a href="<?php echo base_url(PROFILE_IMAGES . $val['media']) ?>" class="fancybox" data-fancybox-type="iframe" rel="gallery"><img src="assets/images/play.png" alt=""></a></span>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <p class="no-data">Profile not having life gallery.</p>
                                <?php } ?>
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
                                <p class="no-data">Fun Facts are not available for this profile.</p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="profile-box affiliations">
                        <h2>Affiliations</h2>
                        <div class="profile-box-body">
                            <ul>
                                <?php if (isset($affiliations) && !empty($affiliations)) { ?>
                                    <?php
                                    foreach ($affiliations as $key => $value) {
                                        if ($value['free_text'] == 1) {
                                            ?>
                                            <li><a><?php echo $value['name'] ?></a></li>
                                        <?php } else { ?>
                                            <li><a href="<?php echo site_url('affiliation/view/') . $value['slug'] ?>" class="official_affiliation"><?php echo $value['name'] ?></a></li>
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <li><p class="no-data">No Affiliations available.</p></li>
                                <?php } ?>
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
<div class="modal fade" id="timeline_details">
    <div class="modal-dialog" role="document">
        <div class="login-signup">
            <div class="modal-body">
                <div class="pup-btn">
                    <button type="button" onclick="$('#timeline_details').modal('toggle')"><i class="fa fa-close"></i></button>
                </div>    
                <div class="modal-header custom_header">Life Timeline Details</div>
                <table class="table">
                    <tbody>
                        <tr class="popup-input">
                            <td><label>Title</label></td>
                            <td><span class="timeline_title"></span></td>
                        </tr>
                        <tr class="popup-input">
                            <td><label>Event Date</label></td>
                            <td><span class="timeline_date"></span></td>
                        </tr>
                        <tr class="popup-input">
                            <td><label>Media</label></td>
                            <td><span class="timeline_media"></span></td>
                        </tr>
                        <tr class="popup-input">
                            <td><label>Details</label></td>
                            <td><span class="timeline_details"></span></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<div class="modal fade publish-share-modal" id="email_popup">
    <div class="modal-dialog" role="document">
        <div class="login-signup">
            <div class="modal-body">
                <div class="pup-btn">
                    <button type="button" onclick="$('#email_popup').modal('toggle')"><i class="fa fa-close"></i></button>
                </div>    
                <div class="modal-header custom_header text-center">
                    Email family & friends (optional)
                    <label class="label-css">Share the Life Profile via email's</label>
                </div>
                <form id="share_email_form" method="post">
                    <div class="input-wrap">
                        <label class="label-css">Enter up to 30 email addresses separated by commas</label>
                        <textarea class="input-css textarea-css" name="email_friends" id="email_friends" placeholder="Enter up to 30 email addresses separated by commas,you will be able to send more later if needed. To share with more than 30 people via email,you can use your regular email to share the Life Profile link." required></textarea>
                        <label id="email_friends-error" class="error" for="email_friends"></label>
                    </div>
                    <input type="hidden" name="profile_slug" id="profile_slug" value="<?php echo $profile['slug'] ?>"/>
                </form>
                <div class="step-btm-btn">
                    <button class="skip" onclick="display_popup('fbshare_popup', 'email_popup')">Skip</button>
                    <button class="next" onclick="return share_email();">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade publish-share-modal" id="fbshare_popup">
    <div class="modal-dialog" role="document">
        <div class="login-signup">
            <div class="modal-body">
                <div class="pup-btn">
                    <button type="button" onclick="$('#fbshare_popup').modal('toggle')"><i class="fa fa-close"></i></button>
                </div>    
                <div class="modal-header custom_header text-center">
                    Share on Social Media (optional)
                    <label class="label-css">Share the Life Profile via facebook</label>
                </div>
                <div class="input-wrap text-center">
                    <div class="profile-share">
                        <a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo $url; ?>')" title="Facebook Share">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 112.196 112.196" style="enable-background:new 0 0 112.196 112.196;" xml:space="preserve">
                                <g>
                                    <circle style="fill:#3B5998;" cx="56.098" cy="56.098" r="56.098"/>
                                    <path style="fill:#FFFFFF;" d="M70.201,58.294h-10.01v36.672H45.025V58.294h-7.213V45.406h7.213v-8.34
                                          c0-5.964,2.833-15.303,15.301-15.303L71.56,21.81v12.51h-8.151c-1.337,0-3.217,0.668-3.217,3.513v7.585h11.334L70.201,58.294z"/>
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
                            </svg>
                        </a>
                        <!--<a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Profile Sharing'; ?>')" title="Linked-in Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"-->
                        <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Profile Sharing'; ?>')" title="Linked-in Share">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 291.319 291.319" style="enable-background:new 0 0 291.319 291.319;" xml:space="preserve">
                                <g>
                                    <path style="fill:#0E76A8;" d="M145.659,0c80.45,0,145.66,65.219,145.66,145.66s-65.21,145.659-145.66,145.659S0,226.1,0,145.66
                                          S65.21,0,145.659,0z"/>
                                    <path style="fill:#FFFFFF;" d="M82.079,200.136h27.275v-90.91H82.079V200.136z M188.338,106.077
                                          c-13.237,0-25.081,4.834-33.483,15.504v-12.654H127.48v91.21h27.375v-49.324c0-10.424,9.55-20.593,21.512-20.593
                                          s14.912,10.169,14.912,20.338v49.57h27.275v-51.6C218.553,112.686,201.584,106.077,188.338,106.077z M95.589,100.141
                                          c7.538,0,13.656-6.118,13.656-13.656S103.127,72.83,95.589,72.83s-13.656,6.118-13.656,13.656S88.051,100.141,95.589,100.141z"/>
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
                            </svg>
                        </a>
                        <a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://twitter.com/share?url=<?php echo $url; ?>')" title="Twitter Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                                                                                                            viewBox="0 0 112.197 112.197" style="enable-background:new 0 0 112.197 112.197;" xml:space="preserve">
                                <g>
                                    <circle style="fill:#55ACEE;" cx="56.099" cy="56.098" r="56.098"/>
                                    <g>
                                        <path style="fill:#F1F2F2;" d="M90.461,40.316c-2.404,1.066-4.99,1.787-7.702,2.109c2.769-1.659,4.894-4.284,5.897-7.417
                                              c-2.591,1.537-5.462,2.652-8.515,3.253c-2.446-2.605-5.931-4.233-9.79-4.233c-7.404,0-13.409,6.005-13.409,13.409
                                              c0,1.051,0.119,2.074,0.349,3.056c-11.144-0.559-21.025-5.897-27.639-14.012c-1.154,1.98-1.816,4.285-1.816,6.742
                                              c0,4.651,2.369,8.757,5.965,11.161c-2.197-0.069-4.266-0.672-6.073-1.679c-0.001,0.057-0.001,0.114-0.001,0.17
                                              c0,6.497,4.624,11.916,10.757,13.147c-1.124,0.308-2.311,0.471-3.532,0.471c-0.866,0-1.705-0.083-2.523-0.239
                                              c1.706,5.326,6.657,9.203,12.526,9.312c-4.59,3.597-10.371,5.74-16.655,5.74c-1.08,0-2.15-0.063-3.197-0.188
                                              c5.931,3.806,12.981,6.025,20.553,6.025c24.664,0,38.152-20.432,38.152-38.153c0-0.581-0.013-1.16-0.039-1.734
                                              C86.391,45.366,88.664,43.005,90.461,40.316L90.461,40.316z"/>
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
                        <a href="javascript:void(0)"  onclick="javascript:genericSocialShare('https://plus.google.com/share?url=<?php echo $url; ?>')" title="Google Plus Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                                                                                                                      viewBox="0 0 112.196 112.196" style="enable-background:new 0 0 112.196 112.196;" xml:space="preserve">
                                <g>
                                    <g>
                                        <circle id="XMLID_30_" style="fill:#DC4E41;" cx="56.098" cy="56.097" r="56.098"/>
                                    </g>
                                    <g>
                                        <path style="fill:#DC4E41;" d="M19.531,58.608c-0.199,9.652,6.449,18.863,15.594,21.867c8.614,2.894,19.205,0.729,24.937-6.648
                                              c4.185-5.169,5.136-12.06,4.683-18.498c-7.377-0.066-14.754-0.044-22.12-0.033c-0.012,2.628,0,5.246,0.011,7.874
                                              c4.417,0.122,8.835,0.066,13.252,0.155c-1.115,3.821-3.655,7.377-7.51,8.757c-7.443,3.28-16.94-1.005-19.282-8.813
                                              c-2.827-7.477,1.801-16.5,9.442-18.675c4.738-1.667,9.619,0.21,13.673,2.673c2.054-1.922,3.976-3.976,5.864-6.052
                                              c-4.606-3.854-10.525-6.217-16.61-5.698C29.526,35.659,19.078,46.681,19.531,58.608z"/>
                                        <path style="fill:#DC4E41;" d="M79.102,48.668c-0.022,2.198-0.045,4.407-0.056,6.604c-2.209,0.022-4.406,0.033-6.604,0.044
                                              c0,2.198,0,4.384,0,6.582c2.198,0.011,4.407,0.022,6.604,0.045c0.022,2.198,0.022,4.395,0.044,6.604c2.187,0,4.385-0.011,6.582,0
                                              c0.012-2.209,0.022-4.406,0.045-6.615c2.197-0.011,4.406-0.022,6.604-0.033c0-2.198,0-4.384,0-6.582
                                              c-2.197-0.011-4.406-0.022-6.604-0.044c-0.012-2.198-0.033-4.407-0.045-6.604C83.475,48.668,81.288,48.668,79.102,48.668z"/>
                                        <g>
                                            <path style="fill:#FFFFFF;" d="M19.531,58.608c-0.453-11.927,9.994-22.949,21.933-23.092c6.085-0.519,12.005,1.844,16.61,5.698
                                                  c-1.889,2.077-3.811,4.13-5.864,6.052c-4.054-2.463-8.935-4.34-13.673-2.673c-7.642,2.176-12.27,11.199-9.442,18.675
                                                  c2.342,7.808,11.839,12.093,19.282,8.813c3.854-1.38,6.395-4.936,7.51-8.757c-4.417-0.088-8.835-0.033-13.252-0.155
                                                  c-0.011-2.628-0.022-5.246-0.011-7.874c7.366-0.011,14.743-0.033,22.12,0.033c0.453,6.439-0.497,13.33-4.683,18.498
                                                  c-5.732,7.377-16.322,9.542-24.937,6.648C25.981,77.471,19.332,68.26,19.531,58.608z"/>
                                            <path style="fill:#FFFFFF;" d="M79.102,48.668c2.187,0,4.373,0,6.57,0c0.012,2.198,0.033,4.407,0.045,6.604
                                                  c2.197,0.022,4.406,0.033,6.604,0.044c0,2.198,0,4.384,0,6.582c-2.197,0.011-4.406,0.022-6.604,0.033
                                                  c-0.022,2.209-0.033,4.406-0.045,6.615c-2.197-0.011-4.396,0-6.582,0c-0.021-2.209-0.021-4.406-0.044-6.604
                                                  c-2.197-0.023-4.406-0.033-6.604-0.045c0-2.198,0-4.384,0-6.582c2.198-0.011,4.396-0.022,6.604-0.044
                                                  C79.057,53.075,79.079,50.866,79.102,48.668z"/>
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
                    </div>
                </div>
                <div class="step-btm-btn">
                    <button class="skip" onclick="return display_popup('email_popup', 'fbshare_popup')">Back</button>
                    <button class="next" onclick="return publish_profile();">Publish Profile</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (!$this->is_user_loggedin)
    $user_logged_in = "not";
else
    $user_logged_in = $this->is_user_loggedin;
?>
<script type="text/javascript">
    $('#timeline_details .timeline_media').parent().parent().hide();
    $('#timeline_details .timeline_details').parent().parent().hide();
    var user_logged_in = '<?php echo $user_logged_in ?>';
    var profile_id = '<?php echo isset($profile['id']) ? base64_encode($profile['id']) : '' ?>';
    var slug = '<?php echo isset($profile['slug']) ? $profile['slug'] : '' ?>';
    max_images_count = <?php echo MAX_IMAGES_COUNT ?>;
    max_videos_count = <?php echo MAX_VIDEOS_COUNT ?>;
    delete_str = '<?php $this->load->view('delete_svg', true); ?>';
    user_image = '<?php echo USER_IMAGES ?>';
    post_image = '<?php echo POST_IMAGES ?>';
</script>
<script src="assets/js/profile_detail.js"></script>
