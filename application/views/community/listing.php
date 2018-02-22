<style type="text/css">.input-css.error{border:1px solid red;}</style>
<div class="common-page common_questionnaire">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title">Support Community</h2>
        </div>
        <div class="common-body">
            <div class="main_post_question">
                <div class="user_left_q">
                    <form id="post_que_form" action="<?php echo site_url('community/post_question') ?>" method="post">
                        <div class="white_bg top_m add_an add_q_section" id="add_question_div" style="display:none;">
                            <h2 class="head_q blue" id="que_label">Add Your Question<a href="javascript:void(0)" id="close_que_btn"><i class="fa fa-times" aria-hidden="true"></i></a></h2>
                            <div class="input-wrap">
                                <input type="text" class="input-css" name="que_title" id="que_title" placeholder="Enter title of question"/>
                            </div>
                            <div class="input-wrap">
                                <textarea class="input-css textarea-css" name="que_description" id="que_description" placeholder="Describe your question"></textarea>
                            </div>
                            <input type="hidden" name="question_slug" id="question_slug" value=""/>
                            <div class="an_btn">
                                <a href="javascript:void(0)" class="post_que_btn"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Post</a>
                            </div>
                        </div>
                    </form>
                    <div class="toggle_btn">
                        <?php if ($this->is_user_loggedin) { ?>
                            <a href="javascript:void(0)" class="a_toggle" id="que_btn"><i class="fa fa-question" aria-hidden="true"></i>Add Your Question</a>
                        <?php } else { ?>
                            <a href="javascript:void(0)" class="a_toggle" onclick="loginModal(this)" data-redirect="<?php echo site_url('community') ?>"><i class="fa fa-question" aria-hidden="true"></i>Add Your Question</a>
                        <?php } ?>
                        <div class="search community_search_div <?php if ($this->input->get('keyword') != '') echo "open" ?>">
                            <a href="javascript:void(0)" onclick="viewCommunitySearch()" class="header_search">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129" class="header_search">
                                    <g>
                                        <path d="M51.6,96.7c11,0,21-3.9,28.8-10.5l35,35c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2c1.6-1.6,1.6-4.2,0-5.8l-35-35   c6.5-7.8,10.5-17.9,10.5-28.8c0-24.9-20.2-45.1-45.1-45.1C26.8,6.5,6.5,26.8,6.5,51.6C6.5,76.5,26.8,96.7,51.6,96.7z M51.6,14.7   c20.4,0,36.9,16.6,36.9,36.9C88.5,72,72,88.5,51.6,88.5c-20.4,0-36.9-16.6-36.9-36.9C14.7,31.3,31.3,14.7,51.6,14.7z"></path>
                                    </g>
                                </svg>
                            </a>
                            <form action="<?php echo site_url('community') ?>" id="community_search_form">
                                <input type="text" name="keyword" id="community_search" class="global_search" placeholder="Search..." value="<?php echo $this->input->get('keyword') ?>"/>
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
                    <?php if ($this->input->get('keyword') != '') echo '<h3>Search result for "' . $this->input->get('keyword') . '"</h3>'; ?>
                    <?php foreach ($questions as $question) { ?>
                        <div class="white_bg question_section">
                            <div class="comments-div first_q best_q other_q">
                                <ul>
                                    <li>
                                        <div class="comments-div-wrap">
                                            <span class="commmnet-postted-img">
                                                <?php
                                                if (isset($question['profile_image']) && !is_null($question['profile_image'])) {
                                                    if (is_null($question['facebook_id']) && is_null($question['google_id'])) {
                                                        ?>
                                                        <a class="fancybox" href="<?php echo base_url(USER_IMAGES . $question['profile_image']); ?>" data-fancybox-group="gallery" ><img src="<?php echo base_url(USER_IMAGES . $question['profile_image']); ?>" class="img-responsive content-group" alt=""></a>
                                                    <?php } else { ?>
                                                        <a class="fancybox" href="<?php echo $question['profile_image']; ?>" data-fancybox-group="gallery" ><img src="<?php echo $question['profile_image']; ?>" class="img-responsive content-group" alt=""></a>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </span>
                                            <?php
                                            $from_date = date_create($question['created_at']);
                                            $to_date = date_create(date('Y-m-d H:i:s'));
                                            $days_diff = date_diff($from_date, $to_date);
                                            ?>
                                            <h3 class="main_q">
                                                <a href="<?php echo site_url('community/view/' . $question['slug']) ?>"><?php echo $question['title'] ?></a>
                                                <small>
                                                    <?php
                                                    $format = format_days($days_diff);
                                                    echo $format;
                                                    if ($format != 'Just Now')
                                                        echo ' ago';
                                                    ?>
                                                </small>
                                            </h3>
                                            <p><?php echo $question['description'] ?></p>
                                            <div class="comment_tag cl_black">
                                                <span class="que_author"><?php echo "By : " . $question['firstname'] . ' ' . $question['lastname'] ?></span>
                                                <span class="spn_comment question_answers" data-question="<?php echo $question['id'] ?>"><i class="fa fa-comment-o" aria-hidden="true"></i><?php echo $question['answers'] ?> Answer<?php if ($question['answers'] > 1) echo "s"; ?></span>
                                            </div>
                                            <div class="inner_cooment_div" id="comment_<?php echo $question['id'] ?>" style="display: none"></div>
                                            <?php if ($question['user_id'] == $this->user_id && $question['answers'] == 0) { ?>
                                                <div class="user-update community-action-btn">
                                                    <a class="edit edit_que_btn" data-slug="<?php echo $question['slug'] ?>" href="javascript:void(0)">Edit</a>
                                                    <a class="delete delete_que_btn" data-slug="<?php echo $question['slug'] ?>" href="javascript:void(0)">Delete</a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php if (!empty($links)) { ?>
                        <div class="community_pagination">
                            <div class="paggination-wrap">
                                <?php echo $links ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="user_right_q">
                    <script type="text/javascript">
                        clicksor_mobile_redirect = false;
//default banner house ad url 
                        clicksor_default_url = '';
                        clicksor_banner_border = '#805066';
                        clicksor_banner_ad_bg = '#FFFFFF';
                        clicksor_banner_link_color = '#000000';
                        clicksor_banner_text_color = '#666666';
                        clicksor_banner_image_banner = true;
                        clicksor_banner_text_banner = true;
                        clicksor_layer_border_color = '#805066';
                        clicksor_layer_ad_bg = '#FFFFFF';
                        clicksor_layer_ad_link_color = '#000000';
                        clicksor_layer_ad_text_color = '#666666';
                        clicksor_text_link_bg = '';
                        clicksor_text_link_color = '';
                        clicksor_enable_text_link = false;
                        clicksor_layer_banner = false;
                    </script>
                    <script type="text/javascript" src="https://b.clicksor.net/show.php?nid=1&amp;pid=389555&amp;adtype=7&amp;sid=652028"></script>
                    <!--<div class="profile-box ad"></div>-->
                    <br/><br/>
                    <script type="text/javascript">
                        clicksor_mobile_redirect = false;
//default banner house ad url 
                        clicksor_default_url = '';
                        clicksor_banner_border = '#805066';
                        clicksor_banner_ad_bg = '#FFFFFF';
                        clicksor_banner_link_color = '#000000';
                        clicksor_banner_text_color = '#666666';
                        clicksor_banner_image_banner = true;
                        clicksor_banner_text_banner = true;
                        clicksor_layer_border_color = '#805066';
                        clicksor_layer_ad_bg = '#FFFFFF';
                        clicksor_layer_ad_link_color = '#000000';
                        clicksor_layer_ad_text_color = '#666666';
                        clicksor_text_link_bg = '';
                        clicksor_text_link_color = '';
                        clicksor_enable_text_link = false;
                        clicksor_layer_banner = false;
                    </script>
                    <script type="text/javascript" src="https://b.clicksor.net/show.php?nid=1&amp;pid=389555&amp;adtype=7&amp;sid=652028"></script>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$loggend_in = 0;
if ($this->is_user_loggedin) {
    $loggend_in = 1;
}
?>
<script type="text/javascript">
                        var current_url = '<?php echo isset($url) ? $url : '' ?>';
                        var user_image = '<?php echo base_url(USER_IMAGES) ?>';
                        var logged_in = <?php echo $loggend_in ?>;
                        var cur_year = '<?php echo date('Y') ?>';
                        var cur_month = '<?php echo date('m') ?>';
                        var cur_day = '<?php echo date('d') ?>';
                        var cur_hour = '<?php echo date('H') ?>';
                        var cur_min = '<?php echo date('i') ?>';
                        var cur_s = '<?php echo date('s') ?>';
</script>
<script src="assets/js/community.js"></script>