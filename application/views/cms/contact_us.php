<script src="assets/js/jquery.fancybox.js"></script>
<script src="assets/js/jquery.fancybox.pack.js"></script>
<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Contact Us</h2>
        </div>
        <div class="common-body">
            <div class="srvs-dtl-l">
                <div class="profile-box">
                    <div id="map" class="custom_map"></div>
                    <br/>
                    <p><strong>Address :</strong><br/><a href="https://www.google.com/maps/place/3415+W+Lake+Mary+Blvd+%23951965lake,+Lake+Mary,+FL+32746,+USA/@28.7554428,-81.3406926,17z/data=!4m5!3m4!1s0x88e76d583d725ad1:0x93eca9ac4182673a!8m2!3d28.7554428!4d-81.3385039" target="_blank"> 3415 W. Lake Mary Blvd. #951965 <br/> Lake Mary, FL 32795 </a></p>
                    <p><strong>Phone :</strong> 863-703-6036</p>
                    <p><strong>E-mail :</strong> support@rememberalways.com</p>
                </div>
            </div>
            <div class="srvs-dtl-r">
                <form method="post" id="contact_us_form">
                    <div class="input-wrap">
                        <label class="label-css">Name</label>
                        <input type="text" name="name" placeholder="Enter Your Name" class="input-css" value="<?php echo set_value('name') ?>"/>
                        <?php
                        echo '<label id="name-error" class="error" for="name">' . form_error('name') . '</label>';
                        ?>
                    </div>
                    <div class="input-wrap">
                        <label class="label-css">E-mail</label>
                        <input type="text" name="email" placeholder="Enter Your Email" class="input-css" value="<?php echo set_value('email') ?>">
                        <?php
                        echo '<label id="email-error" class="error" for="email">' . form_error('email') . '</label>';
                        ?>
                    </div>
                    <div class="input-wrap">
                        <label class="label-css">Phone</label>
                        <input type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="input-css" value="<?php echo set_value('phone') ?>">
                        <?php
                        echo '<label id="phone-error" class="error" for="phone">' . form_error('phone') . '</label>';
                        ?>
                    </div>
                    <div class="input-wrap">
                        <label class="label-css">Subject</label>
                        <input type="text" name="subject" placeholder="Enter Subject" class="input-css" value="<?php echo set_value('subject') ?>">
                        <?php
                        echo '<label id="subject-error" class="error" for="subject">' . form_error('subject') . '</label>';
                        ?>
                    </div>
                    <div class="input-wrap">
                        <label class="label-css">Message</label>
                        <textarea name="message" placeholder="Enter Message" class="input-css" rows="5"><?php echo set_value('message') ?></textarea>
                        <?php
                        echo '<label id="message-error" class="error" for="message">' . form_error('message') . '</label>';
                        ?>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LfQPEIUAAAAAG3Z9wdXuPnlmUe_k2ZL9ij50deY"></div>
                    <?php
                    echo '<label id="g-recaptcha-response-error" class="error" for="g-recaptcha-response">' . form_error('g-recaptcha-response') . '</label>';
                    ?>
                    <?php
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );
                    ?>
                    <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                    <div class="edit-update step-btm-btn">
                        <button type="submit" class="next" id="send_email_btn">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization,places,drawing&key=AIzaSyBR_zVH9ks9bWwA-8AzQQyD6mkawsfF9AI&callback=initMap" async defer></script>
<!-- Jquery mask js file -->
<script src="assets/js/jquery.mask.min.js" type="text/javascript"></script>
<!-- /Jquery mask js file -->
<script>
    $('#phone').mask("999-999-9999");
    function initMap() {

        var myLatlng = new google.maps.LatLng(28.7554428, -81.3406926);
        var map = new google.maps.Map(document.getElementById('map'), {
            center: myLatlng,
            zoom: 16,
        });
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            'address': '3415 W. Lake Mary Blvd. #951965 Lake Mary, FL 32795'
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
                    }
                });
            }
        });

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -25),
            position: {lat: 28.7554428, lng: -81.3406926}
        });
    }
    // Signup Form validation
    $("#contact_us_form").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                email: true,
                required: true,
            },
            phone: {
                required: true,
                phoneUS: true,
//                minlength: 8,
//                maxlength: 15,
            },
            subject: {
                required: true,
            },
            message: {
                required: true,
                minlength: 10,
            },
        },
        submitHandler: function (form) {
            $('.loader').show();
            $('#send_email_btn').attr('disabled', true);
            form.submit();
        }
    });
</script>