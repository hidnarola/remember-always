<script type="text/javascript" src="<?php echo "assets/admin/js/plugins/tables/datatables/datatables.min.js"; ?>"></script>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Home Slider List</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/home_slider'); ?>"><i class="icon-stack position-left"></i> Home Slider List</a></li>
            <li class="active"><i class="icon-comment-discussion position-left"></i><?php echo $heading; ?></li>
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
        <div class="panel panel-flat border-top-xlg border-top-info">
            <div class="panel-heading">

                <!--                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="reload"></a></li>
                                        <li><a data-action="close"></a></li>
                                    </ul>
                                </div>-->
                <a class="heading-elements-toggle"><i class="icon-more"></i></a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="panel-title">
                            <i class="icon-image4 position-left"></i>
                            Slider Image :</h6>
                    </div>
                    <div class="col-md-8">
                        <h6 class="content-group">
                            <i class="icon-stack-text position-left"></i>
                            Slider  Description :
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <?php
                        if (isset($slider) && $slider['image'] != '') {
                            if (preg_match("/\.(png|jpg|jpeg)$/", $slider['image'])) {
                                ?>
                                <a class="fancybox" href="<?php echo SLIDER_IMAGES . $slider['image']; ?>" data-fancybox-group="gallery" ><img src="<?php echo SLIDER_IMAGES . $slider['image']; ?>" class="img-responsive content-group" alt=""></a>
                            <?php } else {
                                ?>
                                <img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" class="img-responsive content-group" alt="">
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <div class="col-md-8">
                        <blockquote>
                            <p>
                                <?php echo isset($slider) ? $slider['description'] : '' ?>
                            </p>
                        </blockquote>
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
