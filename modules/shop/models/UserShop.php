<?php

namespace shop\models;

use extended\helpers\Html;
use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use user\models\User;


/**
 * This is the model class for table "{{%user_shop}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $shop_id
 * @property string $position
 *
 * @property Shop $shop
 * @property User $user
 */
class UserShop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_shop}}';
    }

    public static function createOrUpdate($user_id, $shop_id, $position)
    {
        $model = self::findOne(['user_id'=>$user_id, 'shop_id'=>$shop_id]);
        if(!$model)
            $model = new self(['user_id'=>$user_id, 'shop_id'=>$shop_id, 'position'=>$position]);
        else
            $model->position = $position;

        if(!$model->save())
            throw new Exception(Html::errorSummary($model));
    }
    public static function createIfNotExists($user_id, $shop_id, $position='cooperator')
    {
        if(!self::findOne(['user_id'=>$user_id, 'shop_id'=>$shop_id])){
            $model = new self(['user_id'=>$user_id, 'shop_id'=>$shop_id, 'position'=>$position]);
            if(!$model->save())
                throw new Exception(Html::errorSummary($model));
        }
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

    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_id', 'position'], 'required'],
            [['user_id', 'shop_id'], 'integer'],
            [['position'], 'default', 'value'=>''],
            [['user_id', 'shop_id'], 'default', 'value'=>0],
            [['position'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'shop_id' => Yii::t('app', 'Shop ID'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \shop\models\query\UserShopQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \shop\models\query\UserShopQuery(get_called_class());
    }



}