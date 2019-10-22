<?php

require_once('../functions_main.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, TRUE);
$_POST = $obj;

if((!empty($_POST))) {

    $db = connect_db();

    $response = [
        'success' => false,
        'message' => 'data received',
        'user' => null,
        'message_data' => null,
        'channel' => null,
        'token' => null
    ];

    if ((isset($obj['user'])) && (isset($obj['message_data'])) && (isset($obj['token']))) {

        $user = $obj['user'];
        $msg = $obj['message_data'];
        $channel = $obj['channel'];
        $token = $obj['token'];


        $currentToken = get_current_token($db, $user);
        $newToken = generate_login_token($user);

        if($token === $currentToken) {
            update_token($currentToken, $newToken);
            add_msg($db,$user,$msg,$channel);

            $response = [
                'success' => true,
                'message' => 'message added',
                'user' => $user,
                'message_data' => $msg,
                'channel' => $channel,
                'token' => $newToken
            ];

            echo json_encode($response);
        } else {

            $response['message'] = 'invalid token' . $currentToken;
            $response['user'] = $user;

            echo json_encode($response);
        }
    } else {
        $response['message'] = 'invalid request';

        echo json_encode($response);
    }
} else {
    echo 'FORBIDDEN';
}