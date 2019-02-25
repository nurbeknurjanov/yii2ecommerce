<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\i18n;

use keramika\product\models\Product;
use Yii;


class Formatter extends \yii\i18n\Formatter
{

    public function asCurrency($value, $currency = null, $options = [], $textOptions = [])
    {
        //if(defined('INTL_ICU_DATA_VERSION') && INTL_ICU_DATA_VERSION<49)
        {
            if($this->currencyCode=='KZT'){
                $value = parent::asCurrency($value, $currency, $options, $textOptions);
                $value = trim($value, $this->currencyCode);
                $value = str_replace(',00', '', $value);
                $value = trim($value);
                $value.="₸";
                return $value;
            }
        }
        return parent::asCurrency($value, $currency, $options, $textOptions);
    }

    public function getCurrencySymbol($currency = null)
    {
        //$adminFormatter->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); /
        $string = $this->asCurrency(0, $currency);
        $string = str_replace('0', '', $string);
        $string = str_replace('.', '', $string);
        $string = str_replace(',', '', $string);
        return $string;
    }

    public function asDate($value, $format = null)
    {
        if($value=='0000-00-00')
            return $this->nullDisplay;
        return parent::asDate($value, $format);
    }
    public function asDatetime($value, $format = null)
    {
        if($value=='0000-00-00 00:00:00')
            return $this->nullDisplay;
        return parent::asDatetime($value, $format);
    }

    public function asDateTimeText($value, $type='medium')
    {
        $datetime1 = new \DateTime($value);
        $datetime2 = new \DateTime(date('Y-m-d H:i:s'));
        $interval = $datetime1->diff($datetime2);

        if($interval->format('%y')==0 && $interval->format('%m')==0 && $interval->format('%W')==0)
        {
            if($interval->format('%d')>0 && $interval->format('%d')<=3)
                return Yii::t('common', '{n, plural, one{# day}  other{# days}} ago', ['n' => $interval->format('%d')]);
            elseif($interval->format('%d')==0)
            {
                if($interval->format('%h')>0 && $interval->format('%h')<=3)
                    return Yii::t('common', '{n, plural, one{# hour}  other{# hours}} ago', ['n' => $interval->format('%h')]);
                elseif($interval->format('%h')==0)
                {
                    if($interval->format('%i')>0)
                        return Yii::t('common', '{n, plural, one{# minute}  other{# minutes}} ago', ['n' => $interval->format('%i')]);
                    else
                        return Yii::t('common', 'Just now');
                }
                else
                    return Yii::t('common', 'Today at {date}', ['date'=>date('H:i', strtotime($value)),]);
            }
        }
        return $this->asDatetime($value,$type);
    }

    public function asTextLimit($value, $countOfSymbols=150)
    {
        $string = strip_tags($value);
        $string = str_replace(["\n","\r", "\t"]," ",$string);;
        if(mb_strlen($string)<=$countOfSymbols)
            return $string;

        $string = mb_substr($string, 0, $countOfSymbols, 'UTF-8');
        $string = rtrim($string, "!,.-");
        //$string = substr($string, 0, strrpos($string, ' '));
        return $string."... ";
    }


}