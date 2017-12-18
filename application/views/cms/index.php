<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title"><?php echo isset($page_data['title']) ? $page_data['title'] : '' ?></h2>
        </div>

        <!--<div style="background-image: url('<?php // echo PAGE_BANNER.'/'.$page_data['banner_image']    ?>');" class="hero-image-inner">-->

        <div class="common-body about">
            <?php if (isset($page_data['banner_image']) && !is_null($page_data['banner_image'])) { ?>
                <img src="<?php echo PAGE_BANNER . '/' . $page_data['banner_image'] ?>" alt="" />
            <?php } ?>
            <?php echo $page_data['description'] ?>
        </div>
    </div>
</div>
