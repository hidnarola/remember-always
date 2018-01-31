var regex_img = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
var regex_video = /^([a-zA-Z0-9\s_\\.\-:])+(.mp4)$/;
fundraiser_media = [];
fundraiser_types = [];
currentTab = 'first-step';
$(function () {
    //-- Tab Concepts for profile
    $('ul.nav.nav-tabs  a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    //-- Display accordian in mobile view
    fakewaffle.responsiveTabs(['xs', 'sm']);

    //-- Update current tab on clicking of any tab
    $('ul.nav.nav-tabs  a').on('shown.bs.tab', function (e) {
        current_tab = $(e.target).attr('href'); // get current tab
        currentTab = current_tab.substr(1);
        if (currentTab == 'forth-step') {
            //-- Display timeline data
            $('.loader').show();
            $.ajax({
                url: site_url + "profile/lifetimeline",
                type: "POST",
                data: {profile_id: profile_id},
                success: function (data) {
                    $('.loader').hide();
                    $('.timeline-div').html(data);

                    $('.date-picker').datepicker({
                        format: "mm/dd/yyyy",
                        endDate: "date()",
                        autoclose: true,
                    });
                }
            });
        }
    });

    //-- Initialize datepicker
    $('.date-picker').datepicker({
        format: "mm/dd/yyyy",
        endDate: "date()",
        autoclose: true,
    });
    $(".fancybox")
            .fancybox({
                openEffect: 'none',
                closeEffect: 'none',
                nextEffect: 'none',
                prevEffect: 'none',
                padding: 0,
            });
    // Setup validation
    $("#create_profile_form").validate({
        rules: {
            profile_image: {
                extension: "jpg|png|jpeg",
                maxFileSize: {
                    "unit": "MB",
                    "size": max_image_size
                }
            },
            firstname: {
                required: true
            },
            lastname: {
                required: true
            },
            date_of_birth: {
                required: true
            },
            date_of_death: {
                required: true
            },
            country: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "country") {
                element.siblings('.select2').addClass('error');
                error.appendTo(element.parent('.input-wrap'));
            } else if (element.attr("name") == "state") {
                element.siblings('.select2').addClass('error');
                error.appendTo(element.parent('.input-l'));
            } else if (element.attr("name") == "city") {
                element.siblings('.select2').addClass('error');
                error.appendTo(element.parent('.input-r'));
            } else
                error.insertAfter(element);
        }

    });

    //-- Make city2 dropdown as select2 tags
    $(".service-country").select2({
        theme: "bootstrap"
    });
    $(".service-state").select2({
        theme: "bootstrap",
    });
    $(".service-city").select2({
        tags: true,
        theme: "bootstrap"
    });

    //-- Validate country,state and city dropdown on change event
    $(".service-city").change(function () {
        $(this).valid();
        $(this).siblings('.select2').removeClass('error');
    });

    $("#fun-fact-form").validate({
        rules: {
            fun_fact: {
                required: true
            },
            messages: {
                fun_fact: {
                    required: "Please Enter fun fact",
                },
            },
        },
    });
    $("#affiliation-form").validate({
        rules: {
            select_affiliation: {
                required: function (element) {
                    return $("#affiliation_text").is(':empty');
                }
            },
            affiliation_text: {
                required: function (element) {
                    if ($("#select_affiliation").val() == '')
                        return true;
                    else
                        return false;
                }
            },
            messages: {
                affiliation_text: {
                    required: "Please select or enter affiliation",
                },
            },
        },
    });
    var currentYear = (new Date).getFullYear();

    // Time line form validate
    $('#timeline-form').validate({
        rules: {
            'title[]': {
                required: true
            },
            'year[]': {
                required: true,
                minlength: 4,
                max: currentYear
            },
            'month[]': {
                min: 1,
                max: 12
            },
            'day[]': {
                min: 1,
                max: 31
            },
            'month_year[]': {
                max: currentYear
            },
            'life_pic[]': {
                extension: "jpg|png|jpeg|mp4",
                maxFileSize: {
                    "unit": "MB",
                    "size": max_image_size
                }
            },
        },
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'life_pic[]') {
                error.appendTo(element.parent("div").parent('div').parent('div'));
            } else {
                return false;  // suppresses error message text

            }
        }
    });
    $("#fundraiser_profile-form").validate({
        rules: {
            fundraiser_goal: {
                min: 250
            }
        },
        messages: {
            fundraiser_goal: {
                min: "Please enter amount greater than or equal to $250.",
            }
        }
    });
    $('.service-datepicker').datepicker({format: "mm/dd/yyyy", startDate: "date()", autoclose: true});
    $('.service-time').datetimepicker({
        format: 'LT'
    });
    $('#fundraiser_enddate').datepicker({format: "mm/dd/yyyy", startDate: "date()", autoclose: true});
});
// Display the preview of image on image upload
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var html = '<img src="' + e.target.result + '" style="width: 170px; border-radius: 2px;" alt="">';
            $('.up_btn').html(html);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
// Validate form and submit data
function submit_form() {
    var profile_process = $('#profile_process').val();
    if (profile_process == 0) {
        if ($('#create_profile_form').valid()) {
            $('#profile_process').val(1);
            fd = new FormData(document.getElementById("create_profile_form"));
            $('.loader').show();
            $.ajax({
                url: create_profile_url,
                type: "POST",
                data: fd,
                dataType: "json",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
                    $('.loader').hide();
                    if (data.success == true) {
                        create_profile_url = site_url + "profile/edit/" + data.data.slug;
                        profile_id = btoa(data.data.id);
                        // add validation of unique fun fact rule
                        var rules = $('#fun_fact').rules();
                        if (!findProperty(rules, 'remote')) {
                            $('#fun_fact').rules('add', {
                                remote: site_url + 'profile/check_facts/' + profile_id,
                                messages: {
                                    remote: "This fun fact is already added",
                                }
                            });
                        }
                        $('#affiliation_text').rules('add', {
                            remote: site_url + 'profile/check_affiliation/' + profile_id,
                            messages: {
                                remote: "This affiliation is already added",
                            }
                        });
                        $('#profile_name').html(data.firstname + ' ' + data.lastname);
                        $('#profile_slug').attr('data-href', site_url + 'profile/' + data.slug);
                        profile_slug = data.slug;
                        $('.nav-tabs a[href="#second-step"]').tab('show');

                    } else {
                        $('#profile_process').val(0);
                        showErrorMSg(data.error);
                    }
                }
            });
        }
    }
    return false;
}
//-- Hide show steps based on step id
function profile_steps(obj) {
    $('.profile-steps').addClass('hide');
    $('.steps-li').removeClass('active');
    $('.steps-li').removeClass('process-done');
    $('#' + obj + '-li').addClass('active');

    if (obj == 'first-step') {
        $('#' + obj).removeClass('hide');
    } else if (obj == 'second-step') {
        $('#' + obj).removeClass('hide');
        $('#first-step-li').addClass('process-done');
    } else if (obj == 'third1-step') {
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li').addClass('process-done');
    } else if (obj == 'third-step') {
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li').addClass('process-done');
    } else if (obj == 'forth-step') {
        //-- Display timeline data
        $('.loader').show();
        $.ajax({
            url: site_url + "profile/lifetimeline",
            type: "POST",
            data: {profile_id: profile_id},
            success: function (data) {
                $('.loader').hide();
                $('.timeline-div').html(data);

                $('.date-picker').datepicker({
                    format: "mm/dd/yyyy",
                    endDate: "date()",
                    autoclose: true,
                });
            }
        });


        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li,#third-step-li').addClass('process-done');
    } else if (obj == 'fifth-step') {
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li,#third-step-li,#forth-step-li').addClass('process-done');
    } else if (obj == 'sixth-step') {
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li,#third-step-li,#forth-step-li').addClass('process-done');
    } else if (obj == 'seventh-step') {
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li,#third-step-li,#forth-step-li').addClass('process-done');
    }
    //-- Scroll to top of profile div section 
    $('html, body').animate({
        'scrollTop': $(".create-profile").position().top
    }, 1000);
}
//-- Back step
function back_step() {
    var profile_process = $('#profile_process').val();
    if (profile_process == 1) {
        $('#profile_process').val(0);
        profile_steps('first-step');
    } else if (profile_process == 2) {
        $('#profile_process').val(1);
        profile_steps('second-step');
    } else if (profile_process == 3) {
        if (!$('#third1-step').hasClass('hide')) {
            $('#profile_process').val(3);
            profile_steps('third-step');
        } else if (!$('#forth-step').hasClass('hide')) {
            $('#profile_process').val(3);
            profile_steps('third1-step');
        } else {
            $('#profile_process').val(2);
            profile_steps('second-step');
        }
    } else if (profile_process == 4) {
        $('#profile_process').val(3);
        profile_steps('forth-step');
    } else if (profile_process == 5) {
        $('#profile_process').val(4);
        profile_steps('fifth-step');
    } else if (profile_process == 6) {
        $('#profile_process').val(5);
        profile_steps('sixth-step');
    }
    return false;
}
function skip_step() {
    var profile_process = $('#profile_process').val();
    if (profile_process == 1) {
        $('#profile_process').val(2);
        profile_steps('third-step');
    } else if (profile_process == 2) {
        $('#profile_process').val(3);
        if ($('#third-step').hasClass('hide')) {
            profile_steps('third-step');
        } else {
            profile_steps('third1-step');
        }
    } else if (profile_process == 3) {
        if (!$('#third-step').hasClass('hide')) {
            profile_steps('third1-step');
        } else if (!$('#third1-step').hasClass('hide')) {
            profile_steps('forth-step');
        } else {
            $('#profile_process').val(4);
            profile_steps('fifth-step');
        }
    } else if (profile_process == 4) {
        $('#profile_process').val(5);
        profile_steps('sixth-step');
    } else if (profile_process == 5) {
        $('#profile_process').val(6);
        profile_steps('seventh-step');
    }
    return false;
}

// Proceeds steps
function proceed_step() {
    //-- check if required field is fill up by user
    if (currentTab != 'first-step' && profile_id == 0) {
        $('.nav-tabs a[href="#first-step"]').tab('show');
        $('#create_profile_form').valid();
        showErrorMSg('Please save Basic Info first!');
    } else {
        var profile_process = $('#profile_process').val();
        if (currentTab == 'first-step') {
            if ($('#create_profile_form').valid()) {
                $('#profile_process').val(1);
                fd = new FormData(document.getElementById("create_profile_form"));
                $('.loader').show();
                $.ajax({
                    url: create_profile_url,
                    type: "POST",
                    data: fd,
                    dataType: "json",
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function (data) {
                        $('.loader').hide();
                        if (data.success == true) {
                            create_profile_url = site_url + "profile/edit/" + data.data.slug;
                            profile_id = btoa(data.data.id);
                            // add validation of unique fun fact rule
                            var rules = $('#fun_fact').rules();
                            if (!findProperty(rules, 'remote')) {
                                $('#fun_fact').rules('add', {
                                    remote: site_url + 'profile/check_facts/' + profile_id,
                                    messages: {
                                        remote: "This fun fact is already added",
                                    }
                                });
                            }
                            $('#affiliation_text').rules('add', {
                                remote: site_url + 'profile/check_affiliation/' + profile_id,
                                messages: {
                                    remote: "This affiliation is already added",
                                }
                            });
                            $('#profile_name').html(data.firstname + ' ' + data.lastname);
                            $('#profile_slug').attr('data-href', site_url + 'profile/' + data.slug);
                            profile_slug = data.slug;
                            $('.nav-tabs a[href="#second-step"]').tab('show');

                        } else {
                            $('#profile_process').val(0);
                            showErrorMSg(data.error);
                        }
                    }
                });
            }
        } else if (currentTab == 'second-step') {
            $('.loader').show();
            $.ajax({
                url: site_url + "profile/proceed_steps",
                type: "POST",
                data: {profile_process: 2, profile_id: profile_id},
                dataType: "json",
                success: function (data) {
                    $('.loader').hide();
                    if (data.success == true) {
                        $('#profile_process').val(2);
                        //--display fun facts step
                        $('.nav-tabs a[href="#third-step"]').tab('show');
                    } else {
                        $('#profile_process').val(1);
                        showErrorMSg(data.error);
                    }
                }
            });
        } else if (currentTab == 'third-step') {
            $('.loader').show();
            $.ajax({
                url: site_url + "profile/proceed_steps",
                type: "POST",
                data: {profile_process: 3, profile_id: profile_id},
                dataType: "json",
                success: function (data) {
                    $('.loader').hide();
                    if (data.success == true) {
                        $('#profile_process').val(3);
                        //--display add affiliation step
                        $('.nav-tabs a[href="#third1-step"]').tab('show');
                    } else {
                        $('#profile_process').val(2);
                        showErrorMSg(data.error);
                    }
                }
            });
        } else if (currentTab == 'third1-step') {
            $('.loader').show();
            $.ajax({
                url: site_url + "profile/proceed_steps",
                type: "POST",
                data: {profile_process: 3, profile_id: profile_id},
                dataType: "json",
                success: function (data) {
                    $('.loader').hide();
                    if (data.success == true) {
                        $('#profile_process').val(3);
                        //--display life timeline step
                        $('.nav-tabs a[href="#forth-step"]').tab('show');
                    } else {
                        showErrorMSg(data.error);
                    }
                }
            });
        } else if (currentTab == 'forth-step') {
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
                    $('.loader').show();
                    $.ajax({
                        url: site_url + "profile/add_timeline",
                        type: "POST",
                        data: fd,
                        dataType: "json",
                        processData: false, // tell jQuery not to process the data 
                        contentType: false, // tell jQuery not to set contentType
                        success: function (data) {
                            $('.loader').hide();
                            if (data.success == true) {
                                $('#profile_process').val(4);
                                //--display funeral services tab
                                $('.nav-tabs a[href="#fifth-step"]').tab('show');
                            } else {
                                $('#profile_process').val(3);
                                showErrorMSg(data.error);
                            }
                        }
                    });
                }
            } else {
                $('.loader').show();
                $.ajax({
                    url: site_url + "profile/proceed_steps",
                    type: "POST",
                    data: {profile_process: 4, profile_id: profile_id},
                    dataType: "json",
                    success: function (data) {
                        $('.loader').hide();
                        if (data.success == true) {
                            $('#profile_process').val(4);
                            //--display funeral services tab
                            $('.nav-tabs a[href="#fifth-step"]').tab('show');
                        } else {
                            $('#profile_process').val(3);
                            showErrorMSg(data.error);
                        }
                    }
                });
            }
        } else if (currentTab == 'fifth-step') {
            service_valid = 1;
            if ($('#memorial_date').val() != '' || $('#memorial_time').val() != '' || $('#memorial_place').val() != '' || $('#memorial_address').val() != '' || $('#memorial_country').val() != '' || $('#memorial_state').val() != '' || $('#memorial_city').val() != '' || $('#memorial_zip').val() != '') {
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
                if ($('#memorial_country').val() == '') {
                    $('#memorial_country').siblings('.select2').addClass('error');
                    service_valid = 0;
                }
                if ($('#memorial_state').val() == '') {
                    $('#memorial_state').siblings('.select2').addClass('error');
                    service_valid = 0;
                }
                if ($('#memorial_city').val() == '') {
                    $('#memorial_city').siblings('.select2').addClass('error');
                    service_valid = 0;
                }
                if ($('#memorial_zip').val() == '') {
                    $('#memorial_zip').addClass('error');
                    service_valid = 0;
                }
            }
            if ($('#funeral_date').val() != '' || $('#funeral_time').val() != '' || $('#funeral_place').val() != '' || $('#funeral_address').val() != '' || $('#funeral_country').val() != '' || $('#funeral_state').val() != '' || $('#funeral_city').val() != '' || $('#funeral_zip').val() != '') {
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
                if ($('#funeral_country').val() == '') {
                    $('#funeral_country').siblings('.select2').addClass('error');
                    service_valid = 0;
                }
                if ($('#funeral_state').val() == '') {
                    $('#funeral_state').siblings('.select2').addClass('error');
                    service_valid = 0;
                }
                if ($('#funeral_city').val() == '') {
                    $('#funeral_city').siblings('.select2').addClass('error');
                    service_valid = 0;
                }
                if ($('#funeral_zip').val() == '') {
                    $('#funeral_zip').addClass('error');
                    service_valid = 0;
                }
            }

            if ($('#burial_date').val() != '' || $('#burial_time').val() != '' || $('#burial_place').val() != '' || $('#burial_address').val() != '' || $('#burial_country').val() != '' || $('#burial_state').val() != '' || $('#burial_city').val() != '' || $('#burial_zip').val() != '') {
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
                if ($('#burial_country').val() == '') {
                    $('#burial_country').siblings('.select2').addClass('error');
                    service_valid = 0;
                }
                if ($('#burial_state').val() == '') {
                    $('#burial_state').siblings('.select2').addClass('error');
                    service_valid = 0;
                }
                if ($('#burial_city').val() == '') {
                    $('#burial_city').siblings('.select2').addClass('error');
                    service_valid = 0;
                }
                if ($('#burial_zip').val() == '') {
                    $('#burial_zip').addClass('error');
                    service_valid = 0;
                }
            }

            if (service_valid == 1) {
                $('.loader').show();
                $.ajax({
                    url: site_url + "profile/add_services",
                    type: "POST",
                    data: $('#funeralservice-form').serialize() + "&profile_id=" + profile_id,
                    dataType: "json",
                    success: function (data) {
                        $('.loader').hide();
                        if (data.success == true) {
                            $('#profile_process').val(5);
                            //--display add affiliation step
                            $('.nav-tabs a[href="#sixth-step"]').tab('show');
                        } else {
                            showErrorMSg(data.error);
                        }
                    }
                });
            }
        } else if (currentTab == 'sixth-step') {
            if ($('#fundraiser_profile-form').valid()) {
                fundraiser_valid = 1, entered_detail = 0;
                if ($('#fundraiser_title').val() != '' || $('#fundraiser_goal').val() != '' || $('#fundraiser_enddate').val() != '' || $('#fundraiser_details').val() != '') {
                    if ($('#fundraiser_title').val() == '') {
                        $('#fundraiser_title').addClass('error');
                        fundraiser_valid = 0;
                    }

                    if ($('#fundraiser_goal').val() != '' && $('#fundraiser_goal').val() < 250) {
                        $('#fundraiser_goal').addClass('error');
                        fundraiser_valid = 0;
                    } else {
                        $('#fundraiser_goal').removeClass('error');
                    }
                    /*
                     if ($('#fundraiser_enddate').val() == '') {
                     $('#fundraiser_enddate').addClass('error');
                     fundraiser_valid = 0;
                     }*/
                    if ($('#fundraiser_details').val() == '') {
                        $('#fundraiser_details').addClass('error');
                        fundraiser_valid = 0;
                    }
                    entered_detail = 1;
                }
                if (fundraiser_valid == 1) {
                    if (entered_detail == 1) {
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
                        $('.loader').show();
                        $.ajax({
                            url: site_url + "profile/add_fundraiser",
                            type: "POST",
                            data: postformData,
                            dataType: "json",
                            processData: false, // tell jQuery not to process the data
                            contentType: false, // tell jQuery not to set contentType
                            success: function (data) {
                                $('.loader').hide();
                                if (data.success == true) {
                                    $('#profile_process').val(6);
                                    $('.nav-tabs a[href="#seventh-step"]').tab('show');
                                } else {
                                    showErrorMSg(data.error);
                                }
                            }
                        });
                    } else {
                        //-- update profile step do not store fundraiser detail into database
                        $('.loader').show();
                        $.ajax({
                            url: site_url + "profile/proceed_steps",
                            type: "POST",
                            data: {profile_process: 6, profile_id: profile_id},
                            dataType: "json",
                            processData: false, // tell jQuery not to process the data
                            contentType: false, // tell jQuery not to set contentType
                            success: function (data) {
                                $('.loader').hide();
                                if (data.success == true) {
                                    $('#profile_process').val(6);
                                    $('.nav-tabs a[href="#seventh-step"]').tab('show');
                                } else {
                                    showErrorMSg(data.error);
                                }
                            }
                        });
                    }
                }
            }
        }
    }
    return false;
}
/**
 * Redirect to preview profile page
 * @param {type} obj
 * @returns {Boolean}
 */
function preview_profile() {
    //-- check profile is valid for preview
    if (profile_id == 0) {
        $('.nav-tabs a[href="#first-step"]').tab('show');
        $('#create_profile_form').valid();
        showErrorMSg('Please save Basic Info first!');

    } else {
        window.location.href = site_url + 'profile/' + profile_slug;
    }
    return false;
}
/**
 * Save data and redirect use to dashboard page
 */
function save_finish() {
    //-- check required feild is entered by user if yes save first step data
    //-- check if required field is fill up by user
    if (currentTab != 'first-step' && profile_id == 0) {
        $('.nav-tabs a[href="#first-step"]').tab('show');
        $('#create_profile_form').valid();
        showErrorMSg('Please save Basic Info first!');

    } else {
        if ($('#create_profile_form').valid()) {
            $('#profile_process').val(1);
            fd = new FormData(document.getElementById("create_profile_form"));
            $('.loader').show();
            $.ajax({
                url: create_profile_url,
                type: "POST",
                data: fd,
                async: false,
                dataType: "json",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
                    if (data.success == true) {
                        create_profile_url = site_url + "profile/edit/" + data.data.slug;
                        profile_id = btoa(data.data.id);
                        // add validation of unique fun fact rule
                        var rules = $('#fun_fact').rules();
                        if (!findProperty(rules, 'remote')) {
                            $('#fun_fact').rules('add', {
                                remote: site_url + 'profile/check_facts/' + profile_id,
                                messages: {
                                    remote: "This fun fact is already added",
                                }
                            });
                        }
                        $('#affiliation_text').rules('add', {
                            remote: site_url + 'profile/check_affiliation/' + profile_id,
                            messages: {
                                remote: "This affiliation is already added",
                            }
                        });
                        $('#profile_name').html(data.firstname + ' ' + data.lastname);
                        $('#profile_slug').attr('data-href', site_url + 'profile/' + data.slug);
                        profile_slug = data.slug;

                        //-- Save timeline data
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
                                    async: false,
                                    processData: false, // tell jQuery not to process the data 
                                    contentType: false, // tell jQuery not to set contentType
                                    success: function (data) {
                                        if (data.success == true) {
                                            $('#profile_process').val(4);
                                            save_funeral_tribute();
                                        } else {
                                            $('.loader').hide();
                                            $('#profile_process').val(3);
                                            $('.nav-tabs a[href="#forth-step"]').tab('show');
                                            showErrorMSg(data.error);
                                        }
                                    }
                                });
                            }
                        } else {
                            save_funeral_tribute();
                        }
                    } else {
                        $('.loader').hide();
                        $('.nav-tabs a[href="#first-step"]').tab('show');
                        $('#profile_process').val(0);
                        showErrorMSg(data.error);
                    }
                }
            });
        } else {
            $('.nav-tabs a[href="#first-step"]').tab('show');
        }
    }
    return false;
}

function publish_profile() {
//-- check profile is valid for publish
    if (profile_id == 0) {
        $('.nav-tabs a[href="#first-step"]').tab('show');
        $('#create_profile_form').valid();
        showErrorMSg('Please save Basic Info first!');

    } else {
        swal({
            title: "Are you sure?",
            text: "You want to publish this profile",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
//            focusConfirm:true,
            focusCancel: true,
//          reverseButtons: true,
        }).then(function (isConfirm) {
            if (isConfirm) {
                window.location.href = site_url + 'profile/publish/' + profile_slug;
                return true;
            }
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal("Cancelled", "Your profile is not published. :(", "error");
            }
        });
    }
}
//-- Gallery step
var image_count = 0, video_count = 0;
$("#gallery").change(function () {
    var dvPreview = $("#selected-preview");
    if (typeof (FileReader) != "undefined") {
        if (profile_id == 0) {
            $('.nav-tabs a[href="#first-step"]').tab('show');
            $('#create_profile_form').valid();
            showErrorMSg('Please save Basic Info first!');
        } else {
            $($(this)[0].files).each(function (index) {
                var file = $(this);
                str = '';
                if (regex_img.test(file[0].name.toLowerCase())) {
                    //-- check image and video count
                    if (image_count <= max_images_count) {

                        // upload image
                        var formData = new FormData();
                        formData.append('profile_id', profile_id);
                        formData.append('type', 'image');
                        formData.append('gallery', file[0], file[0].name);
                        $('.loader').show();
                        $.ajax({
                            url: site_url + "profile/upload_gallery",
                            type: "POST",
                            data: formData,
                            dataType: "json",
                            processData: false, // tell jQuery not to process the data
                            contentType: false, // tell jQuery not to set contentType
                            success: function (data) {
                                $('.loader').hide();
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
                    if (video_count <= max_videos_count) {
                        // upload video
                        var videoData = new FormData();
                        videoData.append('profile_id', profile_id);
                        videoData.append('type', 'video');
                        videoData.append('gallery', file[0], file[0].name);
                        $('.loader').show();
                        $.ajax({
                            url: site_url + "profile/upload_gallery",
                            type: "POST",
                            data: videoData,
                            dataType: "json",
                            processData: false, // tell jQuery not to process the data
                            contentType: false, // tell jQuery not to set contentType
                            success: function (data) {
                                $('.loader').hide();
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
        }
    } else {
        showErrorMSg("This browser does not support HTML5 FileReader.");
    }
});

function delete_media(obj, data) {
    $('.loader').show();
    $.ajax({
        url: site_url + "profile/delete_gallery",
        type: "POST",
        data: {'gallery': data},
        dataType: "json",
        success: function (data) {
            $('.loader').hide();
            if (data.success == true) {
                if (data.type == 1) {
                    max_images_count++; //increase max images count if deleted media is image
                } else {
                    max_videos_count++; //increase max videos count if deleted media is video
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
    if (profile_id == 0) {
        $('#funfact-modal').modal('hide');
        showErrorMSg('Please save Basic Info first!');
        $('.nav-tabs a[href="#first-step"]').tab('show');
    } else {
        if ($('#fun-fact-form').valid()) {
            if (facts_count < max_facts_count) {
                $('.loader').show();
                $.ajax({
                    url: site_url + "profile/add_facts",
                    type: "POST",
                    data: {facts: $('#fun_fact').val(), profile_id: profile_id},
                    dataType: "json",
                    success: function (data) {
                        $('.loader').hide();
                        if (data.success == true) {
                            facts_count++;
                            $('#third-step').find('.default-fact-empty').removeClass('default-fact-empty');
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
    }
    return false;
}
function save_funeral_tribute() {
    // Save funeral services data
    service_valid = 1;
    if ($('#memorial_date').val() != '' || $('#memorial_time').val() != '' || $('#memorial_place').val() != '' || $('#memorial_address').val() != '' || $('#memorial_country').val() != '' || $('#memorial_state').val() != '' || $('#memorial_city').val() != '' || $('#memorial_zip').val() != '') {
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
        if ($('#memorial_country').val() == '') {
            $('#memorial_country').addClass('error');
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

    if ($('#funeral_date').val() != '' || $('#funeral_time').val() != '' || $('#funeral_place').val() != '' || $('#funeral_address').val() != '' || $('#funeral_country').val() != '' || $('#funeral_state').val() != '' || $('#funeral_city').val() != '' || $('#funeral_zip').val() != '') {
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
        if ($('#funeral_country').val() == '') {
            $('#funeral_country').addClass('error');
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

    if ($('#burial_date').val() != '' || $('#burial_time').val() != '' || $('#burial_place').val() != '' || $('#burial_address').val() != '' || $('#burial_country').val() != '' || $('#burial_state').val() != '' || $('#burial_city').val() != '' || $('#burial_zip').val() != '') {
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
        if ($('#burial_country').val() == '') {
            $('#burial_country').addClass('error');
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
            async: false,
            data: $('#funeralservice-form').serialize() + "&profile_id=" + profile_id,
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    $('#profile_process').val(5);

                    if ($('#fundraiser_profile-form').valid()) {
                        fundraiser_valid = 1, entered_detail = 0;
                        if ($('#fundraiser_title').val() != '' || $('#fundraiser_goal').val() != '' || $('#fundraiser_enddate').val() != '' || $('#fundraiser_details').val() != '') {
                            if ($('#fundraiser_title').val() == '') {
                                $('#fundraiser_title').addClass('error');
                                fundraiser_valid = 0;
                            }

                            if ($('#fundraiser_goal').val() != '' && $('#fundraiser_goal').val() < 250) {
                                $('#fundraiser_goal').addClass('error');
                                fundraiser_valid = 0;
                            } else {
                                $('#fundraiser_goal').removeClass('error');
                            }
                            /*
                             if ($('#fundraiser_enddate').val() == '') {
                             $('#fundraiser_enddate').addClass('error');
                             fundraiser_valid = 0;
                             }*/
                            if ($('#fundraiser_details').val() == '') {
                                $('#fundraiser_details').addClass('error');
                                fundraiser_valid = 0;
                            }
                            entered_detail = 1;
                        }
                        if (fundraiser_valid == 1) {
                            if (entered_detail == 1) {
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
                                    async: false,
                                    dataType: "json",
                                    processData: false, // tell jQuery not to process the data
                                    contentType: false, // tell jQuery not to set contentType
                                    success: function (data) {
                                        if (data.success == true) {
                                            $('#profile_process').val(6);
                                            //-- Redirect to user dashboard page
                                            window.location.href = site_url + 'dashboard/profiles';
                                        } else {
                                            $('.loader').hide();
                                            $('.nav-tabs a[href="#sixth-step"]').tab('show');
                                            showErrorMSg(data.error);
                                        }
                                    }
                                });
                            } else {

                                //-- Redirect to user dashboard page
                                window.location.href = site_url + 'dashboard/profiles';
                            }
                        } else {
                            $('.loader').hide();
                            //--display tribute fundraiser step
                            $('.nav-tabs a[href="#sixth-step"]').tab('show');
                        }
                    } else {
                        $('.loader').hide();
                        //--display tribute fundraiser step
                        $('.nav-tabs a[href="#sixth-step"]').tab('show');
                    }

                } else {
                    $('.loader').hide();
                    //--display funeral service step
                    $('.nav-tabs a[href="#fifth-step"]').tab('show');
                    showErrorMSg(data.error);
                }
            }
        });
    } else {
        $('.loader').hide();
        //--display funeral service step
        $('.nav-tabs a[href="#fifth-step"]').tab('show');
    }
    return false;
}
function delete_facts(obj, data) {
    $('.loader').show();
    $.ajax({
        url: site_url + "profile/delete_facts",
        type: "POST",
        data: {'fact': data},
        dataType: "json",
        success: function (data) {
            $('.loader').hide();
            if (data.success == true) {
                $(obj).parent('.input-wrap-div').remove();
                facts_count--;
                if (facts_count == 0) {
                    $('#third-step').find('.step-form').addClass('default-fact-empty');
                }
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
    if (profile_id == 0) {
        $('#affiliation-modal').modal('hide');
        showErrorMSg('Please save Basic info first!');
        $('.nav-tabs a[href="#first-step"]').tab('show');
    } else {
        if ($('#affiliation-form').valid()) {
            if (affiliation_count < max_affiliation_count) {
                $('.loader').show();
                $.ajax({
                    url: site_url + "profile/add_affiliation",
                    type: "POST",
                    data: {select_affiliation: $('#select_affiliation').val(), affiliation_text: $('#affiliation_text').val(), profile_id: profile_id},
                    dataType: "json",
                    success: function (data) {
                        $('.loader').hide();
                        if (data.success == true) {
                            $('#third1-step').find('.default-fact-empty').removeClass('default-fact-empty');
                            $('#default-affiliation').remove();
                            str = '';
                            $.each(data.data, function (i, v) {
                                str += '<div class="input-wrap-div">';
                                str += '<div class="input-css">' + v.name + '</div>';
                                str += '<a href="javascript:void(0)" onclick="delete_affiliation(this,\'' + v.id + '\',' + v.type + ')">';
                                str += delete_str;
                                str += '</a></div>';
                            });
                            affiliation_count = data.affiliation_count;
                            $('#selected-affiliation').prepend(str);
//                        $('#selected-affiliation').append(str);
                            $("#affiliation-form")[0].reset();
                            $('#affiliation-modal').modal('hide');
                            $("#affiliation-form").validate().resetForm();
                            $('#select_affiliation').val('');
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
    }
    return false;
}
function delete_affiliation(obj, data, type) {
    $('.loader').show();
    $.ajax({
        url: site_url + "profile/delete_affiliation",
        type: "POST",
        data: {'affiliation': data, 'type': type},
        dataType: "json",
        success: function (data) {
            $('.loader').hide();
            if (data.success == true) {
                $(obj).parent('.input-wrap-div').remove();
                affiliation_count--;
                if (affiliation_count == 0) {
                    $('#third1-step').find('.step-form').addClass('default-fact-empty');
                }
            } else {
                showErrorMSg(data.error);
            }
        }
    });
}

//-- Forth Timeline step
// Add timeline button
$(document).on('click', '.add_timeline_btn', function () {
    if (profile_id == 0) {
        $('.nav-tabs a[href="#first-step"]').tab('show');
        $('#create_profile_form').valid();
        showErrorMSg('Please save Basic Info first!');
    } else {
        if ($('#timeline-form').valid()) {
            if (validate_timeline_date()) {
                timeline_div = $(this).parent('.step-06-l').parent('.step-06').clone();
                timeline_div.find('input[name="timelineid[]"]').val('');
                timeline_div.find('input[name="title[]"]').val('');
                timeline_div.find('input[name="day[]"]').val('');
                timeline_div.find('input[name="month[]"]').val('');
                timeline_div.find('input[name="year[]"]').val('');
                timeline_div.find('textarea[name="details[]"]').val('');
                timeline_div.find('input[name="life_pic[]"]').val('');
                timeline_div.find('.select-file_up_btn').html("Upload Picture or Video? <span>Select</span>");
                $('.timeline-div').append(timeline_div);
                $(this).html('<i class="fa fa-trash"></i> Remove');
                $(this).removeClass('add_timeline_btn');
                $(this).addClass('remove_timeline_btn text-danger mb-20');
                //-- Initialize datepicker
                $('.date-picker').datepicker({
                    format: "mm/dd/yyyy",
                    endDate: "date()",
                    autoclose: true,
                });
            }
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
    $('.loader').show();
    $.ajax({
        url: site_url + "profile/delete_timeline",
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function (data) {
            $('.loader').hide();
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
    $('input[name="day[]"]').each(function () {
        day = $(this);
        month = $(this).parent('.input-three-r').siblings('.input-three-m').find('input[name="month[]"]');
        year = $(this).parent('.input-three-r').siblings('.input-three-l').find('input[name="year[]"]');
        if (day.val() != '' && month.val() == '') {
            month.addClass('error');
            valid = 0;
        } else {
            month.removeClass('error');
        }
        if (day.val() != '' && month.val() != '' && year.val() != '') {
            if (isValidDate(day.val(), month.val(), year.val())) {
                day.removeClass('error');
                month.removeClass('error');
                year.removeClass('error');
            } else {
                valid = 0;
                day.addClass('error');
                month.addClass('error');
                year.addClass('error');
            }
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

// country dropdown change event
$(document).on('change', '.service-country', function () {
    $(this).valid();
    $(this).siblings('.select2').removeClass('error');

    country_val = $(this).val();
    country_id = $(this).attr('id');
    state_id = city_id = '';
    if (country_id == 'country') {
        state_id = 'state';
        city_id = 'city';
    } else if (country_id == 'memorial_country') {
        state_id = 'memorial_state';
        city_id = 'memorial_city';
    } else if (country_id == 'funeral_country') {
        state_id = 'funeral_state';
        city_id = 'funeral_city';
    } else if (country_id == 'burial_country') {
        state_id = 'burial_state';
        city_id = 'burial_city';
    }
    $('#' + state_id).val('');
    $('#' + city_id).val('');
    if (country_val != '') {
        $('.loader').show();
        $.ajax({
            url: site_url + "profile/get_states",
            type: "POST",
            data: {country: country_val},
            dataType: "json",
            success: function (data) {
                $('.loader').hide();
                var options = "<option value=''>Select state</option>";
                for (var i = 0; i < data.length; i++) {
                    code = data[i].shortcode;
                    if (code != null) {
                        codes = code.split('-');
                        code = codes[1];
                    }
                    options += '<option value=' + data[i].id + '>' + data[i].name;
                    if (code != null) {
                        options += ' (' + code + ')';
                    }
                    options += '</option>';
                }
                $('#' + state_id).empty().append(options);
            }
        });
    }
});
// state dropdown change event
$(document).on('change', '.service-state', function () {
    $(this).valid();
    $(this).siblings('.select2').removeClass('error');

    state_val = $(this).val();
    state_id = $(this).attr('id');
    city_id = '';
    if (state_id == 'state') {
        city_id = 'city';
    } else if (state_id == 'memorial_state') {
        city_id = 'memorial_city';
    } else if (state_id == 'funeral_state') {
        city_id = 'funeral_city';
    } else if (state_id == 'burial_state') {
        city_id = 'burial_city';
    }
    $('#' + city_id).val('');
    if (state_val != '') {
        $('.loader').show();
        $.ajax({
            url: site_url + "profile/get_cities",
            type: "POST",
            data: {state: state_val},
            dataType: "json",
            success: function (data) {
                $('.loader').hide();
                var options = "<option value=''>Select City</option>";
                for (var i = 0; i < data.length; i++) {
                    options += '<option value=' + data[i].name + '>' + data[i].name + '</option>';
                }
                $('#' + city_id).empty().append(options);
            }
        });
    }
});
//Textbox change event remove error class
$(document).on('change', '#memorial_date,#memorial_time,#funeral_date,#funeral_time,#burial_date,#burial_time,#memorial_place,#funeral_place,#burial_place,#burial_address,#funeral_address,#memorial_address,#memorial_country,#memorial_state,#memorial_city,#memorial_zip,#funeral_country,#funeral_state,#funeral_city,#funeral_zip,#burial_country,#burial_state,#burial_city,#burial_zip,#fundraiser_title,#fundraiser_details', function () {
    $(this).removeClass('error');
    if ($(this).hasClass('service-country')) {
        $(this).siblings('select2').removeClass('error');
    }
    if ($(this).hasClass('service-state')) {
        $(this).siblings('select2').removeClass('error');
    }
    if ($(this).hasClass('service-city')) {
        $(this).siblings('select2').removeClass('error');
    }
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
                if (fundimage_count <= max_fundimages_count) {
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
                if (fundvideo_count <= max_fundvideos_count) {
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

function delete_fundmedia(obj, type, index) {
    $(fundraiser_media).each(function (key) {
        if (typeof (fundraiser_media[key]) != 'undefined' && fundraiser_media[key]['index'] == index) {
            delete fundraiser_media[key];
        }
    });
    if (type == 1) {
        fundimage_count--; //increase max images count if deleted media is image
    } else {
        fundvideo_count--; //increase max videos count if deleted media is video
    }
    $(obj).parent('.gallery-wrap').parent('li').remove();
}

/**
 * Ajax call to this function delete fund media
 * @param {object} obj
 * @param string media_id
 */
function delete_fundajaxmedia(obj, media_id) {
    $('.loader').show();
    $.ajax({
        url: site_url + "profile/delete_fundmedia",
        type: "POST",
        data: {'media': media_id},
        dataType: "json",
        success: function (data) {
            $('.loader').hide();
            if (data.success == true) {
                if (data.type == 1) {
                    max_fundimages_count++; //increase max images count if deleted media is image
                } else {
                    max_fundvideos_count++; //increase max videos count if deleted media is video
                }
                $(obj).parent('.gallery-wrap').parent('li').remove();
            } else {
                showErrorMSg(data.error);
            }
        }
    });

}
//-- Remove error class if amount is valid
$('#fundraiser_goal').change(function () {
    if ($(this).val() >= 250) {
        $(this).removeClass('error');
    }
});
function isValidDate(day, month, year) {
    var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

// Adjust for leap years
    if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    let errors = []

    if (!(month > 0 && month < 13)) {
        errors.push("month");
    }

    if (day < 0 || day > monthLength[month - 1]) {
        errors.push("day");
    }
    if (errors.length == 0) {
        return true;
    } else {
        return false;
    }
}
$('#firstname,#lastname').change(function () {
    $('#profile_name').html($('#firstname').val() + ' ' + $('#lastname').val());
});
