<div class="common-page common_questionnaire">
    <div class="container">
        <div class="main_post_question">
            <div class="user_left_q">
                <div class="white_bg top_m add_an add_q_section" id="add_question_div" style="display:none;">
                    <h2 class="head_q blue">Add Your Question<a href="javascript:void(0)" id="close_que_btn"><i class="fa fa-times" aria-hidden="true"></i></a></h2>
                    <div class="input-wrap">
                        <textarea class="input-css textarea-css" placeholder="Quod omittam vulputate quo ex."></textarea>
                    </div>
                    <div class="an_btn"><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Post</a></div>
                </div>	
                <div class="toggle_btn">
                    <a href="javascript:void(0)" class="a_toggle" id="que_btn"><i class="fa fa-question" aria-hidden="true"></i>Add Your Question</a>
                    <div class="search community_search_div">
                        <a href="javascript:void(0)" onclick="viewCommunitySearch()" class="header_search">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129" class="header_search">
                                <g>
                                    <path d="M51.6,96.7c11,0,21-3.9,28.8-10.5l35,35c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2c1.6-1.6,1.6-4.2,0-5.8l-35-35   c6.5-7.8,10.5-17.9,10.5-28.8c0-24.9-20.2-45.1-45.1-45.1C26.8,6.5,6.5,26.8,6.5,51.6C6.5,76.5,26.8,96.7,51.6,96.7z M51.6,14.7   c20.4,0,36.9,16.6,36.9,36.9C88.5,72,72,88.5,51.6,88.5c-20.4,0-36.9-16.6-36.9-36.9C14.7,31.3,31.3,14.7,51.6,14.7z"></path>
                                </g>
                            </svg>
                        </a>
                        <form action="<?php echo site_url('community') ?>" id="community_search_form">
                            <input type="text" name="keyword" id="community_search" class="global_search" placeholder="Search..."/>
                            <button type="submit" class="header_search">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129"  class="header_search">
                                    <g>
                                        <path d="M51.6,96.7c11,0,21-3.9,28.8-10.5l35,35c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2c1.6-1.6,1.6-4.2,0-5.8l-35-35   c6.5-7.8,10.5-17.9,10.5-28.8c0-24.9-20.2-45.1-45.1-45.1C26.8,6.5,6.5,26.8,6.5,51.6C6.5,76.5,26.8,96.7,51.6,96.7z M51.6,14.7   c20.4,0,36.9,16.6,36.9,36.9C88.5,72,72,88.5,51.6,88.5c-20.4,0-36.9-16.6-36.9-36.9C14.7,31.3,31.3,14.7,51.6,14.7z"/>
                                    </g>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>	
                <?php foreach ($questions as $question) { ?>
                    <div class="white_bg question_section">
                        <div class="comments-div first_q">
                            <ul>
                                <li>
                                    <div class="comments-div-wrap">
                                        <span class="commmnet-postted-img">
                                            <?php if ($question['profile_image'] != '') { ?>
                                                <img src="<?php echo USER_IMAGES . $question['profile_image'] ?>">
                                                <?php } ?>
                                        </span>
                                        <?php
                                        $from_date = date_create($question['created_at']);
                                        $to_date = date_create(date('Y-m-d H:i:s'));
                                        $days_diff = date_diff($from_date, $to_date);
                                        ?>
                                        <h3 class="main_q"><?php echo $question['title'] ?><?php echo "<small>By:" . $question['firstname'] . ' ' . $question['lastname'] . "</small>"; ?><small><?php echo format_days($days_diff) . ' ago'; ?></small></h3>
                                        <p><?php echo $question['description'] ?></p>
                                    </div>
                                </li>
                            </ul>
                            <div class="comment_tag cl_black"><i class="fa fa-comment-o" aria-hidden="true"></i><?php echo $question['answers'] ?> Answer</div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="paggination-wrap">
                    <?php echo $links ?>
                </div>
            </div>
            <div class="user_right_q">
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
<script type="text/javascript">
    $('#que_btn').click(function () {
        $('.a_toggle').hide();
        $('.a_toggle').addClass('hideqdiv');
        $('#add_question_div').show();
    });
    $('#close_que_btn').click(function () {
        $('#add_question_div').hide();
        $('.a_toggle').removeClass('hideqdiv');
        $('.a_toggle').show();
    });
</script>