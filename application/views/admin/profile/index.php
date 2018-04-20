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
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users2"></i> Users</a></li>
            <li class="active"><i class="icon-profile"></i> Profiles</li>
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
        <div class="panel-heading text-right"></div>
        <!--<div class="table-responsive">-->
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Profile</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Type</th>
                    <th>Privacy</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Created Date</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <!--</div>-->
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script type="text/javascript">
    var user_id = '<?php echo isset($user_id) ? $user_id : '' ?>';
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-blue'
    });
    if (user_id != '') {
        url = site_url + 'admin/users/get_profiles/' + user_id;
    }
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
            order: [[5, "desc"]],
            ajax: url,
            columns: [
                {
                    data: "sr_no",
                    width: '9%',
                    visible: true,
                },
                {
                    data: "profile_image",
                    visible: true,
                    width: '5%',
                    render: function (data, type, full, meta) {
                        if (data != null) {
                            var action = '<a class="fancybox" href="<?php echo base_url() . PROFILE_IMAGES ?>' + data + '" data-fancybox-group="gallery" ><img src="<?php echo base_url() . PROFILE_IMAGES ?>' + data + '" style="width: 58px; height: 58px; border - radius: 2px; " alt="' + data + '"></a>';
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
                    data: "type",
                    visible: true,
                    width: '10%',
                    render: function (data, type, full, meta) {
                        var action = '-';
                        if (data == '1') {
                            action = 'Normal';
                        } else if (data == '2') {
                            action = 'Fundraiser';
                        } else {
                            action = 'Normal';
                        }
                        return action;
                    }
                },
                {
                    data: "privacy",
                    visible: true,
                    width: '10%',
                    render: function (data, type, full, meta) {
                        action = data;
                        return action;
                    }
                },
                {
                    data: "is_blocked",
                    visible: true,
                    width: '10%',
                    render: function (data, type, full, meta) {
                        var action = '';
                        if (data == '1') {
                            action += '<span class="label label-danger">Blocked</span>';
                        } else {
                            action += '<span class="label label-success">Active</span>';
                        }
                        return action;
                    }
                },
                {
                    data: "is_published",
                    visible: true,
                    width: '10%',
                    render: function (data, type, full, meta) {
                        var action = '';
                        if (data == '1') {
                            action += '<span class="label label-success">Yes</span>';
                        } else {
                            action += '<span class="label label-default">No</span>';
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
                        if (full.is_published == 1) {
                            action += '<a href="' + site_url + 'admin/users/profile_action/publish/' + btoa(full.id) + '/' + user_id + '" title="Unpublish Profile" onclick="return confirm_palert(this)" ><i class="icon-cross3"></i> Unpublish Profile</a>';
                        } else {
                            action += '<a href="' + site_url + 'admin/users/profile_action/publish/' + btoa(full.id) + '/' + user_id + '" title="Publish Profile" onclick="return confirm_palert(this)" ><i class="icon-checkmark3"></i> Publish Profile</a>';
                        }
                        if (full.is_blocked == 1) {
                            action += '<a href="' + site_url + 'admin/users/profile_action/unblock/' + btoa(full.id) + '/' + user_id + '" title="Unblock Profile"><i class="icon-user-check"></i> Unblock Profile</a>';
                        } else {
                            action += '<a href="' + site_url + 'admin/users/profile_action/block/' + btoa(full.id) + '/' + user_id + '" title="Block Profile"><i class="icon-user-block"></i> Block Profile</a>';
                        }
                        action += '<a href="' + site_url + 'admin/users/viewprofile/' + btoa(full.id) + '" title="View Profile"><i class="icon-book"></i> View</a>';
                        action += '<a href="' + site_url + 'admin/users/profile_action/delete/' + btoa(full.id) + '/' + user_id + '" onclick="return confirm_alert(this)" title="Delete Profile"><i class="icon-trash"></i> Delete</a>'
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
            text: "You will not be able to recover this profile!",
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
                swal("Cancelled", "Your profile is safe :)", "error");
            }
        });
        return false;
    }
    function confirm_palert(e) {
        text_title = $(e).attr('title');
        swal({
            title: "Are you sure?",
            text: "You want to " + text_title + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes, " + text_title + "!",
            cancelButtonText: "No, cancel plz!"
        }).then(function (isConfirm) {
            if (isConfirm) {
                window.location.href = $(e).attr('href');
                return true;
            }
        });
        return false;
    }

</script>