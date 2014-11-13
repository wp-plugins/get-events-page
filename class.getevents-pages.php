<?php

class GetEvents_Pages {

	private static $instance = null;

	static function init() {

		if ( is_null(self::$instance) ) {
			self::$instance = new GetEvents_Pages;
		}

		return self::$instance;
	}

	private function __construct() {
		add_shortcode( GETEVENTS__SHORTCODE, array( $this, 'addShortCode' ) );
		add_action( 'admin_init', array( $this, 'addPage') );
	}

	// Shortcode for adding the script to the web page

	function addShortCode( $atts ) {
  	$account = get_option( GETEVENTS__DB_USER_INFO );

    if ($account != false) {
    	$id = $account['account']['eventlisting']['id'];
  		$script = '<div id="geEventListing" geId="' . $id . '"></div><script src="' . GETEVENTS_SERVER . '/eventlistings/' . $id . '"></script>';
  		return stripslashes( $script );
  	} else {
  		return 'Please connect your Account for [getevents] to work';
  	}

	}

	static function getPages() {
		$args = array(
			'post_status' => 'draft'
		);

		$pagesContainString = array();
		$pages = get_pages($args);

		if (isset($pages[0])) {

			foreach ($pages as $key => $page) {
				if(strpos($page->post_content,"[".GETEVENTS__SHORTCODE."]") !== false){
					$pagesContainString[$key] = $page;
				}
			}

		}

		return $pagesContainString;
	}

	// Add a page to Wordpress Blog...

	function addPage() {

		if ( isset($_POST['title']) ) {

			$title = $_POST['title'];
			$new_post = array(
		    	'post_title'    => $title,
			    'post_content'  => "[".GETEVENTS__SHORTCODE."]",
			    'post_status'   => 'draft',
			    'post_type'   => 'page',
			    'post_author' => 1,
			    'post_category' => array(8,39)
	    	);

			$post_id = wp_insert_post($new_post,true);
			$pageUrl = get_permalink($post_id);
			$page_info = array(
				'status' => 'ok',
				'post_id' => $post_id,
				'url' => $pageUrl,
				'title' => $title,
			);

			//echo $wp_error;

			if ( $wp_error !== NULL ) {
				$page_info = array(
					'status' => 'error',
					'error' => $wp_error
				);
			}

			$res = json_encode($page_info);
			echo $res;
			die;
		}

	}

}

GetEvents_Pages::init();
