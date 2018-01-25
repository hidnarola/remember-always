<style type="text/css">
    #map_wrapper {height: 400px;}
    #map_canvas {width: 100%;height: 100%;}
</style>
<div class="common-page">
    <div class="container">
        <div class="service_provder_form">
            <div class="services-form services_custom_frm">
                <form method="get" name="provider_form" id="provider_form" action="<?php echo site_url('service_provider') ?>">
                    <div class="srvs-form-div">
                        <input type="text" name="keyword" id="keyword" placeholder="Enter Keyword" class="input-css global_search" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : set_value('keyword') ?>"/>
                    </div>
                    <div class="srvs-form-div">	
                        <input type="text" name="location" id="location" placeholder="Location" class="input-css global_search" value="<?php echo ($this->input->get('location') != '') ? $this->input->get('location') : set_value('location'); ?>"/>
                    </div>
                    <input type="hidden" name="lat" id="input-latitude" value="<?php echo ($this->input->get('lat') != '') ? $this->input->get('lat') : set_value('lat'); ?>">
                    <input type="hidden" name="long" id="input-longitude" value="<?php echo ($this->input->get('long') != '') ? $this->input->get('long') : set_value('long'); ?>">

                    <div class="srvs-form-div srvs_search">	
                        <button type="button" id="provider_srch_btn" class="next" disabled><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>	
                </form>
            </div>
            <div class="result_show">
                <p><?php echo $display_msg ?></p>
            </div>
            <div class="row_directory">
                <div class="col_d_left">
                    <ul class="ul_directory">
                        <?php
                        $lat_arr = $info_content = [];
                        $start = ($this->uri->segment(2) != '') ? $this->uri->segment(2) : 0;
                        $sr = $start + 1;
                        foreach ($services as $key => $service) {
                            $lat_arr[] = [$service['name'], $service['coordinates']['latitude'], $service['coordinates']['longitude']];
                            $info_content[] = ['<div class="info_content"><h3>' . $service['name'] . '</h3><p>' . @$service['location']['display_address'][0] . '<br/>' . @$service['location']['display_address'][1] . '</p></div>'];
                            ?>
                            <li>
                                <div class="inner_d">
                                    <div class="img_profile_d">
                                        <!--<a href="#">-->
                                        <?php if ($service['image_url'] != '') { ?>
                                            <img src="<?php echo $service['image_url'] ?>"/>
                                        <?php } else { ?>
                                            <img src="assets/images/no_image.png"/>
                                        <?php } ?>
                                        <!--</a>-->
                                    </div>
                                    <div class="data_directory">
                                        <div class="data_head">
                                            <h2><a href="<?php echo $service['url'] ?>" target="_blank"><span><?php echo $sr; ?>.</span> <?php echo $service['name'] ?></a></h2>
                                            <div class="rating_span">
                                                <span class="span_ic">
                                                    <?php
                                                    $star_module = floor($service['rating']);
                                                    $half_rating = $service['rating'] - $star_module;
                                                    $star_count = 0;
                                                    while ($star_count < 5) {
                                                        for ($i = 1; $i <= $star_module; $i++) {
                                                            echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                                            $star_count++;
                                                        }
                                                        $star_module = 0;
                                                        if ($star_count < 5) {
                                                            if ($half_rating != 0) {
                                                                echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
                                                                $star_count++;
                                                                $half_rating = 0;
                                                            } else {
                                                                echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                                                $star_count++;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </span>
                                                <span class="rating_count"><?php echo $service['review_count'] ?> review<?php if ($service['review_count'] > 0) echo 's' ?></span>
                                            </div>
                                            <div class="price-category">
                                                <!--<a href="">-->
                                                <?php
                                                $categories = array_column($service['categories'], 'title');
                                                echo implode(',', $categories);
                                                ?>
                                                <!--</a>-->
                                            </div>
                                        </div>
                                        <div class="data_add">
                                            <!--<span class="neighborhood-str-list">North Beach/Telegraph Hill, Russian Hill</span>-->
                                            <?php
                                            $address = implode("<br>", $service['location']['display_address'])
                                            ?>
                                            <address><?php echo $address; ?></address>
                                            <span class="biz-phone"><?php echo $service['display_phone'] ?></span>
                                        </div>
                                    </div>
                                    <!--                                    <div class="reply_data">
                                                                            <div class="img_photo_box"><img src="https://s3-media4.fl.yelpcdn.com/photo/2KcVU8a-k1A6q4ZhTEXj8w/60s.jpg"/></div>
                                                                            <p class="snippet">Picking a headstone is an arduous responsibility, given the difficult situation. Thankfully, Henry and Joe were very kind and understanding of what…<a href="" class="">read more</a></p>
                                                                        </div>-->
                                </div>
                            </li>
                            <?php
                            $sr++;
                        }
                        ?>
                    </ul>
                    <div class="paggination-wrap">
                        <?php
                        if ($total > 0) {
                            $end = $start + count($services);
                            ?>
                            <div class="text-right">
                                <span class="records_info">Showing <?php echo $start + 1; ?>-<?php echo $end; ?> of <?php echo ($total > 10) ? $total : count($services); ?> Records</span>
                                <?php echo $links ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col_d_right">
                    <?php if ($total > 0) { ?>
                        <div class="map_img">
                            <div id="map_wrapper">
                                <div id="map_canvas" class="mapping"></div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="adv_div"><img src="assets/images/blue_adv.png"></div>
                    <div class="adv_div"><img src="assets/images/add_blue.png"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="demo"></div>
<?php $empty = count($services); ?>
<script src="http://maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization,places,drawing&key=AIzaSyBR_zVH9ks9bWwA-8AzQQyD6mkawsfF9AI" type="text/javascript"></script>
<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
    function geoSuccess(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        alert("lat:" + lat + " lng:" + lng);
    }
    function geoError() {
        alert("Geocoder failed.");
    }
    var geocoder;
    function initialize() {
        geocoder = new google.maps.Geocoder();
    }
    getLocation();

    var srch_data = '<?php echo isset($_SERVER['REDIRECT_QUERY_STRING']) ? '?' . $_SERVER['REDIRECT_QUERY_STRING'] : '' ?>';
    var empty = <?php echo $empty ?>;
    var input = (document.getElementById('location'));
    var options = {
        componentRestrictions: {country: "us"}
    };
//    var autocomplete = new google.maps.places.Autocomplete(input, options);
    var autocomplete = new google.maps.places.Autocomplete(input);
    var infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
            $('#input-latitude').val('');
            $('#input-latitude').val('');
        }
        $('#input-latitude').val(place.geometry.location.lat());
        $('#input-longitude').val(place.geometry.location.lng());
    });

    jQuery(function ($) {
        /*
         var script = document.createElement('script');
         script.src = "//maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
         document.body.appendChild(script);*/
        if (empty != 0) {
            initialize();
        }
    });

    function initialize() {
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap',
        };

        // Display a map on the page
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        map.setTilt(45);

        // Multiple Markers
        var markers = <?php echo json_encode($lat_arr) ?>;

        // Info Window Content
        var infoWindowContent = <?php echo json_encode($info_content) ?>;

        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(), marker, i;

        // Loop through our array of markers & place each one on the map  
        for (i = 0; i < markers.length; i++) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0]
            });

            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }

        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
            this.setZoom(10);
            google.maps.event.removeListener(boundsListener);
        });

    }

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
//        $('#provider_form').submit();
        submit_form();
    });
    function submit_form() {
        var location = $('#location').val();
        var keyword = $('#keyword').val();
        if (location == '' && keyword == '') {
            window.location.href = site_url + 'service_provider';
        } else if (location != '' && keyword != '') {
            window.location.href = site_url + 'service_provider?keyword=' + keyword + '&location=' + location.replace('::', ',') + '&lat=' + $('#input-latitude').val() + '&long=' + $('#input-longitude').val();
        } else if (location != '') {
            window.location.href = site_url + 'service_provider?location=' + location.replace('::', ',') + '&lat=' + $('#input-latitude').val() + '&long=' + $('#input-longitude').val();
        } else if (keyword != '') {
            window.location.href = site_url + 'service_provider?keyword=' + keyword;
        }
        return false;
    }


</script>
