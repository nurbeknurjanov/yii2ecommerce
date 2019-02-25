<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models;

use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;


/**
 * This is the model class for table "{{%product_buy_with_this}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $buy_product_id
 *
 * @property Product $product
 * @property Product $buyProduct
 */
class ProductBuyWithThis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_buy_with_this}}';
    }


    public static function createIfNotExists($product_id, $buy_product_id)
    {
        if(!self::findOne(['product_id'=>$product_id,'buy_product_id'=>$buy_product_id])){
            $model = new self(['product_id'=>$product_id,'buy_product_id'=>$buy_product_id]);
            if(!$model->save())
                throw new Exception(Html::errorSummary($model));
        }
    }
 


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'buy_product_id'], 'required'],
            [['product_id', 'buy_product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'product_id' => Yii::t('common', 'Product'),
            'buy_product_id' => Yii::t('common', 'Buy product'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'buy_product_id']);
    }



}