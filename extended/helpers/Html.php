<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\helpers;


class Html extends \yii\helpers\Html
{
    public static function noImgUrl($width=120, $height=120)
    {
        return "https://placehold.it/{$width}x{$height}";
    }
    public static function noImg($width=120, $height=120, $options=[])
    {
        return self::img(self::noImgUrl($width, $height), $options);
    }
    public static function i($options=[])
    {
        return self::tag('i', '', $options);
    }

    public static function inputWithSymbol($model, $attribute, $symbol)
    {
        return Html::tag("div",
            Html::activeTextInput($model, $attribute, ['class'=>'form-control']).
            Html::tag("span", Html::tag("button", $symbol, ['class'=>'btn btn-default']),['class'=>'input-group-btn']),
            ['class'=>'input-group']);
    }

}