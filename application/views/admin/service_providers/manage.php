<script type="text/javascript" src="assets/admin/ckeditor/ckeditor.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-hammer-wrench"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/providers'); ?>"><i class="icon-hammer-wrench"></i> Service Providers</a></li>
            <li class="active"><i class="icon-pencil7 position-left"></i> <?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($this->session->flashdata('success')) {
                ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
                <?php
            } else if ($this->session->flashdata('error')) {
                ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
                <?php
            } else {
                if (!empty(validation_errors())) {
                    ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo validation_errors(); ?></strong>       
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <!-- Basic layout-->
                <form  method="post" id="page_info" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Select Service Category: <span class="text-danger">*</span></label>
                                <select name="service_category" id="service_category" class="form-control selectpicker">
                                    <option value="">-- Select Category --</option>
                                    <?php
                                    if (isset($service_categories) && !empty($service_categories)) {
                                        foreach ($service_categories as $key => $value) {
                                            $selected = '';
                                            if ($provider_data['service_category_id'] == $value['id']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo $value['id'] ?>"><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Name: <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($provider_data['name']) ? $provider_data['name'] : set_value('name'); ?>" placeholder="Please enter name">
                            </div>
                            <div class="form-group">
                                <label>Description: <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="4" cols="4" class="form-control"><?php echo isset($provider_data['description']) ? $provider_data['description'] : set_value('description'); ?></textarea>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <!--<div>Address Section: <span class="text-danger">*</span></div>-->
                                    <div class="col-md-6">
                                        <label>Street Address 1: <span class="text-danger">*</span></label>
                                        <input type="text" name="street1" id="street1" class="form-control" value="<?php echo isset($provider_data['street1']) ? $provider_data['street1'] : set_value('street1'); ?>" placeholder="Please enter address">
                                        <input type="hidden" name="location" id="location" class="form-control" value="<?php echo isset($provider_data['location']) ? $provider_data['location'] : set_value('location'); ?>" >
                                        <input type="hidden" name="latitute" id="latitute" class="form-control" value="<?php echo isset($provider_data['latitute']) ? $provider_data['latitute'] : set_value('latitute'); ?>" >
                                        <input type="hidden" name="longitute" id="longitute" class="form-control" value="<?php echo isset($provider_data['longitute']) ? $provider_data['longitute'] : set_value('longitute'); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Street Address 2: </label>
                                        <input type="text" name="street2" id="street2" class="form-control" value="<?php echo isset($provider_data['street2']) ? $provider_data['street2'] : set_value('street2'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Country: <span class="text-danger">*</span></label>
                                        <select name="country" id="country" class="form-control selectpicker">
                                            <option value="">-- Select Country --</option>
                                            <?php
                                            foreach ($countries as $key => $value) {
                                                $selected = '';
                                                if (isset($provider_data) && $provider_data['country'] == $value['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('country', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>State: <span class="text-danger">*</span></label>
                                        <!--<input type="text" name="state" id="state" class="form-control" value="<?php // echo isset($provider_data['state']) ? $provider_data['state'] : set_value('state');                     ?>">-->
                                        <select name="state" id="state" class="form-control selectpicker">
                                            <option value="">-- Select State --</option>
                                            <?php
                                            if (isset($states) && !empty($states)) {
                                                foreach ($states as $key => $value) {
                                                    $selected = '';
                                                    if (isset($provider_data) && $provider_data['state'] == $value['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('state', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" name="state_hidden" id="state_hidden" class="form-control" value="<?php echo isset($provider_data['state']) ? base64_encode($provider_data['state']) : set_value('state_hidden'); ?>" >
                                    </div>
                                    <div class="col-md-3">
                                        <label>City: <span class="text-danger">*</span></label>
                                        <!--<input type="text" name="city" id="city" class="form-control" value="<?php // echo isset($provider_data['city']) ? $provider_data['city'] : set_value('city');                     ?>">-->
                                        <select name="city" id="city" class="form-control selectpicker">
                                            <option value="">-- Select City --</option>
                                            <?php
                                            if (isset($cities) && !empty($cities)) {
                                                foreach ($cities as $key => $value) {
                                                    $selected = '';
                                                    if (isset($provider_data) && $provider_data['city'] == $value['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('city', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Zip Code: </label>
                                        <input type="text" name="zipcode" id="zipcode" class="form-control" value="<?php echo isset($provider_data['zipcode']) ? $provider_data['zipcode'] : set_value('zipcode'); ?>" readonly="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Phone: <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo isset($provider_data['phone_number']) ? $provider_data['phone_number'] : set_value('phone'); ?>" placeholder="Please enter phone number">
                            </div>
                            <div class="form-group">
                                <label>Website: <span class="text-danger">*</span></label>
                                <input type="text" name="website" id="website" class="form-control" value="<?php echo isset($provider_data['website_url']) ? $provider_data['website_url'] : set_value('website'); ?>" placeholder="Please enter website url">
                            </div>
                            <div class="form-group">
                                <label>Image: <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-3" id="image_preview_div">
                                        <?php
                                        $required = 'required';
                                        if (isset($provider_data['image'])) {
                                            $required = '';
                                            ?>
                                            <img heigth="100" width="170" src="<?php echo base_url(PROVIDER_IMAGES . '/' . $provider_data['image']) ?>" alt="">
                                            <?php
                                        } else {
                                            ?>
                                            <img heigth="100" width="170" src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" alt="">
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="media-body">
                                            <input type="file" name="image" id="image" class="file-styled" <?php echo $required ?>>
                                            <span class="help-block">Accepted formats:  png, jpg , jpeg. Max file size <?php echo MAX_IMAGE_SIZE ?>MB</span>
                                        </div>
                                        <span></span>
                                    </div>
                                </div>
                                <div id="proper_image" class="validation-error-label"></div>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /basic layout -->
            </div>
        </div>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script type="text/javascript">
    $('#city,#state,#country').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('document').ready(function () {
        $("#page_info").validate({
            ignore: [],
            errorClass: 'validation-error-label',
            successClass: 'validation-valid-label',
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            validClass: "validation-valid-label",
            rules: {
                service_category: {
                    required: true,
                },
                name: {
                    required: true,
                },
                description: {
                    required: true,
                },
                street1: {
                    required: true,
                },
                country: {
                    required: true,
                },
                state: {
                    required: true,
                },
                city: {
                    required: true,
                },
                phone: {
                    required: true,
                    phoneUS: true
                },
                website: {
                    required: true,
                    url: true
                },
                image: {
//                    required: true,
                    extension: "jpg|png|jpeg",
                    maxFileSize: {
                        "unit": "MB",
                        "size": max_image_size
                    }
                }
            },
            messages: {
                phone: {
                    phoneUS: "Please specify valid us phone number."
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "description") {
                    error.insertAfter(element);
                } else if (element.hasClass('selectpicker')) {
                    error.insertAfter(element.parent().find('.bootstrap-select'));
                } else if (element.attr("name") == "image") {
                    error.insertAfter($(".uploader"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                $('button[type="submit"]').attr('disabled', true);
                form.submit();
            },
        });
    });
    $(document).on('change', '#image', function (e) {
        readURL(this);
    })
    //-- Get states based on country dropdown change event
    $(document).on('change', '#country', function () {
        country_val = $(this).val();
        $('#state').val('');
        $('#city').val('');
        if (country_val != '') {
            $('#country').valid();
            $('.loader').show();
            $.ajax({
                url: site_url + "profile/get_states",
                type: "POST",
                data: {country: atob(country_val)},
                dataType: "json",
                success: function (data) {
                    $('.loader').hide();
                    var options = "<option value=''>Select state</option>";
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value=' + btoa(data[i].id) + '>' + data[i].name + '</option>';
                    }
                    $('#state').empty().append(options);
                    $('#state').selectpicker('refresh');
                }
            });
        }
    });
    $(document).on('change', '#state', function () {
        var state_id = $("#state option:selected").val();
        $('#state_hidden').val(state_id);
        $url = '<?php echo base_url() ?>' + 'admin/providers/get_city';
        $.ajax({
            type: "POST",
            url: $url,
            data: {
                stateid: state_id,
            }
        }).done(function (data) {
            $("select#city").html(data);
            $('#city').selectpicker('refresh');
        });
    });
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-pink'
    });

    var _validFileExtensions = [".jpg", ".jpeg", ".png", ];
    function readURL(input) {
        var height = 730, width = 1600, img = '', file = '', val = '';
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var valid_extensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (typeof (input.files[0]) != 'undefined') {
                    if (valid_extensions.test(input.files[0].name)) {
                        var html = '<img src="' + e.target.result + '" style="width: 170px; height: 100px; border-radius: 2px;" alt="">';
                    } else {
                        var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 170px; height: 100px; border-radius: 2px;" alt="">';
                    }
                } else {
                    var html = '<img src="assets/admin/images/placeholder.jpg" style="width: 170px; height: 100px; border-radius: 2px;" alt="">';
                }
                $('#image_preview_div').html(html);
            }
            reader.readAsDataURL(input.files[0]);
            // check slider image dimension
            var _URL = window.URL || window.webkitURL;
            if ((file = input.files[0])) {
                img = new Image();
                img.onload = function () {
//                    if (this.width < width || this.height < height) {
//                        is_valid = false;
//                        $('#proper_image').html('Photo should be ' + width + ' X ' + height + ' or more dimensions');
//                    } else {
//                        is_valid = true;
//                        $('#proper_image').html('');
//                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAylcYpcGylc8GTu_PYJI7sqPVn6ITrVnM&libraries=places&callback=initAutocomplete" async defer></script>
<!--<script type="text/javascript" src="<?php echo base_url('assets/admin/js/googleAutoComplete.js') ?>"></script>-->
<script type="text/javascript">
    function initAutocomplete() {
        var input = document.getElementById('street1');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var places = autocomplete.getPlace();
            if (places.length == 0) {
                swal("Cancelled", "Your entered address is not able to track on google so please enter correct address. :)", "error");
                return;
            }

            if (typeof places.geometry !== 'undefined') {
//                $('#location').val(places.formatted_address);
                $('#latitute').val(places.geometry.location.lat());
                $('#longitute').val(places.geometry.location.lng());
            } else {
                googleLocationIssuePrompt();
            }

        });

    }

    function googleLocationIssuePrompt() {
        swal("Cancelled", "Your entered address is not able to track on google so please enter correct address. :)", "error");
    }

    $(document).ready(function () {
        $(document).on('change', '#street1', initAutocomplete);
    });
</script>
<style type="text/css">  .hide{display: none;} </style>