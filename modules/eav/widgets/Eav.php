<?php

/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace eav\widgets;

use eav\models\DynamicField;
use eav\models\DynamicValue;


class Eav extends \yii\base\Widget
{
    public static $fields;
    public static $values;
    public $category_id;
    public function getInstance()
    {
        if(self::$fields!==null)
            return self::$fields;
        return self::$fields = DynamicField::find()->defaultFrom()->in_search()
            ->categoryQuery($this->category_id, true, true, true)
            ->indexBy('dynamic_field.id')->all();
    }
}