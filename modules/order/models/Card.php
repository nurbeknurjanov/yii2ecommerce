<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\models;

use Yii;
use yii\base\Model;
use yii\behaviors\AttributeBehavior;


/**
 * @property int $number
 */
class Card extends Model
{
    public $number;
    public $digits1;
    public $digits2;
    public $digits3;
    public $digits4;
    public $name;
    public $expire_date;
    public $expire_date_month;
    public $expire_date_year;
    public $ccv;

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_VALIDATE => 'number',
                ],
                'value' => function ($event) {
                    /* @var self $model */
                    $model = $event->sender;
                    if($model->digits1 && $model->digits2 && $model->digits3 && $model->digits4)
                        $model->number = $model->digits1.$model->digits2.$model->digits3.$model->digits4;
                    return $model->number;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_VALIDATE => 'expire_date',
                ],
                'value' => function ($event) {
                    /* @var self $model */
                    $model = $event->sender;
                    if($model->expire_date_month && $model->expire_date_year)
                        return '1';
                },
            ],
        ];
    }

    public function rules()
    {
        return [
            [['digits1',
                'digits2',
                'digits3',
                'digits4',
                'name',
                'expire_date_month',
                'expire_date_year',
                'ccv',
                ], 'required', 'whenClient' => "isPaymentOnlineAndOnlinePaymentTypeIsCard", ],
            ['number', 'required', 'whenClient' => "function(){
                                    return isAllDigitsNotFulfilled() && isPaymentOnlineAndOnlinePaymentTypeIsCard()
                                }"],
            ['expire_date', 'required', 'whenClient' =>  "function(){
                                    return isBothDateNotFulfilled() && isPaymentOnlineAndOnlinePaymentTypeIsCard()
                                }" ],
            [['number'], 'cardNumberValidation'],
            [['digits1',
                'digits2',
                'digits3',
                'digits4',
                'expire_date_month',
                'expire_date_year',
                'ccv',  ], 'integer'],
            [['digits1',
                'digits2',
                'digits3',
                'digits4',   ], 'string', 'length'=>4,],
            [['expire_date_month',  ], 'string', 'length'=>2,],
            [['expire_date_year',  ], 'string', 'length'=>4,],
            [['number',  ], 'string', 'length'=>16,],
            [['ccv'], 'string', 'length'=>3,],
        ];
    }

    public function cardNumberValidation()
    {
        if (!$this->luhnCheck($this->number))
            $this->addError('number', 'Card number is invalid.');
    }
    private function luhnCheck($number)
    {
        // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
        $number = preg_replace('/\D/', '', $number);

        // Set the string length and parity
        $numberLength = strlen($number);
        $parity = $numberLength % 2;

        // Loop through each digit and do the maths
        $total = 0;
        for ($i = 0; $i < $numberLength; $i++) {
            $digit = $number[$i];
            // Multiply alternate digits by two
            if ($i % 2 == $parity) {
                $digit *= 2;
                // If the sum is two digits, add them together (in effect)
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            // Total up the digits
            $total += $digit;
        }

        // If the total mod 10 equals 0, the number is valid
        return ($total % 10 == 0) ? true : false;

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'=>Yii::t('common', 'Name'),
            'expire_date_month'=>Yii::t('order', 'Expire month'),
            'expire_date_year'=>Yii::t('order', 'Expire year'),
            'digits1'=>Yii::t('order', '1 - 4 digits'),
            'digits2'=>Yii::t('order', '2 - 4 digits'),
            'digits3'=>Yii::t('order', '3 - 4 digits'),
            'digits4'=>Yii::t('order', '4 - 4 digits'),
            'number'=>Yii::t('order', 'Card number'),
            'expire_date'=>Yii::t('order', 'Expire date'),
            'ccv'=>'CVV',
        ];
    }
}