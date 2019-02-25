<?php

namespace setting\models;

use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $key
 * @property string $keyText
 * @property array $keyValues
 * @property string $value
 * @property string $fieldType
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'unique'],
            [['key', 'value'], 'required'],
            [['value'], 'string'],
            [['key', 'value'], 'default', 'value'=>''],
            [['key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'key' => Yii::t('common', 'Key'),
            'value' => Yii::t('common', 'Value'),
        ];
    }

    /**
     * @inheritdoc
     * @return \setting\models\query\SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \setting\models\query\SettingQuery(get_called_class());
    }


    const HOMEPAGE_CONTENT='HOMEPAGE_CONTENT';
    const BEFORE_HEAD_CONTENT='BEFORE_HEAD_CONTENT';
    const BEFORE_BODY_CONTENT='BEFORE_BODY_CONTENT';
    const MAINTENANCE_MODE='MAINTENANCE_MODE';
    const ALLOW_REGISTRATION='ALLOW_REGISTRATION';
    const ALLOW_LOGIN='ALLOW_LOGIN';
    const NO_SEARCH_RESULTS_FOUND='NO_SEARCH_RESULTS_FOUND';
    public function getKeyValues()
    {
        return [
            self::HOMEPAGE_CONTENT=>'Homepage Content',
            self::BEFORE_HEAD_CONTENT=>'Before Head Content',
            self::BEFORE_BODY_CONTENT=>'Before Body Content',
            self::MAINTENANCE_MODE=>'Maintenance Mode',
            self::ALLOW_REGISTRATION=>'Allow Registration',
            self::ALLOW_LOGIN=>'Allow Login',
            self::NO_SEARCH_RESULTS_FOUND=>'No Search Results Found',
        ];
    }
    public function getKeyText()
    {
        if(isset($this->keyValues[$this->key]))
            return $this->keyValues[$this->key];
        return $this->key;
    }

    public static function getValue($key)
    {
        if($setting = self::find()->key($key)->one())
            return $setting->value;
        //default values
        switch ($key){
            case self::ALLOW_REGISTRATION : return 1; break;
            case self::MAINTENANCE_MODE : return 0; break;
            case self::ALLOW_LOGIN : return 1; break;
            case self::NO_SEARCH_RESULTS_FOUND : return Yii::t('yii', 'No results found.'); break;
        }
    }

    public $fieldTypeValues=[
        'textarea'=>[self::BEFORE_HEAD_CONTENT, self::BEFORE_BODY_CONTENT],
        'ckeditor'=>[self::HOMEPAGE_CONTENT, self::NO_SEARCH_RESULTS_FOUND],
        'checkbox'=>[self::MAINTENANCE_MODE, self::ALLOW_REGISTRATION, self::ALLOW_LOGIN],
    ];
    public function getFieldType()
    {
        foreach ($this->fieldTypeValues as $fieldType=>$keys)
            if(in_array($this->key, $keys))
                return $fieldType;
        return 'textinput';
    }
}