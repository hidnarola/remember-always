<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Blog Details</h2>
        </div>
        <div class="common-body">
            <div class="funeral-l blog-dtl">
                <div class="profile-box">
                    <div class="blog-box">
                        <span><img src="<?php echo BLOG_POST_IMAGES . $blog_data['image'] ?>" alt="" /></span>
                        <div class="blog-content">
                            <h3><a href="<?php echo site_url('blog/details/' . $blog_data['slug']) ?>"><?php echo $blog_data['title'] ?></a></h3>
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
            </div>
        </div>
    </div>
</div>