<?php

namespace user\models;

use country\models\City;
use country\models\Country;
use country\models\query\CityQuery;
use country\models\Region;
use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $id
 * @property integer $country_id
 * @property integer $region_id
 * @property string $city_id
 * @property string $zip_code
 * @property string $address
 * @property User $userObject
 * @property User $user
 *
 * @property Country $country
 * @property Region $region
 * @property City $city
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'region_id', 'city_id'], 'integer'],
            [['address', 'zip_code'], 'default', 'value'=>''],
            [['country_id', 'region_id', 'city_id', 'address'], 'required'],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'Country'),
            'region_id' => Yii::t('app', 'Region'),
            'city_id' => Yii::t('app', 'City'),
            'zip_code' => Yii::t('app', 'Postal/ZIP Code'),
            'address' => Yii::t('app', 'Address'),
        ];
    }



    /**
     * @inheritdoc
     * @return \user\models\query\UserProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \user\models\query\UserProfileQuery(get_called_class());
    }




    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return CityQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    private $_user;
    public function setUserObject($value)
    {
        $this->_user = $value;
    }
    public function getUserObject()
    {
        if($this->_user)
            return $this->_user;
        return $this->_user = $this->user;
    }

    public function fields()
    {
        return [
            'id',
            'cityName'=>function(self $model){
                return $model->city->name;
            },
            'regionName'=>function(self $model){
                return $model->region->name;
            },
            'countryName'=>function(self $model){
                return $model->country->name;
            },
            'address',
            'zip_code',
            'country_id',
            'region_id',
            'city_id',
        ];
    }
}