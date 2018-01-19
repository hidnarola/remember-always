<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Contact Us</h2>
        </div>

        <!--<div style="background-image: url('<?php // echo PAGE_BANNER.'/'.$page_data['banner_image']                     ?>');" class="hero-image-inner">-->

        <div class="common-body">
            <div class="srvs-dtl-l">
                <div class="profile-box">
                    <div id="map" class="custom_map"></div>
                </div>
            </div>
            <div class="srvs-dtl-r">
                <p><strong>Address :</strong><br/><a href="https://www.google.com/maps/place/3415+W+Lake+Mary+Blvd+%23951965lake,+Lake+Mary,+FL+32746,+USA/@28.7554428,-81.3406926,17z/data=!4m5!3m4!1s0x88e76d583d725ad1:0x93eca9ac4182673a!8m2!3d28.7554428!4d-81.3385039" target="_blank"> 3415 W. Lake Mary Blvd. #951965 <br/> Lake Mary, FL 32795 </a></p>
                <p><strong>Phone :</strong> 863-703-6036</p>
                <p><strong>E-mail :</strong> support@rememberalways.com</p>
            </div>
        </div>
    </div>
</div>
<script src="http://maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization,places,drawing&key=AIzaSyBR_zVH9ks9bWwA-8AzQQyD6mkawsfF9AI&callback=initMap" async defer></script>
<script>
    function initMap() {

        var myLatlng = new google.maps.LatLng(28.7554428, -81.3406926);
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

</script>