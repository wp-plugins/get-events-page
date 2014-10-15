<?php

$geteventsOptionAccount = 'getevents_account';
$geteventsServer = 'https://getevents.co';

if (isset($_GET['action']) && $_GET['action']=='disconnect') {
    delete_option($geteventsOptionAccount);
}

if (isset($_GET['action']) && isset($_GET['email']) && isset($_GET['api_token']) && isset($_GET['account_id'])) {

    if ($_GET['action']=='add_account') {

        $geteventsData = array('connected' => true,
            'email' => $_GET['email'],
            'api_token' => $_GET['api_token'],
            'account' => array('id' => $_GET['account_id']));

        if (get_option($geteventsOptionAccount) !== false) {
            update_option($geteventsOptionAccount, $geteventsData);
        } else {
            $deprecated = null;
            $autoload   = 'no';
            add_option($geteventsOptionAccount, $geteventsData, $deprecated, $autoload);
        }

        $httpURL = $geteventsServer.'/platforms/reconnect';
        $ch = curl_init($httpURL);
        $post = http_build_query(array('account_id'=>$_GET['account_id'], 'api_token'=>$_GET['api_token']));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);

        if ($response['status'] == 'ok') {
            $geteventsData = array('connected' => true,
                'email' => $response['account']['email'],
                'api_token' => $response['request']['api_token'],
                'account' => $response['account'],
                'eventlisting' => $response['eventlisting'],
                'script' => $response['script']);
            update_option($geteventsOptionAccount, $geteventsData);
        }

        curl_close($ch);
    }

}

if (isset($_GET['action'])) {

    if ($_GET['action']=='connect_account') {

        $geteventsData = array('connected' => true,
            'email' => $_GET['email'],
            'api_token' => $_GET['api_token'],
            'account' => $_GET['account'],
            'eventlisting' => $_GET['eventlisting'],
            'script' => $_GET['script']);

        if (get_option($geteventsOptionAccount) !== false) {
            update_option($geteventsOptionAccount, $geteventsData);
        } else {
            $deprecated = null;
            $autoload   = 'no';
            add_option($geteventsOptionAccount, $geteventsData, $deprecated, $autoload);
        }

    }

}
?>