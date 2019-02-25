<?php

namespace country\models;

use extended\behaviours\SelectPickerBehaviour;
use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%Country}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 */
class Country extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => SelectPickerBehaviour::class,
                'title'=>'name',
            ]
        ];
    }

    public function t($field)
    {
        if(Yii::$app->language==Yii::$app->sourceLanguage)
            return $this->$field;
        $field.= '_'.Yii::$app->language;
        return $this->$field;
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'short_name'], 'required'],
            [['name'], 'default', 'value'=>''],
            [['name'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Country name'),
        ];
    }

    /**
     * @inheritdoc
     * @return \country\models\query\CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \country\models\query\CountryQuery(get_called_class());
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['country_id' => 'id']);
    }


    public static function getDb()
    {
        return Yii::$app->dbCountries;
    }

}