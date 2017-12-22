var regex_img = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
var regex_video = /^([a-zA-Z0-9\s_\\.\-:])+(.mp4)$/;
var http_regex = /^(https:\/\/)/i;
post_data = [];
post_types = [];
start = 0;
total_timeline_count = 0;
$(function () {
    $(".fancybox")
            .fancybox({
                openEffect: 'none',
                closeEffect: 'none',
                nextEffect: 'none',
                prevEffect: 'none',
                padding: 0
            });
    $("#content-8").mCustomScrollbar({
        axis: "y",
        scrollButtons: {enable: true},
        theme: "3d",
        callbacks: {
            onTotalScroll: function () {
                if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                    var limitStart = $(".post_ul > li").length;
//                     $(".loader").show();
                    loadResults(limitStart);
                }
            }, /*user custom callback function on scroll event*/

        },
        advanced: {

            updateOnBrowserResize: true, /*update scrollbars on browser resize (for layouts based on percentages): boolean*/

            updateOnContentResize: true, /*auto-update scrollbars on content resize (for dynamic content): boolean*/

            autoExpandHorizontalScroll: true, /*auto-expand width for horizontal scrolling: boolean*/

            autoScrollOnFocus: false /*auto-scroll on focused elements: boolean*/

        },
    });

    /* For loading more post on scroll event */
    function loadResults(limitStart) {
        if (start != limitStart) {
            start = limitStart;
            $.ajax({
                url: site_url + 'profile/load_posts/' + limitStart + '/' + profile_id,
                type: "post",
                dataType: "json",
                success: function (data) {
                    var string = '';
                    $.each(data, function (index, value) {
                        string += '<li>' +
                                '<div class="comments-div-wrap"><span class="commmnet-postted-img">';
                        if (typeof value['profile_image'] != 'undefined' && value['profile_image'] != null) {
                            if (http_regex.test(value['profile_image'])) {
                                string += '<img src="' + value['profile_image'] + '" />';
                            } else {
                                string += '<img src="' + user_image + value['profile_image'] + '" />';
                            }
                        }
                        string += '</span>' +
                                '<h3>' + value['firstname'] + ' ' + value['lastname'] + '<small>' + value['interval'] + '  Ago</small></h3>' +
                                '<p>';
                        text = value['comment'];
                        if (value['comment'].length > 200) {
//                        text = value['description'].preg_replace("/^(.{1,500})(\s.*|$)/s", '\\1...');
                            text = value['comment'].substring(0, 200);
                            text += '...';
                        }
                        string += text;
                        string += '</p>';
                        if (typeof value['media'] != 'undefined') {
                            string += '<div class="comoon-ul-li list-02">' +
                                    '<ul>';
                            if (typeof value['media'][1] != 'undefined') {
                                $.each(value['media'][1], function (i, v) {
                                    string += '<li><div class="gallery-wrap"><span class="gallery-video-img">'
                                            + '<a class="fancybox" href="' + post_image + v + '" data-fancybox-type="image" rel="post_group_' + value['id'] + '"><img src="' + post_image + v + '"></a>'
                                            + '</span></div></li>'
                                });
                            }
                            if (typeof value['media'][2] != 'undefined') {
                                $.each(value['media'][2], function (i, v) {
                                    string += '<li><div class="gallery-wrap"><span class="gallery-video-img">'
                                            + '<img src="' + post_image + v.replace('mp4', 'jpg') + '">'
//                                            + '<video  width="100%" height="150px" controls=""><source src="' + post_image + v + '" type="video/mp4"></video>'
                                            + '<span class="gallery-play-btn"><a href="' + post_image + v + '" class="fancybox" data-fancybox-type="iframe" rel="post_group_' + value['id'] + '"><img src="assets/images/play.png" alt=""></a></span>'
                                            + '</span></div></li>'
                                });
                            }
                            string += '</ul></div>';
                        }
                        string += '</div></li>';
                    });
                    $(".post_ul").append(string);
//                $(".loader").hide();
                }
            });
        }
    }
    /* Sharing with social media */
    function genericSocialShare(url) {
        window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
        return true;
    }
    /* add new post form validation */
    $('#post_form').validate({
        onkeyup: false,
        onfocusout: false,
        rules: {
            comment: {
                atleast_one_for_post: true,
            },
//            "image_post[]": {
//                atleast_one_for_post: true,
//            },
//            "video_post[]": {
//                atleast_one_for_post: true,
//            },
        },
        highlight: function (element, errorClass) {
            if ($(element).attr('name') === 'comment') {
                $('#post-modal').modal();

                console.log(post_data);
            }
        },
        messages: {
            comment: {
                atleast_one_for_post: ''
            },
//            "image_post[]": {
//                atleast_one_for_post: '',
//            },
//            "video_post[]": {
//                atleast_one_for_post: '',
//            },
        },
        submitHandler: function (form) {
            var postformData = new FormData();
            postformData.append('comment', $('#comment').val());
            $(post_data).each(function (key) {
                if (post_data[key] != null) {
                    post_types[key] = [];
                    post_types[key] = post_data[key]['media_type'];
                    postformData.append('post_upload[]', post_data[key], post_data[key].name);
                    postformData.append('post_types[]', post_types[key]);
                }
            });
            $.ajax({
                url: site_url + "profile/" + slug,
                type: "POST",
                data: postformData,
                dataType: "json",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
//                    console.log("sdfksjf");
                    if (data.success == true) {
                        //-- Remove default preview div
                        window.location.href = site_url + 'profile/' + slug;
//                        showSuccessMSg(data.data);

                    } else {
                        console.log("sdkndff");
                        showErrorMSg(data.error);
                    }
                }
            });
            return false;
//            form.submit();
        },
    });
    $(document).on('click', "#post_btn", function (e) {
        if (user_logged_in != true) {
            e.preventDefault();
            showErrorMSg('You must login to add post for this profile.');
        }
    });
    /* For changing background or cover image */
    $(document).on('change', "#cover_image", function () {
        readcoverURL(this);
    });

    /* For displaying timeline details on click */
    $(document).on('click', ".timeline", function () {
        $('#timeline_details').modal();
        var timeline = $(this).data('timeline');
        $.ajax({
            url: site_url + 'profile/view_timeline/' + timeline,
            type: "post",
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    //-- Remove default preview div
                    var timeline_data = JSON.parse(data.data);
                    $('#timeline_details .timeline_title').html(timeline_data.title);
                    $('#timeline_details .timeline_date').html(timeline_data.interval);
                    if (timeline_data.timeline_media != null && timeline_data.media_type == 1) {
                        $('#timeline_details .timeline_media').parent().parent().show();
                        $('#timeline_details .timeline_media').html('<img src="' + timeline_data.url + timeline_data.timeline_media + '"/ width="100px" height="100px">');
                    } else if (timeline_data.timeline_media != null && timeline_data.media_type == 2) {
                        $('#timeline_details .timeline_media').parent().parent().show();
                        var video_str = '<span><span class="gallery-video-img">';
                        video_str = '<video  width="100%" height="150px" controls="">';
                        video_str += '<source src="' + timeline_data.url + timeline_data.timeline_media + '" type="video/mp4">';
                        video_str += '</video>';
//                        video_str += '<img src="' + timeline_data.url + timeline_data.timeline_media.replace('mp4', 'jpg') + '"/ width="100px" height="100px">';
                        video_str += '</span></span>';
//                        video_str += '<span class="gallery-play-btn"><a href="' + timeline_data.url + timeline_data.timeline_media + '" class="fancybox" data-fancybox-type="iframe" rel="timeline"><img src="assets/images/play.png" alt=""></a></span>'
                        video_str += '<span class="gallery-play-btn"><img src="assets/images/play.png" alt=""></span>'
                        $('#timeline_details .timeline_media').html(video_str);
                    }
                    if (timeline_data.details != null && timeline_data.details != '') {
                        $('#timeline_details .timeline_details').parent().parent().show();
                        $('#timeline_details .timeline_details').html(timeline_data.details);
                    }
                } else {
                    showErrorMSg(data.error);
                }
            }
        });
    });
    /* For displaying more timeline on view more click */
    $(document).on('click', ".view_more_timeline", function () {
        var limit = $('.timeline_ul li').length;
        loaTimeline(limit);
    });
    /* For loading more post on scroll event */
    function loaTimeline(limitStart) {
        $.ajax({
            url: site_url + 'profile/load_timeline/' + limitStart + '/' + profile_id,
            type: "post",
            dataType: "json",
            success: function (data) {
                var string = '';
                $.each(data, function (index, value) {
                    total_timeline_count = value['total_count'];
                    string += '<li><div class="lifetime-box"><h3><a href="">';
                    string += value['interval'];
                    string += '</a></h3>';
                    string += '<p>' + value['title'] + '</p>';
                    if (value['timeline_media'] != null && value['media_type'] == 1) {
                        string += '<h6><a href="javascript:void(0)" class="timeline fa fa-image" data-timeline="'+btoa(value.id)+'"></a></h6>';
                    } else if (value['timeline_media'] != null && value['media_type'] == 2) {
                        string += '<h6><a href="javascript:void(0)" class="timeline fa fa-play-circle-o" data-timeline="'+btoa(value.id)+'"></a></h6>';
                    } else {
                        string += '<h6><a href = "" class = "fa fa-circle-o" data-timeline="'+btoa(value.id)+'"></a></h6>';
                    }
                    string += '</div></li>';
                });
                $(".timeline_ul").append(string);
                var limit = $('.timeline_ul li').length;
                if (limit == total_timeline_count) {
                    $('.view_more_timeline').hide();
                }
            }
        });

    }
});

// Display the preview and error of cover image  */
function readcoverURL(input) {
    var height = 330, width = 1120, img = '', file = '', val = '';
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
//                console.log("gdfkgdf", e);
            var _URL = window.URL || window.webkitURL;
            var valid_extensions = /(\.jpg|\.jpeg|\.png)$/i;
            if (typeof (input.files[0]) != 'undefined') {
                if (valid_extensions.test(input.files[0].name)) {
                    img = new Image();
                    img.onload = function () {
//                        console.log("width", this.width);
//                        console.log("height", this.height);
                        if (this.width < width || this.height < height) {
                            showErrorMSg('Photo should be ' + width + ' X ' + height + ' or more dimensions');
                        } else {
                            var formData = new FormData();
                            formData.append('profile_id', profile_id);
                            formData.append('cover_image', input.files[0], input.files[0].name);
//                                console.log(formData.get('cover_image'));
                            $.ajax({
                                url: site_url + "profile/upload_cover_image",
                                type: "POST",
                                data: formData,
                                dataType: "json",
                                processData: false, // tell jQuery not to process the data
                                contentType: false, // tell jQuery not to set contentType
                                success: function (data) {
                                    if (data.success == true) {
                                        //-- Remove default preview div
                                        $('.cover_img').attr('src', data.url);
                                        var reader = new FileReader();
                                        reader.readAsDataURL(input.files[0]);
                                        showSuccessMSg(data.data);
                                    } else {
                                        showErrorMSg(data.error);
                                    }
                                }
                            });
                        }
                    };
                    img.src = _URL.createObjectURL(input.files[0]);
                } else {
                    showErrorMSg(input.files[0].name + " is not a valid image file.");
                }
            } else {
                showErrorMSg("This browser does not support HTML5 FileReader.");
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Display the preview of image on post image upload
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
//-- Gallery step
var image_count = 0, video_count = 0;
$(".post_gallery_upload").change(function () {
    var dvPreview = $(".comoon-ul-li ul");
    var selected_type = $(this).data('type');
    if (typeof (FileReader) != "undefined") {
        $($(this)[0].files).each(function (index) {
            var file = $(this);
            str = '';
            if (selected_type == 'image') {
                if (regex_img.test(file[0].name.toLowerCase())) {
                    //-- check image and video count
                    if (image_count <= max_images_count) {
                        // upload image

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            post_data.push(file[0]);
                            var index = post_data.length - 1;
                            post_data[index]['index'] = index;
                            post_data[index]['media_type'] = 1;
                            str = '<li><div class="gallery-wrap"><span class="gallery-video-img">';
                            str += '<img src="' + e.target.result + '" />';
                            str += '</span><a href="javascript:void(0)" class="remove-video" onclick="delete_media(this,1, ' + index + ')">';
                            str += delete_str;
                            str += '</a></div></li>';
                            dvPreview.append(str);
                        }
                        reader.readAsDataURL(file[0]);
                    } else {
                        showErrorMSg("Limit is exceeded to upload images");
                    }
                    image_count++;

                } else {
                    showErrorMSg(file[0].name + " is not a valid image file.");
                }
            } else if (selected_type == 'video') {
                if (regex_video.test(file[0].name.toLowerCase())) {
//                console.log(video_count);
                    if (video_count <= max_videos_count) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            post_data.push(file[0]);
                            var index = post_data.length - 1;
                            post_data[index]['index'] = index;
                            post_data[index]['media_type'] = 2;
                            str = '<li><div class="gallery-wrap"><span class="gallery-video-img">';
                            str += '<video style="width:100%;height:100%" controls><source src="' + URL.createObjectURL(file[0]) + '">Your browser does not support HTML5 video.</video>';
                            str += '</span>'
                            str += '<span class="gallery-play-btn"><a href=""><img src="assets/images/play.png" alt=""></a></span>';
                            str += '<a href="javascript:void(0)" class="remove-video" onclick="delete_media(this,2, ' + index + ')">';
                            str += delete_str;
                            str += '</a></div></li>';
                            dvPreview.append(str);
                        }
                        reader.readAsDataURL(file[0]);
                    } else {
                        showErrorMSg("Limit is exceeded to upload videos");
                    }
                    video_count++;
                } else {
                    showErrorMSg(file[0].name + " is not a valid video file.");
                }
            } else {
                showErrorMSg(file[0].name + " is not a valid image/video file.");
            }
        });
    } else {
        showErrorMSg("This browser does not support HTML5 FileReader.");
    }
});

function delete_media(obj, data, index) {
    $(post_data).each(function (key) {
        if (typeof (post_data[key]) != 'undefined' && post_data[key]['index'] == index) {
            delete post_data[key];
        }
    });
    if (data == 1) {
        image_count--; //increase max images count if deleted media is image
    } else {
        video_count--; //increase max videos count if deleted media is video
    }
    $(obj).parent('.gallery-wrap').parent('li').remove();

}