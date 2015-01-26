<?php

class GetEvents_Admin {

	private static $instance = null;

	static function init() {

		if ( is_null(self::$instance) ) {
			self::$instance = new GetEvents_Admin;
		}

		return self::$instance;
	}

	function admin_menu_getevents() {

    add_menu_page(
        "GetEvents",
        "GetEvents",
        "manage_options",
        __FILE__,
        "getevents",
        GETEVENTS__PLUGIN_URL . "images/icon.png",
        21
    );

	}

	function admin_styles() {
  	wp_register_style( 'getevents-style-css', GETEVENTS__PLUGIN_URL . 'css/getevents_wordpress.css' );
  	wp_enqueue_style( 'getevents-style-css' );
  	add_action( 'wp_enqueue_scripts', 'getevents-style-css' );
	}

	function admin_scripts() {
    wp_enqueue_script( 'getevents-jquery-script', '//code.jquery.com/jquery-2.1.0.min.js' );
    wp_enqueue_script( 'getevents-react-script', '//cdnjs.cloudflare.com/ajax/libs/react/0.12.1/react-with-addons.js' );
    wp_enqueue_script( 'getevents-plugin-script', GETEVENTS__PLUGIN_URL . 'js/WordpressPlugin.js', array("getevents-react-script"), "", true);
    $account = get_option(GETEVENTS__DB_USER_INFO);
/*
 	?>
    <pre>
    <?php
    	print_r($account);
    ?>
    </pre>
    <?php
*/
	    if ($account != false) {

	    	if ($account['account']['eventlisting']['id']) {
			    //wp_enqueue_script( 'getevents-eventlistings', GETEVENTS_SERVER . '/eventlistings/' . $account['account']['eventlisting']['id'] . '', array("getevents-react-script"), "", true);
					//add_action( 'wp_enqueue_scripts', 'getevents-eventlistings' );
	    	}

	    	$getevents_pages = GetEvents_Pages::getPages();

    		$title = '';
    		$permalink = '';
    		$post_id = '';

	    	if (isset($getevents_pages[0])) {
	    		$title = $getevents_pages[0]->post_title;
	    		$permalink = $getevents_pages[0]->guid;
	    		$post_id = $getevents_pages[0]->ID;
 	    	}

	    	wp_localize_script( 'getevents-plugin-script',
		    	'getevents_vars',
		    	array(
					'accountId' => $account['account']['id'],
					'accountName' => $account['account']['name'],
					'accountEmail' => $account['account']['email'],
					'accountApiToken' => $account['account']['api_token'],
					'accountLocationCity' => $account['account']['meta']['location']['name'],
					'accountLocationRegion' => $account['account']['meta']['location']['region'],
					'accountLocationCountry' => $account['account']['meta']['location']['country'],
					'accountLocationLat' => $account['account']['meta']['location']['lat'],
					'accountLocationLng' => $account['account']['meta']['location']['lng'],
					'accountEventListingId' => $account['account']['eventlisting']['id'],
					'siteUrl' => site_url(),
					'adminUrl' => admin_url() . 'admin.php?page=' . plugin_basename( __FILE__ ),
					'email' => get_option('admin_email'),
					'pageTitle' => $title,
					'pageUrl' => $permalink,
					'post_id' => $post_id
				)
			);

	    } else {

		    wp_localize_script( 'getevents-plugin-script',
		    	'getevents_vars',
		    	array(
					'accountId' => '',
					'accountName' => '',
					'accountEmail' => '',
					'accountApiToken' => '',
					'accountLocationCity' => '',
					'accountLocationRegion' => '',
					'accountLocationCountry' => '',
					'accountLocationLat' => '',
					'accountLocationLng' => '',
					'accountEventListingId' => '',
					'siteUrl' => site_url(),
					'adminUrl' => admin_url() . 'admin.php?page=' . plugin_basename( __FILE__ ),
					'email' => get_option('admin_email'),
					'pageTitle' => '' ,
					'pageUrl' => ''

				)
			);

	    }

		add_action( 'wp_enqueue_scripts', 'getevents-react-script' );
		add_action( 'wp_enqueue_scripts', 'getevents-plugin-script' );
	}

	function check_for_signin() {

		if ( isset($_POST['account']) ) {

			$userAccountInfo = array(
				'account' => $_POST['account']
			);

			if (get_option(GETEVENTS__DB_USER_INFO) !== false ) {
				update_option(GETEVENTS__DB_USER_INFO, $userAccountInfo );
				$response = array('status' => 'updated', 'accountInfo' => $userAccountInfo);
			} else {
				$deprecated = null;
				$autoload   = 'no';
				add_option(GETEVENTS__DB_USER_INFO, $userAccountInfo, $deprecated, $autoload );
				$response = array('status' => 'added', 'accountInfo' => $userAccountInfo);
			}

			echo json_encode($response);
			die;
		}

	}

	function check_for_signout() {

		if ( isset($_POST['signout']) ) {
			$response = array('status' => 'ok');

			if (get_option(GETEVENTS__DB_USER_INFO) !== false ) {
				delete_option(GETEVENTS__DB_USER_INFO);
			}

			echo json_encode($response);
			die;
		}

	}

	private function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu_getevents') );

		if (isset($_GET['page']) && $_GET['page'] == plugin_basename( __FILE__ )) {
			$this->admin_scripts();
			$this->admin_styles();
			$this->check_for_signin();
			$this->check_for_signout();
		}

	}

}

GetEvents_Admin::init();

if ( isset($_GET['page']) && $_GET['page'] == plugin_basename( __FILE__ )) {

	if ( isset($_POST['title']) || isset($_POST['account']) || isset($_POST['signout']) ) {
	} else {

?>

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

	}

}

