<script type="text/javascript" src="assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-profile"></i> <span class="text-semibold"> Profiles</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
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
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Profile Image</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Life Bio</th>
                    <th>Created By</th>
                    <th>Created On</th>
                    <th>Most Visited</th>
                    <th>Notable</th>
                </tr>
            </thead>
        </table>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script type="text/javascript">
    $(document).on('click', '.styled', function () {
        data_type = $(this).data('type');
        msg_type = "Notable";
        if (data_type == 'most_visited') {
            msg_type = "Most Visited";
        }
        data_id = $(this).data('id');
        if ($(this).parent().attr('class') == 'checked') {
            $(this).parent().removeClass('checked');
            $(this).prop('checked', false);
            value = 0;
            msg = 'Profile removed from ' + msg_type + ' successfully!';
        } else {
            $(this).parent().addClass('checked');
            $(this).prop('checked', true);
            value = 1;
            msg = 'Profile added to ' + msg_type + ' successfully!';
        }
        $.ajax({
            url: "<?php site_url() ?>admin/profiles/change_data_status",
            data: {id: data_id, value: value, type: data_type},
            type: "POST",
            success: function (result) {
                if (result = 'success') {
                    swal({
                        title: "Success!",
                        text: msg,
                        type: "success"
                    });
                } else {
                    swal({
                        title: "Error!",
                        text: 'Something went wrong! Please try again later.',
                        type: "error"
                    });
                }
            }
        });
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
            order: [[6, "desc"]],
            ajax: site_url + 'admin/profiles/get_profiles',
            columns: [
                {
                    data: "sr_no",
                    visible: true,
                    sortable: false
                },
                {
                    data: "profile_image",
                    visible: true,
                    sortable: false,
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
                },
                {
                    data: "lastname",
                    visible: true,
                },
                {
                    data: "life_bio",
                    visible: true,
                },
                {
                    data: "created_by",
                    visible: true,
                },
                {
                    data: "created_at",
                    visible: true,
                },
                {
                    data: "most_visited",
                    visible: true,
                    render: function (data, type, full, meta) {
                        var status;
                        if (full.most_visited == 1) {
                            status = '<div class="checkbox"><label><div class="checker"><span class="checked"><input type="checkbox" class="styled" value="1" data-id="' + full.id + '" data-type="most_visited"></span></div></label></div>';
                        } else {
                            status = '<div class="checkbox"><label><div class="checker"><span class=""><input type="checkbox" class="styled" value="1" data-id="' + full.id + '" data-type="most_visited"></div></label></div>';
                        }
                        return status;
                    }
                },
                {
                    data: "notable",
                    visible: true,
                    render: function (data, type, full, meta) {
                        var status;
                        if (full.notable == 1) {
                            status = '<div class="checkbox"><label><div class="checker"><span class="checked"><input type="checkbox" class="styled" value="1" data-id="' + full.id + '" data-type="notable"></span></div></label></div>';
                        } else {
                            status = '<div class="checkbox"><label><div class="checker"><span class=""><input type="checkbox" class="styled" value="1" data-id="' + full.id + '" data-type="notable"></div></label></div>';
                        }
                        return status;
                    }
                },
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

</script>