<?php

require_once('../functions_main.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, TRUE);
$_POST = $obj;

if((!empty($_POST))) {
    if(isset($obj['channel']) && isset($obj['user']) && isset($obj['token'])) {

        $db = connect_db();

        $channel = $obj['channel'];
        $user = $obj['user'];
        $token = $obj['token'];

        $currentToken = get_current_token($db, $user);

        $newToken = generate_login_token($user);

        $response = [
            'success' => false,
            'message' => 'data received',
            'messageList' => null,
            'token' => null
        ];


        if($token === $currentToken) {
            update_token($db, $currentToken, $newToken);
            $messages = get_msgs($db, $channel);

            $response['success'] = true;
            $response['message'] = 'messages get performed';
            $response['message_list'] = $messages;
            $response['token'] = $newToken;

            echo json_encode($response);

        } else {
            set_token_inactive_all($db, $user);
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


