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
            <li class="active"><i class="icon-stack position-left"></i> Home Slider List </li>
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

        <div class="panel panel-flat">
            <div class="message alert alert-danger" style="display:none"></div>
            <div class="panel-heading text-right">
                <a href="<?php echo site_url('admin/home_slider/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-plus3"></i></b> Add Slider</a>
            </div>
            <table class="table datatable-basic">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
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
//                scrollX: true,
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
                ajax: 'admin/home_slider/get_sliders',
                columns: [
                    {
                        data: "test_id",
                        visible: true,
                        searchable: false,
                        sortable: false,
                        width: "10%"
                    },
                    {
                        data: "image",
                        visible: true,
                        width: "10%",
                        render: function (data, type, full, meta) {
                            var action = '<a class="fancybox" href="<?php echo base_url() . SLIDER_IMAGES ?>' + data + '" data-fancybox-group="gallery" ><img src="<?php echo base_url() . SLIDER_IMAGES ?>' + data + '" style="width: 58px; height: 58px; border - radius: 2px; " alt="' + data + '"></a>';
//                                    var action = '<img src="' + site_url + 'assets/admin/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" alt="">';
                            return action;
                        }
                    },
                    {
                        data: "description",
                        visible: true,
                        width: "55%"
                    },
                    {
                        data: "is_active",
                        visible: true,
                        width: "10%",
                        render: function (data, type, full, meta) {
                            if (data == '1') {
                                var action = '<span class="label label-success">Active</span>';
                            } else {
                                var action = '<span class="label label-default">In-Active</span>';
                            }

                            return action;
                        }
                    },
                    {
                        data: "id",
                        visible: true,
                        searchable: false,
                        sortable: false,
                        width: "12%",
                        render: function (data, type, full, meta) {
                            var action = '<ul class="icons-list">';
//                            action += '<li class="text-primary-600"><a href="' + site_url + 'admin/categories/edit/' + btoa(full.id) + '" title="Edit"><i class="icon-pencil7"></i></a></li>';
                            action += '<li class="text-teal">&nbsp;&nbsp;<a href="' + site_url + 'admin/home_slider/view/' + btoa(full.id) + '" class="btn border-teal text-teal btn-flat btn-rounded btn-icon btn-xs valign-text-bottom" title="View"><i class="icon-eye"></i></a></li>';
                            action += '<li class="text-primary-600">&nbsp;&nbsp;<a href="' + site_url + 'admin/home_slider/edit/' + btoa(full.id) + '" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-xs" title="Edit"><i class="icon-pencil3"></i></a></li>';
                            action += '<li>&nbsp;&nbsp;<a href="' + site_url + 'admin/home_slider/delete/' + btoa(full.id) + '" title="Delete" onclick="return confirm_alert(this)" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded btn-xs"><i class="icon-trash"></i></a>';
                            action += '</ul>';
                            var action = '';
                            action += '<ul class="icons-list">';
                            action += '<li class="dropdown">';
                            action += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                            action += '<i class="icon-menu9"></i>';
                            action += '</a>';
                            action += '<ul class="dropdown-menu dropdown-menu-right">';
                            action += '<li>';
                            action += '<a href="' + site_url + 'admin/home_slider/edit/' + btoa(full.id) + '" title="Edit"><i class="icon-pencil3"></i> Edit slider</a>'
                            action += '<a href="' + site_url + 'admin/home_slider/view/' + btoa(full.id) + '" title="View"><i class="icon-comment-discussion"></i> View slider</a>'
                            if (full.is_active == '1') {
                                action += '<a href="' + site_url + 'admin/home_slider/hide/' + btoa(full.id) + '" onclick="return hide(this)" class="in_active" title="Hide"><i class="icon-eye-blocked"></i> Hide slider</a>'
                            } else {
                                action += '<a href="' + site_url + 'admin/home_slider/show/' + btoa(full.id) + '" id="' + btoa(full.id) + '" onclick="return show(this)" class="active" title="Show"><i class="icon-eye"></i> Show slider</a>'
                            }
                            action += '<a href="' + site_url + 'admin/home_slider/delete/' + btoa(full.id) + '" onclick="return confirm_alert(this)" title="Delete"><i class="icon-trash"></i> Delete slider</a>'
                            action += '</li>';
                            action += '</ul>';
                            action += '</li>';
                            action += '</ul>';
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
        function confirm_alert(e) {
            var id = $(this).attr("cat_id");
            var url = 'admin/home_slider/delete/' + id;
            swal({
                title: "Are you sure?",
                 text: "You will not be able to recover this slider!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plz!",
                focusCancel: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    window.location.href = $(e).attr('href');
                    return true;
                }
            }, function (dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                if (dismiss === 'cancel') {
                    swal("Cancelled", "Your slider is safe :)", "error");
                }
            });
            return false;
        }
        function hide(e) {
           swal({
                title: "Are you sure?",
                text: "You want to hide this slider!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                focusCancel: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    window.location.href = $(e).attr('href');
                    return true;
                }
            }, function (dismiss) {
            });
            return false;
        }
        function show(e) {
           swal({
                title: "Are you sure?",
                text: "You want to show this slider!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                focusCancel: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    window.location.href = $(e).attr('href');
                    return true;
                }
            }, function (dismiss) {
            });
            return false;
        }
        $(function () {
            $('.fancybox').fancybox();
        });
    </script>
