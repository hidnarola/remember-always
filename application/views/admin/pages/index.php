<script type="text/javascript" src="<?php echo "assets/admin/js/plugins/tables/datatables/datatables.min.js"; ?>"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-magazine"></i> <span class="text-semibold">Pages</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Pages</li>
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
            <?php
        }
    }
    ?>
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading text-right">
                <a href="<?php echo site_url('admin/pages/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-plus3"></i></b> Add new page</a>
            </div>
            <table class="table datatable-basic">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Navigation Name</th>
                        <th>Display In Header</th>
                        <th>Display In Footer</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <?php $this->load->view('Templates/admin_footer'); ?>
    </div>
    <script>
        $(function () {
            $('.datatable-basic').dataTable({
                processing: true,
                serverSide: true,
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
                },
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                order: [[1, "desc"]],
                ajax: 'admin/pages/get_pages',
                columns: [
                    {
                        data: "test_id",
                        visible: true,
                        searchable: false,
                        sortable: false,
                    },
                    {
                        data: "navigation_name",
                        visible: true
                    },
                    {
                        visible: true,
                        searchable: false,
                        sortable: false,
                        render: function (data, type, full, meta) {
                            var status = '<div class="checkbox"><label><div class="checker"><span class=""><input type="checkbox" class="styled" value="1" data-id="' + btoa(full.id) + '" data-type="show_in_header"></div></label></div>';
                            if (full.show_in_header == 1) {
                                status = '<div class="checkbox"><label><div class="checker"><span class="checked"><input type="checkbox" class="styled" value="1" data-id="' + btoa(full.id) + '" data-type="show_in_header"></span></div></label></div>';
                            }
                            return status;
                        }
                    },
                    {
                        visible: true,
                        searchable: false,
                        sortable: false,
                        render: function (data, type, full, meta) {
                            var status = '<div class="checkbox"><label><div class="checker"><span class=""><input type="checkbox" class="styled" value="1" data-id="' + btoa(full.id) + '" data-type="show_in_footer"></span></div></label></div>';
                            if (full.show_in_footer == 1) {
                                status = '<div class="checkbox"><label><div class="checker"><span class="checked"><input type="checkbox" class="styled" value="1" data-id="' + btoa(full.id) + '" data-type="show_in_footer"></span></div></label></div>';
                            }
                            if (full.is_parent > 0) {
                                status = '';
                            }
                            return status;
                        }
                    },
                    {
                        data: "active",
                        visible: true,
                        searchable: false,
                        sortable: false,
                        render: function (data, type, full, meta) {
                            var status = '<span class="label bg-success">Active</span>';
                            if (data == '0') {
                                status = '<span class="label bg-grey">InActive</span>';
                            }
                            if (data == '2') {
                                status = '<span class="label bg-danger">Deleted</span>';
                            }
                            return status;
                        }
                    },
                    {
                        data: "id",
                        visible: true,
                        searchable: false,
                        sortable: false,
                        width: 200,
                        render: function (data, type, full, meta) {
                            var action = '';
                            if (full.active == '1') {
                                if (btoa(full.id) != 31 && btoa(full.id) != 32) {
                                    action += '<a href="' + site_url + 'admin/pages/edit/' + btoa(full.id)+ '" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm"><i class="icon-pencil3"></i></a>';
                                }
                                action += '&nbsp;&nbsp;<a href="' + site_url + 'admin/pages/delete/' + btoa(full.id) + '" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded" onclick="return confirm_alert(this);"><i class="icon-cross2"></i></a>'
                            } else {
                                action += '<a href="' + site_url + 'admin/pages/activate/' + btoa(full.id) + '" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class="icon-checkmark"></i></a>'
                            }
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
            swal({
                title: "Are you sure?",
                text: "You will be able to recover this page!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF7043",
                confirmButtonText: "Yes, delete it!"
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = $(e).attr('href');
                            return true;
                        } else {
                            return false;
                        }
                    });
            return false;
        }
    </script>