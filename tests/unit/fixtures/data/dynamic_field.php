<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use eav\models\DynamicField;

return [
    [
        'id' => '1',
        'label' => 'Brand',
        'key' => 'brand',
        'type' => DynamicField::TYPE_DROP_DOWN_LIST,
        'json_values' => '{
"asus":"Asus",
"apple":"Apple",
"samsung":"Samsung"
}',
        'rule' => '',
        'default_value' => '',
        'enabled' => 1,
        'category_id' => 1,
        'position' => 1,
        'section' => DynamicField::SECTION_SEARCH,
        'unit' => '',
        'with_label' => 0,
        'clickable' => 1,
    ],
	
    [
        'id' => '2',
        'label' => 'Processor',
        'key' => 'processor',
        'type' => DynamicField::TYPE_DROP_DOWN_LIST,
        'json_values' => '{
"i3":"i3",
"i5":"i5",
"i7":"i7"
}',
        'rule' => '',
        'default_value' => '',
        'enabled' => 1,
        'category_id' => 2,
        'position' => 2,
        'section' => DynamicField::SECTION_SEARCH,
        'unit' => '',
        'with_label' => 1,
        'clickable' => 1,
    ],
	
    [
        'id' => '3',
        'label' => 'OS',
        'key' => 'os',
        'type' => DynamicField::TYPE_RADIO_LIST,
        'json_values' => '{
    "android":"Android",
    "iphone os":"iPhone OS"
}',
        'rule' => '',
        'default_value' => '',
        'enabled' => 1,
        'category_id' => 3,
        'position' => 3,
        'section' => DynamicField::SECTION_SEARCH,
        'unit' => '',
        'with_label' => 0,
        'clickable' => 1,
    ],
	
    [
        'id' => '4',
        'label' => 'Size',
        'key' => 'size',
        'type' => DynamicField::TYPE_CHECKBOX_LIST,
        'json_values' => '{
"xs":"xs",
"s":"s",
"m":"m",
"l":"l",
"xl":"xl",
"xxl":"xxl",
"xxxl":"xxxl"
}',
        'rule' => '',
        'default_value' => '',
        'enabled' => 1,
        'category_id' => 15,
        'position' => 4,
        'section' => DynamicField::SECTION_SEARCH,
        'unit' => '',
        'with_label' => 1,
        'clickable' => 0
    ],
    [
        'id' => '5',
        'label' => 'Battery charge time',
        'key' => 'battery_charge_time',
        'type' => DynamicField::TYPE_INPUT,
        'json_values' => '',
        'rule' => 'number',
        'default_value' => '',
        'enabled' => 1,
        'category_id' => 4,
        'position' => 5,
        'section' => DynamicField::SECTION_SEARCH,
        'unit' => 'hours',
        'with_label' => 1,
        'clickable' => 0,
        'data'=>'{
        "slider":"1",
        "input_fields":"1",
        "min":"1",
        "max":"12"
        }',
    ],
];