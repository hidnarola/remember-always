<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Blogs</h2>
        </div>
        <div class="common-body">
            <div class="funeral-l blog-l">
                <?php if (isset($blogs) && !empty($blogs)) { ?>
                    <ul class="blog-list-ul">
                        <?php foreach ($blogs as $key => $val) {
                            ?>
                            <li>
                                <div class="blog-box">
                                    <span><a href="<?php echo site_url('blog/details/' . $val['slug']) ?>"><img src="<?php echo BLOG_POST_IMAGES . $val['image'] ?>" alt="" /></a></span>
                                    <div class="blog-content">
                                        <p>by : <?php echo $val['firstname'] . ' ' . $val['lastname'] ?>  - <?php echo date('d-M-Y', strtotime($val['created_at'])); ?></p>
                                        <h3><a href="<?php echo site_url('blog/details/' . $val['slug']) ?>"><?php echo $val['title'] ?></a></h3>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>Blogs are not posted.</p>
                <?php } ?>
                <div class="paggination-wrap">
                    <?php echo $this->pagination->create_links(); ?>
                </div>	
            </div>

            <div class="funeral-r">
                <div class="profile-box affiliations">
                    <h2>Blog</h2>
                    <div class="profile-box-body">
                        <?php if (isset($blog_list) && !empty($blog_list)) { ?>
                            <ul>
                                <?php foreach ($blog_list as $key => $val) {
                                    ?>
                                    <li><a href="<?php echo site_url('blog/details/' . $val['slug']) ?>"><?php echo $val['title'] ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p class="no-data">Blogs are not posted.</p>
                        <?php } ?>
                    </div>
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
                <script type="text/javascript" src="http://b.clicksor.net/show.php?nid=1&amp;pid=389555&amp;adtype=8&amp;sid=652028"></script>
                <!--<div class="profile-box"></div>-->
            </div>
        </div>
    </div>
</div>