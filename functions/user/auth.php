<?php

require_once('../functions_main.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, TRUE);
$_POST = $obj;

if(!empty($_POST)) {

    $db = connect_db();

    $response = [
        'success' => false,
        'message' => 'data received',
        'auth' => false
    ];

    if(isset($obj['token'])) {
        $token = $obj['token'];
        $tokenData = get_token_data($db,$token);

        if(isset($tokenData['ended'])) {
            if($tokenData['ended'] === '0') {
                $response['success'] = true;
                $response['message'] = 'token authorised';
                $response['auth'] = true;
                echo json_encode($response);
            } else {
                $response['message'] = 'token not authorised';
                echo json_encode($response);
            }
        } else {
            $response['message'] = 'no token found';
            echo json_encode($response);
        }
    } else {
        $response['message'] = 'incorrect data';
        echo json_encode($response);
    }
} else {
    echo 'FORBIDDEN';
}