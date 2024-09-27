<?php

$year = date('Y');
$month = date('m');

echo json_encode([

    [
        'id' => 111,
        'title' => 'Event1',
        'start' => "$year-$month-10",
        'url' => 'http://yahoo.com/',
    ],

    [
        'id' => 222,
        'title' => 'Event2',
        'start' => "$year-$month-20",
        'end' => "$year-$month-22",
        'url' => 'http://yahoo.com/',
    ],

]);
