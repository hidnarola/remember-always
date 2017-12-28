<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Find A Life Profile</h2>
        </div>
        <div class="common-body">
            <div class="services-form">
                <form>
                    <div class="srvs-form-div">
                        <select name="type" class="selectpicker">
                            <option value="profile" <?php if ($this->input->get('type') == 'profile') echo 'selected'; ?>>Profile</option>
                            <option value="service_provider" <?php if ($this->input->get('type') == 'service_provider') echo 'selected'; ?>>Service Provider</option>
                            <option value="affiliation" <?php if ($this->input->get('type') == 'affiliation') echo 'selected'; ?>>Affiliations</option>
                            <option value="blog" <?php if ($this->input->get('type') == 'blog') echo 'selected'; ?>>Blog</option>
                            <option value="all" <?php if ($this->input->get('type') == 'all') echo 'selected'; ?>>All</option>
                        </select>
                    </div>
                    <div class="srvs-form-div">
                        <input type="text" name="keyword" placeholder="Enter Keyword" class="input-css" value="<?php echo $this->input->get('keyword') ?>"/>
                    </div>
                    <div class="srvs-form-div">	
                        <input type="text" name="location" placeholder="Location" class="input-css" value="<?php echo $this->input->get('location') ?>"/>
                    </div>
                    <div class="srvs-form-div">	
                        <button type="submit" class="next global_search">Search</button>
                    </div>	
                </form>
            </div>
            <div class="srh-list">
                <ul>
                    <?php foreach ($results as $key => $result) { ?>
                        <li>
                            <div class="srh-list-box">
                                <div class="srh-list-img">
                                    <!--<a href=""><img src="assets/images/helpful-img.jpg" alt="" /></a>-->
                                    <?php
                                    $tag_class = '';
                                    if ($result['type'] == 'profile') {
                                        $tag_class = 'tag-profile';
                                        if ($result['image'] != '') {
                                            echo "<img src='" . PROFILE_IMAGES . $result['image'] . "' alt=''>";
                                        } else {
                                            echo "<img src='assets/images/no_image.png' alt=''>";
                                        }
                                    } elseif ($result['type'] == 'service_provider') {
                                        $tag_class = 'tag-services';
                                        if ($result['image'] != '') {
                                            echo "<img src='" . PROVIDER_IMAGES . $result['image'] . "' alt=''>";
                                        } else {
                                            echo "<img src='assets/images/no_image.png' alt=''>";
                                        }
                                    } elseif ($result['type'] == 'affiliation') {
                                        $tag_class = 'tag-affiliation';
                                        if ($result['image'] != '') {
                                            echo "<img src='" . AFFILIATION_IMAGE . $result['image'] . "' alt=''>";
                                        } else {
                                            echo "<img src='assets/images/no_image.png' alt=''>";
                                        }
                                    } elseif ($result['type'] == 'blog') {
                                        $tag_class = 'tag-blog';
                                        if ($result['image'] != '') {
                                            echo "<img src='" . BLOG_POST_IMAGES . $result['image'] . "' alt=''>";
                                        } else {
                                            echo "<img src='assets/images/no_image.png' alt=''>";
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="srh-list-dtl">
                                    <div class="<?php echo $tag_class ?>"></div>
                                    <h2>
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
                                    </h2>
                                    <p>
                                        <?php
                                        if (strlen($result['description']) > 90)
                                            echo substr($result['description'], 0, 90) . '...';
                                        else
                                            echo $result['description'];
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="paggination-wrap">
                <?php echo $links ?>
            </div>
        </div>
    </div>
</div>