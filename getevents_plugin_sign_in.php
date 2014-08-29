<?php

if ( isset( $_POST ) && count( $_POST ) ) {
    $action = $_POST['action'];

    if ( $action == "connect_account" ) {
        $data = array( 'status' => $_POST['status'], 'action' => $_POST['action'], 'location' => $_POST['location'], 'keywords' => $_POST['keywords'], 'email' => $_POST['request_email'], 'script' => $_POST['script'] );

        $geteventsOptionListings = 'getevents_account';

        if (get_option($geteventsOptionListings) !== false ) {
            update_option($geteventsOptionListings, $data );
        } else {
            $deprecated = null;
            $autoload   = 'no';
            add_option($geteventsOptionListings, $data, $deprecated, $autoload );
        }

        die();
    }

}

?>

