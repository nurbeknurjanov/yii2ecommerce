<?php

namespace like\models;

use product\models\Product;
use user\models\User;
use Yii;
use yii\base\Event;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\db\AfterSaveEvent;
use comment\models\Comment;


/**
 * This is the model class for table "{{%like}}".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $model_name
 * @property integer $user_id
 * @property string $ip
 * @property integer $mark
 * @property string $created_at
 * @property string $updated_at
 * @property Comment $comment
 * @property boolean $isForComment
 */
class Like extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%like}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function ($event) {
                    return date('Y-m-d H:i:s');
                },
            ],
            [
                'class' => AttributeBehavior::class,
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
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'ip',
                ],
                'value' => function ($event) {
                    return Yii::$app->request->userIP;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT => 'model_name',
                ],
                'value' => function ($event) {
                    return Comment::class;
                },
            ],
        ];
    }

    public function getIsForComment()
    {
        return $this->model_name==Comment::class;
    }


    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT, function(AfterSaveEvent $event){
            /* @var $model self */
            $model = $event->sender;
            if($model->isForComment)
                $model->comment->rating->updateFactor();
        });
        $this->on(self::EVENT_AFTER_UPDATE, function(AfterSaveEvent $event){
            /* @var $model self */
            $model = $event->sender;
            if($model->isForComment)
                $model->comment->rating->updateFactor();
        });

        $this->on(self::EVENT_AFTER_DELETE, function(Event $event){
            /* @var $model self */
            $model = $event->sender;
            if($model->isForComment)
                $model->comment->rating->updateFactor();
        });
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'model_name', 'mark'], 'required'],
            [['model_id', 'user_id', 'mark'], 'integer'],
            [['user_id'], 'default', 'value'=>NULL],
            [['model_name', 'ip'], 'default', 'value'=>''],
            [['model_id', 'mark'], 'default', 'value'=>0],
            [['model_name', 'ip'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'model_id' => Yii::t('common', 'Model ID'),
            'model_name' => Yii::t('common', 'Model Name'),
            'user_id' => Yii::t('common', 'User ID'),
            'ip' => Yii::t('common', 'Ip'),
            'mark' => Yii::t('common', 'Mark'),
        ];
    }

    /**
     * @inheritdoc
     * @return \like\models\query\LikeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \like\models\query\LikeQuery(get_called_class());
    }


	public $markValues=[
	    1=>'Like',
	    -1=>'Dislike',
    ];
    public function getMarkText()
    {
        return isset($this->markValues[$this->mark]) ? $this->markValues[$this->mark]:null;
    }

    public function getComment()
    {
        if($this->model_name!=Comment::class)
            throw new Exception("This like is wrong.");
        return $this->hasOne(Comment::class, ['id'=>'model_id']);
    }
    public function getObject()
    {
        return $this->hasOne($this->model_name, ['id'=>'model_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id'=>'user_id']);
    }

    public $modelNameValues=[
        Comment::class=>'Comment',
        //Product::class=>'Product',
    ];
}