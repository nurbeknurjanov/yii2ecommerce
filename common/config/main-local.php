<?php
return [
    'components' => [
        'db'=>[
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=your_local_db',
            'username' => 'root',
            'password' => 'root1',
            'charset' => 'utf8',
        ],
        'dbCountries'=>[
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=countries',
            'username' => 'root',
            'password' => 'root1',
            'charset' => 'utf8',
        ],
    ],
];
