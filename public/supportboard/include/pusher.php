<?php

if (!isset($_POST['channel_name'])) die();
require('functions.php');
$active_user = sb_get_active_user();
if ($active_user) {
    require SB_PATH . '/vendor/pusher/autoload.php';
    $settings = sb_get_setting('pusher');
    $pusher = new Pusher\Pusher($settings['pusher-key'], $settings['pusher-secret'], $settings['pusher-id'], ['cluster' => $settings['pusher-cluster']]);
    if (strpos($_POST['channel_name'], 'presence') === false) {
        die($pusher->socket_auth($_POST['channel_name'], $_POST['socket_id']));
    } else {
        die($pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], $active_user['id'], ['user_type' => $active_user['user_type']]));
    }
} else die('Forbidden');

?>