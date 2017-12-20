<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Services Provider Directory</h2>
            <a href="<?php echo site_url('service_provider/add') ?>" class="pspl">Post a Services Provider Listing</a>
        </div>
        <div class="common-body">
            <div class="services-form">
                <form method="get" name="provider_form" id="provider_form">
                    <div class="srvs-form-div">
                        <select name="category" id="category" class="selectpicker">
                            <option value="">-- Select Category --</option>
                            <?php
                            if (isset($service_categories) && !empty($service_categories)) {
                                foreach ($service_categories as $key => $value) {
                                    $selected = '';
                                    if (isset($_GET['category']) && $_GET['category'] == $value['name']) {
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option <?php echo $selected; ?> value="<?php echo $value['name'] ?>"><?php echo $value['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="srvs-form-div">
                        <input type="text" name="keyword" id="keyword" placeholder="Enter Keyword" class="input-css" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : set_value('keyword') ?>"/>
                    </div>
                    <div class="srvs-form-div">	
                        <input type="text" name="location" id="location" placeholder="Location" class="input-css" value="<?php echo ($this->input->get('location') != '') ? $this->input->get('location') : set_value('location'); ?>"/>
                    </div>
                    <input type="hidden" name="lat" id="input-latitude" value="<?php echo ($this->input->get('lat') != '') ? $this->input->get('lat') : set_value('lat'); ?>">
                    <input type="hidden" name="long" id="input-longitude" value="<?php echo ($this->input->get('long') != '') ? $this->input->get('long') : set_value('long'); ?>">

                    <div class="srvs-form-div">	
                        <button type="button"  id="provider_srch_btn" class="next" disabled>Search</button>
                    </div>	
                </form>
            </div>
            <div class="services-pro-l">
                <div class="profile-box services-listings" >
                    <h2>Services Listing</h2>
                    <div id="service_ul_data">
                        <ul class="srvs-list-ul service_content" >
                            <?php
                            if (isset($services) && !empty($services)) {
                                foreach ($services as $key => $value) {
                                    ?>
                                    <li>
                                        <span> 
                                            <?php
                                            if (isset($value['image']) && !is_null($value['image'])) {
                                                ?>
                                                <img src="<?php echo PROVIDER_IMAGES . $value['image'] ?>" width="100%" height="100%"/>
                                            <?php } ?>
                                        </span>
                                        <h3><a href="<?php echo site_url('service_provider/view/' . $value['slug']) ?>"><?php echo $value['name'] ?></a></h3>
                                        <p><?php
                                            $text = $value['description'];
                                            if (strlen($value['description']) > 500) {
                                                $text = preg_replace("/^(.{1,500})(\s.*|$)/s", '\\1...', $value['description']);
                                                echo $text;
                                            } else {
                                                echo $text;
                                            }
                                            ?></p>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <p class="no-data">No Services available</p>
                            <?php } ?>
                        </ul>
                        <!--<div class="loader"><img src="assets/images/loader2.gif" /></div>-->
                    </div>
                    <!--                    <div class="loader" style="display: none">
                                            <img src="assets/images/loader.gif" />
                                        </div>-->
                </div>
            </div>
            <div class="services-pro-r">
                <div class="profile-box services-ctgr affiliations">
                    <h2>Services Categories</h2>
                    <div class="profile-box-body">
                        <ul>
                            <?php if (isset($service_categories) && !empty($service_categories)) { ?>
                                <li><a href="<?php echo site_url('service_provider') ?>" class="<?php echo!isset($_GET['category']) ? 'active' : '' ?>">All Service Providers</a></li>
                                <?php foreach ($service_categories as $key => $value) {
                                    ?>
                                    <li><a href="javascript:void(0)" data-value="<?php echo $value['name'] ?>"class="category_click <?php echo isset($_GET['category']) && $_GET['category'] == $value['name'] ? 'active' : '' ?>"><?php echo $value['name'] ?></a></li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li><p class="no-data">No Services Categories available.</p></li>
                            <?php } ?>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="services-pro-m">
                <div class="profile-box ad">
                    <a href=""><img src="assets/images/ad.jpg" alt=""></a>
                </div>
                <div class="profile-box ad">
                    <a href=""><img src="assets/images/ad.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization,places,drawing&key=AIzaSyBR_zVH9ks9bWwA-8AzQQyD6mkawsfF9AI" type="text/javascript"></script>
<script>
    $('.loader').hide();
    var provider_image = '<?php echo PROVIDER_IMAGES ?>';
    var provider_url = '<?php echo site_url('service_provider/view/') ?>';
    $('#category').selectpicker({
        liveSearch: true,
        size: 5
    });
    $("#service_ul_data").mCustomScrollbar({
        axis: "y",
        scrollButtons: {enable: true},
        theme: "3d",
        callbacks: {
            onScroll: function () {
                if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                    var limitStart = $(".service_content li").length;
//                     $(".loader").show();
                    loadResults(limitStart);
                }
            }, /*user custom callback function on scroll event*/

        },
        advanced: {

            updateOnBrowserResize: true, /*update scrollbars on browser resize (for layouts based on percentages): boolean*/

            updateOnContentResize: true, /*auto-update scrollbars on content resize (for dynamic content): boolean*/

            autoExpandHorizontalScroll: true, /*auto-expand width for horizontal scrolling: boolean*/

            autoScrollOnFocus: true /*auto-scroll on focused elements: boolean*/

        },
    });
    var input = (document.getElementById('location'));
    var options = {
        componentRestrictions: {country: "us"}
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    var infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }
        $('#input-latitude').val(place.geometry.location.lat());
        $('#input-longitude').val(place.geometry.location.lng());
        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
//            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    });
    $(document).on('click', '.category_click', function () {
        submit_form($(this).data('value'));
    });
    $(document).on('keyup paste', 'input[type="text"]', function () {
        if ($(this).val() != '') {
            $('#provider_srch_btn').removeAttr('disabled');
        }
    });
    $(document).on('change', 'select', function () {
        if ($(this).val() != '') {
            $('#provider_srch_btn').removeAttr('disabled');
        }
    });
    $(document).on('click', '#provider_srch_btn', function () {
        submit_form($('#category').val());
    });
    function submit_form(category) {
        var location = $('#location').val();
        var keyword = $('#keyword').val();
//        var category = $('#category').val();
        if (location == '' && keyword == '' && category == '') {
            window.location.href = site_url + 'service_provider';
        } else if (location == '' && keyword == '' && category != '') {
            window.location.href = site_url + 'service_provider?category=' + category;
        } else {
            var url = '';
            if (location != '') {
                url += '?location=' + location.replace('::', ',') + '&lat=' + $('#input-latitude').val() + '&long=' + $('#input-longitude').val();
            }
            if (category != '') {
                if (url != '')
                    url += '&category=' + category;
                else
                    url += '?category=' + category;
            }
            if (keyword != '') {
                if (url != '')
                    url += '&keyword=' + keyword;
                else
                    url += '?keyword=' + keyword;
            }
            window.location.href = site_url + 'service_provider' + url;
        }
        return false;
    }
//    $('#service_ul_data').scroll(function () {
//        if ($(".loader").css('display') == 'none') {

//        }
//    });
    function loadResults(limitStart) {
        $.ajax({
            url: '<?php echo site_url() ?>' + 'service_provider/load_providers/' + limitStart,
            type: "post",
            dataType: "json",
//            data: {
//                limitStart: limitStart
//            },
            success: function (data) {
                var string = '';
                $.each(data, function (index, value) {
                    string += '<li>' +
                            '<span>';
                    if (typeof value['image'] != 'undefined' && value['image'] != null) {
                        string += '<img src="' + provider_image + value['image'] + '" width="100%" height="100%" />';
                    }
                    string += '</span>' +
                            '<h3><a href="' + provider_url + value['slug'] + '">' + value['name'] + '</a></h3>' +
                            '<p>';
                    text = value['description'];
                    if (value['description'].length > 500) {
//                        text = value['description'].preg_replace("/^(.{1,500})(\s.*|$)/s", '\\1...');
                        text = value['description'].substring(0, 500);
                        text += '...';
                    }
                    string += text;
                    string += '</p>';
                    $(".service_content").append(string);
                });
//                $(".loader").hide();
            }
        });
    }
</script>
