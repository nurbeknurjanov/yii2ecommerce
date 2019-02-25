<?php

namespace product\models;

use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;


/**
 * This is the model class for table "{{%product_network}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $network_type
 * @property string $network_id
 * @property string $network_code
 *
 * @property Product $product
 */
class ProductNetwork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_network}}';
    }

    public static function remove(Product $product, $type)
    {
        $productNetwork = ProductNetwork::findOne(['product_id'=>$product->id, 'network_type'=>$type]);
        if($productNetwork)
            $productNetwork->delete();
    }
    public static function removeAll(Product $product)
    {
        ProductNetwork::deleteAll(['product_id'=>$product->id]);
    }
    public static function createOrUpdate(Product $product, $type, $network_id, $network_code)
    {
        $productNetwork = self::findOne(['product_id'=>$product->id,'network_type'=>$type]);
        if(!$productNetwork)
            $productNetwork = new self;

        $productNetwork->product_id = $product->id;
        $productNetwork->network_id = $network_id;
        $productNetwork->network_code = $network_code;
        $productNetwork->network_type = $type;
        if(!$productNetwork->save())
            throw new Exception(Html::errorSummary($productNetwork,['header'=>false]));
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

    const NETWORK_TYPE_INSTAGRAM=1;
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

		$this->network_typeValues = [
		    self::NETWORK_TYPE_INSTAGRAM=>'Instragram'
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'network_type'], 'integer'],
            [['product_id', 'network_type', 'network_id', 'network_code'], 'default', 'value'=>NULL],
            [['network_id', 'network_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('product', 'ID'),
            'product_id' => Yii::t('product', 'Product ID'),
            'network_type' => Yii::t('product', 'Network Type'),
            'network_id' => Yii::t('product', 'Network ID'),
            'network_code' => Yii::t('product', 'Network Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return \product\models\query\ProductNetworkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \product\models\query\ProductNetworkQuery(get_called_class());
    }


	public $network_typeValues;
    public function getNetwork_typeText()
    {
        return isset($this->network_typeValues[$this->network_type]) ? $this->network_typeValues[$this->network_type]:null;
    }

}