<?php

namespace country\models;

use extended\behaviours\SelectPickerBehaviour;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Url;


/**
 * This is the model class for table "{{%region}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 *
 * @property City[] $cities
 * @property Order[] $orders
 * @property Country $country
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    public function t($field)
    {
        if(Yii::$app->language==Yii::$app->sourceLanguage)
            return $this->$field;
        $field.= '_'.Yii::$app->language;
        return $this->$field;
    }

    public function behaviors()
    {
        return [
            [
                'class' => SelectPickerBehaviour::class,
                'title'=>'name',
                'ajaxUrl'=>Url::to(['/country/region/select-picker']),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'country_id'], 'required'],
            [['country_id'], 'integer'],
            [['country_id'], 'default', 'value'=>NULL],
            [['name'], 'default', 'value'=>''],
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
            'country_id' => Yii::t('common', 'Country ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @inheritdoc
     * @return \country\models\query\RegionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \country\models\query\RegionQuery(get_called_class());
    }

    public static function getDb()
    {
        return Yii::$app->dbCountries;
    }

}