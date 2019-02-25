<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\helpers;


class ArrayHelper extends \yii\helpers\ArrayHelper
{
    public static function array_splice_assoc(&$input, $offset, $length, $replacement = array()) {
        $replacement = (array) $replacement;
        $key_indices = array_flip(array_keys($input));
        if (isset($input[$offset]) && is_string($offset)) {
            $offset = $key_indices[$offset];
        }
        if (isset($input[$length]) && is_string($length)) {
            $length = $key_indices[$length] - $offset;
        }

        $input = array_slice($input, 0, $offset, TRUE)
            + $replacement
            + array_slice($input, $offset + $length, NULL, TRUE);
    }

    public static function push(&$array, $key=null, $value, $position=null)
    {
        if(!$position)
            $position = count($array);
        if(!$key)
            $key = count($array)+1;
        $array = array_slice($array, 0, $position, true) + array($key => $value)
            + array_slice($array, $position, count($array) - 1, true) ;
        return $array;
    }

    public static function inMultipleArray($needleCondition, array $multipleArray)
    {
        $needleCondition = array_map(function($key, $value){
            return "\$item->$key==$value";
        }, array_keys($needleCondition), $needleCondition);

        $needleCondition = implode(' && ', $needleCondition);
        $needleCondition = "\$result = ($needleCondition);";

        foreach ($multipleArray as $item){
            eval($needleCondition);
            return $result;
        }
    }

    public static function mapWithoutKey($array, $to, $group = null)
    {
        $result = [];
        foreach ($array as $element) {
            $value = static::getValue($element, $to);
            if ($group !== null) {
                $result[static::getValue($element, $group)][] = $value;
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }
}