<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Services Provider Directory</h2>
            <a href="" class="pspl">Post a Services Provider Listing</a>
        </div>
        <div class="common-body">
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
                            <li><a href="<?php echo site_url('service_provider') ?>">All Service Providers</a></li>
                            <?php
                            if (isset($service_categories) && !empty($service_categories)) {
                                foreach ($service_categories as $key => $value) {
                                    ?>
                                    <li><a href="<?php echo site_url('service_provider?category=' . $value['name']) ?>"><?php echo $value['name'] ?></a></li>
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