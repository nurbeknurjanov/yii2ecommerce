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
    [
        'id' => '2',
        'user_id' => NULL,
        'ip' => '127.0.0.1',
        'name' => 'Donald Trump',
        'email' => 'trump@mail.ru',
        'phone' => '+996558011477',
        'country_id' => 231,
        'region_id' => 3956,
        'city_id' => 48019,
        'address' => 'Gorkiy street, building 143, apartment 45',
        'description' => '',
        'delivery_id' => Order::DELIVERY_SERVICE,
        'created_at' => '2018-02-02 13:00',
        'updated_at' => '2018-02-02 13:00',
        'amount' => 250,
        'payment_type' => Order::PAYMENT_TYPE_CASH,
        'status' => Order::STATUS_APPROVED,
        'coupon_id' => NULL
    ],
    [
        'id' => '3',
        'user_id' => NULL,
        'ip' => '127.0.0.1',
        'name' => 'Jim Carry',
        'email' => 'carry@mail.ru',
        'phone' => '+996558011477',
        'country_id' => 231,
        'region_id' => 3956,
        'city_id' => 48019,
        'address' => 'Mark Twain street, building 54, apartment 76',
        'description' => '',
        'delivery_id' => Order::DELIVERY_SERVICE,
        'created_at' => '2018-03-03 14:00',
        'updated_at' => '2018-03-03 14:00',
        'amount' => 725,
        'payment_type' => Order::PAYMENT_TYPE_CASH,
        'status' => Order::STATUS_NEW,
        'coupon_id' => NULL
    ],
];