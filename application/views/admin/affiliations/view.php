<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-office position-left"></i> Affiliations</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/affiliations'); ?>"><i class="icon-office"></i> Affiliations</a></li>
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
                        <?php echo isset($affiliation_data['name']) ? $affiliation_data['name'] . "'s" : 'Affiliation' ?>  Details
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
                                    <th class="text-nowrap">Service Category :</th>
                                    <td><?php echo isset($affiliation_data['category_name']) ? $affiliation_data['category_name'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Name :</th>
                                    <td><?php echo isset($affiliation_data['name']) ? $affiliation_data['name'] : '' ?></td>
                                </tr>
                                <?php if (isset($affiliation_data['image']) && !empty($affiliation_data['image']) && !is_null($affiliation_data['image'])) { ?>
                                    <tr>
                                        <th class="text-nowrap custom_align_top">Image :</th>
                                        <td><a class="fancybox" href="<?php echo base_url(AFFILIATION_IMAGE . $affiliation_data['image']) ?>" data-fancybox-group="gallery" ><img src="<?php echo base_url(AFFILIATION_IMAGE . $affiliation_data['image']) ?>" height="100px" width="100px"></img></a></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th class="text-nowrap">Description :</th>
                                    <td><?php echo isset($affiliation_data['description']) ? $affiliation_data['description'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Country :</th>
                                    <td><?php echo isset($affiliation_data['country_name']) ? $affiliation_data['country_name'] : '-' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">State :</th>
                                    <td><?php echo isset($affiliation_data['state_name']) ? $affiliation_data['state_name'] : '-' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">City :</th>
                                    <td><?php echo isset($affiliation_data['city_name']) ? $affiliation_data['city_name'] : '-' ?></td>
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