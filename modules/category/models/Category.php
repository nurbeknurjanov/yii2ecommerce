<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace category\models;

use eav\models\DynamicField;
use extended\helpers\Helper;
use file\models\File;
use file\models\FileImage;
use file\models\behaviours\FileImageBehavior;
use product\models\Product;
use Yii;
use yii\base\Event;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\AfterSaveEvent;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use extended\helpers\Inflector;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use extended\helpers\Html;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $title
 * @property string $title_ru
 * @property string $title_url
 * @property string $text
 * @property string $imageAttribute
 * @property FileImageCategory $image
 * @property string $data
 * @property bool $isParentChanged
 * @property int $old_parent_id
 * @property int $tree_position
 * @property integer $product_count
 * @property boolean $isRoot
 * @property boolean $isLeaf
 * @property boolean $hasChildren
 * @property boolean $enabled
 * @property array $url
 * @method self getThumbImg(string $thumbType, $options=[], $width='auto', $height='auto')
 * @property string imageImg
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    const EVENT_INIT_POSITION_AND_PARENT_ID='EVENT_INIT_POSITION_AND_PARENT_ID';
    public $parent_id;
    public $old_parent_id;
    public $position;

    const EVENT_INIT_DATA = 'EVENT_INIT_DATA';
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute'=>'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_POSITION_AND_PARENT_ID => 'position',
                ],
                'value' => function ($event) {
                    /*  @var $model self */
                    $model = $event->sender;
                    if($parent = $model->parents(1)->one()){
                        $children = $parent->children(1)->all();
                        foreach ($children as $n=>$child)
                            if($child->id==$model->id){
                                $model->position = $n+1;
                                break;
                            }
                        $model->parent_id = $model->old_parent_id = $parent->id;
                    }else
                        $model->position = $model->tree_position;
                    return $model->position;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'data',
                    self::EVENT_BEFORE_UPDATE => 'data',
                ],
                'value' => function ($event) {
                    /*  @var $model self */
                    $model = $event->sender;
                    if(is_array($model->data))
                        return Helper::arrayToJson($model->data);
                    return $model->data;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_DATA => 'data',
                ],
                'value' => function ( $event) {
                    /* @var $model self */
                    $model = $event->sender;
                    $data = Helper::jsonToArray($model->data);
                    foreach ($data as $attr=>$value)
                        $model->$attr = $value;
                    return $model->data;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'data',
                    self::EVENT_BEFORE_UPDATE => 'data',
                ],
                'value' => function ( $event) {
                    /* @var $model self */
                    $model = $event->sender;
                    $data = Helper::jsonToArray($model->data);
                    //$data['title_seo'] = $model->title_seo;
                    return Helper::arrayToJson($data);
                },
            ],
            'title_url_slug'=>[
                'class' => SluggableBehavior::class,
                //'attribute' => 'title',
                'slugAttribute' => 'title_url',
                'value' => function ($event) {
                    $model = $event->sender;
                    $title = '';
                    $parents = $model->parents()->all();
                    foreach ($parents as $n=>$parent)
                        $title.=  ($n==0?'':'/').Inflector::slug($parent->title);
                    $title.= (!$title?'':'/').Inflector::slug($this->title);
                    return $title;
                },
            ],
            [
                'class' => FileImageBehavior::class,
                'className'=>self::class,
                'loader'=>FileImageCategory::class,
                'fileAttributes'=>['imageAttribute'],
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_AFTER_FIND => 'title',
                ],
                'value' => function ($event) {
                    /*  @var $model self */
                    $model = $event->sender;
                    if(Yii::$app->id!='app-backend')
                        return $model->t('title');
                    return $model->title;
                },
            ],
        ];
    }

    //public $title_seo;
    public $imageAttribute;
    /**
     * @return \file\models\query\FileImageQuery
     */
    public function getImage()
    {
        return $this->hasOne(FileImageCategory::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryImage();
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree', 'lft', 'rgt', 'depth'], 'integer'],
            [['tree'], 'default', 'value'=>NULL],
            [['lft', 'rgt', 'depth'], 'default', 'value'=>0],
            [['position'], 'number', ],
            [['tree_position'], 'number', ],
            [['tree_position'], 'default', 'value'=>0],
            [['tree_position'], 'filter', 'filter'=>'floatval'],

            [['text'], 'string'],
            [['title'], 'required'],
            //[['title_ru'], 'safe'],
            [['title'], 'default', 'value'=>''],
            [['title'], 'string', 'max' => 255],

            ['imageAttribute', 'file',
                'extensions' => 'gif, jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/gif',
                'maxSize'=>1024*1024*4,//4 mb
            ],
            [
                'imageAttribute',
                'image',
                'minWidth' => 825,
                'minHeight' => 233,
                'extensions' => 'gif, jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/gif',
            ],
            ['data', 'jsonValidation', ],
            [['title_url'], 'default', 'value'=>''],
            [['product_count','enabled'], 'default', 'value'=>0],
            [['parent_id'], 'safe'],
            /*['parent_id', 'filter', 'filter' => function($parent_id){
                return intval($parent_id);
            }],*/
            ['enabled', 'boolean'],
            //['title_seo', 'string'],
        ];
    }

    public function jsonValidation()
    {
        if($this->data && !is_array(Helper::jsonToArray($this->data, null, false)))
            $this->addError('values', 'Wrong json format');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'tree' => Yii::t('common', 'Tree'),
            'lft' => Yii::t('common', 'Lft'),
            'rgt' => Yii::t('common', 'Rgt'),
            'depth' => Yii::t('common', 'Depth'),
            'title' => Yii::t('common', 'Title'),
            'text' => Yii::t('common', 'Text'),
            'title_url' => Yii::t('common', 'Url'),
            'enabled' => Yii::t('common', 'Enabled'),
            'imageAttribute'=>Yii::t('common', 'Image'),
        ];
    }

    /**
     * @inheritdoc
     * @return \category\models\query\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \category\models\query\CategoryQuery(get_called_class());
    }


    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }


    /**
     * @return \product\models\query\ProductQuery
     */
    /*public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
            //->orOnCondition(['category_id'=>ArrayHelper::map($this->children()->all(), 'id', 'id')]);
    }*/
    public function getChildrenIDs()
    {
        return array_merge([$this->id], ArrayHelper::map($this->children()->all(), 'id', 'id'));
    }
    public function getProducts()
    {
        return $this->hasMany(Product::class, ["category_id"=>"childrenIDs"]);
    }
    public function getDynamicFields()
    {
        return $this->hasMany(DynamicField::class, ["category_id"=>"childrenIDs"]);
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_DELETE, function(Event $event){
            /* @var $model self */
            $model = $event->sender;

            if($model->children(1)->count()>0)
                throw new Exception("This item has childs. You can not delete this item.", 400);

            if($model->getDynamicFields()->exists())
                throw new Exception("Sorry. You must first detach "
                    .Inflector::titleize(Inflector::pluralize(StringHelper::basename(DynamicField::class)), true)." from the "
                    .Inflector::titleize(StringHelper::basename(self::class), true).' '.$model->title, 400);

            if($model->getProducts()->exists())
                throw new Exception("Sorry. You must first detach "
                    .Inflector::titleize(Inflector::pluralize(StringHelper::basename(Product::class)), true)." from the "
                    .Inflector::titleize(StringHelper::basename(self::class), true).' '.$model->title, 400);
        });


        $this->on(static::EVENT_AFTER_INSERT, [$this, 'deleteCache']);
        $this->on(static::EVENT_AFTER_UPDATE, [$this, 'deleteCache']);
        $this->on(static::EVENT_AFTER_DELETE, [$this, 'deleteCache']);

        $this->on(static::EVENT_AFTER_INSERT, [$this, 'saveTreePosition']);
        $this->on(static::EVENT_AFTER_UPDATE, [$this, 'saveTreePosition']);
        $this->on(static::EVENT_AFTER_DELETE, [$this, 'saveTreePosition']);

        $this->on(self::EVENT_AFTER_UPDATE, function(AfterSaveEvent $event){
            /* @var $model self */
            $model = $event->sender;
            if(isset($event->changedAttributes['enabled'])){
                $children = $model->children()->all();
                self::updateAll(['enabled'=>$model->enabled], ['id'=>ArrayHelper::map($children,'id','id')]);
            }
        });
    }


    public static function deleteCache()
    {
        Yii::$app->cache->flush();
    }

    protected function getIsParentChanged()
    {
        return $this->parent_id!=$this->old_parent_id;
    }
    public function saveNode()
    {
        if($this->validate())
        {
            if(!$this->parent_id){
                if($this->isNewRecord || $this->isParentChanged)//if parent is new created, or child moved to root
                    return $this->makeRoot();
                return $this->save();// parent updates itself
            }

            $parent = self::findOne($this->parent_id);
            if($this->position==="0" || $this->position==="1")
                return $this->prependTo($parent);
            if($this->position==="")
                return $this->appendTo($parent);

            if($this->position){
                $brothers = $parent->children(1)->all();
                if(isset($brothers[$this->position-1-1]))
                    return $this->insertAfter($brothers[$this->position-1-1]);
                if(isset($brothers[$this->position-1]))
                    return $this->insertBefore($brothers[$this->position-1]);
            }
            return $this->appendTo($parent);
        }
    }
    public function deleteNode()
    {
        if($this->isRoot())
            return $this->deleteWithChildren();
        return $this->delete();
    }

    public function isBrother($id)
    {
        foreach ($this->brothers()->all() as $brother)
            if($brother->id==$id)
                return true;
    }
    public function brothers()
    {
        if($parent = $this->parents(1)->one())
            $parent->children(1)->andWhere(['id'=>$this->id]);
        return self::find()->andWhere("1=0");
    }
    public function isActive($id, $strict=true)
    {
        if($this->id==$id)
            return true;

        if($strict==false){
            if($this->isBrother($id))
                return false;
            foreach ($this->children()->all() as $parent)
                if($parent->id==$id)
                    return true;
        }
    }

    public function getHasChildren()
    {
        return !$this->isLeaf;
    }
    public function getIsLeaf()
    {
        $delta = $this->rgt - $this->lft;
        return !($delta>1);
    }

    public function getIsRoot()
    {
        return $this->depth==0;
    }

    public function saveTreePosition()
    {
        if($this->position!==null){
            if($this->isRoot)
                self::updateAll(['tree_position'=>(float) $this->position], ['tree'=>$this->id]);
            else{
                $parent = $this->parents()->one();
                if($parent)
                    self::updateAll(['tree_position'=>(float) $parent->tree_position], ['tree'=>$parent->id]);
            }
        }
    }

    public function getUrl()
    {
        return ['/product/product/list', 'category_title_url'=>$this->title_url];
    }

    public function t($field)
    {
        if(Yii::$app->language==Yii::$app->sourceLanguage)
            return $this->$field;

        return Yii::t('db_category', $this->$field);
        /*$language_field = $field.'_'.Yii::$app->language;
        if($this->hasAttribute($language_field) && $this->$language_field)
            return $this->$language_field;
        throw new Exception("Field for language not found.");*/
    }



    public function fields()
    {
        return [
            'id',
            'title' => function (self $model) {
                return $model->t('title');
            },
            'label' => function (self $model) {
                return $model->t('title');
            },
            'url' => function (self $model) {
                $url = Url::to($model->url);
                return $url;
            },
            'left' => 'lft',
            'right' => 'rgt',
            'depth',
            'isLeaf',
            'hasChildren',
            'text',
            'tree',
        ];
    }
    public function extraFields()
    {
        return [
            'imageUrl' => function (self $model) {
                return $model->image ? $model->image->imageUrl:null;
            },
            'parents' => function (self $model) {
                return $model->parents()->all();
            },
        ];
    }
}