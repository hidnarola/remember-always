<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Services Provider Directory</h2>
            <a href="" class="pspl">Post a Services Provider Listing</a>
        </div>
        <div class="common-body">
            <div class="services-form">
                <form method="get" name="provider_form" id="provider_form">
                    <div class="srvs-form-div">
                            <select name="category" id="category" class="selectpicker">
                            <option value="">-- Select Category --</option>
                            <?php
                            if (isset($service_categories) && !empty($service_categories)) {
                                foreach ($service_categories as $key => $value) {
                                    $selected = '';
                                    if (isset($_GET['category']) && $_GET['category'] == $value['name']) {
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option <?php echo $selected; ?> value="<?php echo $value['name'] ?>"><?php echo $value['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="srvs-form-div">
                        <input type="text" name="keyword" placeholder="Enter Keyword" class="input-css" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : set_value('keyword') ?>"/>
                    </div>
                    <div class="srvs-form-div">	
                        <input type="text" name="location" placeholder="Location" class="input-css" value="<?php echo set_value('location') ?>"/>
                    </div>
                    <div class="srvs-form-div">	
                        <button type="submit"  name="provider_search_btn" id="provider_search_btn"  class="next">Search</button>
                    </div>	
                </form>
            </div>
            <div class="services-pro-l">
                <div class="profile-box services-listings">
                    <h2>Services Listing</h2>
                    <ul class="srvs-list-ul">
                        <?php
                        if (isset($services) && !empty($services)) {
                            foreach ($services as $key => $value) {
                                ?>
                                <li>
                                    <span> 
                                        <?php
                                        if (isset($value['image']) && !is_null($value['image'])) {
                                            ?>
                                            <img src="<?php echo PROVIDER_IMAGES . $value['image'] ?>" width="100%" height="100%"/>
                                        <?php } ?>
                                    </span>
                                    <h3><a href="javascript:void(0)"><?php echo $value['name'] ?></a></h3>
                                    <p><?php echo $value['description'] ?></p>
                                </li>

                                <?php
                            }
                        } else {
                            ?>
                            <li>No Services available</li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="services-pro-r">
                <div class="profile-box services-ctgr affiliations">
                    <h2>Services Categories</h2>
                    <div class="profile-box-body">
                        <ul>
                            <li><a href="<?php echo site_url('service_provider') ?>" class="<?php echo!isset($_GET['category']) ? 'active' : '' ?>">All Service Providers</a></li>
                            <?php
                            if (isset($service_categories) && !empty($service_categories)) {
                                foreach ($service_categories as $key => $value) {
                                    ?>
                                    <li><a href="<?php echo site_url('service_provider?category=' . $value['name']) ?>" class="<?php echo isset($_GET['category']) && $_GET['category'] == $value['name'] ? 'active' : '' ?>"><?php echo $value['name'] ?></a></li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li>No Services Categories available.</li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="services-pro-m">
                <div class="profile-box ad">
                    <a href=""><img src="assets/images/ad.jpg" alt=""></a>
                </div>
                <div class="profile-box ad">
                    <a href=""><img src="assets/images/ad.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>

