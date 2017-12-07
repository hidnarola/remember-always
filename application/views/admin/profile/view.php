<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-users2 position-left"></i> Users</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users2 position-left"></i> Users</a></li>
            <li class="active"><i class="icon-book position-left"></i><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<!-- /page header -->

<?php
if ($this->session->flashdata('success')) {
    ?>
    <div class="content pt0 flashmsg">
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert">X</a>
            <strong><?= $this->session->flashdata('success') ?></strong>
        </div>
    </div>
    <?php
    $this->session->set_flashdata('success', false);
} else if ($this->session->flashdata('error')) {
    ?>
    <div class="content pt0 flashmsg">
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert">X</a>
            <strong><?= $this->session->flashdata('error') ?></strong>
        </div>
    </div>
    <?php
    $this->session->set_flashdata('error', false);
} else {
    if (!empty(validation_errors())) {
        ?>
        <div class="content pt0 flashmsg">
            <div class = "alert alert-danger">
                <a class="close" data-dismiss="alert">X</a>
                <strong><?php echo validation_errors(); ?></strong>       
            </div>
            <?php
        }
    }
    ?>
    <!-- /content area -->
    <div class="content">
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <?php echo isset($user_data['firstname']) ? $user_data['firstname'] . ' ' . $user_data['lastname'] : 'User' ?> Details
                    </h6>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="reload"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                            <li class="active"><a href="#profile_info" data-toggle="tab">Profile Info</a></li>
                            <li><a href="#highlighted-justified-tab2" data-toggle="tab">Inactive</a></li>
                            <li><a href="#highlighted-justified-tab3" data-toggle="tab">FunFacts</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="profile_info">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered page_details" data-alert="" data-all="189">
                                        <tbody>
                                            <tr>
                                                <th class="text-nowrap">Name :</th>
                                                <td><?php echo isset($user_data['firstname']) ? $user_data['firstname'] . ' ' . $user_data['lastname'] : '' ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap">Email :</th>
                                                <td><?php echo isset($user_data['email']) ? $user_data['email'] : '' ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap">Registration Date :</th>
                                                <td><?php echo isset($user_data['created_at']) && !is_null($user_data['created_at']) ? date('d M Y', strtotime($user_data['created_at'])) : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap">User Type :</th>
                                                <td>
                                                    <?php
                                                    if (isset($user_data['facebook_id']) && !is_null($user_data['profile_image'])) {
                                                        echo 'Facebook User';
                                                    } else if (isset($user_data['google_id']) && !is_null($user_data['profile_image'])) {
                                                        echo 'Google User';
                                                    } else {
                                                        echo 'Normal';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap">Status :</th>
                                                <td>
                                                    <?php echo isset($user_data['is_active']) && $user_data['is_active'] == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-default">InActive</span>' ?>
                                                    <?php echo isset($user_data['is_verify']) && $user_data['is_verify'] == '1' ? '<span class="label label-success">Verified</span>' : '<span class="label label-danger">NotVerified</span>' ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap custom_align_top">Profile :</th>
                                                <td>
                                                    <?php
                                                    if (isset($user_data['profile_image']) && !is_null($user_data['profile_image'])) {
                                                        if (is_null($user_data['facebook_id']) && is_null($user_data['google_id'])) {
                                                            ?>
                                                            <a class="fancybox" href="<?php echo base_url(USER_IMAGES . $user_data['profile_image']); ?>" data-fancybox-group="gallery" ><img src="<?php echo base_url(USER_IMAGES . $user_data['profile_image']); ?>" class="img-responsive content-group" width="100px" height="100px" alt=""></a>
                                                        <?php } else { ?>
                                                            <a class="fancybox" href="<?php echo $user_data['profile_image']; ?>" data-fancybox-group="gallery" ><img src="<?php echo $user_data['profile_image']; ?>" class="img-responsive content-group" width="100px" height="100px" alt=""></a>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" class="img-responsive" width="100px" height="100px" alt="">
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="highlighted-justified-tab2">
                                Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid laeggin.
                            </div>

                            <div class="tab-pane" id="highlighted-justified-tab3">
                                DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg whatever.
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <?php
    $this->load->view('Templates/admin_footer');
    ?>
</div>

<script type="text/javascript">
    $(function () {
        $('.fancybox').fancybox();
    });
</script>
