<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use order\models\Order;


return [
    [
        'id' => '1',
        'user_id' => NULL,
        'ip' => '127.0.0.1',
        'name' => 'Adam Smith',
        'email' => 'adam.smith@mail.ru',
        'phone' => '+996558011477',
        'country_id' => 231,
        'region_id' => 3956,
        'city_id' => 48019,
        'address' => 'Lincoln street, building 7, apartment 8',
        'description' => '',
        'delivery_id' => Order::DELIVERY_SERVICE,
        'created_at' => '2018-01-01 12:00',
        'updated_at' => '2018-01-01 12:00',
        'amount' => 1500,
        'payment_type' => Order::PAYMENT_TYPE_CASH,
        'status' => Order::STATUS_APPROVED,
        'coupon_id' => NULL
    ],
];