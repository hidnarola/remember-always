<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title"><?php echo isset($page_data['title']) ? $page_data['title'] : '' ?></h2>
        </div>
        <div class="common-body about">
            <?php if (isset($page_data['banner_image']) && !is_null($page_data['banner_image'])) { ?>
                <div class="cms-banner-img">
                    <img src="<?php echo PAGE_BANNER . $page_data['banner_image'] ?>" alt="<?php echo ($page_data['slug'] == 'about') ? 'Remember Always family looking at photos on a tablet' : ($page_data['slug'] == 'features') ? 'Remember Always family looking at photo' : '' ?>" />
                </div>
            <?php } ?>
            <div class="cms-content">
                <?php echo $page_data['description'] ?>
            </div>
        </div>
    </div>
</div>
