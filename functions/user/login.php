<?php

require_once('../functions_main.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, TRUE);
$_POST = $obj;

if((!empty($_POST))) {

    $db = connect_db();

    $userList = get_users($db);

    $response = [
        'success' => false,
        'message' => 'data received',
        'user' => null,
        'token' => null
    ];

    if ((isset($obj['username'])) && (isset($obj['password']))) {
        $user = $obj['username'];
        $pass = $obj['password'];

        $response['user'] = $user;

        if (in_array_r($user, $userList)) {

            $userHash = get_user_pass_hash($db, $user);

            if(password_verify($pass, $userHash)) {
                $token = generate_login_token($user);
                $addToken = set_token_active($db, $user, $token);

                if($addToken === true) {
                    $response['success'] = true;
                    $response['message'] = 'Login Success';
                    $response['token'] = $token;

                    echo json_encode($response);
                } else {
                    $response['message'] = 'Database Error: Login Failed';
                    echo json_encode($response);
                }
            } else {
                $response['message'] = 'Password incorrect';
                echo json_encode($response);
            }
        } else {
            $response['message'] = 'User not found';
            echo json_encode($response);
        }
    } else {
        $response['message'] = 'Incorrect data sent';
        echo json_encode($response);
    }
} else {
    echo 'FORBIDDEN';
}