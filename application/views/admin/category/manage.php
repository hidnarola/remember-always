<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-plus3"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/categories'); ?>"><i class="icon-list-unordered position-left"></i> Service Categories</a></li>
            <li class="active"><i class="icon-pencil7 position-left"></i><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
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
        </div>
        <?php
    }
}
?>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" id="category_from" method="POST" enctype="multipart/form-data">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="message alert alert-danger" style="display:none"></div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Category Name <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="name" id="name" placeholder="Enter Category Name" class="form-control" value="<?php echo (isset($user_datas['reward_title'])) ? $user_datas['reward_title'] : set_value('reward_title'); ?>">
                            </div>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#category_from').validate();
</script>
<style>
    .image_wrapper{
        height:auto;
        width:auto;
    }
    #imagePreview {
        width: 400px;
        height: 180px;
        background-position: center center;
        background-size: contain;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        display: inline-block;
        float: left;
        margin: 9px;
        background-repeat: no-repeat; 
    }
    #imagePreview_msg {
        width: 100%;
        height: 180px;
        background-position: center center;
        background-size: cover;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    }
    .image_wrapper thumb-inner{
        max-width: auto; 
    }
</style>
