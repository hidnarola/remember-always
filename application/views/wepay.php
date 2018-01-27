<a id="start_oauth2">Click here to create your WePay account</a>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://static.wepay.com/min/js/wepay.v2.js" type="text/javascript"></script>
<script type="text/javascript">
    site_url = '<?php echo site_url() ?>';
    WePay.set_endpoint("production"); // stage or production

    WePay.OAuth2.button_init(document.getElementById('start_oauth2'), {
        "client_id": "122816",
        "scope": ["manage_accounts", "collect_payments", "view_user", "send_money", "preapprove_payments"],
//        "user_name": "test user",
        "user_email": "ku@narola.email",
        "redirect_uri": site_url + "home/wepay/",
        "top": 100, // control the positioning of the popup with the top and left params
        "left": 100,
        "state": "robot", // this is an optional parameter that lets you persist some state value through the flow
        "callback": function (data) {
            /** This callback gets fired after the user clicks "grant access" in the popup and the popup closes. The data object will include the code which you can pass to your server to make the /oauth2/token call **/
            if (data.code.length !== 0) {
                $.ajax({
                    url: site_url + 'home/payment',
                    type: 'POST',
                    data: data,
                    success: function (data) {
                        console.log(data);
                    }
                });
                console.log(data);
                // send the data to the server
            } else {
                console.log('error');
                // an error has occurred and will be in data.error
            }
        }
    });

</script>