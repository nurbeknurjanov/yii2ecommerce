<?php

namespace setting\models;

use extended\helpers\Helper;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use Yii;
use yii\base\Model;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;


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
class JsonRow extends Model
{

    public $id;
    public $json_key;
    public $json_value;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['json_key'], 'unique'],
            [['json_key'], 'required'],
            [['json_value'], 'string'],
            [['json_key', 'json_value'], 'default', 'value'=>''],
            [['json_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'json_key' => Yii::t('common', 'Key'),
            'json_value' => Yii::t('common', 'Value'),
        ];
    }

}