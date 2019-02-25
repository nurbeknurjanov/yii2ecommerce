<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\helpers;


class StringHelper extends \yii\helpers\StringHelper
{

    public static function truncate($string, $length=50, $suffix = '...', $encoding = null, $asHtml = false)
    {
        return parent::truncate(strip_tags($string), $length, $suffix = '...', $encoding = null, $asHtml = false);
    }
}