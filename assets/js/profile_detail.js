var regex_img = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
var regex_video = /^([a-zA-Z0-9\s_\\.\-:])+(.mp4)$/;
post_data = [];
var postformData = new FormData();
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
        theme: "3d"
    });
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
            "image_post[]": {
                atleast_one_for_post: true,
            },
            "video_post[]": {
                atleast_one_for_post: true,
            },
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
            "image_post[]": {
                atleast_one_for_post: '',
            },
            "video_post[]": {
                atleast_one_for_post: '',
            },
        },
        submitHandler: function (form) {

            postformData.append('comment', $('#comment').val());
            $(post_data).each(function (key) {
                if (post_data[key] != null) {
                console.log(post_data[key]);
                   postformData.append('post_upload[]', post_data[key], post_data[key].name);
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
                    console.log("sdfksjf");
//                    if (data.success == true) {
//                        //-- Remove default preview div
////                                $('#default-preview').remove();
//
//                    } else {
//                        console.log("sdkndff");
//                        showErrorMSg(data.error);
//                    }
                }
            });

//            $('#post_data').val(JSON.stringify(post_data));
            return false;
//            form.submit();
        },
    });
    /* For changing background or cover image */
    $(document).on('change', "#cover_image", function () {
        readcoverURL(this);
    });
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
                        console.log("width", this.width);
                        console.log("height", this.height);
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
    if (typeof (FileReader) != "undefined") {
        $($(this)[0].files).each(function (index) {
            var file = $(this);
            str = '';
            if (regex_img.test(file[0].name.toLowerCase())) {
                //-- check image and video count
                if (image_count <= max_images_count) {
                    // upload image
//                    var formData = new FormData();
//                    formData.append('profile_id', profile_id);
//                    formData.append('post_id', post_id);
//                    formData.append('type', 'image');

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
//                    console.log("image", formData.get('post_upload'));
//                    $.ajax({
//                        url: site_url + "profile/upload_post",
//                        type: "POST",
//                        data: formData,
//                        dataType: "json",
//                        processData: false, // tell jQuery not to process the data
//                        contentType: false, // tell jQuery not to set contentType
//                        success: function (data) {
//                            console.log(data);
//                            if (data.success == true) {
//                                //-- Remove default preview div
////                                $('#default-preview').remove();
//                                
//                            } else {
//                                console.log("sdkndff");
//                                showErrorMSg(data.error);
//                            }
//                        }
//                    });
                } else {
                    showErrorMSg("Limit is exceeded to upload images");
                }
                image_count++;

            } else if (regex_video.test(file[0].name.toLowerCase())) {
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
//                    // upload video
//                    var videoData = new FormData();
//                    videoData.append('profile_id', profile_id);
//                    videoData.append('post_id', post_id);
//                    videoData.append('type', 'video');
//                    videoData.append('post_upload', file[0], file[0].name);
//                    console.log("video", post_id);
//                    $.ajax({
//                        url: site_url + "profile/upload_post",
//                        type: "POST",
//                        data: videoData,
//                        dataType: "json",
//                        processData: false, // tell jQuery not to process the data
//                        contentType: false, // tell jQuery not to set contentType
//                        success: function (data) {
//                            if (data.success == true) {
////                                $('#default-preview').remove();
//
//                                str = '<li><div class="gallery-wrap"><span class="gallery-video-img">';
//                                str += '<video style="width:100%;height:100%" controls><source src="' + URL.createObjectURL(file[0]) + '">Your browser does not support HTML5 video.</video>';
//                                str += '</span>'
//                                str += '<span class="gallery-play-btn"><a href=""><img src="assets/images/play.png" alt=""></a></span>';
//                                str += '<a href="javascript:void(0)" class="remove-video" onclick="delete_media(this,\'' + 'video_' + index + '\')">';
//                                str += delete_str;
//                                str += '</a></div></li>';
//                                dvPreview.append(str);
//
//                            } else {
//                                showErrorMSg(data.error);
//                            }
//                        }
//                    });

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

function delete_media(obj, data, index) {
//    $.ajax({
//        url: site_url + "profile/delete_gallery",
//        type: "POST",
//        data: {'gallery': data},
//        dataType: "json",
//        success: function (data) {
    $(post_data).each(function (key) {
        if (typeof (post_data[key]) != 'undefined' && post_data[key]['index'] == index) {
            delete post_data[key];
        }
    });
//            if (data.success == true) {
    if (data == 1) {
        image_count--; //increase max images count if deleted media is image
    } else {
        video_count--; //increase max videos count if deleted media is video
    }
    $(obj).parent('.gallery-wrap').parent('li').remove();

//            } else {
//                showErrorMSg(data.error);
//            }
//        }
//    });
}