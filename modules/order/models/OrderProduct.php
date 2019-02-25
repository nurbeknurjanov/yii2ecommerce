<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use product\models\Product;
use user\models\User;



/**
 * This is the model class for table "order_product".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $user_id
 *
 * @property Order $order
 * @property Product $product
 * @property float $price
 * @property float $amount
 * @property integer $count
 */
class OrderProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_product';
    }

    public function getAmount()
    {
        return (float) $this->count * $this->price;
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'amount'], 'number'],
            [['count'], 'integer', 'min'=>1, 'max'=>1000,],
            [['product_id', 'count', 'price'], 'required'],
            [['order_id', 'product_id'], 'integer'],
            [['order_id'], 'default', 'value'=>0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'order_id' => Yii::t('common', 'Order'),
            'product_id' => Yii::t('product', 'Product'),
            'price' => Yii::t('product', 'Price'),
            'count' => Yii::t('order', 'Count'),
            'amount' => Yii::t('order', 'Amount'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }



}