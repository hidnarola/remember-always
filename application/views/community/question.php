<style type="text/css">.input-css.error{border:1px solid red;}</style>
<div class="common-page common_questionnaire">
    <div class="container">
        <div class="main_post_question">
            <div class="user_left_q">
                <div class="white_bg">
                    <div class="comments-div first_q">
                        <ul>
                            <li>
                                <div class="comments-div-wrap">
                                    <span class="commmnet-postted-img">
                                        <?php
                                        if (isset($question['profile_image']) && !is_null($question['profile_image'])) {
                                            if (is_null($question['facebook_id']) && is_null($question['google_id'])) {
                                                ?>
                                                <a class="fancybox" href="<?php echo base_url(USER_IMAGES . $question['profile_image']); ?>" data-fancybox-group="gallery" ><img src="<?php echo base_url(USER_IMAGES . $question['profile_image']); ?>" class="img-responsive content-group" width="100px" height="100px" alt=""></a>
                                            <?php } else { ?>
                                                <a class="fancybox" href="<?php echo $question['profile_image']; ?>" data-fancybox-group="gallery" ><img src="<?php echo $question['profile_image']; ?>" class="img-responsive content-group" width="100px" height="100px" alt=""></a>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </span>
                                    <h3 class="main_q"><?php echo isset($question) ? $question['title'] : '-' ?>
                                        <small>
                                            Asked By: <?php echo $question['firstname'] . ' ' . $question['lastname'] ?>  
                                            <?php
                                            $from_date = date_create($question['created_at']);
                                            $to_date = date_create(date('Y-m-d H:i:s'));
                                            $days_diff = date_diff($from_date, $to_date);
                                            echo format_days($days_diff);
                                            ?> Ago
                                        </small>
                                    </h3>
                                    <p><?php echo isset($question) ? $question['description'] : '-' ?></p>
                                    <div class="btn_continue"><a href="javascript:void(0)" id="answer">Answer It</a></div>
                                    <div class="post_text" style="display:none;">
                                        <form id="add_answer_form" method="post">
                                            <textarea name="description" class="input-css" id="description" placeholder="Add Answer"></textarea>
                                            <a href="javascript:void(0)" id="add_answer" data-question="<?php echo $question['slug'] ?>">Post</a>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <ul class="social_ic">
                        <li class="fb_i"><a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo $url; ?>')" title="Facebook Share"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li class="pi_i"><a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo isset($question['title']) && !is_null($question['title']) ? $question['title'] : 'Question Sharing'; ?>')" title="Linked-in Share"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <li class="tw_i"><a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://twitter.com/share?url=<?php echo $url; ?>')" title="Twitter Share"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li class="gp_i"><a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://plus.google.com/share?url=<?php echo $url; ?>')" title="Google Plus Share"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
                <div class="white_bg top_m">
                    <h2 class="head_q blue">Other Answer<span>(2)</span></h2>
                    <div class="comments-div first_q best_q other_q">
                        <ul>
                            <li>
                                <div class="comments-div-wrap">
                                    <span class="commmnet-postted-img"></span>
                                    <h3>Sheets containing and recently<small>20min Ago</small></h3>
                                    <p>Was popularised the release sheets containing more recently desktop publishing software a aldus pop pageMaker including.</p>
                                    <div class="comment_tag clicked"><i class="fa fa-comment-o" aria-hidden="true"></i>2 Comment</div>
                                    <div class="inner_cooment_div">
                                        <div class="comments-div">
                                            <ul>
                                                <li>
                                                    <div class="comments-div-wrap">
                                                        <span class="commmnet-postted-img"></span>
                                                        <h3>Sheets containing and recently<small>3month Ago</small></h3>
                                                        <p>Was popularised the release sheets containing more recently desktop publishing software a aldus pop pageMaker including.</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="comments-div-wrap">
                                                        <span class="commmnet-postted-img"></span>
                                                        <h3>Sheets containing and recently<small>3month Ago</small></h3>
                                                        <p>Was popularised the release sheets containing more recently desktop publishing software a aldus pop pageMaker including.</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="post_text">
                                                        <textarea placeholder="Add Comment"></textarea>
                                                        <a href="#">Post</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>	

                                </div>
                            </li>
                            <li>
                                <div class="comments-div-wrap">
                                    <span class="commmnet-postted-img"></span>
                                    <h3>Sheets containing and recently<small>20min Ago</small></h3>
                                    <p>Was popularised the release sheets containing more recently desktop publishing software a aldus pop pageMaker including.</p>
                                    <div class="comment_tag">
                                        <i class="fa fa-comment-o" aria-hidden="true"></i>Add a Comment</div>
                                    <div class="post_text" style="display:none;">
                                        <textarea placeholder="Add Comment"></textarea>
                                        <a href="#">Post</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>	

                </div>
            </div>
            <div class="user_right_q">
                <h2>Recent QUESTIONS</h2>
                <?php if (!empty($recent_questions)) { ?>
                    <ul class="ul_related_q">
                        <?php
                        foreach ($recent_questions as $que) {
                            ?>
                            <li>
                                <div class="related_q">
                                    <h6><a href="<?php echo site_url('community/view/' . $que['slug']) ?>"><?php echo $que['title'] ?>?</a></h6>
                                    <p>Asked by: <span><?php echo $que['firstname'] . ' ' . $que['lastname'] ?></span></p>
                                </div>
                            </li>
                        <?php }
                        ?>
                    </ul>
                    <?php
                } else {
                    echo '<p class="no-data text-left">We have no recent questions!</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    var current_url = '<?php echo isset($url) ? $url : '' ?>';
</script>
<script src="assets/js/community.js"></script>