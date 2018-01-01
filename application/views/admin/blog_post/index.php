<script type="text/javascript" src="assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<style>
    .btn-icon.btn-xs, .input-group-xs > .input-group-btn > .btn.btn-icon {padding-right: 6px;}
    .refund_row {background-color: rgba(253, 82, 82, 0.14);}    
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-books"></i> <span class="text-semibold"> Blog Posts</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active"><i class="icon-books"></i> Blog Posts</li>
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
            <a href="<?php echo site_url('admin/blog_post/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-plus-circle2"></i></b> Add Blog Post</a>
        </div>
        <!--<div class="table-responsive">-->
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Posted By</th>
                    <th>Status</th>
                    <th>Visible in Home</th>
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
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-blue'
    });
    var url = site_url + 'admin/blog_post/get_posts';

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
            order: [[0, "ASC"]],
            ajax: url,
            columns: [
                {
                    data: "sr_no",
                    visible: true,
                },
                {
                    data: "image",
                    visible: true,
                    render: function (data, type, full, meta) {
                        var action = '<a class="fancybox" href="<?php echo base_url() . BLOG_POST_IMAGES ?>' + data + '" data-fancybox-group="gallery" ><img src="<?php echo base_url() . BLOG_POST_IMAGES ?>' + data + '" style="width: 58px; height: 58px; border - radius: 2px; " alt="' + data + '"></a>';
                        return action;
                    }
                },
                {
                    data: "title",
                    visible: true,
                },
                {
                    data: "description",
                    visible: true,
                    render: function (data, type, full, meta) {
                        var action = full.firstname + ' ' + full.lastname;
                        return action;
                    }
                },
                {
                    data: "is_active",
                    visible: true,
                    width: "10%",
                    render: function (data, type, full, meta) {
                        if (data == '1') {
                            var action = '<span class="label label-success">Visible</span>';
                        } else {
                            var action = '<span class="label label-default">Hidden</span>';
                        }

                        return action;
                    }
                },
                {
                    data: "is_view",
                    visible: true,
                    width: "10%",
                    render: function (data, type, full, meta) {
                        var status = '<div class="checkbox"><label><div class="checker"><span class=""><input type="checkbox" class="styled" value="1" data-id="' + btoa(full.id) + '" data-type="show_in_home"></div></label></div>';
                        if (data == 1) {
                            status = '<div class="checkbox"><label><div class="checker"><span class="checked"><input type="checkbox" class="styled" value="1" data-id="' + btoa(full.id) + '" data-type="show_in_home"></span></div></label></div>';
                        }
//                         else {
//                            if (full.sub_count == 2) {
//                                status = '<div class="checkbox"><label><div class="checker disabled"><span><input type="checkbox" class=" styled" value="0" disabled="disabled" data-id="' + btoa(full.id) + '" data-type="show_in_home"></span></div></label></div>';
//                            }
//                        }
                        return status;
                    }
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
                        var editurl = site_url + 'admin/blog_post/edit/' + btoa(full.id);
                        var viewurl = site_url + 'admin/blog_post/view/' + btoa(full.id);
                        var deleteurl = site_url + 'admin/blog_post/delete/' + btoa(full.id);
                        var action = '<ul class="icons-list">';
                        action += '<li class="dropdown">';
                        action += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                        action += '<i class="icon-menu9"></i>';
                        action += '</a>';
                        action += '<ul class="dropdown-menu dropdown-menu-right">';
                        action += '<li>';
                        action += '<a href="' + editurl + '" title="Edit"><i class="icon-pencil3"></i> Edit</a>'
                        action += '<a href="' + viewurl + '" title="View Post"><i class="icon-book"></i> View</a>'
                        if (full.is_active == '1') {
                            action += '<a href="' + site_url + 'admin/blog_post/action/hide/' + btoa(full.id) + '" data-type="hide" onclick="return confirm_view(this)" class="in_active" title="Hide"><i class="icon-eye-blocked"></i>Hide Post</a>'
                        } else {
                            action += '<a href="' + site_url + 'admin/blog_post/action/show/' + btoa(full.id) + '" id="' + btoa(full.id) + '" data-type="show" onclick="return confirm_view(this)" class="active" title="Show"><i class="icon-eye"></i>Show Post</a>'
                        }
                        action += '<a href="' + deleteurl + '" onclick="return confirm_alert(this)" title="Delete"><i class="icon-trash"></i> Delete</a>'
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
            text: "You will not be able to recover this Blog Post!",
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
                swal("Cancelled", "Your Blog Post is safe :)", "error");
            }
        });
        return false;
    }

    function confirm_view(e) {
        var type = $(e).attr('data-type');
        console.log(type);
        if (type == 'show') {
            swal({
                title: "Are you sure?",
                text: "You want to show this blog post!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF7043",
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then(function (isConfirm) {
                if (isConfirm) {
                    window.location.href = $(e).attr('href');
                    return true;
                }
            }, function (dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                if (dismiss === 'cancel') {
                    swal("Cancelled", "Your blog post will not be visible. :)", "error");
                }
            });
        } else if (type == 'hide') {
            swal({
                title: "Are you sure?",
                text: "You want to hide this blog post!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF7043",
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then(function (isConfirm) {
                if (isConfirm) {
                    window.location.href = $(e).attr('href');
                    return true;
                }
            }, function (dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                if (dismiss === 'cancel') {
                    swal("Cancelled", "Your blog post will not be invisible :)", "error");
                }
            });
        }
        return false;
    }

    $(document).on('click', '.styled', function () {
        var check_this = $(this);
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
            url: "<?php site_url() ?>admin/blog_post/change_data_status",
            data: {id: data_id, value: value},
            type: "POST",
            success: function (result) {
                console.log(result);
                if (result == 'success') {
                    swal("Success!", "Your changes was successfully saved!", "success");
                } else {
                    check_this.parent().removeClass('checked');
                    check_this.prop('checked', false);
                    swal("Warning!", "Your cannot set more than 3 blog post for home page!", "error");
                }
            }
        });
    });
</script>