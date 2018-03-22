<?php

return [
    'defaults' => [
        'connection' => 'mysql',
        'disk' => 'local',
    ],
    'groups' => [
        'default' => [
            'expires' => '7 days',
            'relPath' => 'backups/default',
            //'exclude' => ['blocks', 'users'],
            //'include' => ['blocks', 'users'],
        ],
    ],
];