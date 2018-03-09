<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Blog Details</h2>
        </div>
        <div class="common-body">
            <div class="funeral-l blog-dtl">
                <div class="profile-box">
                    <div class="blog-box">
                        <!--<span><a class="fancybox" href="<?php echo base_url(BLOG_POST_IMAGES . $blog_data['image']) ?>" data-fancybox-type="image"><img src="<?php echo BLOG_POST_IMAGES . $blog_data['image'] ?>" alt="" /></a></span>-->
                        <span><img src="<?php echo BLOG_POST_IMAGES . $blog_data['image'] ?>" alt="" /></span>
                        <div class="blog-content">
                            <h3><?php echo $blog_data['title'] ?></h3>
                            <h6>by : <?php echo $blog_data['firstname'] . ' ' . $blog_data['lastname'] ?>  -  <?php echo date('d-M-Y', strtotime($blog_data['created_at'])); ?></h6>
                            <p><?php echo $blog_data['description']; ?></p>
                        </div>
                    </div>
                </div>	
            </div>

            <div class="funeral-r">
                <div class="profile-box affiliations">
                    <h2>Blog</h2>
                    <div class="profile-box-body">
                        <?php if (isset($blogs) && !empty($blogs)) { ?>
                            <ul>
                                <?php foreach ($blogs as $key => $val) {
                                    ?>
                                    <li><a href="<?php echo site_url('blog/details/' . $val['slug']) ?>"><?php echo $val['title'] ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p class="no-data">There are not blogs posted</p>
                        <?php } ?>
                    </div>
                </div>
                <script id="mNCC" language="javascript">
                    medianet_width = "300";
                    medianet_height = "600";
                    medianet_crid = "603212962";
                    medianet_versionId = "3111299";
                </script>
                <script src="//contextual.media.net/nmedianet.js?cid=8CUPCYT30"></script>
            </div>
            <div class="profile-box ad pro_ad_custom">
                <script id="mNCC" language="javascript">
                    medianet_width = "728";
                    medianet_height = "90";
                    medianet_crid = "252046787";
                    medianet_versionId = "3111299";
                </script>
                <script src="//contextual.media.net/nmedianet.js?cid=8CUPCYT30"></script>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
                    $(function () {
                        $(".fancybox")
                                .fancybox({
                                    openEffect: 'none',
                                    closeEffect: 'none',
                                    nextEffect: 'none',
                                    prevEffect: 'none',
                                    padding: 0,
                                });
                    });
</script>