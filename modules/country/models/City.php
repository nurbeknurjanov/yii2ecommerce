<?php

namespace country\models;

use extended\behaviours\SelectPickerBehaviour;
use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Url;


/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $region_id
 *
 * @property Region $region
 * @property Order[] $orders
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    const BIG_VALUES=[
        //36718,37006
    ];
    public function behaviors()
    {
        return [
            [
                'class' => SelectPickerBehaviour::class,
                'title'=>'name',
                'ajaxUrl'=>Url::to(['/country/city/select-picker']),
            ]
        ];
    }


    public function t($field)
    {
        if(Yii::$app->language==Yii::$app->sourceLanguage)
            return $this->$field;
        $field.= '_'.Yii::$app->language;
        if($this->hasAttribute($field))
            return $this->$field;
        throw new Exception("Field for language not found.");
    }




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'region_id'], 'required'],
            [['region_id'], 'integer'],
            [['name'], 'default', 'value'=>''],
            [['region_id'], 'default', 'value'=>0],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'region_id' => Yii::t('common', 'Region ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['city_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \country\models\query\CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \country\models\query\CityQuery(get_called_class());
    }

    public static function getDb()
    {
        return Yii::$app->dbCountries;
    }

}