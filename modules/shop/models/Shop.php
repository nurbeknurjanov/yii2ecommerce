<?php

namespace shop\models;

use extended\helpers\Inflector;
use extended\helpers\StringHelper;
use shop\models\FileImageShop;
use file\models\behaviours\FileImageBehavior;
use file\models\FileImage;
use user\models\query\UserQuery;
use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use product\models\Product;
use user\models\User;
use yii\behaviors\SluggableBehavior;
use extended\helpers\Html;
use yii\db\AfterSaveEvent;
use extended\helpers\ArrayHelper;
use extended\behaviours\ManyToManyBehaviour;

/**
 * This is the model class for table "{{%shop}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $title_url
 * @property string $description
 * @property string $address
 *
 * @property Product[] $products
 * @property User $owner
 * @property User[] $users
 * @property UserShop[] $userShops
 * @property [] $url
 * @property string $link
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop}}';
    }


    const EVENT_INIT_FIELDS_OF_MANY_TO_MANY = 'EVENT_INIT_FIELDS_OF_MANY_TO_MANY';

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'title_url',
            ],
            [
                'class' => FileImageBehavior::class,
                'className'=>self::class,
                'loader'=>FileImageShop::class,
                'fileAttributes'=>['imagesAttribute'],
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_FIELDS_OF_MANY_TO_MANY => 'usersAttribute',
                ],
                'value' => function ($event) {
                    /* @var self $model */
                    $model = $event->sender;
                    $model->usersAttribute = ArrayHelper::map($model->users, 'id', 'id');
                    $model->attachBehavior('usersAttributeBehavior', [
                        'class' => ManyToManyBehaviour::class,
                        'manyAttribute'=>'usersAttribute',
                        'manyAttributeOldValue'=>$model->usersAttribute,
                        'saveFunction'=>'saveUserShops',
                    ]);
                    return $model->usersAttribute;
                },
            ],
        ];
    }

    public function attributes()
    {
        $attributes = parent::attributes();
        $attributes[] = 'usersAttribute';
        return $attributes;
    }
    public $usersAttribute=[];

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


    public function init()
    {
        parent::init();
        //$this->on(static::EVENT_BEFORE_INSERT, [$this, 'someFunction']);
        //$this->on(static::EVENT_BEFORE_UPDATE, [$this, 'someFunction']);

        $this->on(self::EVENT_AFTER_INSERT, function(AfterSaveEvent $event){
            /* @var $model self */
            $model = $event->sender;
            //UserShop::createIfNotExists(Yii::$app->user->id, $model->id, 'owner');
            UserShop::createOrUpdate(Yii::$app->user->id, $model->id, 'owner');
        });


    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['description', 'address'], 'default', 'value'=>NULL],
            [['title', 'title_url'], 'default', 'value'=>''],
            [['title', 'title_url', 'address'], 'string', 'max' => 255],
            [['usersAttribute'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'title_url' => Yii::t('app', 'Title Url'),
            'description' => Yii::t('app', 'Description'),
            'address' => Yii::t('app', 'Address'),
            'imagesAttribute' => Yii::t('common', 'Images'),
            'ownerAttribute' => Yii::t('common', 'Owner'),
            'usersAttribute' => Yii::t('common', 'Users'),
        ];
    }

    public $imagesAttribute=[];

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['shop_id' => 'id']);
    }

    public function saveUserShops()
    {
        $elementsToDelete = array_diff((array) $this->getOldAttribute('usersAttribute'), (array) $this->usersAttribute);
        if($elementsToDelete){
            UserShop::deleteAll(['shop_id'=>$this->id,'user_id'=>$elementsToDelete]);
        }

        if($this->usersAttribute){
            if(is_array($this->usersAttribute)){
                foreach ($this->usersAttribute as $user_id)
                    UserShop::createIfNotExists($user_id, $this->id);
            }
            else
                UserShop::createIfNotExists($this->usersAttribute, $this->id);
        }
    }
    
    /**
     * @return UserQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])
            ->via('userShopsOwner')
            ;
    }
    /**
     * @return UserQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->via('userShops');
    }

    public function getUserShops()
    {
        return $this->hasMany(UserShop::class, ['shop_id'=>'id']);
    }
    public function getUserShopsOwner()
    {
        return $this->getUserShops()
            ->andOnCondition(['position'=>'owner'])
            ->from(['user_shop_owner'=>UserShop::tableName()])
            ;
    }


    /**
     * @inheritdoc
     * @return \shop\models\query\ShopQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \shop\models\query\ShopQuery(get_called_class());
    }

    public function getUrl()
    {
        if(Yii::$app->id=='app-backend')
            return ['/shop/shop/view', 'id'=>$this->id];
        return ['/shop/shop/view', 'title_url'=>$this->title_url];
    }


    public function getThumbImg(string $thumbType, $options=[], $width='auto', $height='auto')
    {
        $model = $this;

        $thumbAttribute = 'thumb'.ucfirst($thumbType);
        if((new FileImageShop)->$thumbAttribute===false)
            throw new Exception("There is no $thumbType thumb type for ".Inflector::titleize(StringHelper::basename($model::className()), true));

        if(!isset($options['alt']))
            $options['alt']=$model->title;


        $cssSize = "width:{$width};height:{$height};";
        if(isset($options['style']))
            $options['style'].=$cssSize;
        else
            $options['style']=$cssSize;
        if($model->mainImage)
            return $model->mainImage->getThumbImg($thumbType, $options);

        if($width=='auto'){
            $widthAttribute = 'thumb'.ucfirst($thumbType).'Width';
            $width = (new FileImageShop)->$widthAttribute.'px';
        }
        if($height=='auto'){
            $heightAttribute = 'thumb'.ucfirst($thumbType).'Height';
            $height = (new FileImageShop)->$heightAttribute.'px';
        }

        return Html::noImg($width, $height, $options);
    }
    public function getImageImg($options=[], $width='auto', $height='auto')
    {
        $model = $this;
        if(!isset($options['alt']))
            $options['alt']=$model->title;


        $cssSize = "width:{$width};height:{$height};";
        if(isset($options['style']))
            $options['style'].=$cssSize;
        else
            $options['style']=$cssSize;

        if($model->mainImage)
            return $model->mainImage->getImageImg($options);

        if($width=='auto')
            $width = (new FileImageShop)->imageWidth.'px';

        if($height=='auto')
            $height = (new FileImageShop)->imageHeight.'px';


        if($this->mainImage)
            return $this->mainImage->getImageImg($options);

        return Html::noImg($width, $height, $options);
    }


    public $ownerAttribute;


    public function getLink()
    {
        return Html::a($this->title, $this->url);
    }
}