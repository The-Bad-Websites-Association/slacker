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
        'user' => null
    ];

    if ((isset($obj['username'])) && (isset($obj['token']))) {
        $user = $obj['username'];
        $token = $obj['token'];

        $state = set_token_inactive($db, $user, $token);
        if($state === true) {
            $response['success'] = true;
            $response['message'] = 'user logged out';
            $response['user'] = $user;
            echo json_encode($response);

        } else {
            $response['message'] = 'user failed to be logged out';
            $response['user'] = $user;
            echo json_encode($response);
        }
    } else {
        $response['message'] = 'Incorrect data sent';
        echo json_encode($response);
    }
} else {
    echo 'FORBIDDEN';
}