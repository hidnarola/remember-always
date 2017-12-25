<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title"><?php echo isset($title) ? $title : 'Affiliation' ?></h2>
            <a href="<?php echo site_url('affiliation/add') ?>" class="pspl">Add Affiliation</a>
        </div>
        <div class="common-body">
            <div class="services-form funeral-srh">
                <form method="get" name="affiliation_form" id="affiliation_form">
                    <div class="srvs-form-div">
                        <select name="category" id="category" class="selectpicker">
                            <option value="">-- Select Category --</option>
                            <?php
                            if (isset($affiliation_categories) && !empty($affiliation_categories)) {
                                foreach ($affiliation_categories as $key => $value) {
                                    $selected = '';
                                    if (isset($_GET['category']) && $_GET['category'] == $value['name']) {
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option <?php echo $selected; ?> value="<?php echo $value['name'] ?>"><?php echo $value['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="srvs-form-div">
                        <input type="text" name="keyword" id="keyword" placeholder="Enter Keyword" class="input-css" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : set_value('keyword') ?>"/>
                    </div>
                    <div class="srvs-form-div">	
                        <button type="button"  id="provider_srch_btn" class="next" disabled>Search</button>
                    </div>	
                </form>
            </div>
            <div class="services-pro-l">
                <div class="profile-box services-listings" >
                    <h2>Affiliations Listing</h2>
                    <div id="affiliation_ul_data" class="affiliation_ul_data">
                        <ul class="srvs-list-ul affiliation_content" >
                            <?php
                            if (isset($affiliations) && !empty($affiliations)) {
                                foreach ($affiliations as $key => $value) {
                                    ?>
                                    <li>
                                        <span> 
                                            <?php
                                            if (isset($value['image']) && !is_null($value['image'])) {
                                                ?>
                                                <img src="<?php echo AFFILIATION_IMAGE . $value['image'] ?>" width="100%" height="100%"/>
                                            <?php }else{ ?>
                                                <img src="assets/images/no_image.png" width="100%" height="100%"/>
                                            <?php } ?>
                                        </span>
                                        <h3><a href="<?php echo site_url('affiliation/view/' . $value['slug']) ?>"><?php echo $value['name'] ?></a></h3>
                                        <p><?php
                                            $text = $value['description'];
                                            if (strlen($value['description']) > 500) {
                                                $text = preg_replace("/^(.{1,500})(\s.*|$)/s", '\\1...', $value['description']);
                                                echo $text;
                                            } else {
                                                echo $text;
                                            }
                                            ?></p>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <p class="no-data">No affiliations available</p>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="services-pro-r">
                <div class="profile-box services-ctgr affiliations">
                    <h2>Affiliation Categories</h2>
                    <div class="profile-box-body">
                        <ul>
                            <?php if (isset($affiliation_categories) && !empty($affiliation_categories)) { ?>
                                <li><a href="<?php echo site_url('affiliation') ?>" class="<?php echo!isset($_GET['category']) ? 'active' : '' ?>">All Affiliations</a></li>
                                <?php foreach ($affiliation_categories as $key => $value) {
                                    ?>
                                    <li><a href="javascript:void(0)" data-value="<?php echo $value['name'] ?>"class="category_click <?php echo isset($_GET['category']) && $_GET['category'] == $value['name'] ? 'active' : '' ?>"><?php echo $value['name'] ?></a></li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li><p class="no-data">No Affiliation Categories available.</p></li>
                            <?php } ?>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="services-pro-m">
                <div class="profile-box ad">
                    <a href=""><img src="assets/images/ad.jpg" alt=""></a>
                </div>
                <div class="profile-box ad">
                    <a href=""><img src="assets/images/ad.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var srch_data = '<?php echo isset($_SERVER['REDIRECT_QUERY_STRING']) ? '?' . $_SERVER['REDIRECT_QUERY_STRING'] : '' ?>';
    $('.loader').hide();
    var affiliation_image = '<?php echo AFFILIATION_IMAGE ?>';
    var affiliation_url = '<?php echo site_url('affiliation/view/') ?>';
    $('#category').selectpicker({
        liveSearch: true,
        size: 5
    });
    $("#affiliation_ul_data").mCustomScrollbar({
        axis: "y",
        scrollButtons: {enable: true},
        theme: "3d",
        callbacks: {
            onTotalScroll: function () {
                if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                    var limitStart = $(".affiliation_content li").length;
//                     $(".loader").show();
                    loadResults(limitStart);
                }
            },
        },
        advanced: {

            updateOnBrowserResize: true, /*update scrollbars on browser resize (for layouts based on percentages): boolean*/

            updateOnContentResize: true, /*auto-update scrollbars on content resize (for dynamic content): boolean*/

            autoExpandHorizontalScroll: true, /*auto-expand width for horizontal scrolling: boolean*/

            autoScrollOnFocus: true /*auto-scroll on focused elements: boolean*/

        },
    });
    $(document).on('click', '.category_click', function () {
        submit_form($(this).data('value'));
    });
    $(document).on('keyup paste', 'input[type="text"]', function () {
        if ($(this).val() != '') {
            $('#provider_srch_btn').removeAttr('disabled');
        }
    });
    $(document).on('change', 'select', function () {
        if ($(this).val() != '') {
            $('#provider_srch_btn').removeAttr('disabled');
        }
    });
    $(document).on('click', '#provider_srch_btn', function () {
        submit_form($('#category').val());
    });
    function submit_form(category) {
        var keyword = $('#keyword').val();
        if (location == '' && keyword == '' && category == '') {
            window.location.href = site_url + 'affiliation';
        } else if (location == '' && keyword == '' && category != '') {
            window.location.href = site_url + 'affiliation?category=' + category;
        } else {
            var url = '';
            if (category != '') {
                if (url != '')
                    url += '&category=' + category;
                else
                    url += '?category=' + category;
            }
            if (keyword != '') {
                if (url != '')
                    url += '&keyword=' + keyword;
                else
                    url += '?keyword=' + keyword;
            }
            window.location.href = site_url + 'affiliation' + url;
        }
        return false;
    }

    function loadResults(limitStart) {
        $.ajax({
            url: '<?php echo site_url() ?>' + 'affiliation/load_affiliations/' + limitStart + srch_data,
            type: "get",
            dataType: "json",
            success: function (data) {
                var string = '';
                $.each(data, function (index, value) {
                    string += '<li>' +
                            '<span>';
                    if (typeof value['image'] != 'undefined' && value['image'] != null) {
                        string += '<img src="' + affiliation_image + value['image'] + '" width="100%" height="100%" />';
                    }
                    string += '</span>' +
                            '<h3><a href="' + affiliation_url + value['slug'] + '">' + value['name'] + '</a></h3>' +
                            '<p>';
                    text = value['description'];
                    if (value['description'].length > 500) {
//                        text = value['description'].preg_replace("/^(.{1,500})(\s.*|$)/s", '\\1...');
                        text = value['description'].substring(0, 500);
                        text += '...';
                    }
                    string += text;
                    string += '</p>';
                });
                $(".affiliation_content").append(string);
            }
        });
    }
</script>
