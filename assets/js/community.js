// Question listing and question detail page
$(function () {
    //-- Question listing page --//

    //Add question button click event
    $('#que_btn').click(function () {
        $('.a_toggle').hide();
        $('.a_toggle').addClass('hideqdiv');
        $('#add_question_div').show();
    });

    //Close question button click
    $(document).on('click', '#close_que_btn', function () {
        $('#add_question_div').hide();
        $('#question_slug').val('');
        $('#que_label').html('Add Your Question<a href="javascript:void(0)" id="close_que_btn"><i class="fa fa-times" aria-hidden="true"></i></a>');
        $('.a_toggle').removeClass('hideqdiv');
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
            text: "You want to delete this profile",
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
        if ($('#add_answer_form').valid()) {
            var answerformData = new FormData(document.getElementById("add_answer_form"));
            answerformData.append('slug', $(this).data('question'));
            $.ajax({
                url: site_url + "community/add_answers",
                type: "POST",
                data: answerformData,
                dataType: "json",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
                    if (data.success == true) {
                        //-- Remove default preview div
                        window.location.href = current_url;
                    } else {
                        showErrorMSg(data.error);
                    }
                }
            });
            return false;
        }
        console.log("emflm in out");
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