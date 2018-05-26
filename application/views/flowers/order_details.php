<script src="assets/js/jquery.fancybox.js"></script>
<script src="assets/js/jquery.fancybox.pack.js"></script>
<?php
$delivery_date = '';
$recepint = [];
if (isset($order_data) && !empty($order_data)) {
    foreach ($order_data->ITEMS as $key => $val) {
        $recepint = $val->RECIPIENT;
        $delivery_date = $val->DELIVERYDATE;
    }
}
?>
<div class="common-page">
    <div class="container">
        <div class="common-head">
            <h2 class="h2title title_cart"><?php echo isset($title) ? $title : 'Order Details' ?></h2>
        </div>
        <div class="common-body">
            <div class="box_cart thanks_order">
                <?php if (isset($order_data) && !empty($order_data)) { ?>
                    <h2 class="thanks_title">Thanks for your order</h2>
                    <h6 class="order_num">Order Number: <?php echo $order_data->ORDERNO ?></h6>
                    <?php if (!empty($delivery_date)) { ?>
                        <h6 class="order_num">Delivery Date: <?php echo date('M d, Y', strtotime($delivery_date)) ?></h6>
                    <?php } ?>
                    <div class="add_order">
                        <ul>
                            <?php if (!empty($recepint)) { ?>
                                <li class="shipping address">
                                    <h4>Shipping Adress</h4>
                                    <p class="address_name"><?php echo $recepint->NAME ?></p>
                                    <p><?php echo $recepint->ADDRESS1 ?><?php echo!empty($recepint->ADDRESS2) ? '<br> ' . $recepint->ADDRESS2 . ',' : '' ?> <br> <?php echo $recepint->CITY . ', ' . $recepint->STATE . ', ' . $recepint->COUNTRY . ' ' . $recepint->ZIPCODE ?> </p>
                                </li>
                            <?php } ?>
                            <li class="shipping address">
                                <h4>Billing Adress</h4>
                                <p class="address_name"><?php echo $order_data->CUSTOMER->NAME ?></p>
                                <p><?php echo $order_data->CUSTOMER->ADDRESS1 ?><?php echo!empty($order_data->CUSTOMER->ADDRESS2) ? '<br> ' . $order_data->CUSTOMER->ADDRESS2 . ',' : '' ?> <br> <?php echo $order_data->CUSTOMER->CITY . ', ' . $order_data->CUSTOMER->STATE . ', ' . $order_data->CUSTOMER->COUNTRY . ' ' . $order_data->CUSTOMER->ZIPCODE ?> </p>
                            </li>
                        </ul>
                    </div>
                    <div class="box_purchase_order">
                        <?php foreach ($order_data->ITEMS as $key => $val) { ?>
                            <ul class="box_detail_cart">
                                <li><img class="" src="<?php echo $val->THUMBNAIL ?>"></li>
                                <li>
                                    <div class="cart_name"><a href="javascript:void(0)" class="cart-item-name" style="font-size:20px;"><?php echo $val->NAME ?></a></div>
                                </li>
                                <li>
                                    <div class="price_cart">Price :<span>$<?php echo $val->PRICE ?></span></div>
                                </li>
                            </ul>
                        <?php } ?>
                        <ul class="cart_totle_ul">
                            <li class=""><div class="totle_sub"><span class="price_type">Subtotal :</span><span class="crt_p">$<?php echo $order_data->SUBTOTAL ?></span></div></li>
                            <li class=""><div class="totle_sub"><span class="price_type">Delivery Charge :</span><span class="crt_p">$<?php echo $order_data->SERVICECHARGE ?></span></div></li>
                            <li class=""><div class="totle_sub"><span class="price_type">Tax :</span><span class="crt_p">$<?php echo $order_data->TAX ?></span></div></li>
                            <li class=""><div class="totle_sub"><span class="price_type">Total :</span><span class="crt_p">$<?php echo $order_data->TOTAL ?></span></div></li>

                        </ul>
                    </div>
                <?php } else { ?>
                    <p class="no-data">Order details you wish to find is not available. Please check your order number is correct!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>