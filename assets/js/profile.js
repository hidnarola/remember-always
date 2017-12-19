var regex_img = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
var regex_video = /^([a-zA-Z0-9\s_\\.\-:])+(.mp4)$/;
$(function () {
    //-- Initialize datepicker
    $('.date-picker').datepicker({
        format: "mm/dd/yyyy",
        endDate: "date()"
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
            }
        },

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
                    console.log('text', $("#affiliation_text").is(':empty'));
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
                'required': true
            },
            'month[]': {
                min: 1,
                max: 12
            },
            'month_year[]': {
                max: currentYear
            },
            'year[]': {
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
    $('.service-datepicker').datepicker({format: "mm/dd/yyyy", startDate: "date()"});
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
            $.ajax({
                url: site_url + "profile/create",
                type: "POST",
                data: fd,
                dataType: "json",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
                    if (data.success == true) {
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
                        profile_steps('second-step');
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
        $('.main-steps').removeClass('hide');
        $('#' + obj).removeClass('hide');
    } else if (obj == 'second-step') {
        $('.main-steps').removeClass('hide');
        $('#' + obj).removeClass('hide');
        $('#first-step-li').addClass('process-done');
    } else if (obj == 'third1-step') {
        $('.main-steps').removeClass('hide');
        $('#third-step-li').addClass('active');
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li').addClass('process-done');
    } else if (obj == 'third-step') {
        $('.main-steps').removeClass('hide');
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li').addClass('process-done');
    } else if (obj == 'forth-step') {
        //-- Display timeline data

        $.ajax({
            url: site_url + "profile/lifetimeline",
            type: "POST",
            data: {profile_id: profile_id},
            success: function (data) {
                $('.timeline-div').html(data);

                $('.date-picker').datepicker({
                    format: "mm/dd/yyyy",
                    endDate: "date()"
                });
            }
        });


        $('.main-steps').removeClass('hide');
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li,#third-step-li').addClass('process-done');
    } else if (obj == 'fifth-step') {
        $('.main-steps').removeClass('hide');
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li,#third-step-li,#forth-step-li').addClass('process-done');
    } else if (obj == 'sixth-step') {
        $('.main-steps').addClass('hide');
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li,#third-step-li,#forth-step-li').addClass('process-done');
    } else if (obj == 'seventh-step') {
        $('.main-steps').addClass('hide');
        $('#' + obj).removeClass('hide');
        $('#first-step-li,#second-step-li,#third-step-li,#forth-step-li').addClass('process-done');
    }
}
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
        profile_steps('forth-step');
    } else if (profile_process == 6) {
        $('#profile_process').val(5);
        profile_steps('fifth-step');
    } else if (profile_process == 7) {
        $('#profile_process').val(6);
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
        } else {
            $('#profile_process').val(4);
            profile_steps('forth-step');
        }
    } else if (profile_process == 4) {
        $('#profile_process').val(5);
        profile_steps('fifth-step');
    } else if (profile_process == 5) {
        $('#profile_process').val(6);
        profile_steps('sixth-step');
    } else if (profile_process == 6) {
        $('#profile_process').val(7);
        profile_steps('seventh-step');
    }
    return false;
}

// Proceeds steps
function proceed_step() {
    var profile_process = $('#profile_process').val();
    if (profile_process == 1) {
        $.ajax({
            url: site_url + "profile/proceed_steps",
            type: "POST",
            data: {profile_process: 2, profile_id: profile_id},
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    $('#profile_process').val(2);
                    profile_steps('third-step');
                } else {
                    $('#profile_process').val(1);
                    showErrorMSg(data.error);
                }
            }
        });
    } else if (profile_process == 2) {
        $.ajax({
            url: site_url + "profile/proceed_steps",
            type: "POST",
            data: {profile_process: 3, profile_id: profile_id},
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    $('#profile_process').val(3);
                    if ($('#third-step').hasClass('hide') && $('#third1-step').hasClass('hide')) {
                        profile_steps('third-step');
                    } else if ($('#third1-step').hasClass('hide') && !$('#third-step').hasClass('hide')) {
                        profile_steps('third1-step');
                    } else {
                        profile_steps('forth-step');
                    }
                } else {
                    $('#profile_process').val(2);
                    showErrorMSg(data.error);
                }
            }
        });
    } else if (profile_process == 3) {
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
                                $('#profile_process').val(4);
                                profile_steps('fifth-step');
                            } else {
                                $('#profile_process').val(3);
                                showErrorMSg(data.error);
                            }
                        }
                    });
                }
            } else {
                $.ajax({
                    url: site_url + "profile/proceed_steps",
                    type: "POST",
                    data: {profile_process: 4, profile_id: profile_id},
                    dataType: "json",
                    success: function (data) {
                        if (data.success == true) {
                            $('#profile_process').val(4);
                            profile_steps('fifth-step');
                        } else {
                            $('#profile_process').val(3);
                            showErrorMSg(data.error);
                        }
                    }
                });
            }

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
                if (image_count <= max_images_count) {

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
                                    str += '<img src="' + e.target.result + '" style="width:100%">';
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
                                str = '<li><div class="upload-wrap"><span>';
                                str += '<video style="width:100%;height:100%" controls><source src="' + URL.createObjectURL(file[0]) + '">Your browser does not support HTML5 video.</video>';
                                str += '</span><a href="javascript:void(0)" class="remove-video" onclick="delete_media(this,\'' + data.data + '\')">';
                                str += delete_str;
                                str += '</a></div></li>';
                                dvPreview.append(str);

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
    if ($('#fun-fact-form').valid()) {
        if (facts_count < max_facts_count) {
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
                max_facts_count++;
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
        if (affiliation_count < max_affiliation_count) {
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