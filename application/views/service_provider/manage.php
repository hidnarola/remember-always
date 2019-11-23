<script src="assets/js/jquery.fancybox.js"></script>
<script src="assets/js/jquery.fancybox.pack.js"></script>
<div class="create-profile">
    <div class="create-profile-top">
        <div class="container">
            <h2>Post Service Provider Listing</h2>
        </div>
    </div>
    <div class="create-profile-body main-steps">
        <div class="container">
            <div class="create-profile-box">
                <div class="step-form">
                    <form method="post" enctype="multipart/form-data" id="provider_form">
                        <div id="forth-step">
                            <div class="step-form">
                                <div class="step-06">
                                    <div class="step-06-l">
                                        <div class="input-wrap">
                                            <label class="label-css">Category <span class="text-danger">*</span></label>
                                            <select name="category" id="category" class="selectpicker">
                                                <option value="">-- Select Category --</option>
                                                <?php
                                                if (isset($service_categories) && !empty($service_categories)) {
                                                    foreach ($service_categories as $key => $value) {
                                                        $selected = '';
                                                        if (isset($provider_data['service_category_id']) && $provider_data['service_category_id'] == $value['id']) {
                                                            $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>"  <?php echo $this->input->method() == 'post' ? set_select('category', base64_encode($value['id']), TRUE) : '' ?>><?php echo $value['name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php
                                            echo '<label id="category-error" class="error" for="category">' . form_error('category') . '</label>';
                                            ?>
                                        </div>
                                        <div class="input-wrap">
                                            <label class="label-css">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" placeholder="Name" class="input-css" value="<?php echo isset($provider_data['name']) ? $provider_data['name'] : set_value('name'); ?>">
                                            <?php
                                            echo '<label id="name-error" class="error" for="name">' . form_error('name') . '</label>';
                                            ?>
                                        </div>
                                        <div class="input-wrap">
                                            <label class="label-css">Description <span class="text-danger">*</span></label>
                                            <textarea class="input-css textarea-css" id="description" name="description" placeholder="Description"><?php echo isset($provider_data['description']) ? $provider_data['description'] : set_value('description'); ?></textarea>
                                            <?php
                                            echo '<label id="description-error" class="error" for="description">' . form_error('description') . '</label>';
                                            ?>
                                        </div>
                                        <div class="input-wrap">
                                            <label class="label-css">Address <span class="text-danger">*</span></label>
                                            <div class="input-l">
                                                <input type="text" name="street1" id="street1" placeholder="Street1 address" class="input-css" value="<?php echo isset($provider_data['street1']) ? $provider_data['street1'] : set_value('street1'); ?>">
                                                <input type="hidden" name="location" id="location" class="form-control" value="<?php echo isset($provider_data['location']) ? $provider_data['location'] : set_value('location'); ?>" >
                                                <input type="hidden" name="latitute" id="latitute" class="form-control" value="<?php echo isset($provider_data['latitute']) ? $provider_data['latitute'] : set_value('latitute'); ?>" >
                                                <input type="hidden" name="longitute" id="longitute" class="form-control" value="<?php echo isset($provider_data['longitute']) ? $provider_data['longitute'] : set_value('longitute'); ?>">
                                                <?php
                                                echo '<label id="street1-error" class="error" for="street1">' . form_error('street1') . '</label>';
                                                ?>
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="street2" id="street2" placeholder="Street2 address" class="input-css" value="<?php echo isset($provider_data['street2']) ? $provider_data['street2'] : set_value('street2'); ?>">
                                                <?php
                                                echo '<label id="street2-error" class="error" for="street2">' . form_error('street2') . '</label>';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <select name="country" id="country" class="selectpicker">
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
                                                <?php
                                                echo '<label id="country-error" class="error" for="country">' . form_error('country') . '</label>';
                                                ?>
                                            </div>
                                            <div class="input-r">
                                                <select name="state" id="state" class="selectpicker">
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
                                                <?php
                                                echo '<label id="state_hidden-error" class="error" for="state_hidden">' . form_error('state_hidden') . '</label>';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <div class="input-l">
                                                <select name="city" id="city" class="selectpicker">
                                                    <option value="">-- Select City --</option>
                                                    <?php
                                                    if (isset($cities) && !empty($cities)) {
                                                        foreach ($cities as $key => $value) {
                                                            $selected = '';
                                                            if (isset($provider_data) && $provider_data['city'] == $value['id']) {
                                                                $selected = 'selected';
                                                            }
                                                            ?>
                                                            <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>"  <?php echo $this->input->method() == 'post' ? set_select('city', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                                echo '<label id="city-error" class="error" for="city">' . form_error('city') . '</label>';
                                                ?>
                                            </div>
                                            <div class="input-r">
                                                <input type="text" name="zipcode" id="zipcode" placeholder="Zip" class="input-css" value="<?php echo isset($provider_data['zipcode']) ? $provider_data['zipcode'] : set_value('zipcode'); ?>"> 
                                            </div>
                                        </div>
                                        <div class="input-wrap">
                                            <label class="label-css">Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" class="input-css" value="<?php echo isset($provider_data['phone_number']) ? $provider_data['phone_number'] : set_value('phone_number'); ?>">
                                            <?php
                                            echo '<label id="phone_number-error" class="error" for="phone_number">' . form_error('phone_number') . '</label>';
                                            ?>
                                        </div>
                                        <div class="input-wrap">
                                            <label class="label-css">Website <span class="text-danger">*</span></label>
                                            <input type="text" name="website" id="website" placeholder="Wesbsite" class="input-css" value="<?php echo isset($provider_data['website']) ? $provider_data['website'] : set_value('website'); ?>">
                                            <?php
                                            echo '<label id="website-error" class="error" for="website">' . form_error('website') . '</label>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="step-06-r">
                                        <div class="select-file">
                                            <div class="select-file-upload">
                                                <span class="select-file_up_btn up_btn">
                                                    <?php
                                                    $required = 'required="required"';
                                                    if (isset($provider_data) && $provider_data['image'] != '') {
                                                        $required = '';
                                                        echo "<img src='" . PROVIDER_IMAGES . $provider_data['image'] . "' width='100%'>";
                                                    } else {
                                                        echo 'Upload image for service provider<span>Select File</span>';
                                                    }
                                                    ?>
                                                </span>
                                                <input type="file" name="image" id="image" multiple="false" onchange="readURL(this);" <?php echo $required ?>> 
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <?php
                                $csrf = array(
                                    'name' => $this->security->get_csrf_token_name(),
                                    'hash' => $this->security->get_csrf_hash()
                                );
                                ?>
                                <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                                <div class="step-btm-btn">
                                    <button type="submit" class="next">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>	

</div>
<script type="text/javascript">
    $(function () {
        $('#category,#city,#state,#country').selectpicker({
            liveSearch: true,
            size: 5
        });
        // Setup validation
        $("#provider_form").validate({
            ignore: ['select:hidden'],
            rules: {
                category: {
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
                city: {
                    required: true,
                },
                state: {
                    required: true,
                },
                phone_number: {
                    required: true,
                    phoneUS: true
                },
                website: {
                    required: true,
                    url: true
                },
                image: {
                    extension: "jpg|png|jpeg",
                    maxFileSize: {
                        "unit": "MB",
                        "size": max_image_size
                    }
                }
            },
            messages: {
                phone_number: {
                    phoneUS: "Please specify valid us phone number."
                },
            },
            errorPlacement: function (error, element) {
                if (element.hasClass('selectpicker')) {
                    error.insertAfter(element.parent().find('.bootstrap-select'));
                } else if (element.attr("name") == "image") {
                    error.insertAfter($(".select-file"));
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
                type: "get",
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
        $('#city').val('');
        if (state_id != '') {
            $('#state').valid();
            $('.loader').show();
            $url = site_url + 'service_provider/get_cities_by_state';
            $.ajax({
                type: "get",
                url: $url,
                data: {
                    stateid: state_id,
                }
            }).done(function (data) {
                $('.loader').hide();
                $("select#city").html(data);
                $('select#city').selectpicker('refresh');
            });
        }
    });
    $(document).on('change', '#city', function () {
        $(this).valid();
    });
    // Display the preview of image on image upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var valid_extensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (valid_extensions.test(input.files[0].name)) {
                    var html = '<img src="' + e.target.result + '" style="width: 100%;" alt="">';
                    $('.up_btn').html(html);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAylcYpcGylc8GTu_PYJI7sqPVn6ITrVnM&libraries=places&callback=initAutocomplete" async defer></script>
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