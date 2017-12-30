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
                custom_zipcode: true
            },
            r_phone: {
                required: true,
                number: true,
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
                custom_zipcode: true
            },
            c_phone: {
                required: true,
                number: true,
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
            console.log("in valid");
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
                    console.log(data);
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
//                        window.location.href = site_url + 'flowers/get_order_details/' + data.order_no;
                    } else {
                        $('#flower_process').val(1);
                        showErrorMSg(data.error);
                    }
                }
            });
        }
//        $.ajax({
//            url: site_url + "profile/proceed_steps",
//            type: "POST",
//            data: {flower_process: 3, profile_id: profile_id},
//            dataType: "json",
//            success: function (data) {
//                if (data.success == true) {
//                    $('#flower_process').val(3);
//                    if ($('#third-step').hasClass('hide') && $('#third1-step').hasClass('hide')) {
//                        profile_steps('third-step');
//                    } else if ($('#third1-step').hasClass('hide') && !$('#third-step').hasClass('hide')) {
//                        profile_steps('third1-step');
//                    } else {
//                        profile_steps('forth-step');
//                    }
//                } else {
//                    $('#flower_process').val(2);
//                    showErrorMSg(data.error);
//                }
//            }
//        });
    } else if (flower_process == 3) {
        if (!$('#third-step').hasClass('hide')) {
            profile_steps('third1-step');
        } else if ($('#third-step').hasClass('hide') && !$('#third1-step').hasClass('hide')) {
            profile_steps('forth-step');
        } else if ($('#third-step').hasClass('hide') && $('#third1-step').hasClass('hide')) {
// submit form and save data-- Save time line data
// check if title is not empty
            title_empty = 1;
            $('input[name="title[]"]').each(function () {
                if ($(this).val() != '') {
                    title_empty = 0;
                }
            });
            if (title_empty == 0) {
                if ($('#timeline-form').valid() && validate_timeline_date()) {
                    fd = new FormData(document.getElementById("timeline-form"));
                    fd.append('profile_id', profile_id);
                    $.ajax({
                        url: site_url + "profile/add_timeline",
                        type: "POST",
                        data: fd,
                        dataType: "json",
                        processData: false, // tell jQuery not to process the data 
                        contentType: false, // tell jQuery not to set contentType
                        success: function (data) {
                            if (data.success == true) {
                                $('#flower_process').val(4);
                                profile_steps('fifth-step');
                            } else {
                                $('#flower_process').val(3);
                                showErrorMSg(data.error);
                            }
                        }
                    });
                }
            } else {
                $.ajax({
                    url: site_url + "profile/proceed_steps",
                    type: "POST",
                    data: {flower_process: 4, profile_id: profile_id},
                    dataType: "json",
                    success: function (data) {
                        if (data.success == true) {
                            $('#flower_process').val(4);
                            profile_steps('fifth-step');
                        } else {
                            $('#flower_process').val(3);
                            showErrorMSg(data.error);
                        }
                    }
                });
            }

        }
    } else if (flower_process == 4) {
        service_valid = 1;
        if ($('#memorial_date').val() != '' || $('#memorial_time').val() != '' || $('#memorial_place').val() != '' || $('#memorial_address').val() != '' || $('#memorial_state').val() != '' || $('#memorial_city').val() != '' || $('#memorial_zip').val() != '') {
            if ($('#memorial_date').val() == '') {
                $('#memorial_date').addClass('error');
                service_valid = 0;
            }
            if ($('#memorial_time').val() == '') {
                $('#memorial_time').addClass('error');
                service_valid = 0;
            }
            if ($('#memorial_place').val() == '') {
                $('#memorial_place').addClass('error');
                service_valid = 0;
            }
            if ($('#memorial_address').val() == '') {
                $('#memorial_address').addClass('error');
                service_valid = 0;
            }
            if ($('#memorial_state').val() == '') {
                $('#memorial_state').addClass('error');
                service_valid = 0;
            }
            if ($('#memorial_city').val() == '') {
                $('#memorial_city').addClass('error');
                service_valid = 0;
            }
            if ($('#memorial_zip').val() == '') {
                $('#memorial_zip').addClass('error');
                service_valid = 0;
            }
        }

        if ($('#funeral_date').val() != '' || $('#funeral_time').val() != '' || $('#funeral_place').val() != '' || $('#funeral_address').val() != '' || $('#funeral_state').val() != '' || $('#funeral_city').val() != '' || $('#funeral_zip').val() != '') {
            if ($('#funeral_date').val() == '') {
                $('#funeral_date').addClass('error');
                service_valid = 0;
            }
            if ($('#funeral_time').val() == '') {
                $('#funeral_time').addClass('error');
                service_valid = 0;
            }
            if ($('#funeral_place').val() == '') {
                $('#funeral_place').addClass('error');
                service_valid = 0;
            }
            if ($('#funeral_address').val() == '') {
                $('#funeral_address').addClass('error');
                service_valid = 0;
            }
            if ($('#funeral_state').val() == '') {
                $('#funeral_state').addClass('error');
                service_valid = 0;
            }
            if ($('#funeral_city').val() == '') {
                $('#funeral_city').addClass('error');
                service_valid = 0;
            }
            if ($('#funeral_zip').val() == '') {
                $('#funeral_zip').addClass('error');
                service_valid = 0;
            }
        }

        if ($('#burial_date').val() != '' || $('#burial_time').val() != '' || $('#burial_place').val() != '' || $('#burial_address').val() != '' || $('#burial_state').val() != '' || $('#burial_city').val() != '' || $('#burial_zip').val() != '') {
            if ($('#burial_date').val() == '') {
                $('#burial_date').addClass('error');
                service_valid = 0;
            }
            if ($('#burial_time').val() == '') {
                $('#burial_time').addClass('error');
                service_valid = 0;
            }
            if ($('#burial_place').val() == '') {
                $('#burial_place').addClass('error');
                service_valid = 0;
            }
            if ($('#burial_address').val() == '') {
                $('#burial_address').addClass('error');
                service_valid = 0;
            }
            if ($('#burial_state').val() == '') {
                $('#burial_state').addClass('error');
                service_valid = 0;
            }
            if ($('#burial_city').val() == '') {
                $('#burial_city').addClass('error');
                service_valid = 0;
            }
            if ($('#burial_zip').val() == '') {
                $('#burial_zip').addClass('error');
                service_valid = 0;
            }
        }

        if (service_valid == 1) {
            $.ajax({
                url: site_url + "profile/add_services",
                type: "POST",
                data: $('#funeralservice-form').serialize() + "&profile_id=" + profile_id,
                dataType: "json",
                success: function (data) {
                    if (data.success == true) {
                        $('#flower_process').val(5);
                        profile_steps('sixth-step');
                    } else {
                        showErrorMSg(data.error);
                    }
                }
            });
        }
    } else if (flower_process == 5) {
        fundraiser_valid = 1;
        if ($('#fundraiser_title').val() != '' || $('#fundraiser_goal').val() != '' || $('#fundraiser_enddate').val() != '' || $('#fundraiser_details').val() != '') {
            if ($('#fundraiser_title').val() == '') {
                $('#fundraiser_title').addClass('error');
                fundraiser_valid = 0;
            }
            if ($('#fundraiser_goal').val() == '') {
                $('#fundraiser_goal').addClass('error');
                fundraiser_valid = 0;
            }
            if ($('#fundraiser_enddate').val() == '') {
                $('#fundraiser_enddate').addClass('error');
                fundraiser_valid = 0;
            }
            if ($('#fundraiser_details').val() == '') {
                $('#fundraiser_details').addClass('error');
                fundraiser_valid = 0;
            }
        }
        if (fundraiser_valid == 1) {
            var postformData = new FormData(document.getElementById('fundraiser_profile-form'));
            postformData.append('profile_id', profile_id);
            $(fundraiser_media).each(function (key) {
                if (fundraiser_media[key] != null) {
                    fundraiser_types[key] = [];
                    fundraiser_types[key] = fundraiser_media[key]['media_type'];
                    postformData.append('fundraiser_append_media[]', fundraiser_media[key], fundraiser_media[key].name);
                    postformData.append('fundraiser_append_types[]', fundraiser_types[key]);
                }
            });
            $.ajax({
                url: site_url + "profile/add_fundraiser",
                type: "POST",
                data: postformData,
                dataType: "json",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
                    if (data.success == true) {
                        $('#flower_process').val(6);
                        profile_steps('seventh-step');
                    } else {
                        showErrorMSg(data.error);
                    }
                }
            });
        }
    }

    return false;
}
//-- Gallery step
var image_count = 0, video_count = 0;
$("#gallery").change(function () {
    var dvPreview = $("#selected-preview");
    if (typeof (FileReader) != "undefined") {
        $($(this)[0].files).each(function (index) {
            var file = $(this);
            str = '';
            if (regex_img.test(file[0].name.toLowerCase())) {
//-- check image and video count
                if (image_count <= maxlength_images_count) {

// upload image
                    var formData = new FormData();
                    formData.append('profile_id', profile_id);
                    formData.append('type', 'image');
                    formData.append('gallery', file[0], file[0].name);
                    $.ajax({
                        url: site_url + "profile/upload_gallery",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        processData: false, // tell jQuery not to process the data
                        contentType: false, // tell jQuery not to set contentType
                        success: function (data) {
                            if (data.success == true) {
                                //-- Remove default preview div
                                $('#default-preview').remove();
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    str = '<li><div class="upload-wrap"><span>';
                                    str += '<a href="' + URL.createObjectURL(file[0]) + '" class="fancybox" rel="upload_gallery" data-fancybox-type="image"><img src="' + e.target.result + '"></a>';
                                    str += '</span><a href="javascript:void(0)" class="remove-video" onclick="delete_media(this,\'' + data.data + '\')">';
                                    str += delete_str;
                                    str += '</a></div></li>';
                                    dvPreview.append(str);
                                }
                                reader.readAsDataURL(file[0]);
                            } else {
                                showErrorMSg(data.error);
                            }
                        }
                    });
                } else {
                    showErrorMSg("Limit is exceeded to upload images");
                }
                image_count++;
            } else if (regex_video.test(file[0].name.toLowerCase())) {
                if (video_count <= maxlength_videos_count) {
// upload video
                    var videoData = new FormData();
                    videoData.append('profile_id', profile_id);
                    videoData.append('type', 'video');
                    videoData.append('gallery', file[0], file[0].name);
                    $.ajax({
                        url: site_url + "profile/upload_gallery",
                        type: "POST",
                        data: videoData,
                        dataType: "json",
                        processData: false, // tell jQuery not to process the data
                        contentType: false, // tell jQuery not to set contentType
                        success: function (data) {
                            if (data.success == true) {
                                $('#default-preview').remove();
                                str = '<li><div class="upload-wrap"><span id="upload_gallery_' + index + '">';
                                str += '<video id="video_' + index + '" style="width:100%;height:100%;visibility:hidden;" controls><source src="' + URL.createObjectURL(file[0]) + '">Your browser does not support HTML5 video.</video>';
                                str += '</span>';
                                str += '<span class="gallery-play-btn"><a href="' + URL.createObjectURL(file[0]) + '" class="fancybox" rel="upload_gallery" data-fancybox-type="iframe"><img src="assets/images/play.png" alt=""></a></span>';
                                str += '<a href="javascript:void(0)" class="remove-video" onclick="delete_media(this,\'' + data.data + '\')">';
                                str += delete_str;
                                str += '</a></div></li>';
                                dvPreview.append(str);
                                var video = document.querySelector('#video_' + index);
                                video.addEventListener('loadeddata', function () {
                                    var canvas = document.createElement("canvas");
                                    canvas.width = video.videoWidth;
                                    canvas.height = video.videoHeight;
                                    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                                    var img = document.createElement("img");
                                    img.src = canvas.toDataURL();
                                    $('#upload_gallery_' + index).prepend(img);
                                }, false);
                            } else {
                                showErrorMSg(data.error);
                            }
                        }
                    });
                } else {
                    showErrorMSg("Limit is exceeded to upload videos");
                }
                video_count++;
            } else {
                showErrorMSg(file[0].name + " is not a valid image/video file.");
            }
        });
    } else {
        showErrorMSg("This browser does not support HTML5 FileReader.");
    }
});
function delete_media(obj, data) {
    $.ajax({
        url: site_url + "profile/delete_gallery",
        type: "POST",
        data: {'gallery': data},
        dataType: "json",
        success: function (data) {
            if (data.success == true) {
                if (data.type == 1) {
                    maxlength_images_count++; //increase maxlength images count if deleted media is image
                } else {
                    maxlength_videos_count++; //increase maxlength videos count if deleted media is video
                }
                $(obj).parent('.upload-wrap').parent('li').remove();
            } else {
                showErrorMSg(data.error);
            }
        }
    });
}
//-- Add fun fact step
function add_funfact() {
    if ($('#fun-fact-form').valid()) {
        if (facts_count < maxlength_facts_count) {
            $.ajax({
                url: site_url + "profile/add_facts",
                type: "POST",
                data: {facts: $('#fun_fact').val(), profile_id: profile_id},
                dataType: "json",
                success: function (data) {
                    if (data.success == true) {
                        facts_count++;
                        $('#default-facts').remove();
                        str = '<div class="input-wrap-div">';
                        str += '<div class="input-css">' + $('#fun_fact').val() + '</div>';
                        str += '<a href="javascript:void(0)" onclick="delete_facts(this,\'' + data.data + '\')">';
                        str += delete_str;
                        str += '</div>';
                        $('#selected-facts').append(str);
                        $("#fun-fact-form")[0].reset();
                        $('#funfact-modal').modal('hide');
                        $("#fun-fact-form").validate().resetForm();
                        $('#fun_fact').rules('add', {
                            remote: site_url + 'profile/check_facts/' + profile_id,
                            messages: {
                                remote: "This fun fact is already added",
                            }
                        });
                    } else {
                        showErrorMSg(data.error);
                    }
                }
            });
        } else {
            showErrorMSg('You can add up to 10 fun facts only.');
        }
    }
    return false;
}
function delete_facts(obj, data) {
    $.ajax({
        url: site_url + "profile/delete_facts",
        type: "POST",
        data: {'fact': data},
        dataType: "json",
        success: function (data) {
            if (data.success == true) {
                $(obj).parent('.input-wrap-div').remove();
                maxlength_facts_count++;
            } else {
                showErrorMSg(data.error);
            }
        }
    });
}
function findProperty(obj, key) {
    if (typeof obj === "object") {
        if (key in obj) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}
//-- Third Affiliation Step
function add_affiliation() {
    if ($('#affiliation-form').valid()) {
        if (affiliation_count < maxlength_affiliation_count) {
            $.ajax({
                url: site_url + "profile/add_affiliation",
                type: "POST",
                data: {select_affiliation: $('#select_affiliation').val(), affiliation_text: $('#affiliation_text').val(), profile_id: profile_id},
                dataType: "json",
                success: function (data) {
                    if (data.success == true) {
                        $('#default-facts').remove();
                        str = '';
                        $.each(data.data, function (i, v) {
                            str += '<div class="input-wrap-div">';
                            str += '<div class="input-css">' + v.name + '</div>';
                            str += '<a href="javascript:void(0)" onclick="delete_affiliation(this,\'' + v.id + '\',' + v.type + ')">';
                            str += delete_str;
                            str += '</div>';
                        });
                        affiliation_count = data.affiliation_count;
                        $('#selected-affiliation').append(str);
                        $("#affiliation-form")[0].reset();
                        $('#affiliation-modal').modal('hide');
                        $("#affiliation-form").validate().resetForm();
                        $('#affiliation_text').rules('add', {
                            remote: site_url + 'profile/check_affiliation/' + profile_id,
                            messages: {
                                remote: "This affiliation is already added",
                            }
                        });
                    } else {
                        showErrorMSg(data.error);
                    }
                }
            });
        } else {
            showErrorMSg('You can add up to 10 affiliations only.');
        }
    }
    return false;
}
function delete_affiliation(obj, data, type) {
    $.ajax({
        url: site_url + "profile/delete_affiliation",
        type: "POST",
        data: {'affiliation': data, 'type': type},
        dataType: "json",
        success: function (data) {
            if (data.success == true) {
                affiliation_count--;
                $(obj).parent('.input-wrap-div').remove();
            } else {
                showErrorMSg(data.error);
            }
        }
    });
}

//-- Forth Timeline step
// Add timline button
$(document).on('click', '.add_timeline_btn', function () {
    if ($('#timeline-form').valid()) {
        if (validate_timeline_date()) {
            timeline_div = $(this).parent('.step-06-l').parent('.step-06').clone();
            timeline_div.find('input[name="timelineid[]"]').val('');
            timeline_div.find('input[name="title[]"]').val('');
            timeline_div.find('input[name="date[]"]').val('');
            timeline_div.find('input[name="month[]"]').val('');
            timeline_div.find('input[name="month_year[]"]').val('');
            timeline_div.find('input[name="year[]"]').val('');
            timeline_div.find('input[name="details[]"]').val('');
            timeline_div.find('input[name="life_pic[]"]').val('');
            timeline_div.find('.select-file_up_btn').html("Upload Picture or Video? <span>Select</span>");
            $('.timeline-div').append(timeline_div);
            $(this).html('<i class="fa fa-trash"></i> Remove');
            $(this).removeClass('add_timeline_btn');
            $(this).addClass('remove_timeline_btn text-danger mb-20');
            //-- Initialize datepicker
            $('.date-picker').datepicker({
                format: "mm/dd/yyyy",
                endDate: "date()"
            });
        }
    }
});
// Remove timeline button
$(document).on('click', '.remove_timeline_btn', function () {
    $(this).parent('.step-06-l').parent('.step-06').remove();
});
$(document).on('click', '.remove_org_timeline_btn', function () {
    var id = $(this).attr('data-id');
    var obj = $(this);
    $.ajax({
        url: site_url + "profile/delete_timeline",
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function (data) {
            if (data.success == true) {
                obj.parent('.step-06-l').parent('.step-06').remove();
            } else {
                showErrorMSg(data.error);
            }
        }
    });
});
//onchange media event for life timeline
$(document).on('change', '.timeline-media', function () {
    obj = $(this);
    if (this.files && this.files[0]) {
//-- check if file is image or not
        if (regex_img.test(this.files[0].name.toLowerCase())) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var html = '<img src="' + e.target.result + '" style="width: 170px; border-radius: 2px;" alt="">';
                obj.prev('.select-file_up_btn').html(html);
            }
            reader.readAsDataURL(this.files[0]);
        } else if (regex_video.test(this.files[0].name.toLowerCase())) {
            var html = '<video style="width:100%;" controls><source src="' + URL.createObjectURL(this.files[0]) + '">Your browser does not support HTML5 video.</video>'
            obj.prev('.select-file_up_btn').html(html);
        } else {
            obj.prev('.select-file_up_btn').html('Upload Picture or Video? <span>Select</span>');
        }
    }
});
//Validates date,month and year
function validate_timeline_date() {
    valid = 1;
    $('input[name="date[]"]').each(function () {
        date = $(this);
        month = $(this).siblings('input[name="month[]"]');
        month_year = $(this).siblings('input[name="month_year[]"]');
        year = $(this).siblings('input[name="year[]"]');
        if (date.val() == '' && (month.val() == '' || month_year.val() == '') && year.val() == '') {
            date.addClass('error');
            valid = 0;
        } else {
            date.removeClass('error');
        }
    });
    if (valid == 0) {
        return false;
    } else {
        return true;
    }
}
//Remove error class if date,month or year is valid
$(document).on('change', 'input[name="year[]"],input[name="month[]"],input[name="month_year[]"]', function () {
    date = $(this).siblings('input[name="date[]"]')
    if ($(this).attr('name') == 'year[]') {
        date.removeClass('error');
    } else {
        if ($(this).attr('name') == 'month[]') {
            month_year = $(this).siblings('input[name="month_year[]"]')
            if ($(this).val() != '' && month_year.val() != '') {
                date.removeClass('error');
            }
        } else {
            month = $(this).siblings('input[name="month[]"]');
            if ($(this).val() != '' && month.val() != '') {
                date.removeClass('error');
            }
        }
    }
});
// select box change event
$(document).on('change', '.service-state', function () {
    state_val = $(this).val();
    state_id = $(this).attr('id');
    city_id = '';
    if (state_id == 'memorial_state') {
        city_id = 'memorial_city';
    } else if (state_id == 'funeral_state') {
        city_id = 'funeral_city';
    } else if (state_id == 'burial_state') {
        city_id = 'burial_city';
    }
    $('#' + city_id).val();
    $.ajax({
        url: site_url + "profile/get_cities",
        type: "POST",
        data: {state: state_val},
        dataType: "json",
        success: function (data) {
            var options = "<option value=''>Select City</option>";
            for (var i = 0; i < data.length; i++) {
                options += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
            }
            $('#' + city_id).empty().append(options);
        }
    });
});
//Textbox change event remove error class
$(document).on('change', '#memorial_date,#memorial_time,#funeral_date,#funeral_time,#burial_date,#burial_time,#memorial_place,#funeral_place,#burial_place,#burial_address,#funeral_address,#memorial_address,#memorial_state,#memorial_city,#memorial_zip,#funeral_state,#funeral_city,#funeral_zip,#burial_state,#burial_city,#burial_zip', function () {
    $(this).removeClass('error');
});
//Tribute Fund Raiser Profile
var fundimage_count = 0, fundvideo_count = 0;
$("#fundraiser_media").change(function () {
    var dvPreview = $("#fundraiser_preview");
    if (typeof (FileReader) != "undefined") {
        $($(this)[0].files).each(function (index) {
            var file = $(this);
            str = '';
            if (regex_img.test(file[0].name.toLowerCase())) {
//-- check image and video count
                if (fundimage_count <= maxlength_fundimages_count) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        fundraiser_media.push(file[0]);
                        var index = fundraiser_media.length - 1;
                        fundraiser_media[index]['index'] = index;
                        fundraiser_media[index]['media_type'] = 1;
                        str = '<li><div class="gallery-wrap"><span>';
                        str += '<a href="' + e.target.result + '" class="fancybox" data-fancybox-type="image" rel="fundraiser"><img src="' + e.target.result + '" style="width:100%"></a>';
                        str += '</span><a href="javascript:void(0)" class="remove-video" onclick="delete_fundmedia(this,1,' + index + ')">';
                        str += delete_str;
                        str += '</a></div></li>';
                        dvPreview.append(str);
                    }
                    reader.readAsDataURL(file[0]);
                } else {
                    showErrorMSg("Limit is exceeded to upload images");
                }
                fundimage_count++;
            } else if (regex_video.test(file[0].name.toLowerCase())) {
                if (fundvideo_count <= maxlength_fundvideos_count) {
                    fundraiser_media.push(file[0]);
                    var index = fundraiser_media.length - 1;
                    fundraiser_media[index]['index'] = index;
                    fundraiser_media[index]['media_type'] = 2;
                    str = '<li><div class="gallery-wrap"><span id="fund_' + index + '">';
                    str += '<video id="fundvideo_' + index + '" style="width:100%;height:100%;visibility:hidden;" controls><source src="' + URL.createObjectURL(file[0]) + '">Your browser does not support HTML5 video.</video>';
                    str += '</span>';
                    str += '<span class="gallery-play-btn"><a href="' + URL.createObjectURL(file[0]) + '" class="fancybox" rel="fundraiser" data-fancybox-type="iframe"><img src="assets/images/play.png" alt=""></a></span>';
                    str += '<a href="javascript:void(0)" class="remove-video" onclick="delete_fundmedia(this,2,' + index + ')">';
                    str += delete_str;
                    str += '</a></div></li>';
                    dvPreview.append(str);
                    var video = document.querySelector('#fundvideo_' + index);
                    video.addEventListener('loadeddata', function () {
                        var canvas = document.createElement("canvas");
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                        var img = document.createElement("img");
                        img.src = canvas.toDataURL();
                        $('#fund_' + index).prepend(img);
                    }, false);
                } else {
                    showErrorMSg("Limit is exceeded to upload videos");
                }
                fundvideo_count++;
            } else {
                showErrorMSg(file[0].name + " is not a valid image/video file.");
            }
        });
    } else {
        showErrorMSg("This browser does not support HTML5 FileReader.");
    }
});
/**
 * Redirect to preview profile page
 * @param {type} obj
 * @returns {Boolean}
 */
function preview_profile(obj) {
    var data_href = $(obj).attr('data-href');
    window.location.href = data_href;
    return false;
}

function delete_fundmedia(obj, type, index) {
    $(fundraiser_media).each(function (key) {
        if (typeof (fundraiser_media[key]) != 'undefined' && fundraiser_media[key]['index'] == index) {
            delete fundraiser_media[key];
        }
    });
    if (type == 1) {
        fundimage_count--; //increase maxlength images count if deleted media is image
    } else {
        fundvideo_count--; //increase maxlength videos count if deleted media is video
    }
    $(obj).parent('.gallery-wrap').parent('li').remove();
}

function add_to_cart(code) {
    $.ajax({
        url: site_url + "flowers/manage_cart/" + code + '/add',
        type: "POST",
        dataType: "json",
        success: function (data) {
            if (data.success == true) {
                showSuccessMSg(data.data);
                window.location.href = site_url + 'flowers/cart';
            } else {
                showErrorMSg(data.error);
            }
        }
    });
}
function remove_cart(code) {
    $.ajax({
        url: site_url + "flowers/manage_cart/" + code + '/remove',
        type: "POST",
        dataType: "json",
        success: function (data) {
            if (data.success == true) {
                showSuccessMSg(data.data);
                window.location.href = site_url + 'flowers/cart';
            } else {
                showErrorMSg(data.error);
            }
        }
    });
}


$(document).on('hover', 'i', function () {

});