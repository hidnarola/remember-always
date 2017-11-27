<script type="text/javascript" src="<?php echo "assets/admin/js/plugins/tables/datatables/datatables.min.js"; ?>"></script>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Service Category List</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active"><i class="icon-list-unordered position-left"></i> Service Category List </li>
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
    <!-- Content area -->
    <div class="content">
        <!-- /content area -->
        <div class="content">
            <div class="panel panel-flat">
                <div class="message alert alert-danger" style="display:none"></div>
                <div class="panel-heading text-right">
                    <a href="<?php echo site_url('admin/categories/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-plus3"></i></b> Add Category</a>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th >Name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $this->load->view('Templates/admin_footer');
        ?>
    </div>
    <div class='modal fade ' id='showproduct' tabindex='-1'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&cross;</button>
                    <h4 class='modal-title' id='myModalLabel'>Confirmation</h4>
                </div>
                <div class='modal-body'>
                    <span>Are you sure you want to Hide this product ?</span>
                    <div class='modal-footer'>
                        <button class='btn btn-default' data-dismiss='modal' type='button'>Close</button>
                        <button class='btn btn-primary show_prod'  type='button'>Hide</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('.datatable-basic').dataTable({
                scrollX: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
                },
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                order: [[0, "asc"]],
                ajax: 'admin/categories/get_categories',
                columns: [
                    {
                        data: "test_id",
                        visible: true,
                        searchable: false,
                        sortable: false,
                    },
                    {
                        data: "name",
                        visible: true,
                    },
                    {
                        data: "id",
                        visible: true,
                        searchable: false,
                        sortable: false,
                        render: function (data, type, full, meta) {
                            var action = '<td class="text-center"><ul class="icons-list"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a><ul class="dropdown-menu dropdown-menu-right">';
                            if (full.hide_product == 0) {
                                action += '<li><a href="javascript:void(0)" id="prod_id_' + full.id + '" class="hide_info" title="Hide" prod_id="' + full.id + '"><i class="fa fa-eye-slash"></i>Hide</a></li>';
                            } else {
//                                action += '<li><a href="javascript:void(0)" onclick="pause_campaign(' + full.id + ',\'activate\')" title="Edit"><i class="icon-play4"></i>Show</a></li>';
                                action += '<li><a href="javascript:void(0)" id="show_prod_' + full.id + '" class="show_info" title="Hide" prod_id="' + full.id + '"><i class="fa fa-eye"></i>Show</a></li>';
                            }
                            action += '</ul></li></ul></td>';
                            return action;
                        }
                    }
                ]
            });
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });
        });
//        $(document).on("click", ".hide_info", function (e) {
//            var id = $(this).attr("prod_id");
//            $('#hideproduct').modal('show');
//            $('.hide_prod').on('click', function () {
//                $.ajax({
//                    type: "POST",
//                    url: "product/hide/" + id,
//                    success: function (data) {
//                        $('#hideproduct').modal('hide');
//                        location.reload();
//                    }
//                });
//            });
//            return false;
//        });
//        $(document).on("click", ".show_info", function (e) {
//            var id = $(this).attr("prod_id");
//            $('#showproduct').modal('show');
//            $('.show_prod').on('click', function () {
//                $.ajax({
//                    type: "POST",
//                    url: "product/show/" + id,
//                    success: function (data) {
//                        $('#showproduct').modal('hide');
//                        location.reload();
//                    }
//                });
//            });
//            return false;
//        });
    </script>
