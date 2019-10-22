<?php

require_once('../functions_main.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, TRUE);
$_POST = $obj;

if (!empty($_POST)) {

    $db = connect_db();

    $userList = get_users($db);

    $response = [
    'success' => false,
    'message' => 'data received'
    ];

    if (isset($obj['username']) && isset($obj['password']) && isset($obj['password2'])) {
        $user = $obj['username'];
        $pass1 = $obj['password'];
        $pass2 = $obj['password2'];

        if (!in_array_r($user, $userList)) {
            if($pass1 === $pass2) {

                $passHash = password_hash($pass1, PASSWORD_DEFAULT);
                $state = add_user($db,$user,$passHash);

                if($state === true) {
                    $response['success'] =  true;
                    $response['message'] = "Account with name '" . $user . "' created!";
                    echo json_encode($response);

                } else {
                    $response['success'] =  false;
                    $response['message'] = 'Error adding account to the database. ERROR: ' . $state;
                    echo json_encode($response);

                }
            } else {
                $response['success'] =  false;
                $response['message'] = 'Passwords don\'t match';
                echo json_encode($response);

            }
        } else {
            $response['success'] =  false;
            $response['message'] = "Account with name '" . $user . "' already exists!";
            echo json_encode($response);

        }
    } else {
        $response['success'] =  false;
        $response['message'] = 'Incorrect data received, please check you have entered a username and password';
        echo json_encode($response);

    }
} else {
    echo 'FORBIDDEN';
}