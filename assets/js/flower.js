$(function () {
    jQuery.validator.addMethod("card_validator", function (value, element) {
        var select_val = $("#c_card").val().toLowerCase();
        var result = '';
        if (select_val == 'ax') {
            $('#c_cardnumber').validateCreditCard(function (value) {
                result = value;
            });

            if (result.card_type != null && result.card_type.name == 'amex' && result.valid == true) {
                return true;
            } else {
                return false;
            }
        } else if (select_val == 'vi' || select_val == 'mc' || select_val == 'di') {
            $('#c_cardnumber').validateCreditCard(function (value) {
                result = value;
            });
            if (result.card_type != null && (result.card_type.name == 'mastercard' || result.card_type.name == 'discover' || result.card_type.name == 'visa') && result.valid === true) {
                return true;
            } else {
                return false;
            }
        } else {
            $('#c_cardnumber').validateCreditCard(function (value) {
                result = value;
            });
            if (result.valid) {
                return true;
            } else {
                return false;
            }
        }
    }, "The specified US or Canadian ZIP Code is invalid");

    $("i").tooltip();
    $(".fancybox")
            .fancybox({
                openEffect: 'none',
                closeEffect: 'none',
                nextEffect: 'none',
                prevEffect: 'none',
                padding: 0,
            });
    $('.country').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('.city').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('.state').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('#r_d_date').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('.c_country').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('.c_city').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('.c_state').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('#c_card').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('#c_month').selectpicker({
        liveSearch: true,
        size: 5
    });
    $('#c_year').selectpicker({
        liveSearch: true,
        size: 5
    });
    // Deliver From data validation
    $('#cart_form').validate({
        ignore: ['select:hidden'],
        errorClass: 'error',
        rules: {
            r_name: {
                required: true
            },
            r_address1: {
                required: true,
            },
            r_country: {
                required: true,
            },
            r_state: {
                required: true,
            },
            r_city: {
                required: true,
            },
            r_address1: {
                required: true,
            },
            r_zipcode: {
                required: true,
//                custom_zipcode: true
            },
            r_phone: {
                required: true,
//                number: true,
//                maxlength: 13,
                maxlength: 10,
                minlength: 10,
            },
            r_d_date: {
                required: true,
            },
            r_card_msg: {
                required: true,
//                maxlength: 200
            },
        },
        errorPlacement: function (error, element) {
            if (element.hasClass('selectpicker')) {
                element.parent().find('.bootstrap-select').addClass('error');
            }
        }
    });
    $('#cart_deliver_form').validate({
        ignore: ['select:hidden'],
        errorClass: 'error',
        rules: {
            c_fname: {
                required: true
            },
            c_lname: {
                required: true,
            },
            c_country: {
                required: true,
            },
            c_state: {
                required: true,
            },
            c_city: {
                required: true,
            },
            c_address1: {
                required: true,
            },
            c_zipcode: {
                required: true,
//                custom_zipcode: true
            },
            c_phone: {
                required: true,
//                number: true,
                maxlength: 10,
                minlength: 10,
            },
            c_email: {
                required: true,
                email: true
            },
            c_card: {
                required: true,
            },
            c_cardnumber: {
                required: true,
//                card_validator: true,
                number: true
            },
            c_month: {
                required: true,
            },
            c_year: {
                required: true,
            },
            c_code: {
                required: true,
                number: true
            },
        },
        errorPlacement: function (error, element) {
            if (element.hasClass('selectpicker')) {
                element.parent().find('.bootstrap-select').addClass('error');
            }
        }
    });
    var shrt_des_maxlengthChars = $("#card_msg");
    var shrt_des_maxlength_length = shrt_des_maxlengthChars.attr('maxlengthlength');
    if (shrt_des_maxlength_length > 0) {
        shrt_des_maxlengthChars.bind('keyup', function (e) {
            shrt_des_length = new Number(shrt_des_maxlengthChars.val().length);
            shrt_des_counter = shrt_des_maxlength_length - shrt_des_length;
            $("#card_msg_count").text("(" + shrt_des_counter + " characters remaining)");
        });
    }
    var add_maxlengthChars = $("#instruct");
    var add_maxlength_length = add_maxlengthChars.attr('maxlengthlength');
    if (add_maxlength_length > 0) {
        add_maxlengthChars.bind('keyup', function (e) {
            add_length = new Number(add_maxlengthChars.val().length);
            add_counter = add_maxlength_length - add_length;
            $("#instruct_count").text("(" + add_counter + " characters remaining)");
        });
    }
});
$(document).on('change', '.selectpicker', function () {
    if ($(this).val() != '') {
        $(this).parent().find('.bootstrap-select').removeClass('error');
        if ($(this).parent().find('.bootstrap-select').hasClass('country')) {
            var country_id = $('option:selected', this).attr('data-bind');
            $url = site_url + 'flowers/get_data';
            $.ajax({
                type: "POST",
                url: $url,
                data: {
                    id: country_id,
                    type: 'state',
                }
            }).done(function (data) {
                if (data != '') {
                    $("#r_state").html(data);
                    $("#r_state").selectpicker('refresh');
                    $("#r_city").html('<option value="">-- Select City --</option>');
                    $("#r_city").selectpicker('refresh');
                }
            });
        } else if ($(this).parent().find('.bootstrap-select').hasClass('state')) {
            var state_id = $('option:selected', this).attr('data-bind');
            $url = site_url + 'flowers/get_data';
            $.ajax({
                type: "POST",
                url: $url,
                data: {
                    id: state_id,
                    type: 'city',
                }
            }).done(function (data) {
                if (data != '') {
                    $("#r_city").html(data);
                    $("#r_city").selectpicker('refresh');
                }
            });
        } else if ($(this).parent().find('.bootstrap-select').hasClass('c_country')) {
            var country_id = $('option:selected', this).attr('data-bind');
            $url = site_url + 'flowers/get_data';
            $.ajax({
                type: "POST",
                url: $url,
                data: {
                    id: country_id,
                    type: 'state',
                }
            }).done(function (data) {
                if (data != '') {
                    $("#c_state").html(data);
                    $("#c_state").selectpicker('refresh');
                }
            });
        } else if ($(this).parent().find('.bootstrap-select').hasClass('c_state')) {
            var state_id = $('option:selected', this).attr('data-bind');
            $url = site_url + 'flowers/get_data';
            $.ajax({
                type: "POST",
                url: $url,
                data: {
                    id: state_id,
                    type: 'city',
                }
            }).done(function (data) {
                if (data != '') {
                    $("#c_city").html(data);
                    $("#c_city").selectpicker('refresh');
                }
            });
        }
    }
});
$(document).on('focusout', '#r_zipcode', function () {
    var zip = $(this).val();
    $url = site_url + 'flowers/get_data';
    $.ajax({
        type: "POST",
        url: $url,
        data: {
            id: zip,
            type: 'zip',
        }
    }).done(function (data) {
        if (data != '') {
            $("select#r_d_date").html(data);
            $("select#r_d_date").selectpicker('refresh');
        }
    });
});
//-- Hide show steps based on step id
function profile_steps(obj) {
//    console.log(obj);
    $('.flowers-steps').addClass('hide');
    $('.steps-li').removeClass('current_active');
//    $('.steps-li').removeClass('process-done');
    $('#' + obj + '-li').addClass('current_active');
    if (obj == 'first-step') {
        $('.main-steps').removeClass('hide');
        $('.title_cart').html('My Cart');
        $('#' + obj).removeClass('hide');
    } else if (obj == 'second-step') {
        $('.title_cart').html('Delivery Info');
        $('.main-steps').removeClass('hide');
        $('#' + obj).removeClass('hide');
//        $('#first-step-li').addClass('process-done');
    } else if (obj == 'third-step') {
        $('.title_cart').html('Billing');
        $('.main-steps').removeClass('hide');
        $('#third-step-li').addClass('current_active');
        $('#' + obj).removeClass('hide');
//        $('#first-step-li,#second-step-li').addClass('process-done');
    }
}

function back_step() {
    var flower_process = $('#flower_process').val();
    if (flower_process == 1) {
        $('#flower_process').val(0);
        profile_steps('first-step');
    } else if (flower_process == 2) {
        $('#flower_process').val(1);
        profile_steps('second-step');
    } else if (flower_process == 3) {
        $('#flower_process').val(3);
        profile_steps('third-step');
    }
    return false;
}
/*First step for Placeing order*/
function submit_form() {
    var flower_process = $('#flower_process').val();
    if (flower_process == 0) {
        $('#flower_process').val(1);
        profile_steps('second-step');
    }
    return false;
}
// Proceeds steps
function proceed_step() {
    var flower_process = $('#flower_process').val();
    if (flower_process == 1) {
        if ($('#cart_form').valid()) {
            var fd = new FormData(document.getElementById("cart_form"));
            fd.append('process_step', flower_process);
            $.ajax({
                url: site_url + "flowers/place_order",
                type: "POST",
                data: fd,
                dataType: "json",
                processData: false, // tell jQuery not to process the data 
                contentType: false,
                success: function (data) {
                    if (data.success == true) {
                        $('#flower_process').val(2);
                        profile_steps('third-step');
                    } else {
                        $('#flower_process').val(1);
                        showErrorMSg(data.error);
                    }
                }
            });
        }
    } else if (flower_process == 2) {
        if ($('#cart_deliver_form').valid()) {
            $('.loader').show();
            var fd = new FormData(document.getElementById("cart_deliver_form"));
            fd.append('process_step', flower_process);
            $.ajax({
                url: site_url + "flowers/place_order",
                type: "POST",
                data: fd,
                dataType: "json",
                processData: false, // tell jQuery not to process the data 
                contentType: false,
                success: function (data) {
                    if (data.success == true) {
                        $('#flower_process').val(2);
                        showSuccessMSg('Your order is successfully placed!');
                        window.location.href = site_url + 'flowers/get_order_details/' + data.order_no;
                    } else {
                        $('.loader').hide();
                        $('#flower_process').val(1);
                        showErrorMSg(data.error);
                    }
                }
            });
        }
    }
    return false;
}
/* For adding an item in cart */
function add_to_cart(code) {
    $('.loader').show();
    $.ajax({
        url: site_url + "flowers/manage_cart/" + code + '/add',
        type: "POST",
        dataType: "json",
        success: function (data) {
//            $('.loader').hide();
            if (data.success == true) {
                showSuccessMSg(data.data);
                window.location.href = site_url + 'flowers/cart';
            } else {
                $('.loader').hide();
                showErrorMSg(data.error);
            }
        }
    });
}
/* For Removing an item in cart */
function remove_cart(code) {
    $('.loader').show();
    $.ajax({
        url: site_url + "flowers/manage_cart/" + code + '/remove',
        type: "POST",
        dataType: "json",
        success: function (data) {
            if (data.success == true) {
                showSuccessMSg(data.data);
                window.location.href = site_url + 'flowers/cart';
//                $('.loader').hide();
            } else {
                $('.loader').hide();
                showErrorMSg(data.error);
            }
        }
    });
}


$(document).on('hover', 'i', function () {

});

//--Custom zipcode for US and Canada

jQuery.validator.addMethod("us_zipcode", function (value, element) {
    return this.optional(element) || /(^\d{5}(-\d{4})?$)/.test(value)
}, "The specified US or Canadian ZIP Code is invalid");

jQuery.validator.addMethod("canada_zipcode", function (value, element) {
    return this.optional(element) || /(^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$)/.test(value)
}, "The specified US or Canadian ZIP Code is invalid");
//-- Update zipcode rules on country change
$(document).on('change', '#r_country', function () {
    $('#r_zipcode').rules('remove', 'us_zipcode');
    $('#r_zipcode').rules('remove', 'canada_zipcode');
    if ($(this).val() == 'CA') {
        $('#r_zipcode').rules('add', 'canada_zipcode');
    } else if ($(this).val() == 'US') {
        $('#r_zipcode').rules('add', 'us_zipcode');
    }
});
//-- Update zipcode rules on country change
$(document).on('change', '#c_country', function () {
    $('#c_zipcode').rules('remove', 'us_zipcode');
    $('#c_zipcode').rules('remove', 'canada_zipcode');
    if ($(this).val() == 'CA') {
        $('#c_zipcode').rules('add', 'canada_zipcode');
    } else if ($(this).val() == 'US') {
        $('#c_zipcode').rules('add', 'us_zipcode');
    }
});