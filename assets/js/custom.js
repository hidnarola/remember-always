/**
 * Common functions used 
 * @author KU 
 */
$(function () {

    $('.sign-up-pop').on('click', function () {
        jQuery('[href="#sign-up"]').trigger('click')
    });

    $('.login-pop').on('click', function () {
        jQuery('[href="#log-in"]').trigger('click')
    });

    $('.popup-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function () {
                t = jQuery(this);
                if ($(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });

    //Prevent form submition by pressing enter key
    $(document).on('keypress', 'input', function (event) {
        text_class = $(this).attr('class');
        if (text_class != 'global_search') {
            if (event.which == '13') {
                event.preventDefault();
            }
        }
    });
    $(document).on('click', function (e) {
        if ($(e.target).attr("id") != 'global_search' && $(e.target).attr('class') != 'header_search' && $(e.target).attr('id') != 'community_search') {
            $(".search").removeClass("open");
        }
    });
    //Display success/error flash messages
    if (s_msg != '') {
        new PNotify({
            title: 'Success!',
            text: s_msg,
            buttons: {
                sticker: false
            },
//            styling:'bootstrap3',
            type: 'success'
        });
    } else if (e_msg != '') {
        new PNotify({
            title: 'Error!',
            text: e_msg,
            buttons: {
                sticker: false
            },
            type: 'error'
        });
    }
    if (reset_pwd == 1) {
        $('#resetpwd-modal').modal();
    }
    $("#owl-demo").owlCarousel({
        autoPlay: 6000, // Added to autoplay slides
        navigation: true, // Show next and prev buttons
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        rewindNav: true,
        rewindSpeed: 0
    });
    $("#recently-added-div").owlCarousel({
        autoplay:false,
        singleItem: true,
    });
    $("#most-visited-div").owlCarousel({
        autoplay:false,
        singleItem: true,
    });
    $("#notable-div").owlCarousel({
        autoplay:false,
        singleItem: true,
    });
    $("#testimonial").owlCarousel({
        autoPlay: 3000,
        items: 3,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 2]
    });

    $("#blog-carousel").owlCarousel({
        autoPlay: 3000,
        items: 3,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 2]
    });
    // Login Form validation
    $("#login-form").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
            }
        },
        messages: {
            email: {
                required: "Enter your email",
            },
            password: {
                required: "Enter your password",
            }
        },
        submitHandler: function (form) {
            $('#login_form_btn').attr('disabled', true);
            var login_url = $('#login-form').attr('action');
            var check_redirect = "?redirect";

            if (login_url.indexOf(check_redirect) == -1) {
                url = window.location.href;
                login_url = site_url + 'login?redirect=' + btoa(url);
                $('#login-form').attr('action', login_url);
            }
            form.submit();
        }
    });
    // Signup Form validation
    $("#signup-form").validate({
        rules: {
            email: {
                email: true,
                required: true,
                remote: site_url + 'signup/check_email'
            },
            firstname: {
                required: true,
            },
            lastname: {
                required: true,
            },
            password: {
                required: true,
                minlength: 5
            },
            con_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            terms_condition: {
                required: true,
            }
        },
        messages: {
            email: {
                required: "Email is required",
                remote: jQuery.validator.format("Email already exist!")
            },
            password: {
                required: "Password is password",
                minlength: "Your password must be at least 5 characters long"
            },
            con_password: {
                required: "Confirm Password is required",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            firstname: {
                required: "Firstname is required",
            },
            lastname: {
                required: "Lastname is required",
            },
            terms_condition: {
                required: "Please accept terms and condition",
            }
        },
        submitHandler: function (form) {
            $('#signup_form_btn').attr('disabled', true);
            form.submit();
        }
    });
    $("#forgot_password_form").validate({
        rules: {
            email: {
                email: true,
                required: true,
                remote: site_url + 'login/check_email'
            }
        },
        messages: {
            email: {
                remote: jQuery.validator.format("Invalid Email Address")
            }
        },
        submitHandler: function (form) {
            $('#reset_password_btn').attr('disabled', true);
            form.submit();
        }
    });

    $("#reset_password_form").validate({
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            con_password: {
                required: true,
                minlength: 5,
                equalTo: "#reset_password"
            },
        },
        messages: {
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long"
            },
            con_password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
        },
        submitHandler: function (form) {
            $('#change_password_btn').attr('disabled', true);
            form.submit();
        }
    });

    //-- Set the image orientation for mobile images
    $('.profile-exif-img').each(function () {
        var img = $(this);
        img.attr('src', $(this).attr('src'));
        fixExifOrientation(img);
    });
});


$(function () {
    var suggestionEngine = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: site_url + 'search/autocomplete?query=',
            replace: function (url, query) {
                return url + query;
            },
            ajax: {
                type: "POST",
                data: {
                    q: function () {
                        return $('#global_search').val()
                    }
                }
            }
        }
    });

    var suggestionTemplate = function (data) {
//        if (data.image) {
//            return '<div><img class="image" src="' + data.image + '"/> <p class="menu-text">' + data.title + '</p>' + '<p class="price menu-text"> $' + data.price + '</p></div>';
//        } else {
//            if (data.type == 'business') {
//                biz_location = '';
//                if (data.location != '' && data.location != null) {
//                    biz_location = data.location;
//                }
//                return '<div><p class="menu-text"><a href="biz/' + data.slug + '">' + data.value + '</a><i style="float:right;">' + biz_location + '</i></p></div>';
//            } else {
//                return '<div><p class="menu-text">' + data.value + '</p></div>';
//            }
//        }
        if (data.type == 'profile')
            return '<div><p class="menu-text"><a href="' + site_url + 'profile/' + data.slug + '">' + data.name + '</a></p></div>';
        else if (data.type == 'service_provider')
            return '<div><p class="menu-text"><a href="' + site_url + 'service_provider/view/' + data.slug + '">' + data.name + '<a/></p></div>';
        else if (data.type == 'affiliation')
            return '<div><p class="menu-text"><a href="' + site_url + 'affiliation/view/' + data.slug + '">' + data.name + '<a/></p></div>';
        else if (data.type == 'blog')
            return '<div><p class="menu-text"><a href="' + site_url + 'blog/details/' + data.slug + '">' + data.name + '<a/></p></div>';
    }

    suggestionEngine.initialize();


    $('#global_search').typeahead(
            {
//                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'search_location',
                displayKey: 'name', //--- use for change value on change suggestions
                source: suggestionEngine,
                limit: 5,
                templates: {
                    notFound: '<p class="not"><i class="fa fa-info-circle" style="margin-top:1px;"></i>&nbsp; Not found </p>',
                    suggestion: suggestionTemplate
                }
            });

    //--- if enter with search textbox
    $("#global_search").keydown(function (e) {
        var value = e.keyCode;
        search_text = $(this).val();
        if (value == 13) {

            $.ajax({
                url: site_url + 'search/get_result',
                type: 'POST',
                data: {search_text: search_text},
                success: function (data) {
                    data = JSON.parse(data);
                    //--- check user search type and then redirect to valid result page
                    if (data.type == 'profile') {
//                        console.log(site_url + 'profile/' + data.slug);
                        window.location = site_url + 'profile/' + data.slug;
                    } else if (data.type == 'service_provider') {
//                        console.log(site_url + 'service_provider/view/' + data.slug);
                        window.location = site_url + 'service_provider/view/' + data.slug;
                    } else if (data.type == 'affiliation') {
//                        console.log(site_url + 'affiliation/view/' + data.slug);
                        window.location = site_url + 'affiliation/view/' + data.slug;
                    } else if (data.type == 'blog') {
//                        console.log(site_url + 'blog/details/' + data.slug);
                        window.location = site_url + 'blog/details/' + data.slug;
                    } else {
                        console.log('here...');

                        $('#global_search_form').submit();
                    }
                }
            });
        }
    });
});
/**
 * Display Login/signup modal
 * @param string modalType
 */
function showModal(modalType) {
    $('.' + modalType + '-pop').trigger('click');
    /*
     $('#login').modal();
     $('.nav-tabs a[href="#' + modalType + '"]').tab('show'); */
}
/**
 * Display Forgot password modal
 * @param string modalType
 */
function showForgotModal() {
//    $('#login').modal('hide');
    $.magnificPopup.close();
    $('#forgot-pwdmodal').modal();
}
/**
 * Hide forgot password modal and display login modal
 */
function loginforgetModal() {
    $('#forgot-pwdmodal').modal('hide');
    $('.login-pop').trigger('click');
//    $('#login').modal();
}
/**
 * Hide reset password modal and display login modal
 */
function loginrestModal() {
    $('#resetpwd-modal').modal('hide');
    $('.login-pop').trigger('click');
//    $('#login').modal();
}
/**
 * Display login popup when authorized access is needed
 */
function loginModal(obj) {
    var redirect_url = $(obj).attr('data-redirect');
    $('#login-form').attr('action', site_url + 'login?redirect=' + btoa(redirect_url));
    $('.login-pop').trigger('click');
    /*
     showErrorMSg('Please login first!');
     $('#login').modal();
     $('.nav-tabs a[href="#log-in"]').tab('show');*/
}
function showSuccessMSg(msg) {
    new PNotify({
        title: 'Success!',
        text: msg,
        buttons: {
            sticker: false
        },
//            styling:'bootstrap3',
        type: 'success'
    });
}
function showErrorMSg(msg) {
    new PNotify({
        title: 'Error!',
        text: msg,
        buttons: {
            sticker: false
        },
        //            styling:'bootstrap3',
        type: 'error'
    });
}
/**
 * Custom function for updatign url when query string is present.
 */
function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
        return uri + separator + key + "=" + value;
    }
}
//Display searchbox on click event
function viewSearchbox() {
    if (!$('.header_search_div').hasClass('open')) {
        $('.header_search_div').addClass('open');
    }
}
//Display searchbox on click event for community searchbox
function viewCommunitySearch() {
    if (!$('.community_search_div').hasClass('open')) {
        $('.community_search_div').addClass('open');
    }
}
/**
 * Check exif of image
 * @param {object} $img
 */
function fixExifOrientation($img) {
    $img.on('load', function () {
        EXIF.getData($img[0], function () {
            switch (parseInt(EXIF.getTag(this, "Orientation"))) {
                case 2:
                    $img.addClass('flip');
                    break;
                case 3:
                    $img.addClass('rotate-180');
                    break;
                case 4:
                    $img.addClass('flip-and-rotate-180');
                    break;
                case 5:
                    $img.addClass('flip-and-rotate-270');
                    break;
                case 6:
                    $img.addClass('rotate-90');
                    break;
                case 7:
                    $img.addClass('flip-and-rotate-90');
                    break;
                case 8:
                    $img.addClass('rotate-270');
                    break;
            }
        });
    });
}
/**
 * Custom validator method for max file size
 */
// This set of validators requires the File API, so if we'ere in a browser
// that isn't sufficiently "HTML5"-y, don't even bother creating them.  It'll
// do no good, so we just automatically pass those tests.
var is_supported_browser = !!window.File,
        fileSizeToBytes,
        formatter = $.validator.format;
/**
 * Converts a measure of data size from a given unit to bytes.
 *
 * @param number size
 *   A measure of data size, in the give unit
 * @param string unit
 *   A unit of data.  Valid inputs are "B", "KB", "MB", "GB", "TB"
 *
 * @return number|bool
 *   The number of bytes in the above size/unit combo.  If an
 *   invalid unit is specified, false is returned
 */
fileSizeToBytes = (function () {
    var units = ["B", "KB", "MB", "GB", "TB"];
    return function (size, unit) {
        var index_of_unit = units.indexOf(unit),
                coverted_size;
        if (index_of_unit === -1) {
            coverted_size = false;
        } else {
            while (index_of_unit > 0) {
                size *= 1024;
                index_of_unit -= 1;
            }
            coverted_size = size;
        }
        return coverted_size;
    };
}());
$.validator.addMethod("maxFileSize",
        function (value, element, params) {
            var files,
                    unit = params.unit || "KB",
                    size = params.size || 100,
                    max_file_size = fileSizeToBytes(size, unit),
                    is_valid = false;
            if (!is_supported_browser || this.optional(element)) {
                is_valid = true;
            } else {
                files = element.files;
                if (files.length < 1) {
                    is_valid = false;
                } else {
                    is_valid = files[0].size <= max_file_size;
                }
            }
            return is_valid;
        },
        function (params, element) {
            return formatter(
                    "File cannot be larger than {0}{1}.",
                    [params.size || 100, params.unit || "KB"]
                    );
        }
);
$.validator.addMethod('atleast_one_for_post', function (value, element, param) {
    if (($('input[name="images_post[]"]')[0].files.length == 0) && ($('input[name="video_post[]"]')[0].files.length == 0) && $.trim($('#comment').val()) == '') {
        return false;
    } else {
        return true;
    }
}, 'Post is Empty. Please enter post comment or slect image or video file for post.');

jQuery.validator.addMethod("custom_zipcode", function (value, element) {
//    return this.optional(element) || /\d{5}-\d{4}$|^\d{5}$/.test(value)
    return this.optional(element) || /(^\d{5}(-\d{4})?$)|(^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$)/.test(value)
}, "The specified US or Canadian ZIP Code is invalid");

$(document).on('click', '.manage_cart', function () {
    var code = $(this).data('item');
});

/* Sharing with social media */
function genericSocialShare(url) {
    window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
    return true;
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


