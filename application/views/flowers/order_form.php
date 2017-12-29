<div class="common-page main-steps">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title title_cart"><?php echo isset($title) ? $title : 'My Cart' ?></h2>
            <?php if (isset($cart_items) && !empty($cart_items)) { ?>
                <div class="process_billing">
                    <div class="process_inner_div process-steps">
                        <ul class="process_inner_div_ul">
                            <li><a href="javascript:void(0);" class="current_active steps-li" id="first-step-li">1</a><span>My Cart</span></li>
                            <li><a href="javascript:void(0);" class="steps-li" id="second-step-li">2</a><span>Delivery Info</span></li>
                            <li><a href="javascript:void(0);" class="steps-li" id="third-step-li">3</a><span>Billing</span></li>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="common-body">
            <div id="first-step" class="flowers-steps">
                <div class="box_cart">
                    <?php if (isset($cart_items) && !empty($cart_items)) { ?>

                        <input type="hidden" name="flower_process" id="flower_process" value="0"/>
                        <?php
                        $price = 0;
                        foreach ($cart_items as $key => $val) {
                            $price = $val->PRICE + $price;
                            ?>
                            <ul class="box_detail_cart">
                                <li><img class="" src="<?php echo $val->SMALL ?>"></li>
                                <li>
                                    <div class="cart_name"><a href="<?php echo site_url('flowers/view') . $val->CODE ?>" class="cart-item-name" style="font-size:20px;"><?php echo $val->NAME ?></a></div>
                                    <button type="button" class="remove_cart" onclick="return remove_cart('<?php echo $val->CODE ?>')">Remove</button>
                                </li>
                                <li>
                                    <div class="price_cart">Price :<span>$<?php echo $val->PRICE ?></span></div>
                                </li>
                            </ul>
                        <?php } ?>
                        <ul class="cart_totle_ul">
    <!--                                <li class=""><div class="totle_sub"><span class="price_type">Subtotal :</span><span class="crt_p">$119.90</span></div></li>
                            <li class=""><div class="totle_sub"><span class="price_type">Delivery Charge :</span><span class="crt_p">$14.99</span></div></li>
                            <li class=""><div class="totle_sub"><span class="price_type">Tax :</span><span class="crt_p">$0.00</span></li>-->
                            <li class=""><div class="totle_sub"><span class="price_type">Total :</span><span class="crt_p">$<?php echo $price; ?></span></div></li>
                        </ul>
                        <div class="comment-btm checkout_btn">
                            <button onclick="return submit_form();">Check Out</button>
                        </div>
                    <?php } else { ?>
                        <p class="no-data">Your cart is empty</p>
                    <?php } ?>
                </div>
            </div>
            <div id="second-step" class="hide flowers-steps">
                <!--<h2 class="title_name_f">French Garden</h2>-->		
                <div class="form_delivery">
                    <form method="post" enctype="multipart/form-data" id="cart_form">
                        <div class="delivery_l">
                            <h2>Deliver To</h2>
                            <div class="input-wrap">
                                <input type="text" name="r_name" placeholder="Name *" class="input-css">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                            <div class="input-wrap">
                                <input type="text" name="r_institute" placeholder="Institution" class="input-css">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                            <div class="input-wrap">
                                <input type="text" name="r_address1" placeholder="Address1 *" class="input-css">
                            </div>
                            <div class="input-wrap">
                                <input type="text" name="r_address2"  placeholder="Address2" class="input-css">
                            </div>
                            <div class="input-wrap">
                                <select name="r_country" id="r_country" class="country selectpicker">
                                    <option value="">-- Select Country --</option>
                                    <?php
                                    if (isset($countries) && !empty($countries)) {
                                        foreach ($countries as $key => $value) {
                                            $selected = '';
                                            if (isset($_POST['country']) && $_POST['country'] == $value['id']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>"  <?php echo $this->input->method() == 'post' ? set_select('country', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-wrap">
                                <select name="r_state" id="r_state" class="state selectpicker">
                                    <option value="">-- Select State --</option>
                                    <?php
                                    if (isset($states) && !empty($states)) {
                                        foreach ($states as $key => $value) {
                                            $selected = '';
                                            if (isset($_POST['state']) && $_POST['state'] == $value['id']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>" <?php echo $this->input->method() == 'post' ? set_select('state', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-wrap">
                                <select name="r_city" id="r_city" class="city selectpicker">
                                    <option value="">-- Select City --</option>
                                    <?php
                                    if (isset($cities) && !empty($cities)) {
                                        foreach ($cities as $key => $value) {
                                            $selected = '';
                                            if (isset($_POST['city']) && $_POST['city'] == $value['id']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo base64_encode($value['id']) ?>"  <?php echo $this->input->method() == 'post' ? set_select('city', base64_encode($value['id']), TRUE) : '' ?> ><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-wrap">
                                <input type="text" name="r_zipcode" id="r_zipcode" placeholder="Zip Code *" class="input-css">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                            <div class="input-wrap input-wrap_small">
                                <input type="text" name="r_phone" placeholder="Phone *" class="input-css">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <small>xxx-xxx-xxxx</small>
                            </div>
                        </div>						
                        <div class="delivery_r">
                            <h2>Delivery Date <span class="text-danger">*</span></h2>	
                            <div class="input-wrap">
                                <label class="label-css">Select your delivery date below.<i class="fa fa-info-circle" aria-hidden="true" title="This order usually can be delivered today if it is placed before 1:00PM recipients local time. Orders received after that cutoff will be delivered the following day unless the following day is Sunday in which case the delivery will be made on Monday."></i></label>
                                <select name="r_d_date" id="r_d_date" class="selectpicker">
                                    <option value="">--Delivery Date--</option>
                                </select>
                            </div>
                            <div class="input-wrap second">
                                <label class="label-css">Flower Card Message <span class="text-danger">*</span><i class="fa fa-info-circle" aria-hidden="true"></i></label>
                                <textarea name="r_card_msg"  class="input-css textarea-css" id="card_msg" placeholder="Quod omittam vulputate quo ex." maxlength="200"></textarea>
                                <big id="card_msg_count">(200 characters remaining)</big>
                            </div>
                            <div class="input-wrap third">
                                <label class="label-css">Special Delivery Instructions</label>
                                <label class="label_info">Please enter anything important. For example, colors or types flowers in arrangement that are important to you or important delivery information.</a></label>
                                <textarea name="r_instruct" class="input-css textarea-css" name="instruct" id="instruct" placeholder="Quod omittam vulputate quo ex." maxlength="100"></textarea>
                                <big id="instruct_count">(100 characters remaining)</big>
                            </div>

                        </div>
                        <div class="comment-btm cart_btn">
                            <button class="back" onclick="return back_step()">Back</button>
                            <button type="button" name="cart_btn" onclick="return proceed_step();">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">.input-css.error, .bootstrap-select.error{border:1px solid red;}</style>
<script src="assets/js/flower.js"></script>