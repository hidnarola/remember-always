<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-users2 position-left"></i> Users</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users2 position-left"></i> Users</a></li>
            <li class="active"><i class="icon-book position-left"></i><?php echo $heading; ?></li>
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
        </div>
        <?php
    }
}
?>
<!-- /content area -->
<div class="content">
    <div class="col-md-12">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <?php echo isset($profile_data['firstname']) ? $profile_data['firstname'] . ' ' . $profile_data['lastname'] . "'s Profile" : 'Profile' ?> Details
                </h6>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                        <li class="active"><a href="#profile_info" data-toggle="tab">Profile Info</a></li>
                        <li><a href="#affiliation_tab" data-toggle="tab">Affiliations</a></li>
                        <li><a href="#funfact_tab" data-toggle="tab">FunFacts</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile_info">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered page_details" data-alert="" data-all="189">
                                    <tbody>
                                        <tr>
                                            <th class="text-nowrap">Profile Name :</th>
                                            <td><?php echo isset($profile_data['firstname']) ? $profile_data['firstname'] . ' ' . $profile_data['lastname'] : '' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Profile Type :</th>
                                            <td><?php echo isset($profile_data['type']) && $profile_data['type'] == 1 ? 'Normal' : 'Fundraiser' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Date of Birth :</th>
                                            <td><?php echo isset($profile_data['date_of_birth']) && !is_null($profile_data['date_of_birth']) ? date('d M Y', strtotime($profile_data['date_of_birth'])) : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Date of Death :</th>
                                            <td><?php echo isset($profile_data['date_of_death']) && !is_null($profile_data['date_of_death']) ? date('d M Y', strtotime($profile_data['date_of_death'])) : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">User Name :</th>
                                            <td><?php echo isset($profile_data['user_fname']) ? $profile_data['user_fname'] . ' ' . $profile_data['user_lname'] : '' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Privacy :</th>
                                            <td><?php echo isset($profile_data['privacy']) ? $profile_data['privacy'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Life Bio :</th>
                                            <td><?php echo isset($profile_data['life_bio']) && !is_null($profile_data['life_bio']) ? $profile_data['life_bio'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Created Date :</th>
                                            <td><?php echo isset($profile_data['created_at']) && !is_null($profile_data['created_at']) ? date('d M Y', strtotime($profile_data['created_at'])) : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Status :</th>
                                            <td>
                                                <?php echo isset($profile_data['is_published']) && $profile_data['is_published'] == '1' ? '<span class="label label-success">Published</span>' : '<span class="label label-default">Not Published</span>' ?>
                                                <?php echo isset($profile_data['is_blocked']) && $profile_data['is_blocked'] == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Blocked</span>' ?>
                                            </td>
                                        </tr>
                                        <?php if ($profile_data['type'] == 2) { ?>
                                            <tr>
                                                <th class="text-nowrap">Fundraiser Title :</th>
                                                <td><?php echo isset($profile_data['title']) && !is_null($profile_data['title']) ? $profile_data['title'] : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap">Fundraiser Goal :</th>
                                                <td><?php echo isset($profile_data['goal']) && !is_null($profile_data['goal']) ? $profile_data['goal'] : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap">Fundraiser Details :</th>
                                                <td><?php echo isset($profile_data['details']) && !is_null($profile_data['details']) ? $profile_data['details'] : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap">Fundraiser Created Date :</th>
                                                <td><?php echo isset($profile_data['fp_created_at']) && !is_null($profile_data['fp_created_at']) ? date('d M Y', strtotime($profile_data['fp_created_at'])) : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap">Fundraiser End Date :</th>
                                                <td><?php echo isset($profile_data['end_date']) && !is_null($profile_data['end_date']) ? date('d M Y', strtotime($profile_data['end_date'])) : '-' ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th class="text-nowrap custom_align_top">Profile :</th>
                                            <td>
                                                <?php
                                                if (isset($profile_data['profile_image']) && !is_null($profile_data['profile_image'])) {
                                                    ?>
                                                    <a class="fancybox" href="<?php echo base_url(PROFILE_IMAGES . $profile_data['profile_image']); ?>" data-fancybox-group="gallery" ><img src="<?php echo base_url(PROFILE_IMAGES . $profile_data['profile_image']); ?>" class="img-responsive content-group" width="100px" height="100px" alt=""></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" class="img-responsive" width="100px" height="100px" alt="">
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="affiliation_tab">
                            <?php
                            if (isset($affiliations) && !empty($affiliations)) {
                                foreach ($affiliations as $key => $val) {
                                    ?>
                                    <blockquote>
                                        <p>
                                            <a href="javasxript:void(0)" class='affiliation_name' data-bind='<?php echo base64_encode($val['id']) ?>'><?php echo isset($val['name']) ? $val['name'] : '' ?></a>
                                        </p>
                                        <footer><?php echo isset($val['created_at']) && !is_null($val['created_at']) ? date('d M Y', strtotime($val['created_at'])) : '-' ?></footer>
                                    </blockquote>
                                    <p></p>
                                    <?php
                                }
                            } else {
                                ?>
                                <p>There is no affiliations added for this profile. </p>
                            <?php } ?>
                        </div>

                        <div class="tab-pane" id="funfact_tab">
                            <?php if (isset($fun_facts) && !empty($fun_facts)) { ?>
                                <?php
                                foreach ($fun_facts as $key => $val) {
                                    ?>
                                    <blockquote>
                                        <p >
                                            <?php echo isset($val['facts']) ? $val['facts'] : '' ?>
                                        </p>
                                        <footer><?php echo isset($val['created_at']) && !is_null($val['created_at']) ? date('d M Y', strtotime($val['created_at'])) : '-' ?></footer>

                                    </blockquote>
                                    <p></p>
                                    <?php
                                }
                            } else {
                                ?>
                                <p>There is no fun facts added for this profile. </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-12'>
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title">
                    Funeral Service Details
                </h6>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                        <li class="active"><a href="#memorial" data-toggle="tab">Memorial Service & Viewing Section</a></li>
                        <li><a href="#funnel" data-toggle="tab">Funeral Service Section</a></li>
                        <li><a href="#burial" data-toggle="tab">Burial Section</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="memorial">
                        <?php if (isset($funnel_services['Memorial']) && !empty($funnel_services['Memorial'])) { ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered page_details" data-alert="" data-all="189">
                                    <tbody>
                                        <tr>
                                            <th class="text-nowrap">Place Name :</th>
                                            <td><?php echo isset($funnel_services['Memorial']['place_name']) ? $funnel_services['Memorial']['place_name'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Date :</th>
                                            <td><?php echo isset($funnel_services['Memorial']['date']) && !is_null($funnel_services['Memorial']['date']) ? date('d M Y', strtotime($funnel_services['Memorial']['date'])) : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Time :</th>
                                            <td><?php echo isset($funnel_services['Memorial']['time']) ? $funnel_services['Memorial']['time'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Address :</th>
                                            <td><?php echo isset($funnel_services['Memorial']['address']) ? $funnel_services['Memorial']['address'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">City :</th>
                                            <td><?php echo isset($funnel_services['Memorial']['city_name']) ? $funnel_services['Memorial']['city_name'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">State :</th>
                                            <td><?php echo isset($funnel_services['Memorial']['state_name']) ? $funnel_services['Memorial']['state_name'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Zipcode :</th>
                                            <td><?php echo isset($funnel_services['Memorial']['zip']) ? $funnel_services['Memorial']['zip'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Created Date :</th>
                                            <td><?php echo isset($funnel_services['Memorial']['created_at']) && !is_null($funnel_services['Memorial']['created_at']) ? date('d M Y', strtotime($funnel_services['Memorial']['created_at'])) : '-' ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <p>There is no Memorial Service & Viewing Section for this profile.</p>
                        <?php } ?>
                    </div>
                    <div class="tab-pane" id="funnel">
                        <?php if (isset($funnel_services['Funeral']) && !empty($funnel_services['Funeral'])) { ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered page_details" data-alert="" data-all="189">
                                    <tbody>
                                        <tr>
                                            <th class="text-nowrap">Place Name :</th>
                                            <td><?php echo isset($funnel_services['Funeral']['place_name']) ? $funnel_services['Funeral']['place_name'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Date :</th>
                                            <td><?php echo isset($funnel_services['Funeral']['date']) && !is_null($funnel_services['Funeral']['date']) ? date('d M Y', strtotime($funnel_services['Funeral']['date'])) : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Time :</th>
                                            <td><?php echo isset($funnel_services['Funeral']['time']) ? $funnel_services['Funeral']['time'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Address :</th>
                                            <td><?php echo isset($funnel_services['Funeral']['address']) ? $funnel_services['Funeral']['address'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">City :</th>
                                            <td><?php echo isset($funnel_services['Funeral']['city_name']) ? $funnel_services['Funeral']['city_name'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">State :</th>
                                            <td><?php echo isset($funnel_services['Funeral']['state_name']) ? $funnel_services['Funeral']['state_name'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Zipcode :</th>
                                            <td><?php echo isset($funnel_services['Funeral']['zip']) ? $funnel_services['Funeral']['zip'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Created Date :</th>
                                            <td><?php echo isset($funnel_services['Funeral']['created_at']) && !is_null($funnel_services['Funeral']['created_at']) ? date('d M Y', strtotime($funnel_services['Funeral']['created_at'])) : '-' ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <p>There is no Funnel Service Section for this profile.</p>
                        <?php } ?>
                    </div>
                    <div class="tab-pane" id="burial">
                        <?php if (isset($funnel_services['Burial']) && !empty($funnel_services['Burial'])) { ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered page_details" data-alert="" data-all="189">
                                    <tbody>
                                        <tr>
                                            <th class="text-nowrap">Place Name :</th>
                                            <td><?php echo isset($funnel_services['Burial']['place_name']) ? $funnel_services['Burial']['place_name'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Date :</th>
                                            <td><?php echo isset($funnel_services['Burial']['date']) && !is_null($funnel_services['Burial']['date']) ? date('d M Y', strtotime($funnel_services['Burial']['date'])) : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Time :</th>
                                            <td><?php echo isset($funnel_services['Burial']['time']) ? $funnel_services['Burial']['time'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Address :</th>
                                            <td><?php echo isset($funnel_services['Burial']['address']) ? $funnel_services['Burial']['address'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">City :</th>
                                            <td><?php echo isset($funnel_services['Burial']['city_name']) ? $funnel_services['Burial']['city_name'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">State :</th>
                                            <td><?php echo isset($funnel_services['Burial']['state_name']) ? $funnel_services['Burial']['state_name'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Zipcode :</th>
                                            <td><?php echo isset($funnel_services['Burial']['zip']) ? $funnel_services['Burial']['zip'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap">Created Date :</th>
                                            <td><?php echo isset($funnel_services['Burial']['created_at']) && !is_null($funnel_services['Burial']['created_at']) ? date('d M Y', strtotime($funnel_services['Burial']['created_at'])) : '-' ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <p>There is no Burial Section for this profile.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="affiliation_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title" id="affiliation_title">Affiliation Details</h1>
                </div>

                <div class="modal-body">
                    <table class="table table-striped table-bordered page_details" data-alert="" data-all="189">
                        <tbody>
                            <tr>
                                <th class="text-nowrap">Name :</th>
                                <td class="name"></td>
                            </tr>
                            <tr class="hide">
                                <th class="text-nowrap">Image :</th>
                                <td class="image"><img src="" width="100px" height="100px"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Category :</th>
                                <td class="category_name"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Country :</th>
                                <td class="country"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">State :</th>
                                <td class="state"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">City :</th>
                                <td class="city"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Date :</th>
                                <td class="added_date"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Description :</th>
                                <td class="description"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->load->view('Templates/admin_footer');
    ?>
</div>
<script type="text/javascript">
    $(function () {
        $('.fancybox').fancybox();
        $(document).on('click', '.affiliation_name', function () {
            var data_id = $(this).data('bind');
//            console.log(data_id);
            $.ajax({
                url: '<?php echo site_url() ?>' + 'admin/users/load_data',
                type: "post",
                dataType: "json",
                data: {
                    id: data_id,
                    type: 'affiliation'
                },
                success: function (data) {
                    if (data != '') {
                        if (data['image'] != null) {
                            $('.image').parent().removeClass('hide');
                            $('.image').find('img').attr('src',data['url']);
                        } else {
                            $('.image').parent().addClass('hide');
                        }
                        $('#affiliation_model').modal();
                        $('.name').html(data['name']);
                        $('.category_name').html(data['category_name']);
                        $('.country').html(data['country_name']);
                        $('.state').html(data['state_name']);
                        $('.city').html(data['city_name']);
                        $('.added_date').html(data['created_at']);
                        $('.description').html(data['description']);
                    } else {
                        swal("Success!", "Affiliation is freetext so no more information is available.", "error");
                    }
                }
            });
        });
    });
</script>
