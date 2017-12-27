<?php
$url = site_url($_SERVER['PATH_INFO']);
$category = '';
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = $_GET['category'];
}
?>
<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title"><?php echo isset($title) ? $title : 'Flowers' ?></h2>
        </div>
        <div class="common-body">
            <div class="mypost-l">
                <div class="profile-box services-ctgr affiliations funneral_flowers">
                    <h2>Flowers categories</h2>
                    <div class="profile-box-body">
                        <ul>
                            <li><a href="<?php echo site_url('flowers'); ?>" class="<?php echo $category == '' ? 'active' : '' ?>">All</a></li>
                            <li role="tab" id="funeral_specific" >
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#funeral_specific_ul" aria-expanded="<?php echo key_exists($category, $categories) ? 'true' : 'false' ?>" aria-controls="funeral_specific" class="<?php echo key_exists($category, $categories) ? 'active collapsed' : '' ?>">Funeral Specific</a>
                                <ul id="funeral_specific_ul" class="sub_ul_custom panel-collapse collapse <?php echo key_exists($category, $categories) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="funeral_specific">
                                    <?php foreach ($categories as $key => $val) { ?>
                                        <li><a href="<?php echo $url . '?category=' . $key ?>" class="<?php echo $category == $key ? 'active' : '' ?>"><?php echo $val ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li role="tab" id="funeralprize_specific" >
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#funeralprize_specific_ul" aria-expanded="<?php echo key_exists($category, $prize_categories) ? 'true' : 'false' ?>" aria-controls="funeralprize_specific" class="<?php echo key_exists($category, $prize_categories) ? 'active collapsed' : '' ?>">Funeral Flowers By Prize</a>
                                <ul id="funeralprize_specific_ul" class="sub_ul_custom panel-collapse collapse <?php echo key_exists($category, $prize_categories) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="funeralprize_specific">
                                    <?php foreach ($prize_categories as $key => $val) { ?>
                                        <li><a href="<?php echo $url . '?category=' . $key ?>" class="<?php echo $category == $key ? 'active' : '' ?>"><?php echo $val ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mypost-r">
                <div class="main_listing_data">
                    <?php if (isset($flowers) && !empty($flowers)) { ?>
                        <ul class="listing_data">
                            <?php foreach ($flowers as $key => $val) {
                                ?>
                                <li>
                                    <div class="listing_inner_div">
                                        <div class="lst_img"><img src="<?php echo $flowers[$key]->SMALL ?>" alt="Arrive In Style" class=""></div>
                                        <h2 class="lst_product_name_xl"><?php echo $flowers[$key]->NAME ?></h2>
                                        <p class="lst_price">$<?php echo $flowers[$key]->PRICE ?>5</p>
                                        <div class="lst_btn">
                                            <a href="<?php echo site_url('flowers/view/').$flowers[$key]->CODE?>" class="lst_info">Info</a>
                                            <a href="javascript:void(0)" class="buy_info manage_cart" data-item="<?php echo $flowers[$key]->CODE ?>">Buy</a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p>No Flowers available.</p>
                    <?php } ?>
                    <div class="paggination-wrap">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>	
                </div>
            </div>
        </div>
    </div>
</div>