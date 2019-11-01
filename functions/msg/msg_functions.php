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

function update() {
    sleep(1);

    ob_flush();
    ob_clean();
    flush();

    header("Cache-Control: no-cache");
    header("Content-Type: text/event-stream\n\n");

    echo "event: update\n";
    echo 'data: {}';
    echo "\n\n";

    ob_end_flush();
    ob_flush();
    flush();

}