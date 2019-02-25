<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models;

use category\models\Category;
use extended\behaviours\SelectPickerBehaviour;
use product\models\FileImageProduct;
use comment\models\Comment;
use eav\models\DynamicField;
use eav\models\DynamicValue;
use eav\models\query\DynamicFieldQuery;
use eav\models\query\DynamicValueQuery;
use extended\helpers\Inflector;
use extended\behaviours\ManyToManyBehaviour;
use file\models\FileImage;
use file\models\behaviours\FileImageBehavior;
use file\models\query\FileImageQuery;
use order\models\Order;
use order\models\OrderProduct;
use product\models\query\ProductNetworkQuery;
use product\models\query\ProductQuery;
use product\models\query\RatingQuery;
use yii\base\Exception;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use Yii;
use yii\behaviors\AttributeBehavior;
use user\models\User;
use yii\db\AfterSaveEvent;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $title_url
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $statusText
 * @property array $statusValues
 * @property array $productCategories
 * @property integer $category_id
 * @property Category $category
 * @property Category[] $categories
 * @property FileImage $mainImage
 * @property FileImage[] $images
 * @property float $price
 * @property integer $discount
 * @property string $discountText
 * @property integer $type
 * @property array $typeArray
 * @property string $typeText
 * @property array $typeValues
 * @property integer $sku
 * @property array $comments
 * @property DynamicValue[] $values
 * @property DynamicValue[] $valuesWithFields
 * @property string $valuesText
 * @property array $buyWithThisAttribute
 * @property array $buyWithThisProducts
 * @property array $buyProducts
 * @property array $url
 * @property DynamicField[] $fieldModels
 * @property DynamicValue[] $valueModels
 *
 * @property float $rating
 * @property array $ratings
 * @property Rating $bestRating
 * @property float $rating_count
 * @property bool $enabled
 * @property bool $isNovelty
 * @property bool $isPromote
 * @property bool $isPopular
 * @property string $typeClass
 * @property integer $group_id
 * @property array $groupedProductsAttribute
 * @property array $groups
 * @property boolean $canBeParentOfGroup
 * @property boolean $isGrouped
 * @property boolean $isGroupChild
 * @property Product $groupParent
 * @property ProductNetwork $productNetwork
 * @property ProductNetwork $productNetworkInstagram
 * @property string $externalNetworkText
 * @property string $skuText
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }


    const EVENT_INIT_FIELDS_OF_MANY_TO_MANY='EVENT_INIT_FIELDS_OF_MANY_TO_MANY';
    const EVENT_INIT_DYNAMIC_FIELDS='EVENT_INIT_DYNAMIC_FIELDS';
    public $valueModels=[];
    public $fieldModels=[];
    public function saveDynamicValues()
    {
        $queryToDelete = DynamicValue::find()->defaultFrom()->andWhere(['object_id'=>$this->id]);
        foreach ($this->valueModels as $valueModel)
            if($valueModel->isNotEmpty){
                $valueModel->object_id=$this->id;
                if(!$valueModel->save())
                    throw new Exception(Html::errorSummary($valueModel), 400);
                $queryToDelete->andWhere(['!=', 'id', $valueModel->id]);
            }

        DynamicValue::deleteAll($queryToDelete->where);
        return true;
    }
    public function loadDynamicData()
    {
        foreach ($this->valueModels as &$valueModel){
            $valueModel->loadRequestData();
        }
    }
    public function setDynamicRules()
    {
        foreach ($this->valueModels as &$valueModel){
            $valueModel->loadRequestData();
        }
    }

    public function behaviors()
    {
        return [
            'fieldModelsBehavior'=>[
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_DYNAMIC_FIELDS => 'fieldModels',
                    self::EVENT_INIT_DYNAMIC_FIELDS => 'fieldModels',
                ],
                'value' => function ($event) {
                    /* @var self $model */
                    /* @var DynamicField[] $fieldModels */
                    $model = $event->sender;
                    $model->valueModels=[];
                    $model->fieldModels = DynamicField::find()
                        ->defaultFrom()
                        ->defaultOrder()
                        ->enabled()
                        ->categoryQuery($model->category_id, true, true, true)
                        ->orKeyQuery()
                        ->indexBy('id')->all();
                    foreach ($model->fieldModels as $fieldModel)
                        $model->valueModels[$fieldModel->id]=$fieldModel->getValueObject($model->id);
                    return $model->fieldModels;
                },
            ],
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
                    self::EVENT_BEFORE_INSERT => ['type'],
                    self::EVENT_BEFORE_UPDATE => 'type',
                ],
                'value' => function ($event) {
                    /* @var $model self */
                    $model = $event->sender;
                    if(is_array($model->type))
                        return implode(',', $model->type);
                    return $model->type;
                },
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_FIELDS_OF_MANY_TO_MANY => 'buyWithThisAttribute',
                ],
                'value' => function ($event) {
                    /* @var self $model */
                    $model = $event->sender;
                    $model->buyWithThisAttribute = ArrayHelper::map($model->buyProducts, 'id', 'id');
                    $model->attachBehavior('buyWithThisBehavior', [
                        'class' => ManyToManyBehaviour::class,
                        'manyAttribute'=>'buyWithThisAttribute',
                        'manyAttributeOldValue'=>$model->buyWithThisAttribute,
                        'saveFunction'=>'saveBuyWithThisProducts',
                    ]);
                    return $model->buyWithThisAttribute;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_FIELDS_OF_MANY_TO_MANY => 'groupedProductsAttribute',
                ],
                'value' => function ($event) {
                    /* @var self $model */
                    $model = $event->sender;
                    if($model->canBeParentOfGroup){
                        $model->groupedProductsAttribute = ArrayHelper::map($model->groups, 'id', 'id');
                        $model->attachBehavior('groupedProductsBehavior', [
                            'class' => ManyToManyBehaviour::class,
                            'manyAttribute'=>'groupedProductsAttribute',
                            'manyAttributeOldValue'=>$model->groupedProductsAttribute,
                            'saveFunction'=>'saveGroupedProducts',
                        ]);
                        return $model->groupedProductsAttribute;
                    }
                },
            ],
            [
                'class' => FileImageBehavior::class,
                'className'=>self::class,
                'loader'=>FileImageProduct::class,
                'fileAttributes'=>['imagesAttribute'],
            ],
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
            'title_url_slug'=>[
                'class' => SluggableBehavior::class,
                //'attribute' => 'title',
                'slugAttribute' => 'title_url',
                'value' => function ($event) {
                    $model = $event->sender;
                    $title = $model->category->title_url;
                    return $title."/".Inflector::slug($this->title);
                },
            ],
            [
                'class' => SelectPickerBehaviour::class,
            ],
        ];
    }
    public $groupedProductsAttribute;
    public $imagesAttribute;
    /**
     * @return FileImageQuery
     */
    public function getImages()
    {
        return $this->hasMany(FileImage::class, ['model_id' => 'id'])
            ->defaultFrom()
            ->queryClassName(self::class)->queryImages();
    }
    /**
     * @return FileImageQuery
     */
    public function getMainImage()
    {
        return $this->hasOne(FileImage::class, ['model_id' => 'id'])
            ->defaultFrom()
            ->queryClassName(self::class)->queryMainImage();
    }


    public $buyWithThisAttribute;
    public function attributes()
    {
        $attributes = parent::attributes();
        $attributes[] = 'buyWithThisAttribute';
        $attributes[] = 'groupedProductsAttribute';
        return $attributes;
    }
    public function saveBuyWithThisProducts()
    {
        $toDeleteRecords=[];
        $elementsToDelete = array_diff((array) $this->getOldAttribute('buyWithThisAttribute'), (array) $this->buyWithThisAttribute);
        if($elementsToDelete)
            $toDeleteRecords = ProductBuyWithThis::find()
                ->andWhere(['product_id'=>$this->id])
                ->andWhere(['buy_product_id'=>$elementsToDelete])
                ->all();

        $transaction = Yii::$app->db->beginTransaction();
        try {

            foreach ($toDeleteRecords as $record)
                $record->delete();

            if($this->buyWithThisAttribute){
                if(is_array($this->buyWithThisAttribute)){
                    foreach ($this->buyWithThisAttribute as $buy_product_id)
                        ProductBuyWithThis::createIfNotExists($this->id, $buy_product_id);
                }
                else
                    ProductBuyWithThis::createIfNotExists($this->id, $this->buyWithThisAttribute);
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }


    }


    public function saveGroupedProducts()
    {
        $elementsToDelete = array_diff((array) $this->getOldAttribute('groupedProductsAttribute'), (array) $this->groupedProductsAttribute);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->deleteFromGroup($elementsToDelete);
            $this->addToGroup($this->groupedProductsAttribute);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    public function deleteFromGroup($productIDs)
    {
        if($productIDs){
            if(is_array($productIDs))
                foreach ($productIDs as $productID)
                    Product::findOne($productID)->updateAttributes(['group_id'=>null]);
            else
                Product::findOne($productIDs)->updateAttributes(['group_id'=>null]);
            $this->updateGroupID();
        }
    }
    public function addToGroup($productIDs)
    {
        if($productIDs){
            if(is_array($productIDs))
                foreach ($productIDs as $productID)
                    Product::findOne($productID)->updateAttributes(['group_id'=>$this->id]);
            else
                Product::findOne($productIDs)->updateAttributes(['group_id'=>$this->id]);
            $this->updateGroupID();
        }
    }
    public function updateGroupID()
    {
        unset($this->groups);
        if(!$this->groups)
            $this->updateAttributes(['group_id'=>null]);
        else
            $this->updateAttributes(['group_id'=>$this->id]);
    }

    public function getBuyWithThisProducts()
    {
        return $this->hasMany(ProductBuyWithThis::class, ['product_id'=>'id']);
    }
    public function getBuyProducts()
    {
        return $this->hasMany(Product::class, ['id'=>'buy_product_id'])->via('buyWithThisProducts');
    }




    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::class, ['product_id'=>'id']);
    }
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id'=>'category_id'])->via('productCategories');
    }
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id'=>'category_id']);
    }


    const STATUS_EXISTS=1;
    const STATUS_GONE=0;
    const STATUS_ENDING=2;
    public function getStatusValues()
    {
        return [
            self::STATUS_EXISTS=>Yii::t('product', 'Exists'),
            self::STATUS_GONE=>Yii::t('product', 'Gone'),
            self::STATUS_ENDING=>Yii::t('product', 'Ending'),
        ];
    }
    public function getStatusText()
    {
        return isset($this->statusValues[$this->status]) ? $this->statusValues[$this->status]:null;
    }




    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_INSERT, function($event){
            /* @var $model self */
            $model = $event->sender;
            $category = $model->category;
            $category->updateAttributes(['product_count'=>$category->getProducts()->count()]);
            $parents = $category->parents()->all();
            foreach ($parents as $category)
                $category->updateAttributes(['product_count'=>$category->getProducts()->count()]);
        });
        $this->on(self::EVENT_AFTER_DELETE, function($event){
            /* @var $model self */
            $model = $event->sender;
            $category = $model->category;
            $category->updateAttributes(['product_count'=>$category->getProducts()->count()]);
            $parents = $category->parents()->all();
            foreach ($parents as $category)
                $category->updateAttributes(['product_count'=>$category->getProducts()->count()]);
        });
        $this->on(self::EVENT_AFTER_UPDATE, function(AfterSaveEvent $event){
            /* @var $model self */
            $model = $event->sender;
            if(isset($event->changedAttributes['category_id'])){
                $category = $model->category;
                $category->updateAttributes(['product_count'=>$category->getProducts()->count()]);
                $parents = $category->parents()->all();
                foreach ($parents as $category)
                    $category->updateAttributes(['product_count'=>$category->getProducts()->count()]);

                $oldCategory = Category::findOne($event->changedAttributes['category_id']) ;
                $oldCategory->updateAttributes(['product_count'=>$oldCategory->getProducts()->count()]);
                $parents = $oldCategory->parents()->all();
                foreach ($parents as $category)
                    $category->updateAttributes(['product_count'=>$category->getProducts()->count()]);
            }
        });

        $this->on(self::EVENT_AFTER_DELETE, function($event){
            /* @var $model self */
            $model = $event->sender;
            if($model->isGroupChild)
                $model->groupParent->updateGroupID();

            ProductNetwork::removeAll($model);
        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'category_id'=>['category_id', 'required'],
            'category_id_intval'=>['category_id', 'filter', 'filter'=>'intval',],
            [['title','status', 'price'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'description', 'title_url'], 'default', 'value'=>''],
            [['user_id', 'status'], 'default', 'value'=>0],
            [['created_at', 'updated_at'], 'default', 'value'=>'0000-00-00 00:00:00'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'default', 'value' => ''],
            [['discount'], 'number'],
            ['imagesAttribute', 'file',
                'extensions' => 'gif, jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/gif',
                'maxFiles'=>10,
                'maxSize'=>1024*1024*4,//4 mb
            ],
            ['type', 'default', 'value'=>NULL,],
            ['group_id', 'integer'],
            ['sku', 'string'],
            //['sku', 'unique'],
            [['buyWithThisAttribute', 'groupedProductsAttribute'], 'safe'],
            [['rating_count','enabled'], 'default',  'value'=>0,],
            ['enabled', 'boolean'],
            ['groupedProductsAttribute', 'groupedProductsAttributeValidation'],
        ];
    }

    public function groupedProductsAttributeValidation()
    {
        if($this->groupedProductsAttribute){
            if(!$this->canBeParentOfGroup)
                $this->addError('groupedProductsAttribute', "Product '$this->title' can not be parent of group.");
            foreach ($this->groupedProductsAttribute as $product_id){
                $product = Product::findOne($product_id);
                if(!$product->canBeChildOfGroup($this->id))
                    $this->addError('groupedProductsAttribute', "Product '$product->title' can not be child of '{$this->title}'s group.");
            }
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'status' => Yii::t('common', 'Status'),
            'imagesAttribute' => Yii::t('common', 'Images'),
            'sku' => Yii::t('product', 'SKU'),
            'price' => Yii::t('product', 'Price'),
            'buyWithThisAttribute' => Yii::t('product', 'Buy with'),
            'enabled' => Yii::t('product', 'Enabled'),
        ];
    }

    /**
     * @inheritdoc
     * @return \product\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \product\models\query\ProductQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }






    public function getSkuText()
    {
        if($this->sku)
            return $this->sku;
        return "000-".$this->id;
    }
    public function getUrl()
    {
        return Url::to(['/product/product/view', 'id'=>$this->id, 'title_url'=>$this->title_url]);
    }
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['model_id'=>'id'])->defaultFrom()->andOnCondition(['comment.model_name'=>'product\models\Product']);
    }


    const TYPE_PROMOTE=1;
    const TYPE_POPULAR=2;
    const TYPE_NOVELTY=3;
    public function getTypeValues()
    {
        return [
            self::TYPE_PROMOTE=>Yii::t('product', 'Promotion'),
            self::TYPE_POPULAR=>Yii::t('product', 'Popular'),
            self::TYPE_NOVELTY=>Yii::t('product', 'Novelties'),
        ];
    }
    public function getTypeArray()
    {
        if($this->type)
            return explode(',', $this->type);
        return [];
    }
    public function getIsPromote()
    {
        return in_array(self::TYPE_PROMOTE, $this->typeArray);
    }
    public function getIsNovelty()
    {
        return in_array(self::TYPE_NOVELTY, $this->typeArray);
    }
    public function getIsPopular()
    {
        return in_array(self::TYPE_POPULAR, $this->typeArray);
    }
    public function getTypeClass()
    {
        $class=[];
        if($this->isNovelty)
            $class[]='new';
        if($this->isPopular)
            $class[]='hit';
        if($this->isPromote && $this->discount){
            $class[]='promote';
        }
        return implode(' ', $class);
    }
    public function getTypeText($separator=', ')
    {
        $types = [];
        if($this->typeArray){
            foreach ($this->typeArray as $type) {
                if(isset($this->typeValues[$type]))
                    $types[] = $this->typeValues[$type];
            }
        }
        return implode($separator, $types);
    }

    /**
     * @return ProductQuery
     */
    public function getGroups()
    {
        if($this->isGroupChild)
            $query = $this->hasMany(Product::class, ['group_id' => 'group_id']);
        else
            $query = $this->hasMany(Product::class, ['group_id' => 'id']);
        $query->andOnCondition(['!=','id',$this->id]);
        return $query;
    }
    /**
     * @return ProductQuery
     */
    public function getGroupParent()
    {
        return $this->hasOne(Product::class, ['id' => 'group_id']);
    }


    /**
     * @return DynamicValueQuery
     */
    public function getValues()
    {
        return $this->hasMany(DynamicValue::class, ['object_id' => 'id']);
    }
    /**
     * @return DynamicValueQuery
     */
    public function getValuesWithFields()
    {
        /* @var DynamicFieldQuery $query */
        $query = $this->getValues();
        $query->joinWith(['field'=>function(DynamicFieldQuery $dynamicFieldQuery){
            $dynamicFieldQuery->defaultFrom();
            $dynamicFieldQuery->defaultOrder();
        }]);
        $query->indexBy(function(DynamicValue $value){
            return $value->field->key;
        });
        return $query;
    }

    /**
     * @return string
     */
    public function getValuesText($separator=', ', $condition=null)
    {
        /* @var DynamicFieldQuery $query */
        $query = $this->getValuesWithFields();
        if($condition)
            $query->andWhere($condition);
        $query->orderBy("dynamic_field.position");
        $values = $query->all();
        $values = ArrayHelper::map($values, "id", function(DynamicValue $value){
            $field = $value->field;
            $text = $value->valueText;
            if($field->unit)
                $text.=' '.$field->unit;
            if($field->with_label)
                $text = $field->label.': '.$text;
            return $text;
        });
        return implode($separator, $values);
    }


    /**
     * @return RatingQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::class, ['product_id' => 'id']);
    }
    /**
     * @return RatingQuery
     */
    public function getHighFactorRating()
    {
        Yii::$app->db->createCommand("SET sql_mode = '';")->execute();
        /*
        SELECT * FROM product_rating r INNER JOIN (SELECT MAX(mark) AS max_mark, product_id, id FROM product_rating
                                           WHERE product_id=1
                                           GROUP BY product_id) m
ON m.max_mark = r.mark
    AND m.product_id = r.product_id
    */
        /* return $this->hasOne(Rating::class, ['product_id' => 'id'])->defaultFrom()
             ->innerJoin("(SELECT MAX(mark) AS max_mark, product_id, id FROM product_rating
                                            WHERE product_id='{$this->id}'
                                            GROUP BY product_id) m ON m.max_mark=rating.mark")
             ;*/
        //MOD
        /* @var $ratingQuery RatingQuery */
        $ratingQuery = $this->hasOne(Rating::class, ['product_id' => 'id']);
        $ratingQuery->defaultFrom();
        $ratingQuery->orderBy("factor DESC");
        $ratingQuery->limit(1);
        return $ratingQuery;
    }
    public function updateRatingValue()
    {
        $ratingCount = $this->getRatings()->count();

        $marks = $this->getRatings()->select("SUM(mark*(factor))")->positiveVote()->createCommand()->queryScalar();
        $factors = $this->getRatings()->select("SUM(factor)")->positiveVote()->createCommand()->queryScalar();
        if($factors)
            $ratingValue = $marks/$factors;
        else
            $ratingValue=null;
        $this->updateAttributes(['rating'=>$ratingValue ? $ratingValue:null, 'rating_count'=>$ratingCount]);
    }







    public function getProductOrders()
    {
        return $this->hasMany(OrderProduct::class, ['product_id'=>'id']);
    }
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['id'=>'order_id'])->via('productOrders')->from(['o'=>Order::tableName()]);
    }

    /**
     * @return ProductNetworkQuery
     * */
    public function getProductNetwork()
    {
        return $this->hasOne(ProductNetwork::class, ['product_id'=>'id']);
    }
    public function getProductNetworkInstagram()
    {
        return $this->getProductNetwork()->instagram();
    }

    public function getExternalNetworkText()
    {
        return implode("\n", [
            $this->title,
            $this->getAttributeLabel('sku').': '.$this->skuText,
            $this->getAttributeLabel('price').': '.Yii::$app->formatter->asCurrency($this->price),
            //Yii::$app->urlManagerFrontend->createAbsoluteUrl($this->url)
        ]);
    }

    public function getDiscountText()
    {
        if($this->discount)
            return $this->discount.'%';
    }

    public function getIsGrouped()
    {
        return (boolean) $this->group_id;
    }
    public function getIsGroupChild()
    {
        return $this->isGrouped && $this->id!=$this->group_id;
    }
    public function getCanBeParentOfGroup()
    {
        if($this->isNewRecord)
            return true;
        if(!$this->group_id)
            return true;
        if($this->id==$this->group_id)
            return true;
        return false;
    }
    public function canBeChildOfGroup($group_id)
    {
        if($this->id==$this->group_id)
            return false;
        if($this->isNewRecord)
            return true;
        if(!$this->group_id)
            return true;
        if($group_id==$this->group_id)
            return true;
        return false;
    }

}