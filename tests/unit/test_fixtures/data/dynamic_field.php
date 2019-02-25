<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use eav\models\DynamicField;
use extended\helpers\Helper;

return [
    [
        'id' => '1',
        'category_id' => 1,
        'label' => 'Processor',
        'key' => 'processor',
        'type' => DynamicField::TYPE_DROP_DOWN_LIST,
        'json_values' => Helper::arrayToJson(['i3'=>'i3','i5'=>'i5','i7'=>'i7']),
        'rule' => '',
        'default_value' => '',
        'enabled' => 1,
        'position' => 1,
        'section' => DynamicField::SECTION_SEARCH,
        'unit' => '',
        'with_label' => 0,
        'clickable' => 1,
    ],
    [
        'id' => '2',
        'category_id' => null,
        'label' => 'Brand',
        'key' => 'brand',
        'type' => DynamicField::TYPE_DROP_DOWN_LIST,
        'json_values' => Helper::arrayToJson(['apple'=>'Apple','asus'=>'Asus']),
        'rule' => '',
        'default_value' => '',
        'enabled' => 1,
        'position' => 1,
        'section' => DynamicField::SECTION_SEARCH,
        'unit' => '',
        'with_label' => 0,
        'clickable' => 1,
    ],
];