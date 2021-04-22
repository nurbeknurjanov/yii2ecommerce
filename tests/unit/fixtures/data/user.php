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
        'name' => 'Administrator',
        'email' => 'admin@mail.ru',
        'status' => User::STATUS_ACTIVE,
        'created_at' => time(),
        'updated_at' => time(),
        'description' => '<p>Yii developer</p>',
        'subscribe' => 1
    ],
    [
        'id' => '2',
        'username' => 'seller',
        'auth_key' => '',
        'password_hash' => '$2y$13$5HE.hbkpLjyLMsXXDAvDMOQBgO1TCoOJUah1U/bhnXnYUsLF7TN.q',
        'name' => 'Seller',
        'email' => 'seller@mail.ru',
        'status' => User::STATUS_ACTIVE,
        'created_at' => time(),
        'updated_at' => time(),
        'description' => '<p>Yii developer</p>',
        'subscribe' => 1
    ],
];