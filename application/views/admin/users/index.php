<script type="text/javascript" src="assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<style>
    .btn-icon.btn-xs, .input-group-xs > .input-group-btn > .btn.btn-icon {padding-right: 6px;}
    .refund_row {background-color: rgba(253, 82, 82, 0.14);}    
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-users2"></i> <span class="text-semibold"> Users</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active"><i class="icon-users2"></i> Users</li>
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
            <a href="<?php echo site_url('admin/users/add') ?>" class="btn btn-success btn-labeled"><b><i class="icon-plus-circle2"></i></b> Add User</a>
        </div>
        <!--<div class="table-responsive">-->
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Profile</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>User Type</th>
                    <th>Active Status</th>
                    <th>Verification Status</th>
                    <th>Registration Date</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <!--</div>-->
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script type="text/javascript">
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-blue'
    });
    $(function () {
        $('.datatable-basic').dataTable({
//            scrollX:true,
            autoWidth: false,
            processing: true,
            serverSide: true,
            language: {
                search: '<span>Filter:</span> _INPUT_',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
            },
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            order: [[7, "desc"]],
            ajax: site_url + 'admin/users/get_users',
            columns: [
                {
                    data: "sr_no",
                    width: '9%',
                    visible: true,
                    sortable: false
                },
                {
                    data: "profile_image",
                    visible: true,
                    width: '5%',
                    render: function (data, type, full, meta) {
                        if (data != null && (full.facebook_id == null && full.google_id == null)) {
                            var action = '<a class="fancybox" href="<?php echo base_url() . USER_IMAGES ?>' + data + '" data-fancybox-group="gallery" ><img src="<?php echo base_url(USER_IMAGES) ?>' + data + '" style="width: 58px; height: 58px; border - radius: 2px; " alt="' + data + '"></a>';
                        } else if (data != null && (full.facebook_id != null || full.google_id != null)) {
                            var action = '<a class="fancybox" href="' + data + '" data-fancybox-group="gallery" ><img src="' + data + '" style="width: 58px; height: 58px; border - radius: 2px; " alt=""></a>';
                        } else {
                            var action = '<img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" class="img-circle img-lg" alt="' + data + '">';
                        }
                        return action;
                    }
                },
                {
                    data: "firstname",
                    visible: true,
                    width: '10%',
                },
                {
                    data: "lastname",
                    visible: true,
                    width: '10%',
                },
                {
                    data: "facebook_id",
                    visible: true,
                    width: '10%',
                    render: function (data, type, full, meta) {
                        if (full.facebook_id != null) {
                            var action = 'Facebook User';
                        } else if (full.google_id != null) {
                            var action = 'Google User';
                        } else {
                            var action = 'Normal';
                        }
                        return action;
                    }
                },
                {
                    data: "is_active",
                    visible: true,
                    width: '10%',
                    render: function (data, type, full, meta) {
                        var action = '';
                        if (data == '1') {
                            action += '<span class="label label-success">Active</span>';
                        } else {
                            action += '<span class="label label-default">InActive</span>';
                        }
                        return action;
                    }
                },
                {
                    data: "is_verify",
                    visible: true,
                    width: '10%',
                    render: function (data, type, full, meta) {
                        if (data == '1') {
                            var action = '<span class="label label-success">Verified</span>';
                        } else {
                            var action = '<span class="label label-danger">Not Verified</span>';
                        }

                        return action;
                    }
                },
                {
                    data: "created_at",
                    visible: true,
                    width: '10%',
                },
                {
                    data: "is_delete",
                    visible: true,
                    searchable: false,
                    sortable: false,
                    width: '10%',
                    render: function (data, type, full, meta) {
                        var action = '';
                        action += '<ul class="icons-list">';
                        action += '<li class="dropdown">';
                        action += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                        action += '<i class="icon-menu9"></i>';
                        action += '</a>';
                        action += '<ul class="dropdown-menu dropdown-menu-right">';
                        action += '<li>';
                        action += '<a href="' + site_url + 'admin/users/edit/' + btoa(full.id) + '" title="Edit Service Provider"><i class="icon-pencil3"></i> Edit</a>';
                        action += '<a href="' + site_url + 'admin/users/posts/' + btoa(full.id) + '" title="Manage Posts"><i class="icon-comment"></i> Manage Post</a>';
                        action += '<a href="' + site_url + 'admin/users/profile/' + btoa(full.id) + '" title="Manage Profile"><i class="icon-profile"></i> Manage Profile</a>';
                        action += '<a href="' + site_url + 'admin/users/view/' + btoa(full.id) + '" title="View Service Provider"><i class="icon-book"></i> View</a>';
                        action += '<a href="' + site_url + 'admin/users/delete/' + btoa(full.id) + '" onclick="return confirm_alert(this)" title="Delete User"><i class="icon-trash"></i> Delete</a>'
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
    $(function () {
        $('.fancybox').fancybox();
    });
    function confirm_alert(e) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this user!",
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
                swal("Cancelled", "Your user is safe :)", "error");
            }
        });
        return false;
    }

</script>