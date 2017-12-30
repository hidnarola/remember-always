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
            <li class="active"><i class="icon-magazine position-left"></i> Pages</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            if ($this->session->flashdata('success')) {
                ?>
                <div class="alert alert-success hide-msg">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <strong><?php echo $this->session->flashdata('success') ?></strong>
                </div>
            <?php } elseif ($this->session->flashdata('error')) {
                ?>
                <div class="alert alert-danger hide-msg">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>                    
                    <strong><?php echo $this->session->flashdata('error') ?></strong>
                </div>
            <?php } elseif (!empty(validation_errors())) { ?>
                <div class="alert alert-danger hide-msg">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>                    
                    <strong><?php echo validation_errors(); ?></strong>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="panel panel-flat">
        <div class="panel-heading text-right">
            <a href="<?php echo site_url('admin/pages/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-plus-circle2"></i></b> Add new page</a>
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
            autoWidth: false,
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
                        return status;
                    }
                },
                {
                    data: "id",
                    visible: true,
                    searchable: false,
                    sortable: false,
                    render: function (data, type, full, meta) {
                        var action = '<ul class="icons-list">';
                        action += '<li class="dropdown">';
                        action += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                        action += '<i class="icon-menu9"></i>';
                        action += '</a>';
                        action += '<ul class="dropdown-menu dropdown-menu-right">';
                        action += '<li>';
                        action += '<a href="' + site_url + 'admin/pages/edit/' + btoa(full.id) + '" title="Edit"><i class="icon-pencil3"></i> Edit page</a>'
                        action += '<a href="' + site_url + 'admin/pages/view/' + btoa(full.id) + '" title="View"><i class="icon-book"></i> View page</a>'
                        if (full.active == '1') {
                            action += '<a href="' + site_url + 'admin/pages/actions/inactive/' + btoa(full.id) + '" onclick="return hide(this)" class="in_active" title="Hide"><i class="icon-eye-blocked"></i> Inactive Page</a>'
                        } else {
                            action += '<a href="' + site_url + 'admin/pages/actions/active/' + btoa(full.id) + '" id="' + btoa(full.id) + '" onclick="return show(this)" class="active" title="Show"><i class="icon-eye"></i> Active page</a>'
                        }
                        action += '<a href="' + site_url + 'admin/pages/actions/delete/' + btoa(full.id) + '" onclick="return confirm_alert(this)" title="Delete"><i class="icon-trash"></i> Delete page</a>'
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
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this page!",
            type: "warning",
            confirmButtonColor: "#FF7043",
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
                swal("Cancelled", "Your page is safe :)", "error");
            }
        });
        return false;
    }

    function hide(e) {
        swal({
            title: "Are you sure?",
            text: "You want to in-activate this page!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
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
            text: "You want to activate this page!",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            confirmButtonColor: "#FF7043",
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

    $(document).on('click', '.styled', function () {
        data_type = $(this).data('type');
        data_id = $(this).data('id');
        if ($(this).parent().attr('class') == 'checked') {
            $(this).parent().removeClass('checked');
            $(this).prop('checked', false);
            value = 0;
        } else {
            $(this).parent().addClass('checked');
            $(this).prop('checked', true);
            value = 1;
        }

        $.ajax({
            url: "<?php site_url() ?>admin/pages/change_data_status",
            data: {type: data_type, id: data_id, value: value},
            type: "POST",
            success: function (result) {
                swal("Success!", "Your changes was successfully arranged!", "success");
//                    common_ajax_call();
            }
        });
    });
</script>