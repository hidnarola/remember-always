<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-comment position-left"></i> Posts</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-comment position-left"></i> Posts</a></li>
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
                        <?php echo isset($post_data['user_fname']) ? $post_data['user_fname'] . "'s" : '' ?> Post Details
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
                                    <th class="text-nowrap">User Name :</th>
                                    <td><?php echo isset($post_data['user_fname']) ? $post_data['user_fname'] . ' ' . $post_data['user_lname'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Posted Date :</th>
                                    <td><?php echo isset($post_data['p_date']) && !is_null($post_data['p_date']) ? date('d M Y', strtotime($post_data['p_date'])) : '-' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Profile Name :</th>
                                    <td><?php echo isset($post_data['profile_fname']) ? $post_data['profile_fname'] . ' ' . $post_data['profile_lname'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Profile Privacy :</th>
                                    <td><?php echo isset($post_data['privacy']) ? $post_data['privacy'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Profile Type :</th>
                                    <td><?php echo isset($post_data['type']) && $post_data['type'] == '1' ? 'Normal' : (isset($post_data['type']) && $post_data['type'] == '2' ? 'Fundraiser' : '') ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap custom_align_top">Comment :</th>
                                    <td><?php echo isset($post_data['comment']) ? $post_data['comment'] : '-' ?></td>
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
