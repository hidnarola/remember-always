<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title"><?php echo isset($title) ? $title : 'Dashboard' ?></h2>
            <!--<a href="" class="pspl">Post a Services Provider Listing</a>-->
        </div>
        <div class="common-body">
            <div class="mypost-l">
                <div class="profile-box services-ctgr affiliations">
                    <h2>Dashboard Links</h2>
                    <div class="profile-box-body">
                        <ul>
                            <li><a href="<?php echo site_url('dashboard/profiles') ?>" <?php echo (isset($slug) && ($slug == '' || $slug == 'profiles')) ? 'class="active"' : '' ?>>My Profiles</a></li>
                            <li><a href="<?php echo site_url('dashboard/affiliations') ?>" <?php echo (isset($slug) && ($slug == 'affiliations')) ? 'class="active"' : '' ?>>Affiliations</a></li>
                            <li><a href="<?php echo site_url('editprofile') ?>">Edit Profile </a></li>
                            <li><a href="<?php echo site_url('logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mypost-r">
                <div class="profile-box services-listings" id="profiles" <?php echo (isset($slug) && ($slug == '' || $slug == 'profiles')) ? 'style="display:block;"' : 'style="display:none"' ?>>
                    <h2>My Profiles</h2>
                    <?php if (isset($profiles) && !empty($profiles)) { ?>
                        <ul class="srvs-list-ul">
                            <?php foreach ($profiles as $key => $val) { ?>
                                <li>
                                    <span></span>
                                    <h3><a href=""><?php echo $val['firstname'] . ' ' . $val['lastname'] . ' (' . $val['nickname'] . ')' ?></a></h3>
                                    <p><?php echo $val['life_bio'] ?></p>
                                    <div class="user-update">
                                        <a href="javascript:void(0)" class="edit">Edit </a>
                                        <?php if ($val['is_published'] == 0) { ?>
                                            <a href="javascript:void(0)" class="public publish" data-profile="<?php echo $val['slug'] ?>">Publish</a>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="no-data">No profiles are created.</p>
                    <?php } ?>

                </div>
                <div class="profile-box services-listings" id="affiliations" <?php echo (isset($slug) && ($slug == 'affiliations')) ? 'style="display:block;"' : 'style="display:none"' ?>>
                    <h2>Affiliations</h2>
                    <?php if (isset($affiliations) && !empty($affiliations)) { ?>
                        <ul class="srvs-list-ul">
                            <?php foreach ($affiliations as $key => $val) { ?>
                                <li>
                                    <span>
                                        <?php
                                        if (isset($val['image']) && $val['image'] != '') {
                                            echo "<img src='" . AFFILIATION_IMAGE . $val['image'] . "' style='width:170px;'>";
                                        }
                                        ?>
                                    </span>
                                    <h3><a href=""><?php echo $val['name'] . ' (' . $val['category_name'] . ')' ?></a></h3>
                                    <p><?php echo $val['description'] ?></p>
                                    <div class="user-update">
                                        <a href="<?php echo site_url('affiliation/edit/' . $val['slug']) ?>" class="edit">Edit </a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="no-data">No profiles are created.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var current_url = '<?php echo site_url($_SERVER['PATH_INFO']); ?>';
    $(document).on('click', ".publish", function () {
        var id = $(this).data("profile");
        var url = 'dashboard/profile_publish/' + id;
        swal({
            title: "Are you sure?",
            text: "You want to publish this profile",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
//            focusConfirm:true,
            focusCancel: true,
//          reverseButtons: true,
        }).then(function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                    }
                });
                window.location.href = current_url;
                return true;
            }
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal("Cancelled", "Your profile is not published. :)", "error");
            }
        });
        return false;
    });
</script>