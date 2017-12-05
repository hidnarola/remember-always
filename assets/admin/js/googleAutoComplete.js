function initAutocomplete() {
    $('#street1').each(function () {
        console.log("asdjasdbhj");
        var currentThis = $(this);
        var input = document.getElementById('street1');
//        var options = {
//            componentRestrictions: {country: 'uk'}
//        };
        var options = {
//            types: ['(cities)'],
            componentRestrictions: {country: "us"}
        };
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener('place_changed', function () {
            var places = autocomplete.getPlace();
//            console.log(places);
            if (places.length == 0) {
                 swal("Cancelled", "Your entered address is not able to track on google so please enter correct address. :)", "error");
                return;
            }
            
//            places.forEach(function (place) {
                if (typeof places.geometry !== 'undefined') {
                    $('#latitute').val(places.geometry.location.lat());
                    $('#longitute').val(places.geometry.location.lng());
                } else {
                    googleLocationIssuePrompt();
                }
//            });

            /**
             * This code is used copy address when selection is done from auto complete
             */
            fillInAddress(places);
        });
    });
}

function fillInAddress(place) {
    var componentForm = {
        street_number: 'long_name',
        route: 'long_name',
        sublocality_level_1: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        postal_code: 'long_name',
    };
    var formFields = {
        street_number: 'street1',
        route: 'street1',
        sublocality_level_1: 'street2',
        locality: 'city',
        administrative_area_level_1: 'state',
        postal_code: 'zipcode',
    };
    fillInAddressComponents(place, componentForm, formFields);
}

function fillInAddressComponents(place, componentForm, formFields) {
//    place = place[0];
    for (var field in formFields) {
        document.getElementById(formFields[field]).value = '';
    }
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    if (typeof place.address_components != 'undefined') {
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (formFields[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                if (addressType === 'street_number' || addressType === 'route' || addressType == 'sublocality_level_2') {
                    document.getElementById(formFields[addressType]).value += ' ' + val;
                } else {
                    document.getElementById(formFields[addressType]).value = val;
                }
            }
        }
    }
}

function googleLocationIssuePrompt() {
    var title = 'Information';
    var data_message = 'Your entered address is not able to track on google so please enter your address manually.';
    swal("Cancelled", "Your entered address is not able to track on google so please enter correct address. :)", "error");
}

$(document).ready(function () {
    $(document).on('change', '#street1', initAutocomplete);
});