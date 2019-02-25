<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models;

use like\models\Like;
use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use comment\models\Comment;
use yii\db\AfterSaveEvent;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "{{%product_rating}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $ip
 * @property integer $product_id
 * @property integer $mark
 * @property Comment $comment
 * @property Product $product
 * @property integer $factor
 * @property Like[] $likes
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_rating}}';
    }


    public function behaviors()
    {
        return [
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
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'ip',
                ],
                'value' => function ($event) {
                    return Yii::$app->request->userIP;
                },
            ],
        ];
    }

    public function updateFactor()
    {
        $this->factor = (float) $this->getLikes()->select("SUM(mark)")->createCommand()->queryScalar()+1;
        $this->factor = round($this->factor,2);
        $this->save();
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_INSERT, function(AfterSaveEvent $event){
            /* @var $model self */
            $model = $event->sender;
            $model->product->updateRatingValue();
        });
        $this->on(self::EVENT_AFTER_UPDATE, function(AfterSaveEvent $event){
            /* @var $model self */
            $model = $event->sender;
            $model->product->updateRatingValue();
        });


        $this->on(self::EVENT_BEFORE_DELETE, function($event){
            /* @var $model self */
            $model = $event->sender;
            Like::deleteAll(['id'=>ArrayHelper::map($model->likes, 'id', 'id')]);
        });
        $this->on(self::EVENT_AFTER_DELETE, function($event){
            /* @var $model self */
            $model = $event->sender;
            $model->product->updateRatingValue();
        });

    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mark'], 'required'],
            [['user_id', 'product_id', 'mark'], 'integer'],
            [['ip'], 'default', 'value'=>''],
            [['factor'], 'default', 'value'=>1],
            [['ip'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'ip' => Yii::t('common', 'Ip'),
            'product_id' => Yii::t('common', 'Product ID'),
            'mark' => Yii::t('comment', 'Mark'),
        ];
    }

    /**
     * @inheritdoc
     * @return \product\models\query\RatingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \product\models\query\RatingQuery(get_called_class());
    }


	public $markValues;
    public function getMarkText()
    {
        return isset($this->markValues[$this->mark]) ? $this->markValues[$this->mark]:null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::className(), ['model_id' => 'id'])->defaultFrom()->andOnCondition(['like.model_name'=>'comment\models\Comment']);
    }
}