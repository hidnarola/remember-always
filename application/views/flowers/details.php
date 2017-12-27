<?php
$categories = '';
$data = array_column($flower->CATEGORIES, 'DISPLAY');
?>
<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title"><?php echo isset($title) ? $title : 'Flower Details' ?></h2>

        </div>
        <div class="common-body common-body-listing_profile">
            <div class="profile_section_wrapper">
                <div class="profile_detail_left">
                    <div id="item_image">
                        <img src="<?php echo $flower->LARGE ?>">
                    </div>
                </div>
                <div class="profile_detail_right">
                    <h2 class="item_name"><?php echo $flower->NAME ?></h2>
                    <p class="item_code">Item No. <?php echo $flower->CODE ?></p>
                    <p class="item_description"><?php echo $flower->DESCRIPTION ?></p>
                    <p class="item_code">Categories: <?php echo !empty($data) ? implode(',',$data) : '-' ?></p>
                    <p class="item_price">$<?php echo $flower->PRICE ?></p>
                    <p class="comment-btm">
                        <button class="manage_cart" data-item="<?php echo $flower->CODE ?>">Add To Cart</button>
                    </p>
                </div>
            </div>	
        </div>
    </div>
</div>