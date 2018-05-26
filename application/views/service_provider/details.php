<script src="assets/js/jquery.fancybox.js"></script>
<script src="assets/js/jquery.fancybox.pack.js"></script>
<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Services Provider Directory</h2>
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
            <div class="srvs-dtl-l">
                <div class="profile-box">
                    <div id="map" class="custom_map"></div>
                    <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d409238.3125063342!2d34.24871928851536!3d36.74238673925092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1527f4a4c0be6e9f%3A0x4dbef2b1f81e7d77!2sMersin%2C+Mesudiye+Mahallesi%2C+Camili+Mahallesi%2FAkdeniz%2FMersin+Province%2C+Turkey!5e0!3m2!1sen!2sin!4v1513226635691" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
                </div>
                <div class="ad-srvs-dtl">
                    <div class="profile-box ad">
                        <a href=""><img src="assets/images/ad.jpg" alt=""></a>
                    </div>
                    <div class="profile-box ad">
                        <a href=""><img src="assets/images/ad.jpg" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="srvs-dtl-r">
                <h3><?php echo isset($provider_data['name']) ? $provider_data['name'] : '' ?> <?php echo isset($provider_data['category_name']) ? '(' . $provider_data['category_name'] . ')' : '' ?>
                    <!--<small>Category : </small>-->
                </h3>
                <p> <?php
                    if (isset($provider_data['image']) && !is_null($provider_data['image'])) {
                        ?>
                        <a href ="<?php echo PROVIDER_IMAGES . $provider_data['image'] ?>" class="fancybox"><img src="<?php echo PROVIDER_IMAGES . $provider_data['image'] ?>"/></a>
                    <?php } echo implode('</p><p>', array_filter(explode("\n", $provider_data['description']))) ?></p>
                <div class="srvs-personal-dtl">
                    <h6 class="srvs-contact"><strong>Country :</strong> <a><?php echo isset($provider_data['country_name']) ? $provider_data['country_name'] : '' ?></a></h6>
                    <h6 class="srvs-contact"><strong>State :</strong> <a><?php echo isset($provider_data['state_name']) ? $provider_data['state_name'] : '' ?></a></h6>
                    <h6 class="srvs-contact"><strong>City :</strong> <a><?php echo isset($provider_data['city_name']) ? $provider_data['city_name'] : '' ?></a></h6>
                    <h6 class="srvs-contact"><strong>Zip Code :</strong> <a><?php echo isset($provider_data['zipcode']) ? $provider_data['zipcode'] : '' ?></a></h6>
                    <h6 class="srvs-contact"><strong>Contact :</strong> <a><?php echo isset($provider_data['phone_number']) ? $provider_data['phone_number'] : '' ?></a></h6>
                    <h6><strong>Site :</strong> <a href="<?php echo isset($provider_data['website_url']) ? $provider_data['website_url'] : '' ?>"><?php echo isset($provider_data['website_url']) ? $provider_data['website_url'] : '' ?></a></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization,places,drawing&key=AIzaSyBR_zVH9ks9bWwA-8AzQQyD6mkawsfF9AI&callback=initMap" async defer></script>
<script>
    function initMap() {
        var prop_lat = '<?php
                    if (isset($provider_data)) {
                        echo $provider_data['latitute'];
                    }
                    ?>';
        var prop_lng = '<?php
                    if (isset($provider_data)) {
                        echo $provider_data['longitute'];
                    }
                    ?>';
        var prop_address = '<?php
                    if (isset($provider_data)) {
                        echo $provider_data['location'];
                    }
                    ?>';
        var prop_zipcode = '<?php
                    if (isset($provider_data) && !empty($provider_data['zipcode'])) {
                        echo $provider_data['zipcode'];
                    }
                    ?>';
        if (prop_lat != '' && prop_lng != '') {
            var myLatlng = new google.maps.LatLng(parseFloat(prop_lat), parseFloat(prop_lng));
            console.log(document.getElementById('map'));
            var map = new google.maps.Map(document.getElementById('map'), {
                center: myLatlng,
                zoom: 16,
//                allowfullscreen:true,
            });
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'address': prop_address
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var service = new google.maps.places.PlacesService(map);
                    console.log(results[0]['place_id']);
                    service.getDetails({
                        placeId: results[0]['place_id']
                    }, function (place, status) {
                        marker.setPosition(place.geometry.location);
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + place.formatted_address);
                            infowindow.open(map, marker);
                        }
                    });
                }
            });

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -25),
                position: {lat: parseFloat(prop_lat), lng: parseFloat(prop_lng)}
            });
        }

    }
    $(".fancybox").fancybox();
    $('#category').selectpicker({
        liveSearch: true,
        size: 5
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
</script>
