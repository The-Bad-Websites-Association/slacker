<?php

function add_msg(PDO $db, int $channel,  string $user, string $msg) :bool {
    $msgAddQuery = "INSERT INTO `messages` (`channel_id`, `user`, `message`) VALUES (:channel, :user, :msg);";
    $query = $db->prepare($msgAddQuery);
    $query->bindParam(':channel', $channel, PDO::PARAM_INT);
    $query->bindValue(':user', $user, PDO::PARAM_STR);
    $query->bindParam(':msg', $msg, PDO::PARAM_STR);
    $state = $query->execute();

    return $state;
}


