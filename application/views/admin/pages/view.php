<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-magazine position-left"></i>  Pages</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/pages'); ?>"><i class="icon-magazine position-left"></i> Pages</a></li>
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
                <!--            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <i class="icon-magazine position-left"></i>
                                    <strong><?php // echo isset($page_data['navigation_name']) ? $page_data['navigation_name'] : ''   ?></strong> &nbsp;&nbsp;Page Details</h6>
                                <a class="heading-elements-toggle"><i class="icon-more"></i></a>
                            </div>-->
                <div class="panel-heading " role="tab" id="heading1">
                    <h4 class="panel-title">
                        <?php echo isset($page_data['navigation_name']) ? $page_data['navigation_name'] : '' ?> Page Details
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
                                    <th class="text-nowrap">Navigation Name :</th>
                                    <td><?php echo isset($page_data['navigation_name']) ? $page_data['navigation_name'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Page Title :</th>
                                    <td><?php echo isset($page_data['title']) ? $page_data['title'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Status :</th>
                                    <td><?php echo isset($page_data['active']) && $page_data['active'] == '1' ? '<span class="label bg-success-400">Active</span>' : '<span class="label bg-grey-400">In-Active</span>' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">SEO Meta title :</th>
                                    <td><?php echo isset($page_data['meta_title']) ? $page_data['meta_title'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">SEO Meta keyword :</th>
                                    <td><?php echo isset($page_data['meta_keyword']) ? $page_data['meta_keyword'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">SEO Meta Description :</th>
                                    <td><?php echo isset($page_data['meta_description']) ? $page_data['meta_description'] : '' ?></td>
                                </tr>
                                <?php if (isset($page_data['banner_image']) && !empty($page_data['banner_image']) && !is_null($page_data['banner_image'])) { ?>
                                    <tr>
                                        <th class="text-nowrap custom_align_top">Banner Image :</th>
                                        <td><a class="fancybox" href="<?php echo base_url(PAGE_BANNER . $page_data['banner_image']) ?>" data-fancybox-group="gallery" ><img src="<?php echo base_url(PAGE_BANNER . $page_data['banner_image']) ?>" height="100px" width="170px"></img></a></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th class="text-nowrap custom_align_top">Description :</th>
                                    <td><?php echo isset($page_data['description']) ? $page_data['description'] : '' ?></td>
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
