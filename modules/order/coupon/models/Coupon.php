<?php

namespace coupon\models;

use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%coupon}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property integer $discount
 * @property string $interval_from
 * @property string $interval_to
 * @property integer $used
 * @property integer $reusable
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coupon}}';
    }

    /*
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function ($event) {
                    return date('Y-m-d H:i:s');
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'user_id',
                ],
                'value' => function ($event) {
                    // @var $model self
                    $model = $event->sender;
                    return Yii::$app->user->id;
                },
            ],
        ];
    }
    */

    public function init()
    {
        parent::init();
        //$this->on(static::EVENT_BEFORE_INSERT, [$this, 'someFunction']);
        //$this->on(static::EVENT_BEFORE_UPDATE, [$this, 'someFunction']);
        /*
        $this->on(self::EVENT_AFTER_UPDATE, function(AfterSaveEvent $event){
            // @var $model self
            $model = $event->sender;
        });
        */

		$this->usedValues = [
            0=>Yii::t('common', 'No'),
            1=>Yii::t('common', 'Yes')
        ];
		$this->reusableValues = [
            0=>Yii::t('common', 'No'),
            1=>Yii::t('common', 'Yes')
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'code', 'discount', 'interval_from', 'interval_to', 'reusable'], 'required'],
            [['discount', 'used', 'reusable'], 'integer'],
            [['interval_from', 'interval_to'], 'safe'],
            [['title', 'code'], 'default', 'value'=>''],
            [['discount', 'used', 'reusable'], 'default', 'value'=>0],
            [['interval_from', 'interval_to'], 'default', 'value'=>'0000-00-00 00:00:00'],
            [['title', 'code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title' => Yii::t('common', 'Title'),
            'code' => Yii::t('common', 'Code'),
            'discount' => Yii::t('common', 'Discount'),
            'interval_from' => Yii::t('common', 'Interval From'),
            'interval_to' => Yii::t('common', 'Interval To'),
            'used' => Yii::t('common', 'Used'),
            'reusable' => Yii::t('common', 'Reusable'),
        ];
    }

    /**
     * @inheritdoc
     * @return \coupon\models\query\CouponQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \coupon\models\query\CouponQuery(get_called_class());
    }


	public $usedValues;
    public function getUsedText()
    {
        return isset($this->usedValues[$this->used]) ? $this->usedValues[$this->used]:null;
    }


	public $reusableValues;
    public function getReusableText()
    {
        return isset($this->reusableValues[$this->reusable]) ? $this->reusableValues[$this->reusable]:null;
    }



}