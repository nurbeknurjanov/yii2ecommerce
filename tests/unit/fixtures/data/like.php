<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

$date= date('Y-m-d H:i:s');

return [
    [
        'id' => '1',
        'model_id' => '1',
        'model_name' => 'comment\\models\\Comment',
        'user_id' => NULL,
        'ip' => '127.0.0.1',
        'mark' => 1,
        'created_at' => $date,
        'updated_at' => $date,
    ],
    [
        'id' => '3',
        'model_id' => '2',
        'model_name' => 'comment\\models\\Comment',
        'user_id' => NULL,
        'ip' => '127.0.0.2',
        'mark' => -1,
        'created_at' => $date,
        'updated_at' => $date,
    ],
];