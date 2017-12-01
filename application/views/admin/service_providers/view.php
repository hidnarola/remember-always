<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-hammer-wrench position-left"></i> Service Providers</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/providers'); ?>"><i class="icon-hammer-wrench position-left"></i> Service Providers</a></li>
            <li class="active"><i class="icon-comment-discussion position-left"></i><?php echo $heading; ?></li>
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
            <?php
        }
    }
    ?>
    <!-- /content area -->
    <div class="content">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel border-top-xlg border-top-info panel-white">
                <div class="panel-heading " role="tab" id="heading1">
                    <h4 class="panel-title">
                        <?php echo isset($provider_data['name']) ? $provider_data['name'] : '' ?> Service Provider Details
                        <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1" aria-expanded="true" aria-controls="collapse1" class="pull-right">
                            <i class="solsoCollapseIcon fa fa-chevron-up"></i>	
                        </a>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered page_details" data-alert="" data-all="189">
                            <tbody>
                                <tr>
                                    <th class="text-nowrap">Navigation Name :</th>
                                    <td><?php echo isset($provider_data['name']) ? $provider_data['name'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Description :</th>
                                    <td><?php echo isset($provider_data['description']) ? $provider_data['description'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Latitude :</th>
                                    <td><?php echo isset($provider_data['latitute']) ? $provider_data['latitute'] : '-' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Longitude :</th>
                                    <td><?php echo isset($provider_data['longitute']) ? $provider_data['longitute'] : '-' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Zipcode :</th>
                                    <td><?php echo isset($provider_data['zipcode']) ? $provider_data['zipcode'] : '-' ?></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap" colspan="2">Location :</th>
                                </tr>
                                <tr>
                                    <th class="text-nowrap" colspan="2"> <div id="map" class="map-container map-marker-simple"></div></th>
                                </tr>
                            </tbody>
                        </table>
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
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdsZQ2FI5Qr-fawy7THvNJKojMGoUkJP8&libraries=places&callback=initMap" async defer></script>
    <script type="text/javascript">
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
//                console.log(myLatlng.lat());
//                console.log(myLatlng.lng());
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: myLatlng,
                    zoom: 16,
                });
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
                                 marker.addListener('click', function() {
                                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + place.formatted_address);
                                infowindow.open(map, marker);
                                 });
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
    </script>