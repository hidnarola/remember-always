<!-- /theme JS files -->
<div class="create-profile">
    <div class="create-profile-top">
        <div class="container">
            <h2>Add Affiliation</h2>
        </div>
    </div>
    <div class="create-profile-body main-steps">
        <div class="container">
            <div class="create-profile-box">
                <div class="step-form">
                    <form method="post" enctype="multipart/form-data" id="affiliation_form">
                        <div id="forth-step">
                            <div class="step-title">
<!--                                <h2>Add <small>(optional)</small> </h2>
                                <p>Enter information about important milestones in your loved ones life.</p>-->
                            </div>
                            <div class="step-form">
                                <div class="step-06">
                                    <div class="step-06-l">
                                        <div class="input-wrap">
                                            <label class="label-css">Category <span class="text-danger">*</span></label>
                                            <select name="category" id="category" class="selectpicker">
                                                <option value="">-- Select Category --</option>
                                                <?php
                                                if (isset($categories) && !empty($categories)) {
                                                    foreach ($categories as $key => $value) {
                                                        $selected = '';
                                                        if (isset($provider_data['category_id']) && $provider_data['category_id'] == $value['id']) {
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
                                            <div class="input-three-l">
                                                <select name="country" id="country" class="selectpicker">
                                                    <option value="">-- Select Country --</option>
                                                    <?php
                                                    if (isset($countries) && !empty($countries)) {
                                                        foreach ($countries as $key => $value) {
                                                            $selected = '';
                                                            if (isset($provider_data) && $provider_data['country'] == $value['id']) {
                                                                $selected = 'selected';
                                                            }
                                                            ?>
                                                            <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>"  <?php echo $this->input->method() == 'post' ? set_select('country', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                                echo '<label id="country-error" class="error" for="country">' . form_error('country') . '</label>';
                                                ?>
                                            </div>
                                            <div class="input-three-m">
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
                                            <div class="input-three-r">
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
                                        </div>
                                    </div>
                                    <div class="step-06-r">
                                        <div class="select-file">
                                            <div class="select-file-upload">
                                                <span class="select-file_up_btn up_btn">
                                                    <?php
                                                    if (isset($provider_data) && $provider_data['image'] != '') {
                                                        echo "<img src='" . PROVIDER_IMAGES . $provider_data['image'] . "'>";
                                                    } else {
                                                        echo 'Upload image for service provider<span>Select File</span>';
                                                    }
                                                    ?>
                                                </span>
                                                <input type="file" name="image" id="image" multiple="false"> 
                                            </div>
                                        </div>
                                    </div>

                                </div>
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
        $('#category').selectpicker({
            liveSearch: true,
            size: 5
        });
        $('#country').selectpicker({
            liveSearch: true,
            size: 5
        });
        $('#city').selectpicker({
            liveSearch: true,
            size: 5
        });
        $('#state').selectpicker({
            liveSearch: true,
            size: 5
        });
        // Setup validation
        $("#affiliation_form").validate({
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
                country: {
                    required: true,
                },
                state: {
                    required: true,
                },
                city: {
                    required: true,
                },
                image: {
                    extension: "jpg|png|jpeg",
                    maxFileSize: {
                        "unit": "MB",
                        "size": max_image_size
                    }
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "image") {
                    error.insertAfter($(".select-file"));
                } else if (element.hasClass('selectpicker')) {
                    error.insertAfter(element.parent().find('.bootstrap-select'));
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });

    $(document).on('change', '#country', function () {
        var country_id = $("#country option:selected").val();
        $url = '<?php echo base_url() ?>' + 'affiliation/get_data';
        $.ajax({
            type: "POST",
            url: $url,
            data: {
                id: country_id,
                type: 'state',
            }
        }).done(function (data) {
            if (data != '') {
                $("select#state").html(data);
                $("select#state").selectpicker('refresh');
            }
        });
    });
    $(document).on('change', '#state', function () {
        var state_id = $("#state option:selected").val();
        $url = '<?php echo base_url() ?>' + 'affiliation/get_data';
        $.ajax({
            type: "POST",
            url: $url,
            data: {
                id: state_id,
                type: 'city',
            }
        }).done(function (data) {
            if (data != '') {
                $("select#city").html(data);
                $("select#city").selectpicker('refresh');
            }
        });
    });
    $(document).on('change', '#image', function (e) {
        readURL(this);
    });
    // Display the preview of image on image upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var valid_extensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (valid_extensions.test(input.files[0].name)) {
                    var html = '<img src="' + e.target.result + '" style="width: 170px; border-radius: 2px;" alt="">';
                    $('.up_btn').html(html);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAylcYpcGylc8GTu_PYJI7sqPVn6ITrVnM&libraries=places&callback=initAutocomplete" async defer></script>
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/googleAutoComplete.js') ?>"></script>
<style>