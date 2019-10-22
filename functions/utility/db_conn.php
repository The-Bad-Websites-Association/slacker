<?php

function connect_db() :PDO {
    $db = new PDO('mysql:host=db; dbname=slacker', 'root', 'password');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $db;
}