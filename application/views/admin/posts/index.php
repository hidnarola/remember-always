<script type="text/javascript" src="assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<style>
    .btn-icon.btn-xs, .input-group-xs > .input-group-btn > .btn.btn-icon {padding-right: 6px;}
    .refund_row {background-color: rgba(253, 82, 82, 0.14);}    
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-comment"></i> <span class="text-semibold"> Posts</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <?php if (isset($user_id)) { ?>
                <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users2"></i> Users</a></li>
            <?php } ?>
            <li class="active"><i class="icon-comment"></i> Posts</li>
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
            <a href="<?php echo isset($user_id) ? site_url('admin/users/postadd/' . $user_id) : site_url('admin/posts/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-plus-circle2"></i></b> Add Post</a>
        </div>
        <!--<div class="table-responsive">-->
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Comments</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Posted Date</th>
                    <th>Actions</th>
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
    var url = site_url + 'admin/posts/get_posts';
    if (user_id != '') {
        url = site_url + 'admin/posts/get_posts/' + user_id;
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
            order: [[0, "desc"]],
            ajax: url,
            columns: [
                {
                    data: "sr_no",
                    visible: true,
                },
                {
                    data: "comment",
                    visible: true,
                },
                {
                    data: "firstname",
                    visible: true,
                },
                {
                    data: "lastname",
                    visible: true,
                },
                {
                    data: "created_at",
                    visible: true,
                },
                {
                    data: "id",
                    visible: true,
                    searchable: false,
                    sortable: false,
                    render: function (data, type, full, meta) {
                        var editurl = site_url + 'admin/posts/edit/' + btoa(full.id);
                        var viewurl = site_url + 'admin/posts/view/' + btoa(full.id);
                        var deleteurl = site_url + 'admin/posts/delete/' + btoa(full.id);
                        if (user_id != '') {
                            editurl = site_url + 'admin/users/postedit/' + user_id + '/'+ btoa(full.id);
                            viewurl = site_url + 'admin/users/posts/view/' + btoa(full.id) + '/' + user_id;
                            deleteurl = site_url + 'admin/users/postdelete/' + user_id + '/' + btoa(full.id);
                        }
                        var action = '<ul class="icons-list">';
                        action += '<li class="dropdown">';
                        action += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                        action += '<i class="icon-menu9"></i>';
                        action += '</a>';
                        action += '<ul class="dropdown-menu dropdown-menu-right">';
                        action += '<li>';
                        action += '<a href="' + editurl + '" title="Edit"><i class="icon-pencil3"></i> Edit Post</a>'
                        action += '<a href="' + viewurl + '" title="View Post"><i class="icon-book"></i> View Post</a>'
                        action += '<a href="' + deleteurl + '" onclick="return confirm_alert(this)" title="Delete"><i class="icon-trash"></i> Delete Post</a>'
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
            text: "You will not be able to recover this post!",
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
                swal("Cancelled", "Your post is safe :)", "error");
            }
        });
        return false;
    }

</script>