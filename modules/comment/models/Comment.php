<?php

namespace comment\models;

use extended\helpers\StringHelper;
use file\models\File;
use file\models\FileImage;
use file\models\behaviours\FileImageBehavior;
use file\models\FileVideoNetwork;
use file\models\behaviours\FileVideoNetworkBehavior;
use like\models\Like;
use product\models\Product;
use product\models\Rating;
use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use user\models\User;
use yii\db\AfterSaveEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\JsExpression;
use \himiklab\yii2\recaptcha\ReCaptchaValidator;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $model_name
 * @property integer $user_id
 * @property string $ip
 * @property string $name
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Product $product
 * @property Rating $rating
 * @property Rating $ratingObject
 * @property Like[] $likes
 * @property boolean $enabled
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    protected $_rating;
    public function getRatingObject()
    {
        if($this->_rating)
            return $this->_rating;
        if($this->rating)
            return $this->_rating = $this->rating;
        return $this->_rating = new Rating();
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function ($event) {
                    return date('Y-m-d H:i:s');
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT => ['created_at'],
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

            'images'=>[
                'class' => FileImageBehavior::class,
                'className'=>self::class,
                'loader'=>FileImageComment::class,
                'fileAttributes'=>['imagesAttribute'],
            ],

            'videoNetwork'=>[
                'class' => FileVideoNetworkBehavior::class,
                'className'=>self::class,
                'fileAttributes'=>['videoAttribute'],
            ],
        ];
    }

    public $videoAttribute;

    public $imagesAttribute=[];


    /**
     * @return \file\models\query\FileQuery
     */
    public function getImages()
    {
        return $this->hasMany(FileImage::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryImages();
    }
    /**
     * @return \file\models\query\FileQuery
     */
    public function getMainImage()
    {
        return $this->hasOne(FileImage::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryMainImage();
    }

    /**
     * @return \file\models\query\FileQuery
     */
    public function getVideo()
    {
        return $this->hasOne(FileVideoNetwork::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryNetwork();
    }

    public function saveOwnRating()
    {
        $rating = $this->ratingObject;
        $rating->id = $this->id;
        $rating->product_id = $this->model_id;
        $rating->save();
    }
    public function deleteOwnRating()
    {
        $this->ratingObject->delete();
    }





    public function init()
    {
        parent::init();

        $this->on(static::EVENT_AFTER_INSERT, [$this, 'saveOwnRating']);
        $this->on(static::EVENT_AFTER_UPDATE, [$this, 'saveOwnRating']);
        $this->on(static::EVENT_BEFORE_DELETE, [$this, 'deleteOwnRating']);
    }

    public function getNameAttributeText()
    {
        return $this->user ? Html::a($this->user->fullName, ['/user/user/view', 'id'=>$this->user_id]):$this->name;
    }

    public $modelNameValues=[
        Product::class=>'Product',
    ];

    public $reCaptcha;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'model_name', 'text'], 'required'],
            ['name', 'required', 'when'=>function($model) {
                return Yii::$app->user->isGuest;
            }, 'whenClient' => "function (attribute, value) {
                        return ".( (boolean) Yii::$app->user->isGuest ).";
                    }"],

            [['model_id', 'user_id'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'default', 'value'=>NULL],
            [['model_name', 'ip', 'name', 'text'], 'default', 'value'=>''],
            [['model_id'], 'default', 'value'=>0],
            [['created_at', 'updated_at'], 'default', 'value'=>'0000-00-00 00:00:00'],
            [['model_name'], 'string', 'max' => 200],
            [['ip', 'name'], 'string', 'max' => 255],
            [['videoAttribute'], 'validateVideo'],
            ['enabled', 'boolean'],
            ['enabled',  'default', 'value'=>0],
            ['created_at', 'safe'],
            [['reCaptcha'], ReCaptchaValidator::className(),
                'when'=>function($model){
                    return YII_ENV_PROD;
                },
                'whenClient'=>new JsExpression("function (attribute, value) {
                                        return ".(YII_ENV_PROD).";
                                    }"),
            ]
        ];
    }
    public function validateVideo()
    {
        $model = new FileVideoNetwork(['link'=>$this->videoAttribute]);
        if(!$model->validate(['link']))
            $this->addError("videoAttribute", Yii::t('file', 'The link of video is incorrect.'));
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
            'name' => Yii::t('common', 'Name'),
            'text' => Yii::t('common', 'Text'),
            'videoAttribute' => Yii::t('common', 'Video'),
            'imagesAttribute' => Yii::t('common', 'Images'),
            'created_at' => Yii::t('common', 'Created date'),
            'updated_at' => Yii::t('common', 'Updated date'),
            'reCaptcha' => Yii::t('common', 'Captcha'),
        ];
    }

    /**
     * @inheritdoc
     * @return \comment\models\query\CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \comment\models\query\CommentQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRating()
    {
        return $this->hasOne(Rating::class, ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::class, ['model_id' => 'id'])->defaultFrom()->andOnCondition(['like.model_name'=>self::class]);
    }

    /**
     * @return \product\models\query\ProductQuery
     */
    public function getProduct()
    {
        /* @var \product\models\query\ProductQuery $productQuery */
        /*if($this->model_name!=Product::class)
            throw new Exception("This comment is wrong.");*/
        $productQuery = $this->hasOne(Product::class, ['id' => 'model_id']);
        return $productQuery;
    }

    public $ratingOrderAttribute;

    public function getTitle()
    {
        return StringHelper::truncate($this->text, 30);
    }
}