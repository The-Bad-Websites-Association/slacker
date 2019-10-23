<?php

function add_msg(PDO $db, string $user, string $msg, int $channel = 1) :bool {
    $msgAddQuery = "INSERT INTO `messages` (`channel_id`, `user`, `message`) VALUES (:channel, :user, :msg);";
    $query = $db->prepare($msgAddQuery);
    $query->bindParam(':channel', $channel, PDO::PARAM_INT);
    $query->bindValue(':user', $user, PDO::PARAM_STR);
    $query->bindParam(':msg', $msg, PDO::PARAM_STR);
    $state = $query->execute();

    return $state;
}

function get_msgs(PDO $db, string $channel) :array {
    $msgGetQuery = "SELECT `id`,`user`,`message` FROM `messages` WHERE `channel_id` = :channel;";
    $query = $db->prepare($msgGetQuery);
    $query->bindParam(':channel', $channel, PDO::PARAM_INT);
    $query->execute();
    $msgs = $query->fetchAll();

    return $msgs;
}