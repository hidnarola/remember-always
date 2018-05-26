<script src="assets/js/jquery.fancybox.js"></script>
<script src="assets/js/jquery.fancybox.pack.js"></script>
<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Affiliations</h2>
        </div>
        <div class="common-body akk">
            <div class="srvs-dtl-l">
                <?php if ($affiliation['image'] != null) { ?>
                    <img src="<?php echo AFFILIATION_IMAGE . $affiliation['image'] ?>" />
                <?php } else { ?>
                    <img src="assets/images/no_image.png" />
                <?php }
                ?>
            </div>
            <div class="srvs-dtl-r <?php echo ($affiliation['image'] == null) ? 'full-width' : '' ?>">
                <h3>
                    <?php echo isset($affiliation['name']) ? $affiliation['name'] : '' ?> <?php echo isset($affiliation['category_name']) ? '(' . $affiliation['category_name'] . ')' : '' ?>
                </h3>
                <p><i class="fa fa-map-marker"></i>
                    <?php
                    echo isset($affiliation['city_name']) ? $affiliation['city_name'] . ', ' : '';
                    echo isset($affiliation['state_name']) ? $affiliation['state_name'] . ', ' : '';
                    echo isset($affiliation['country_name']) ? $affiliation['country_name'] : ''
                    ?>
                </p>

<!--<p><?php echo implode('</p><p>', array_filter(explode("\n", $affiliation['description']))) ?></p>-->
                <p><?php echo $affiliation['description'] ?></p>
                <!--                <div class="srvs-personal-dtl">
                                    <h6 class="srvs-contact"><strong>Country :</strong> <a><?php ?></a></h6>
                                    <h6 class="srvs-contact"><strong>State :</strong> <a><?php echo isset($affiliation['state_name']) ? $affiliation['state_name'] : '' ?></a></h6>
                                    <h6 class="srvs-contact"><strong>City :</strong> <a><?php echo isset($affiliation['city_name']) ? $affiliation['city_name'] : '' ?></a></h6>
                                </div>-->
                <?php if (isset($profiles) && !empty($profiles)) { ?>
                    <div class="srvs-personal-dtl profile-css-div">
                        <h6 class="srvs-contact"><strong>Profiles:</strong></h6>
                    </div>
                    <ul class="srvs-personal-point">
                        <?php foreach ($profiles as $key => $value) {
                            ?>
                            <li><a href="<?php echo site_url('profile/') . $value['slug'] ?>"><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

