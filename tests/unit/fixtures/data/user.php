<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use user\models\User;

return [
    [
        'id' => '1',
        'username' => 'admin',
        'auth_key' => '_gOPydMje6EV9PR3IqAk5bK8h9BM6OLn',
        'password_hash' => '$2y$13$g0Xj.0poxUBuFQzLjWKrFuHEgxmxPqMFbP.6BrOt5rJ3VLWKjySc2',
        'name' => 'Nurbek Nurjanov',
        'email' => 'nurbek.nurjanov@mail.ru',
        'status' => User::STATUS_ACTIVE,
        'created_at' => time(),
        'updated_at' => time(),
        'language' => 'en-US',
        'time_zone' => 'Asia/Almaty',
        'referrer_id' => '0',
        'from' => '',
        'description' => '<p>Yii developer</p>',
        'subscribe' => 1
    ]
];