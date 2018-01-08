$(function () {
    $(document).on('click', '#answer', function () {
        $('.post_text').toggle();
    });

    $('#add_answer_form').validate({
        rules: {
            'description': {
                'required': true
            }
        },
        errorPlacement: function (error, element) {
            return false;  // suppresses error message text
        }
    });
    $(document).on('click', '#add_answer', function () {
        if ($('#add_answer_form').valid()) {
            var answerformData = new FormData(document.getElementById("add_answer_form"));
            answerformData.append('slug', $(this).data('question'));
            $.ajax({
                url: site_url + "questions/add_answers",
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
});