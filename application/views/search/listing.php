<div class="new-srh-for">
    <div class="container">
        <h2 class="h2title">Find memorial Life Profiles <br/> and other site content</h2>
        <form action="<?php echo site_url('search') ?>" id="search_form">
            <div class="select_arrow">
                <select name="type" id="search_type" class="input-css">
                    <option value="profile" <?php if ($this->input->get('type') == 'profile') echo 'selected'; ?>>Life Profiles</option>
                    <option value="affiliation" <?php if ($this->input->get('type') == 'affiliation') echo 'selected'; ?>>Affiliations</option>
                    <option value="blog" <?php if ($this->input->get('type') == 'blog') echo 'selected'; ?>>Blog</option>
                    <option value="all" <?php if ($this->input->get('type') == 'all' || $this->input->get('type') == '') echo 'selected'; ?>>All</option>
                </select>
                <i class="fa fa-caret-down"></i>
            </div>
            <div class="srvs-input">
                <input type="text" name="keyword" id="general-search-keyword" placeholder="Enter Keyword" class="input-css" value="<?php echo $this->input->get('keyword') ?>"/>
            </div>
            <div class="srvs-input">	
                <input type="text" name="location" id="general-search-location" placeholder="Location" class="input-css" value="<?php echo $this->input->get('location') ?>"/>
            </div>
            <div class="srvs-btn">	
                <button type="submit" class="global_search">FIND</button>
            </div>
        </form>
    </div> 
</div>

<div class="common-page">
    <div class="container">
        <div class="">
            <div class="new-srh-result">
                <ul>
                    <?php
                    if (!empty($results)) {
                        foreach ($results as $key => $result) {
                            ?>
                            <li>
                                <div class="result-img">
                                    <?php
                                    $tag_class = '';
                                    $visit_url = '';
                                    if ($result['type'] == 'profile') {
                                        $tag_class = 'tag-profile';
                                        $visit_url = site_url('profile/' . $result['slug']);
                                        if ($this->input->get('type') == 'profile') {
                                            $tag_class = '';
                                        }
                                        echo "<a href='" . $visit_url . "'>";
                                        if ($result['image'] != '') {
                                            echo "<img src='" . PROFILE_IMAGES . $result['image'] . "' alt='" . $result['name'] . " Online Memorial Remember Always' title='" . $result['name'] . " Online Memorial Remember Always' class='profile-exif-img'>";
                                        } else {
                                            echo "<img src='assets/images/no_image.png' alt='' width='100%'>";
                                        }
                                        echo "</a>";
                                    } elseif ($result['type'] == 'service_provider') {
                                        $tag_class = 'tag-services';
                                        $visit_url = site_url('service_provider/view/' . $result['slug']);

                                        echo "<a href='" . $visit_url . "'>";
                                        if ($result['image'] != '') {
                                            echo "<img src='" . PROVIDER_IMAGES . $result['image'] . "' alt=''>";
                                        } else {
                                            echo "<img src='assets/images/no_image.png' alt='' width='100%'>";
                                        }
                                        echo "</a>";
                                    } elseif ($result['type'] == 'affiliation') {
                                        $tag_class = 'tag-affiliation';
                                        $visit_url = site_url('affiliation/view/' . $result['slug']);

                                        echo "<a href='" . $visit_url . "'>";
                                        if ($result['image'] != '') {
                                            echo "<img src='" . AFFILIATION_IMAGE . $result['image'] . "' alt=''>";
                                        } else {
                                            echo "<img src='assets/images/no_image.png' alt='' width='100%'>";
                                        }
                                        echo "</a>";
                                    } elseif ($result['type'] == 'blog') {
                                        $tag_class = 'tag-blog';
                                        $visit_url = site_url('blog/details/' . $result['slug']);

                                        echo "<a href='" . $visit_url . "'>";
                                        if ($result['image'] != '') {
                                            echo "<img src='" . BLOG_POST_IMAGES . $result['image'] . "' alt=''>";
                                        } else {
                                            echo "<img src='assets/images/no_image.png' alt='' width='100%'>";
                                        }
                                        echo "</a>";
                                    }
                                    ?>
                                    <!--<div class="<?php echo $tag_class ?>"></div>-->
                                </div>
                                <div class="result-body">
                                    <h3>
                                        <?php
                                        if ($result['type'] == 'profile') {
                                            $visit_txt = 'Visit';
                                            echo "<a href='" . $visit_url . "'>" . $result['name'] . "</a>";
                                            echo "<small>" . date('M d, Y', strtotime($result['date_of_birth'])) . ' - ' . date('M d, Y', strtotime($result['date_of_death'])) . "</small>";
                                        } else if ($result['type'] == 'service_provider') {
                                            $visit_txt = 'Visit';
                                            echo "<a href='" . $visit_url . "'>" . $result['name'] . "</a>";
                                        } else if ($result['type'] == 'affiliation') {
                                            $visit_txt = 'View';
                                            echo "<a href='" . $visit_url . "'>" . $result['name'] . "</a>";
                                        } else if ($result['type'] == 'blog') {
                                            $visit_txt = 'Read';
                                            echo "<a href='" . $visit_url . "'>" . $result['name'] . "</a>";
                                        }
                                        ?>
                                    </h3>
                                    <?php
                                    if ($result['type'] != 'blog') {
                                        echo "<p><small>";
                                        if ($result['city'] != '') {
                                            echo $result['city'] . ', ';
                                        }
                                        if ($result['state'] != '') {
                                            echo $result['state'] . ', ';
                                        }
                                        if ($result['country'] != '') {
                                            echo $result['country'];
                                        }
                                        echo "</small></p>";
                                    }
                                    ?>
                                    <p>
                                        <?php
                                        if (strlen($result['description']) > 230)
                                            echo substr(strip_tags($result['description']), 0, 230) . '...';
                                        else
                                            echo $result['description'];
                                        ?>
                                    </p>
                                    <a href="<?php echo $visit_url ?>" class="visit-btn"><?php echo $visit_txt ?></a>
                                </div>
                            </li>
                            <?php
                        }
                    }else {
                        ?>
                        <p class="no-data">No records available</p>
                    <?php }
                    ?>
                </ul>
            </div>
            <div class="paggination-wrap">
                <?php echo $links ?>
            </div>
            <div class="funeral-r" style="display:none;">
                <div class="profile-box fun-facts">
                    <h2>Search for Service Providers</h2>
                    <ul class="srvs-list-ul srvs_profile srvs_right">
                        <li>
                            <span><img src="assets/images/flowers.jpg"></span>
                            <p>Find service providers such as funeral homes, churches, florists, caterers and more..</p>
                        </li>
                    </ul>
                    <div class="btn_pr">
                        <a href="<?php echo site_url('service_provider') ?>" class="btn-link plannig-service-btn">Search Now</a>
                    </div>
                </div>
                <div class="profile-box fun-facts">
                    <h2>Create a Life Profile</h2>
                    <ul class="srvs-list-ul srvs_profile srvs_right">
                        <li>
                            <span><img src="assets/images/oldladi.png"></span>
                            <p>Memorialize your loved  one’s life story with words, pictures, video, timeline and more.</p>
                        </li>
                    </ul>
                    <div class="btn_pr">
                        <?php if ($this->is_user_loggedin) { ?>
                            <a href="<?php echo site_url('profile/create_profile') ?>" class="btn-link">Create a life profile</a>
                        <?php } else { ?>
                            <a href="javascript:void(0)" onclick="loginModal(this)" data-redirect="<?php echo site_url('profile/create_profile') ?>"  class="btn-link">Create a life profile</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="section_blog_post">
                    <h2>Life Profile Blog Posts</h2>
                    <p>Benefits of Life Profile</p>
                    <div class="btn_pr"><a href="<?php echo site_url('blog') ?>" class="btn-link color-01">Read More</a></div>
                </div>
                <!--<div class="profile-box ad pro_ad_custom"></div>-->
            </div>
        </div>
        <?php
        $segment = $this->uri->segment(2);
        if ($segment != '') {
            $page = $segment / 12;
            $page = $page + 1;
        } else {
            $page = 1;
        }
        ?>
        <?php if ($page == 1 || $page % 3 == 1) { ?> 
            <div class="share-memories" id="div-1">
                <div class="share-memories-l">
                    <a href="<?php echo site_url('profile/create_profile') ?>"><img src="assets/images/create_profile.jpeg" width="230px"></a>
                </div>
                <div class="share-memories-r">
                    <h3><a href="<?php echo site_url('profile/create_profile') ?>">Create a beautiful online memorial Life Profile of a loved one to preserve and share memories.</a></h3>
                    <p>Share his/her life story vividly, share funeral services information, share and receive memories with stories and pictures and videos, get financial help with a memorial fundraiser, and more.</p>
                    <em>A great way to honor your loved one’s life.</em>
                    <a href="<?php echo site_url('profile/create_profile') ?>" class="get-btn">Get Started</a>
                </div>
            </div>
        <?php } else if ($page == 2 || $page % 3 == 2) { ?>
            <div class="share-memories" id="div-2">
                <div class="share-memories-l">
                    <a href="<?php echo site_url('profile/create_profile') ?>"><img src="assets/images/tribute_image.jpeg" width="230px"></a>
                </div>
                <div class="share-memories-r">
                    <h3><a href="<?php echo site_url('profile/create_profile') ?>">Create a Tribute Fundraiser to get the financial help you need during a difficult time.</a></h3>
                    <p>Easily create a fundraiser as a part of your loved one's memorial Life Profile to get donations from family and friends. This can help with funeral expenses, go to the benefit of your loved one's cause, or other uses. Family and friends will be honored to support.</p>
                    <a href="<?php echo site_url('profile/create_profile') ?>" class="get-btn">Get Started</a>
                </div>
            </div>
        <?php } else if ($page == 3 || $page % 3 == 0) { ?>
            <div class="share-memories" id="div-3">
                <div class="share-memories-l">
                    <a href="<?php echo site_url('flowers') ?>"><img src="assets/images/flowers.jpg"></a>
                </div>
                <div class="share-memories-r">
                    <h3><a href="<?php echo site_url('flowers') ?>">Need to send flowers to show your love and support, and express sympathy.</a></h3>
                    <p>Easily send flowers to anywhere in the US or Canada right here from Remember Always.</p>
                    <a href="<?php echo site_url('flowers') ?>" class="get-btn">Send flowers</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    $("#content-8").mCustomScrollbar({
        axis: "y",
        scrollButtons: {enable: true},
        theme: "3d"
    });
    //-- Prevent form submission on change event
//    $('#search_type').change(function () {
//        $('#search_form').submit();
//    });
    $("#general-search-keyword,#general-search-location").keydown(function (e) {
        var value = e.keyCode;
        if (value == 13) {
            $('#search_form').submit();
        }
    });
</script>
