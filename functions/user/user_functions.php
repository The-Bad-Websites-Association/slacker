<?php

function get_users(PDO $db) :array {

    $userListQuery = "SELECT `uname` FROM `users`";
    $query = $db->prepare($userListQuery);
    $query->execute();
    $userList = $query->fetchAll();

    return $userList;
}

function add_user(PDO $db, string $user, string $hash) :bool {

    $userCreateQuery = "INSERT INTO `users` (`uname`,`hash`) VALUES (:username, :passhash)";
    $query = $db->prepare($userCreateQuery);
    $query->bindParam(":username", $user, PDO::PARAM_STR);
    $query->bindParam(":passhash", $hash, PDO::PARAM_STR);
    $state = $query->execute();

    return $state;
}

function get_user_pass_hash(PDO $db, string $user) :string {

    $userHashQuery = "SELECT `hash` FROM `users` WHERE `uname` = :user";
    $query = $db->prepare($userHashQuery);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $query->execute();
    $userHash = $query->fetch();

    return $userHash['hash'];
}

function generate_login_token(string $user) :string {
    $string = $user . time() . rand();
    $token = md5($string, false);

    return $token;
}

function set_token_active(PDO $db, string $user,string $token) :bool {

    $tokenAddQuery = "INSERT INTO `users_active` (`uname`,`token`) VALUES (:user, :token)";
    $query = $db->prepare($tokenAddQuery);
    $query->bindParam(":user", $user, PDO::PARAM_STR);
    $query->bindParam(":token", $token, PDO::PARAM_STR);
    $state = $query->execute();

    return $state;
}

function set_token_inactive(PDO $db, string $user, string $token) :bool {

    $tokenInactiveQuery = "UPDATE `users_active` SET `ended` = '1', `time_out` = :timeval WHERE `uname` = :user AND `token` = :token";
    $query = $db->prepare($tokenInactiveQuery);
    $query->bindParam(':timeval', date('Y-n-d H:i:s'), PDO::PARAM_STR);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $query->bindParam(':token', $token, PDO::PARAM_STR);
    $state = $query->execute();

    return $state;

}

function get_current_token(PDO $db,string $user) :string {

    $tokenQuery = "SELECT `token` FROM `users_active` WHERE NOT `ended` = '1' AND `uname` = :user";
    $query = $db->prepare($tokenQuery);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $token = $query->fetch();

    return $token;
}

function update_token(PDO $db, string $oldToken, string $newToken) :bool {
    $updateTokenQuery = "UPDATE `users_active` SET `token` = :newtoken WHERE `token` = :oldtoken AND NOT `ended` = '1';";
    $query = $db->prepare($updateTokenQuery);
    $query->bindParam(':oldtoken', $oldToken, PDO::PARAM_STR);
    $query->bindParam(':newtokeb', $newToken, PDO::PARAM_STR);
    $state = $query->execute();

    return $state;

}

function get_token_data(PDO $db,string $token) :array {

    $tokenQuery = "SELECT * FROM `users_active` WHERE `token` = :token";
    $query = $db->prepare($tokenQuery);
    $query->bindParam(':token', $token, PDO::PARAM_STR);
    $query->execute();
    $token = $query->fetch();

    if($token === false) {
        $token = [];
    }

    return $token;
}

