<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Find A Life Profile</h2>
        </div>
        <div class="common-body">
            <form action="<?php echo site_url('search') ?>" id="search_form">
                <div class="services-form funeral-srh search_new_design">
                    <div class="srvs-form-div">
                        <input type="text" name="keyword" id="general-search-keyword" placeholder="Enter Keyword" class="input-css" value="<?php echo $this->input->get('keyword') ?>"/>
                    </div>
                    <div class="srvs-form-div">	
                        <input type="text" name="location" id="general-search-location" placeholder="Location" class="input-css" value="<?php echo $this->input->get('location') ?>"/>
                    </div>
                    <div class="srvs-form-div">	
                        <button type="submit" class="global_search">Search</button>
                    </div>
                </div>
                <div class="funeral-l">
                    <div class="profile-box">
                        <h2>Search Results / Life Profile Search Results
                            <select name="type" id="search_type" class="input-css">
                                <option value="profile" <?php if ($this->input->get('type') == 'profile') echo 'selected'; ?>>Profile</option>
                                <option value="service_provider" <?php if ($this->input->get('type') == 'service_provider') echo 'selected'; ?>>Service Provider</option>
                                <option value="affiliation" <?php if ($this->input->get('type') == 'affiliation') echo 'selected'; ?>>Affiliations</option>
                                <option value="blog" <?php if ($this->input->get('type') == 'blog') echo 'selected'; ?>>Blog</option>
                                <option value="all" <?php if ($this->input->get('type') == 'all' || $this->input->get('type') == '') echo 'selected'; ?>>All</option>
                            </select>
                        </h2>
                        <div class="comments-div comments_div_profile" id="content-8">
                            <ul class="srvs-list-ul srvs_profile">
                                <?php
                                if (!empty($results)) {
                                    foreach ($results as $key => $result) {
                                        ?>
                                        <li>
                                            <span>
                                                <div class="add_tag">
                                                    <?php
                                                    $tag_class = '';
                                                    if ($result['type'] == 'profile') {
                                                        $tag_class = 'tag-profile';
                                                        if ($result['image'] != '') {
                                                            echo "<img src='" . PROFILE_IMAGES . $result['image'] . "' alt='' class='profile-exif-img'>";
                                                        } else {
                                                            echo "<img src='assets/images/no_image.png' alt='' width='100%'>";
                                                        }
                                                    } elseif ($result['type'] == 'service_provider') {
                                                        $tag_class = 'tag-services';
                                                        if ($result['image'] != '') {
                                                            echo "<img src='" . PROVIDER_IMAGES . $result['image'] . "' alt=''>";
                                                        } else {
                                                            echo "<img src='assets/images/no_image.png' alt='' width='100%'>";
                                                        }
                                                    } elseif ($result['type'] == 'affiliation') {
                                                        $tag_class = 'tag-affiliation';
                                                        if ($result['image'] != '') {
                                                            echo "<img src='" . AFFILIATION_IMAGE . $result['image'] . "' alt=''>";
                                                        } else {
                                                            echo "<img src='assets/images/no_image.png' alt='' width='100%'>";
                                                        }
                                                    } elseif ($result['type'] == 'blog') {
                                                        $tag_class = 'tag-blog';
                                                        if ($result['image'] != '') {
                                                            echo "<img src='" . BLOG_POST_IMAGES . $result['image'] . "' alt=''>";
                                                        } else {
                                                            echo "<img src='assets/images/no_image.png' alt='' width='100%'>";
                                                        }
                                                    }
                                                    ?>
                                                    <div class="<?php echo $tag_class ?>"></div>
                                                </div>
                                            </span>
                                            <h3>
                                                <?php
                                                if ($result['type'] == 'profile') {
                                                    echo "<a href='" . site_url('profile/' . $result['slug']) . "'>" . $result['name'] . "</a>";
                                                } else if ($result['type'] == 'service_provider') {
                                                    echo "<a href='" . site_url('service_provider/view/' . $result['slug']) . "'>" . $result['name'] . "</a>";
                                                } else if ($result['type'] == 'affiliation') {
                                                    echo "<a href='" . site_url('affiliation/view/' . $result['slug']) . "'>" . $result['name'] . "</a>";
                                                } else if ($result['type'] == 'blog') {
                                                    echo "<a href='" . site_url('blog/details/' . $result['slug']) . "'>" . $result['name'] . "</a>";
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
                                                if (strlen($result['description']) > 90)
                                                    echo substr(strip_tags($result['description']), 0, 90) . '...';
                                                else
                                                    echo $result['description'];
                                                ?>
                                            </p>
                                            <!--<p>Omega psi , jerblue</p>-->
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
                    </div>
                </div>
            </form>
            <div class="funeral-r">
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
                            <a href="<?php echo site_url('profile/create') ?>" class="btn-link">Create a life profile</a>
                        <?php } else { ?>
                            <a href="javascript:void(0)" onclick="loginModal(this)" data-redirect="http://clientapp.narola.online/HD/remember-always/profile/create"  class="btn-link">Create a life profile</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="section_blog_post">
                    <h2>Life Profile Blog Posts</h2>
                    <p>Benefits of Life Profile</p>
                    <div class="btn_pr"><a href="<?php echo site_url('blog') ?>" class="btn-link color-01">Read More</a></div>
                </div>
                <script type="text/javascript">
                    clicksor_mobile_redirect = false;
                    //default banner house ad url 
                    clicksor_default_url = '';
                    clicksor_banner_border = '#805066';
                    clicksor_banner_ad_bg = '#FFFFFF';
                    clicksor_banner_link_color = '#000000';
                    clicksor_banner_text_color = '#666666';
                    clicksor_banner_image_banner = true;
                    clicksor_banner_text_banner = true;
                    clicksor_layer_border_color = '#805066';
                    clicksor_layer_ad_bg = '#FFFFFF';
                    clicksor_layer_ad_link_color = '#000000';
                    clicksor_layer_ad_text_color = '#666666';
                    clicksor_text_link_bg = '';
                    clicksor_text_link_color = '';
                    clicksor_enable_text_link = false;
                    clicksor_layer_banner = false;
                </script>
                <script type="text/javascript" src="https://b.clicksor.net/show.php?nid=1&amp;pid=389555&amp;adtype=7&amp;sid=652028"></script>
                <!--<div class="profile-box ad pro_ad_custom"></div>-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
                    $("#content-8").mCustomScrollbar({
                        axis: "y",
                        scrollButtons: {enable: true},
                        theme: "3d"
                    });
                    $('#search_type').change(function () {
                        $('#search_form').submit();
                    });
                    $("#general-search-keyword,#general-search-location").keydown(function (e) {
                        var value = e.keyCode;
                        if (value == 13) {
                            $('#search_form').submit();
                        }
                    });
</script>
