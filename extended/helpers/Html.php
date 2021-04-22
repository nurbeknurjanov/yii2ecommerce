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
        $width = str_replace('px','',$width);
        $height = str_replace('px','',$height);
        return "https://fakeimg.pl/{$width}x{$height}";
    }
    public static function noImg($width=120, $height=120, $options=[])
    {
        return self::img(self::noImgUrl($width, $height), $options);
    }
    public static function i($options=[])
    {
        return self::tag('i', '', $options);
    }

    public static function inputWithSymbol($model, $attribute, $options = [], $symbol)
    {
        if(!isset($options['inputOptions']['class']))
            $options['inputOptions']['class'] = 'form-control';
        if(!isset($options['containerOptions']['class']))
            $options['containerOptions']['class'] = 'input-group';

        $button = Html::tag("button", $symbol, ['class'=>'btn btn-default']);
        $span = Html::tag("span", $button,['class'=>'input-group-btn']);
        $input = Html::activeTextInput($model, $attribute, $options['inputOptions']);
        return Html::tag("div", $input.$span, $options['containerOptions']);
    }

}