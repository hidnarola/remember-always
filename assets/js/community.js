// Question listing and question detail page
$(function () {
    //-- Question listing page --//

    //Add question button click event
    $('#que_btn').click(function () {
        $('.a_toggle').hide();
        $('.a_toggle').parent('.toggle_btn').addClass('hideqdiv');
        $('#add_question_div').show();
    });

    //Close question button click
    $(document).on('click', '#close_que_btn', function () {
        $('#add_question_div').hide();
        $('#question_slug').val('');
        $('#que_label').html('Add Your Question<a href="javascript:void(0)" id="close_que_btn"><i class="fa fa-times" aria-hidden="true"></i></a>');
        $('.a_toggle').parent('.toggle_btn').removeClass('hideqdiv');
        $('.a_toggle').show();
        $('#que_title').rules('add', {
            remote: site_url + 'community/check_question/',
            messages: {
                remote: "Question already exist!",
            }
        });
    });

    //Edit que button click event
    $('.edit_que_btn').click(function () {
        que_slug = $(this).attr('data-slug');
        $('.loader').show();

        $.ajax({
            url: site_url + "community/get_question",
            type: "POST",
            data: {slug: que_slug},
            dataType: "json",
            success: function (data) {
                $('.loader').hide();
                if (data.success == true) {
                    //-- Scroll to top of profile div section 
                    $('html, body').animate({
                        'scrollTop': 0
                    }, 1000);
                    $('.a_toggle').hide();
                    $('.a_toggle').addClass('hideqdiv');
                    $('#add_question_div').show();

                    $('#que_title').rules('add', {
                        remote: site_url + 'community/check_question/' + data.question.slug,
                        messages: {
                            remote: "Question already exist!",
                        }
                    });

                    $('#que_label').html('Edit Your Question<a href="javascript:void(0)" id="close_que_btn"><i class="fa fa-times" aria-hidden="true"></i></a>');
                    $('#que_title').val(data.question.title);
                    $('#que_description').val(data.question.description);
                    $('#question_slug').val(data.question.slug);
                    $('#que_title').focus();
                } else {
                    showErrorMSg(data.error);
                }
            }
        });
    });

    //Validate post question 
    $('#post_que_form').validate({
        rules: {
            que_title: {
                required: true,
                minlength: 5,
                remote: site_url + 'community/check_question',
            },
            que_description: {
                required: true,
                minlength: 10
            }
        },
        messages: {
            que_title: {
                remote: "Question already exist!",
            }
        }
//        errorPlacement: function (error, element) {
//            return false;  // suppresses error message text
//        }
    });

    $('.post_que_btn').click(function () {
        obj = $(this);
        if ($('#post_que_form').valid()) {
            obj.removeClass('post_que_btn');
            $('#post_que_form').submit();
        }
    });
    $('.delete_que_btn').click(function () {
        slug = $(this).attr('data-slug');
        swal({
            title: "Are you sure?",
            text: "You want to delete this Question",
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
                window.location.href = site_url + 'community/delete_question/' + slug;
                return true;
            }
        });
    });


    //-- Question detail page--//
    $(document).on('click', '#answer', function () {
        $('.post_text').toggle();
    });


    $('#add_answer_form').validate({
        rules: {
            description: {
                required: true,
                minlength: 5
            }
        },
        /* errorPlacement: function (error, element) {
         return false;  // suppresses error message text
         }*/
    });
    $(document).on('click', '#add_answer', function () {
        obj = $(this);
        if ($('#add_answer_form').valid()) {
            $(obj).removeAttr('add_answer');
            $('#add_answer_form').submit();
        }
    });
    //-- On comment box click event
    $(document).on('click', '.answer_comments', function () {
        obj = $(this);
        answer = obj.attr('data-answer');
        if (!$(this).hasClass('clicked')) {
            obj.addClass('clicked');
            show_comments(answer);
        } else {
            $('#comment_' + answer).hide();
            obj.removeClass('clicked');
        }

    });
    //-- Post comment to particular answers
    $(document).on('click', '.post_comment', function () {
        if (logged_in == 1) {
            obj = $(this);
            answer = obj.attr('data-answer');
            console.log('id is ','comment_' + answer);
            comment = $('#comment_text_' + answer).val();
            console.log('coomment values is ', comment);
            if ($('#comment_form_' + answer).valid()) {
                $.ajax({
                    url: site_url + "community/post_comment",
                    type: "POST",
                    data: {answer: answer, comment: comment},
                    dataType: "json",
                    async: false,
                    success: function (data) {
                        $('.loader').hide();
                        if (data.success == true) {
                            show_comments(answer);
                        } else {
                            showErrorMSg(data.error);
                        }
                    }
                });
            }
        } else {
            // if not logged in then display login modal
            $('#login-form').attr('action', site_url + 'login?redirect=' + btoa(current_url));
            $('#login').modal();
            $('.nav-tabs a[href="#log-in"]').tab('show');
        }
    });
    $(".fancybox")
            .fancybox({
                openEffect: 'none',
                closeEffect: 'none',
                nextEffect: 'none',
                prevEffect: 'none',
                padding: 0,
            });

});
function show_comments(answer) {
    $('.loader').show();
    $.ajax({
        url: site_url + "community/get_comments",
        type: "POST",
        data: {answer: answer},
        dataType: "json",
        async: false,
        success: function (data) {
            $('.loader').hide();
            if (data.success == true) {
                total_comments = data.comments.length;
                obj.html('<i class="fa fa-comment-o" aria-hidden="true"></i>' + total_comments + ' Comment');
                str = '';
                comment_str = '<li>';
                comment_str += '<form method="post" id="comment_form_' + answer + '">';
                comment_str += '<div class="post_text">';
                comment_str += '<textarea placeholder="Add Comment" name="comment" id="comment_' + answer + '" required="required"></textarea>';
                comment_str += '<a href="javascript:void(0)" class="post_comment" data-answer="' + answer + '">Post</a>';
                comment_str += '</div>';
                comment_str += '</form>';
                comment_str += '</li>';
                str += '<div class="comments-div">';
                str += '<ul>';
                $.each(data.comments, function (index, value) {
                    str += '<li>';
                    str += '<div class="comments-div-wrap">';
                    str += '<span class="commmnet-postted-img">';
                    if (value.profile_image != '') {
                        if (value.facebook_id != '' || value.google_id != '') {
                            str += '<a class="fancybox" href="' + value.profile_image + '" data-fancybox-group="gallery" ><img src="' + value.profile_image + '" class="img-responsive content-group" alt=""></a>';
                        } else {
                            str += '<a class="fancybox" href="' + user_image + value.profile_image + '" data-fancybox-group="gallery" ><img src="' + user_image + value.profile_image + '" class="img-responsive content-group" alt=""></a>';
                        }
                    }
                    str += '</span>';
                    str += '<h3>' + value.firstname + ' ' + value.lastname + '<small>' + value.created_at + '</small></h3>';
                    str += '<p>' + value.answer + '</p>'
                    str += '</div>';
                    str += '</li>';
                });
                str += comment_str;
                str += '</ul>';
                str += '</div>';
                $('#comment_' + answer).html(str);
                $('#comment_' + answer).show();

            } else {
                showErrorMSg(data.error);
            }
        }
    });
}