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
            <?php
        }
    }
    ?>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <!-- Basic layout-->
                    <form  method="post" id="page_info" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                        <div class="panel panel-flat">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Select Service Category:</label>
                                    <select name="service_category" id="service_category" class="form-control">
                                        <option value="">None</option>
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
                                    <label>Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($provider_data['name']) ? $provider_data['name'] : set_value('name'); ?>">
                                </div>

                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea name="description" id="description" rows="4" cols="4" class="form-control"><?php echo isset($provider_data['description']) ? $provider_data['description'] : set_value('description'); ?></textarea>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Location <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <div class="form-group mt-1">
                                            <input id="searchInput" name="location" class="controls form-control" type="text" placeholder="Enter a location" value="<?php echo set_value('location'); ?>">
                                            <div id="map" class="map-container map-basic"></div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12 mt-10">
                                        <div class="form-group col-md-4">
                                            <input type="text" name="latitute" id="latitute" class="form-control" placeholder="Latitude" readonly value="<?php echo set_value('latitute'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" name="longitute" id="longitute" class="form-control" placeholder="Longitude" readonly value="<?php set_value('longitute'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="zipcode" readonly value="<?php echo set_value('zipcode'); ?>">
                                        </div>
                                    </div>
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
                    location: {
                        required: true,
                    },

                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "banner_image") {
                        error.insertAfter($(".uploader"));
                    } else if (element.attr("name") == "description") {
                        error.insertAfter(element.parent());
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
        $(".file-styled").uniform({
            fileButtonClass: 'action btn bg-pink'
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdsZQ2FI5Qr-fawy7THvNJKojMGoUkJP8&libraries=places&callback=initMap" async defer></script>
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
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 37.09024, lng: -95.712891},
                zoom: 5,
//            mapTypeControlOptions: {
//                mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'tehgrayz']
//            }
            });
            if (prop_lat != '' && prop_lng != '') {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: parseFloat(prop_lat), lng: parseFloat(prop_lng)},
                    zoom: 16,
//                mapTypeControlOptions: {
//                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'tehgrayz']
//                }
                });
            }
//        var mapType = new google.maps.StyledMapType(stylez, {name: "Grayscale"});
//        map.mapTypes.set('tehgrayz', mapType);
//        map.setMapTypeId('tehgrayz');
            input = document.getElementById('searchInput');
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
//                draggable: true
            });
            if (prop_lat != '' && prop_lng != '') {
                var marker = new google.maps.Marker({
                    map: map,
                    anchorPoint: new google.maps.Point(0, -29),
//                    draggable: true,
                    position: {lat: parseFloat(prop_lat), lng: parseFloat(prop_lng)}
                });
                $('#searchInput').val(prop_address);
                $('#latitute').val(prop_lat);
                $('#longitute').val(prop_lng);
                $('#zipcode').val(prop_zipcode);
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'address': prop_address
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var service = new google.maps.places.PlacesService(map);
                        service.getDetails({
                            placeId: results[0]['place_id']
                        }, function (place, status) {
                            marker.setPosition(place.geometry.location);
                            if (status === google.maps.places.PlacesServiceStatus.OK) {
                                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + place.formatted_address);
                                infowindow.open(map, marker);
                                marker.addListener('click', function () {
                                    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + place.formatted_address);
                                    infowindow.open(map, marker);
                                });
                            }
                        });
                    }
                });
            }

//            marker.addListener('drag', function () {
//                console.log(marker.getPosition());
////              console.log(this.getPosition().lat());
////              console.log(this.getPosition().lng());
////              console.log(this.getPosition().postal_code());
//            });
//            marker.addListener('dragend', function () {
//               var place = autocomplete.getPlace();
//                if (!place.geometry) {
//                    window.alert("Autocomplete's returned place contains no geometry");
//                    return;
//                }
//
//                // If the place has a geometry, then present it on a map.
//                if (place.geometry.viewport) {
//                    map.fitBounds(place.geometry.viewport);
//                } else {
//                    map.setCenter(place.geometry.location);
//                    map.setZoom(17);
//                }
//                marker.setIcon(({
//                    url: place.icon,
//                    size: new google.maps.Size(71, 71),
//                    origin: new google.maps.Point(0, 0),
//                    anchor: new google.maps.Point(17, 34),
//                    scaledSize: new google.maps.Size(35, 35)
//                }));
//                marker.setPosition(place.geometry.location);
//                marker.setVisible(true);
//                var address = '';
//                if (place.address_components) {
//                    address = [
//                        (place.address_components[0] && place.address_components[0].short_name || ''),
//                        (place.address_components[1] && place.address_components[1].short_name || ''),
//                        (place.address_components[2] && place.address_components[2].short_name || '')
//                    ].join(' ');
//                }
//
//                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
//                infowindow.open(map, marker);
//                //Location details
//                for (var i = 0; i < place.address_components.length; i++) {
//                    if (place.address_components[i].types[0] == 'postal_code') {
//                        console.log("in here");
//                        $('#zipcode').val(place.address_components[i].long_name);
//                    } else {
//                        $('#zipcode').val('');
//                    }
//                }
//                $('#latitute').val(place.geometry.location.lat());
//                $('#longitute').val(place.geometry.location.lng());
//            });
            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + place.formatted_address);
                infowindow.open(map, marker);
                //Location details
                for (var i = 0; i < place.address_components.length; i++) {
                    if (place.address_components[i].types[0] == 'postal_code') {
                        $('#zipcode').val(place.address_components[i].long_name);
                    } else {
                        $('#zipcode').val('');
                    }
                }
//            console.log(place);
                //document.getElementById('location').innerHTML = place.formatted_address;
                $('#latitute').val(place.geometry.location.lat());
                $('#longitute').val(place.geometry.location.lng());
            });
        }


        $(document).on('keyup', '#searchInput', function () {
            if ($(this).val() == '') {
//                var input = document.getElementById('searchInput');
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 37.09024, lng: -95.712891},
                    zoom: 5,
                });
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                $('#latitute').val('');
                $('#longitute').val('');
                $('#zipcode').val('');
            }
        });
    </script>
    <style>
        .hide {
            display: none;
        }
        #map {
            width: 100%;
            height: 400px;
        }
        .controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }
        #searchInput {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 50%;
        }
        #searchInput:focus {
            border-color: #4d90fe;
        }
        #searchInput-error, #location-error{
            margin-left: 12%;
            margin-top: 4.5%;
        }
    </style>