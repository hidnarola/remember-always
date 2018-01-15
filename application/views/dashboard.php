<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title"><?php echo isset($title) ? $title : 'Dashboard' ?></h2>
            <!--<a href="" class="pspl">Post a Services Provider Listing</a>-->
        </div>
        <div class="common-body">
            <div class="mypost-l">
                <div class="profile-box services-ctgr affiliations">
                    <h2>Dashboard Links</h2>
                    <div class="profile-box-body">
                        <ul>
                            <li><a href="<?php echo site_url('dashboard/profiles') ?>" <?php echo (isset($slug) && ($slug == '' || $slug == 'profiles')) ? 'class="active"' : '' ?>>My Profiles</a></li>
                            <li><a href="<?php echo site_url('dashboard/affiliations') ?>" <?php echo (isset($slug) && ($slug == 'affiliations')) ? 'class="active"' : '' ?>>Affiliations</a></li>
                            <li><a href="<?php echo site_url('editprofile') ?>">Edit Profile </a></li>
                            <li><a href="<?php echo site_url('logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mypost-r">
                <div class="profile-box services-listings" id="profiles" <?php echo (isset($slug) && ($slug == '' || $slug == 'profiles')) ? 'style="display:block;"' : 'style="display:none"' ?>>
                    <h2>My Profiles</h2>
                    <?php if (isset($profiles) && !empty($profiles)) { ?>
                        <ul class="srvs-list-ul">
                            <?php foreach ($profiles as $key => $val) { ?>
                                <li>
                                    <span>
                                        <?php
                                        if (isset($val['profile_image']) && $val['profile_image'] != '') {
                                            echo "<img src='" . PROFILE_IMAGES . $val['profile_image'] . "' width='100%' height='100%' class='mCS_img_loaded'>";
                                        }
                                        ?>
                                    </span>
                                    <h3>
                                        <a href="<?php echo site_url('profile/') . $val['slug'] ?>">
                                            <?php
                                            echo $val['firstname'] . ' ' . $val['lastname'];
                                            if ($val['nickname'] != '')
                                                echo ' (' . $val['nickname'] . ')';
                                            ?>
                                        </a>
                                    </h3>
                                    <p><?php echo $val['life_bio'] ?></p>
                                    <div class="user-update">
                                        <a href="<?php echo site_url('profile/' . $val['slug']) ?>" class="donate-btn">Visit</a>
                                        <a href="<?php echo site_url('profile/edit/') . $val['slug'] ?>" class="edit">Edit </a>
                                        <?php if ($val['type'] == 1) { ?>
                                            <a href="<?php echo site_url('profile/edit/' . $val['slug'] . '?tribute=1') ?>" class="flowers-btn">Add a fundraiser </a>
                                        <?php } ?>
                                        <?php if ($val['is_published'] == 0) { ?>
                                            <a href="javascript:void(0)" class="public publish" data-profile="<?php echo $val['slug'] ?>">Publish</a>
                                        <?php } ?>
                                        <a href="javascript:void(0)" class="delete profile_delete" data-profile="<?php echo $val['slug'] ?>">Delete</a>
                                        <div class="dashboard-share profile-share">
                                            <a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo site_url('profile/' . $val['slug']) ?>')" title="Facebook Share">
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
                                            <!--<a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?url=<?php echo site_url('profile/' . $val['slug']) ?>&title=<?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Profile Sharing'; ?>')" title="Linked-in Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"-->
                                            <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?url=<?php echo site_url('profile/' . $val['slug']) ?>&title=<?php echo isset($profile['firstname']) && !is_null($profile['firstname']) ? $profile['firstname'] . ' ' . $profile['lastname'] : 'Profile Sharing'; ?>')" title="Linked-in Share">
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
                                            <a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://twitter.com/share?url=<?php echo site_url('profile/' . $val['slug']) ?>')" title="Twitter Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
                                            <a href="javascript:void(0)"  onclick="javascript:genericSocialShare('https://plus.google.com/share?url=<?php echo site_url('profile/' . $val['slug']) ?>')" title="Google Plus Share"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="no-data">No profiles available.</p>
                    <?php } ?>

                </div>
                <div class="profile-box services-listings" id="affiliations" <?php echo (isset($slug) && ($slug == 'affiliations')) ? 'style="display:block;"' : 'style="display:none"' ?>>
                    <h2>Affiliations</h2>
                    <?php if (isset($affiliations) && !empty($affiliations)) { ?>
                        <ul class="srvs-list-ul">
                            <?php foreach ($affiliations as $key => $val) { ?>
                                <li>
                                    <span> 
                                        <?php
                                        if (isset($val['image']) && $val['image'] != '') {
                                            echo "<img src='" . AFFILIATION_IMAGE . $val['image'] . "' width='100%' height='100%' class='mCS_img_loaded'>";
                                        }
                                        ?>
                                    </span>
                                    <h3><a href="<?php echo site_url('affiliation/view/') . $val['slug'] ?>"><?php echo $val['name'] . ' (' . $val['category_name'] . ')' ?></a></h3>
                                    <p><?php echo $val['description'] ?></p>
                                    <div class="user-update">
                                        <a href="<?php echo site_url('affiliation/edit/' . $val['slug']) ?>" class="edit">Edit </a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="no-data">No affiliation added.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var current_url = '<?php echo site_url($_SERVER['PATH_INFO']); ?>';
    $(document).on('click', ".publish", function () {
        var id = $(this).data("profile");
        var url = 'dashboard/profile_publish/' + id;
        swal({
            title: "Are you sure?",
            text: "You want to publish this profile",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
//            focusConfirm:true,
            focusCancel: true,
//          reverseButtons: true,
        }).then(function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                    }
                });
                window.location.href = current_url;
                return true;
            }
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal("Cancelled", "Your profile is not published. :)", "error");
            }
        });
        return false;
    });
    $(document).on('click', ".profile_delete", function () {
        var id = $(this).data("profile");
        var url = 'dashboard/profile_action/delete/' + id;
        swal({
            title: "Are you sure?",
            text: "You want to delete this profile",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
//            focusConfirm:true,
            focusCancel: true,
//          reverseButtons: true,
        }).then(function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                    }
                });
                window.location.href = current_url;
                return true;
            }
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal("Cancelled", "Your profile is safe. :)", "error");
            }
        });
        return false;
    });
</script>