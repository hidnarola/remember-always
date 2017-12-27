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
        <div class="col-md-10 col-md-offset-1">
            <div class="panel border-top-xlg border-top-info panel-white">
                <div class="panel-heading " role="tab" id="heading1">
                    <h4 class="panel-title">
                        <?php echo isset($user_data['firstname']) ? $user_data['firstname'] . ' ' . $user_data['lastname'] : 'User' ?> Details
                        <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1" aria-expanded="true" aria-controls="collapse1" class="pull-right">
                            <i class="solsoCollapseIcon fa fa-chevron-up"></i>	
                        </a>
                    </h4>
                </div>
                <div class="panel-body">
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
                                    <th class="text-nowrap">Phone :</th>
                                    <td>
                                        <?php echo isset($user_data['phone']) && !is_null($user_data['phone']) ? $user_data['phone'] : '-' ?>
                                    </td>
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
                                    <th class="text-nowrap">Address 1 :</th>
                                    <td>
                                        <?php echo isset($user_data['address1']) && !is_null($user_data['address1']) ? $user_data['address1'] : '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Address 2 :</th>
                                    <td>
                                        <?php echo isset($user_data['address2']) && !is_null($user_data['address2']) ? $user_data['address2'] : '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Country :</th>
                                    <td>
                                        <?php echo isset($user_data['country']) && !is_null($user_data['country']) ? $user_data['country_name'] : '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">State :</th>
                                    <td>
                                        <?php echo isset($user_data['state']) && !is_null($user_data['state']) ? $user_data['state_name'] : '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">City :</th>
                                    <td>
                                        <?php echo isset($user_data['city']) && !is_null($user_data['city']) ? $user_data['city_name'] : '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Zipcode :</th>
                                    <td>
                                        <?php echo isset($user_data['zipcode']) && !is_null($user_data['zipcode']) ? $user_data['zipcode'] : '-' ?>
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
