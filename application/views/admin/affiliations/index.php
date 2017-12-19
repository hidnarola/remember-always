<script type="text/javascript" src="assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<style>
    .btn-icon.btn-xs, .input-group-xs > .input-group-btn > .btn.btn-icon {padding-right: 6px;}
    .refund_row {background-color: rgba(253, 82, 82, 0.14);}    
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-office"></i> <span class="text-semibold">Affiliations</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active"><i class="icon-office"></i> Affiliations</li>
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
            <?php } ?>
        </div>
    </div>
    <div class="panel panel-flat">
        <div class="panel-heading text-right">
            <a href="<?php echo site_url('admin/affiliations/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-plus-circle2"></i></b> Add Affiliation</a>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Category</th>
                    <th>Name</th>
                    <!--<th>Description</th>-->
                    <!--<th>Phone Number</th>-->
                    <th>Added Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script type="text/javascript">
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-blue'
    });

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
            order: [[5, "desc"]],
            ajax: site_url + 'admin/affiliations/get_affiliation',
            columns: [
                {
                    data: "sr_no",
                    visible: true,
                },
                {
                    data: "category_name",
                    visible: true,
                },
                {
                    data: "name",
                    visible: true
                },
//                {
//                    data: "description",
//                    visible: true,
//                    render: function (data, type, full, meta) {
//                        console.log(data);
//                        var text = data;
//                        if (data.length > 500) {
//                            text = data.substring(0, 500);
//                            text +='...';
//                        }
//                        return text;
//                    }
//                },
//                {
//                    data: "phone_number",
//                    visible: true,
//                },
                {
                    data: "created_at",
                    visible: true,
                },
                {
                    data: "is_approved",
                    visible: true,
                    render: function (data, type, full, meta) {
                        if (data == '1') {
                            var action = '<span class="label label-success">Approved</span>';
                        } else {
                            var action = '<span class="label label-danger">Not Approved</span>';
                        }

                        return action;
                    }
                },
                {
                    data: "is_delete",
                    visible: true,
                    searchable: false,
                    sortable: false,
                    render: function (data, type, full, meta) {
                        var action = '';
                        action += '<ul class="icons-list">';
                        action += '<li class="dropdown">';
                        action += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                        action += '<i class="icon-menu9"></i>';
                        action += '</a>';
                        action += '<ul class="dropdown-menu dropdown-menu-right">';
                        action += '<li>';
                        action += '<a href="' + site_url + 'admin/affiliations/edit/' + btoa(full.id) + '" title="Edit Affiliation"><i class="icon-pencil3"></i> Edit</a>';

                        if (full.is_approved == '1') {
                            var type = 'approve';
                            action += '<a href="' + site_url + 'admin/affiliations/action/unapprove/' + btoa(full.id) + '" title="UnApprove Affiliation" data-type="' + type + '" onclick="return confirm_approve(this)"><i class="icon-cross"></i> UnApprove</a>';
                        } else {
                            var type = 'unapprove';
                            action += '<a href="' + site_url + 'admin/affiliations/action/approve/' + btoa(full.id) + '" title="Approve Affiliation" data-type="' + type + '" onclick="return confirm_approve(this)"><i class="icon-check"></i> Approve</a>';
                        }
                        action += '<a href="' + site_url + 'admin/affiliations/view/' + btoa(full.id) + '" title="View Affiliation"><i class="icon-book"></i> View</a>';
                        action += '<a href="' + site_url + 'admin/affiliations/delete/' + btoa(full.id) + '" onclick="return confirm_alert(this)" title="Delete Affiliation"><i class="icon-trash"></i> Delete</a>'
                        action += '</li>';
                        action += '</ul>';
                        action += '</li>';
                        action += '</ul>';
                        return action;
                    }
                }

            ],
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
    });


    function confirm_alert(e) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this affiliation!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plz!"
        }).then(function (isConfirm) {
            if (isConfirm) {
                window.location.href = $(e).attr('href');
                return true;
            }
        }, function (dismiss) {
            // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
            if (dismiss === 'cancel') {
                swal("Cancelled", "Your affiliation is safe :)", "error");
            }
        });
        return false;
    }
    function confirm_approve(e) {
        var type = $(e).attr('data-type');
        console.log(type);
        if (type == 'approve') {
            swal({
                title: "Are you sure?",
                text: "You want to approve this service!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF7043",
                confirmButtonText: "Yes, Approve it!",
                cancelButtonText: "No, cancel plz!"
            }).then(function (isConfirm) {
                if (isConfirm) {
                    window.location.href = $(e).attr('href');
                    return true;
                }
            }, function (dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                if (dismiss === 'cancel') {
                    swal("Cancelled", "Your affiliation is not approved :)", "error");
                }
            });
        } else if (type == 'unapprove') {
            swal({
                title: "Are you sure?",
                text: "You want to Unapprove this affiliation!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF7043",
                confirmButtonText: "Yes, UnApprove it!",
                cancelButtonText: "No, cancel plz!"
            }).then(function (isConfirm) {
                if (isConfirm) {
                    window.location.href = $(e).attr('href');
                    return true;
                }
            }, function (dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                if (dismiss === 'cancel') {
                    swal("Cancelled", "Your affiliation is still unapproved :)", "error");
                }
            });
        }
        return false;
    }

</script>