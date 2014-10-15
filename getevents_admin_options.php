<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P6W3XQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P6W3XQ');</script>
<!-- End Google Tag Manager -->


<?php

$geteventsServer = 'https://getevents.co';

$admin_email = get_option('admin_email');

$geteventsCreateUserURL = $geteventsServer . "/platforms/create?platform=wordpress&email=";
$geteventsCreateUserURL .= $admin_email . "&website=";
$geteventsCreateUserURL .= site_url() . "&complete=";

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $geteventsCreateUserURL .= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
} else {
    $geteventsCreateUserURL .= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

?>

<script type="text/javascript">
    var geteventsCreateUserURL = "<?php echo $geteventsCreateUserURL;?>";

    setTimeout(function() {
        _kmq.push(['record', 'Wp install plugin']);
    }, 1000);

</script>

<div class="wrap">
    <h2><img src="<?php echo plugin_dir_url( __FILE__ ) ."/images/getevents.png";?>" alt=""/> for wordpress</h2>

<?php
    $geteventsOptionAccount = 'getevents_account';

    if (get_option($geteventsOptionAccount) !== false) {
        $geteventsAccount = get_option($geteventsOptionAccount);
?>

        <div id="getevents-connected">
            <h3>You are now connected to getevents with:</h3>
            <h3 id="user_request_email"><?php echo $geteventsAccount['email'];?></h3>
            <p><br /><br /><a href="admin.php?page=get-events-page/getevents_admin.php&action=disconnect">Disconnect</a></p>
        </div>

        <div id="getevents-listings">
            <h3>Your Event Listings:</h3>
            <h3 id="user_location"><?php echo $geteventsAccount['eventlisting']['location']['city'];?></h3>
            <a href="<?php echo $geteventsServer; ?>/platforms/sign-in?platform=wordpress=&email=<?php echo $geteventsAccount['email']; ?>" target="_blank" id="configure_link" class="button-primary">Configure Event Listings</a>
            <p>To add your Event Listings, add the shortcode <strong>[getevents]</strong> to your blog post or page.</p>
            <p>Shortcode: <span class="getevents-shortcode">[getevents]</span></p>
        </div>

<?php
    } else {
?>

        <div class="getevents-options">

            <div id="getevents-connect">
                <h3>Connect your GetEvents account.</h3>
                <p>Your GetEvents Password is not saved inside your Wordpress site.</p>
                <a class="button-primary" href="#" title="Connect account" id="getevents-connect-button">Connect Account</a>
            </div>

            <div id="user_login" style="display:none">
                <h3>Connect your GetEvents account.</h3>
                <form name="test" method="post" id="getevent_form" >
                    <input type="email" name="user_email" required="required" placeholder="GetEvents Email" id="user_email" onblur="return checkEmailAddress();" value="<?php echo $admin_email; ?>"/>
                    <div id="error-email"></div>
                    <br />
                    <input type="password" name="user_password" value="" required="required" placeholder="GetEvents Password" id="user_password" onblur="return checkPassword();" />
                    <div id="error-password" class="getevents-error-message"></div>
                    <div id="getevents-signin">
                        <p>Your GetEvents Password is not saved inside your Wordpress site.</p>
                        <input type="button" name="submit"  value="Connect Account" class="button-primary" id="getevents-signin-button"/>
                    </div>
                    <br />
                    <div id="error-signin" class="getevents-error-message"></div>
                </form>
            </div>

        </div>

        <div class="getevents-create-account">
            <h3>Don’t have a GetEvents account?</h3>
            <p>Create one now, it is free and easy to add Event Listings to your Wordpress site</p>
            <a href="#" onclick="geteventsCreateUser()">Create GetEvents Account</a>
        </div>

<?php
    }
?>
</div>

