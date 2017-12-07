<!-- /theme JS files -->
<div class="create-profile">
    <div class="create-profile-top">
        <div class="container">
            <h2>Create a Life Profile.</h2>
            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur auto edit.</p>
            <a href="javascript:void(0)" onclick="$('#create_profile_form').valid()">Save and Finish Later</a>
        </div>
    </div>
    <div class="create-profile-body">
        <div class="container">
            <div class="create-profile-box">
                <div class="process-step">
                    <ul>
                        <li class="active"><a href="">01</a></li>
                        <li><a href="">02</a></li>
                        <li><a href="">03</a></li>
                        <li><a href="">04</a></li>
                        <li><a href="">05</a></li>
                    </ul>
                    <a href="javascript:void(0)" class="save-draft" onclick="$('#create_profile_form').valid()">Save as draft</a>
                </div>

                <div class="step-form">
                    <form method="post" enctype="multipart/form-data" id="create_profile_form">
                        <div class="step-01-l-wrap">
                            <div class="step-01-l">
                                <div class="upload-btn"> 
                                    <span class="up_btn">Upload Profile Picture</span>
                                    <input type="file" name="profile_image" id="my_doc_upload" multiple="false" onchange="readURL(this);"> 
                                </div>
                            </div>

                            <div class="step-01-m">
                                <div class="input-wrap">
                                    <label class="label-css">Add Profile Details</label>
                                    <div class="input-l">
                                        <input type="text" name="firstname" placeholder="First Name" class="input-css"/>
                                    </div>
                                    <div class="input-r">
                                        <input type="text" name="lastname" placeholder="Last Name" class="input-css"/>
                                    </div>
                                </div>
                                <div class="input-wrap">
                                    <input type="text" name="nickname" placeholder="Nick Name" class="input-css"/>
                                </div>
                                <div class="input-wrap">
                                    <div class="input-l">
                                        <input type="text" name="date_of_birth" placeholder="Date of Birth" class="input-css"/>
                                    </div>
                                    <div class="input-r">
                                        <input type="text" name="date_of_death" placeholder="Dath of Death" class="input-css"/>
                                    </div>
                                </div>
                            </div>
                            <div class="step-01-r">
                                <div class="input-wrap">
                                    <label class="label-css">Create Life Bio</label>
                                    <textarea class="input-css textarea-css" placeholder="Write about Bio... "></textarea>
                                    <label class="label-css">Tips for writing a Life Bio</label>
                                </div>
                            </div>
                        </div>	
                        <div class="step-btm-btn">
                            <button class="back">Back</button>
                            <button class="skip">Skip</button>
                            <button class="next" onclick="$('#create_profile_form').valid()">Next</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>	
</div>
<script type="text/javascript">
    $(function () {
        // Setup validation
        $("#create_profile_form").validate({
            rules: {
                profile_image: {
                    required: true
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
</script>