<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Affiliations</h2>
        </div>
        <div class="common-body akk">
            <?php if ($affiliation['image'] != null) { ?>
                <div class="srvs-dtl-l">
                    <img src="<?php echo AFFILIATION_IMAGE . $affiliation['image'] ?>" />
                </div>
            <?php } ?>
              <div class="srvs-dtl-r <?php echo ($affiliation['image'] == null) ? 'full-width': ''?>">
                <h3><?php echo isset($affiliation['name']) ? $affiliation['name'] : '' ?> <?php echo isset($affiliation['category_name']) ? '(' . $affiliation['category_name'] . ')' : '' ?>
                </h3>
                <p><?php implode('</p><p>', array_filter(explode("\n", $affiliation['description']))) ?></p>
                <div class="srvs-personal-dtl">
                    <h6 class="srvs-contact"><strong>Country :</strong> <a><?php echo isset($affiliation['country_name']) ? $affiliation['country_name'] : '' ?></a></h6>
                    <h6 class="srvs-contact"><strong>State :</strong> <a><?php echo isset($affiliation['state_name']) ? $affiliation['state_name'] : '' ?></a></h6>
                    <h6 class="srvs-contact"><strong>City :</strong> <a><?php echo isset($affiliation['city_name']) ? $affiliation['city_name'] : '' ?></a></h6>
                </div>

                <div class="srvs-personal-dtl profile-css-div">
                    <h6 class="srvs-contact"><strong>Profile :</strong>
                    </h6>
                </div>
                <?php if (isset($profiles) && !empty($profiles)) { ?>
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

