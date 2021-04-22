<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace eav\models;

use Yii;
use yii\base\Event;
use yii\behaviors\AttributeBehavior;
use eav\models\DynamicField AS DF;
use extended\helpers\Helper;
use yii\helpers\Html;

/**
 * This is the model class for table "dynamic_value".
 *
 * @property integer $id
 * @property integer $object_id
 * @property integer $field_id
 * @property DynamicField $field
 * @property string $value
 * @property string $valueFrom
 * @property string $valueTo
 * @property string $valueText
 * @property string $valueLinkText
 * @property boolean $isEmpty
 * @property boolean $isNotEmpty
 * @property DynamicField $_fieldObject
 * @property DynamicField $fieldObject
 */
class DynamicValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoci
     */

    public $valueFrom;
    public $valueTo;
    public function loadRequestData()
    {
        $request = Yii::$app->request;

        $field = $this->fieldObject;

        if($request->isPost && isset($request->post()[$this->formName()][$this->field_id]))
            $this->load($request->post()[$this->formName()][$this->field_id], '');
        elseif($request->isPost && isset($request->post()[$this->formName()][$this->field->key]))
            $this->load($request->post()[$this->formName()][$this->field->key], '');
        elseif($request->isGet && isset($request->queryParams[$this->formName()][$this->field_id]))
            $this->load($request->queryParams[$this->formName()][$this->field_id], '');
        elseif($request->isGet && isset($request->queryParams[$this->formName()][$field->key]))
            $this->load($request->queryParams[$this->formName()][$field->key], '');
        else{
            //for frontend
            if($request->get($field->key)){
                if(is_string($request->get($field->key)) && strpos($request->get($field->key), '-')!==false)
                    $this->value = explode('-',$request->get($field->key));
                else
                    $this->value = $request->get($field->key);
            }
            if($request->get($field->key.'From'))
                $this->valueFrom = $request->get($field->key.'From');
            if($request->get($field->key.'To'))
                $this->valueTo = $request->get($field->key.'To');
        }
    }

    public static function tableName()
    {
        return 'dynamic_value';
    }

    /**
     * @inheritdoc
     * @return \eav\models\query\DynamicValueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \eav\models\query\DynamicValueQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes'=>[
                    self::EVENT_BEFORE_VALIDATE => ['value'],
                ],
                'value' => function (Event $event) {
                    /* @var $model self */
                    $model = $event->sender;
                    if(is_array($model->value))
                        $model->value=implode(',',$model->value);
                    return $model->value;
                },
            ],
        ];
    }


    public function getIsEmpty()
    {
        return ($this->value===null || $this->value==='' || $this->value===[]) && !$this->valueFrom && !$this->valueTo;
    }
    public function getIsNotEmpty()
    {
        return !$this->isEmpty;
    }
    public function getValueText($delimiter=", ")
    {
        $field = $this->fieldObject;
        if(in_array($field->type, [DF::TYPE_INPUT,DF::TYPE_AREA]))
            return $this->value;

        if(is_array($this->value) || in_array($field->type, [DF::TYPE_DROP_DOWN_LIST_MULTIPLE,DF::TYPE_CHECKBOX_LIST]) && $this->isNotEmpty) {
            $return=[];
            if(is_array($this->value))
                $value = $this->value;
            else
                $value = explode(',', $this->value);
            foreach ($value as $val)
                $return[]=isset(Helper::jsonToArray($field->json_values)[$val]) ? Helper::jsonToArray($field->json_values)[$val]:null;
            return implode($delimiter,$return);
        }

        if(in_array($field->type, [DF::TYPE_DROP_DOWN_LIST,DF::TYPE_RADIO_LIST]) && $this->isNotEmpty)
            return isset(Helper::jsonToArray($field->json_values)[$this->value]) ? Helper::jsonToArray($field->json_values)[$this->value]:null;

    }
    public function getValueLinkText()
    {
        $field = $this->fieldObject;
        $value = $this->value;
        if(in_array($field->type, [DF::TYPE_INPUT,DF::TYPE_AREA]))
            $value = $this->value;
        if(in_array($field->type, [DF::TYPE_DROP_DOWN_LIST,DF::TYPE_RADIO_LIST]) && $this->isNotEmpty){
            if(isset(Helper::jsonToArray($field->json_values)[$this->value]))
                $value = Helper::jsonToArray($field->json_values)[$this->value];
        }
        if(in_array($field->type, [DF::TYPE_DROP_DOWN_LIST_MULTIPLE,DF::TYPE_CHECKBOX_LIST]) && $this->isNotEmpty)
        {
            if(is_array($this->value))
                $values = $this->value;
            else
                $values = explode(',', $this->value);
            foreach ($values as $n=>$val){
                $value = $val;
                if(isset(Helper::jsonToArray($field->json_values)[$val]))
                    $val = Helper::jsonToArray($field->json_values)[$val];
                if($field->clickable)
                    $val = Html::a($val, ['/product/product/list', $field->key=>$value]);
                $values[$n] = $val;
            }
            return implode(', ',$values);
        }
        if($field->clickable)
            $value = Html::a($value, ['/product/product/list', $field->key=>$this->value]);
        return $value;
    }

    public function getField()
    {
        return $this->hasOne(DynamicField::class, ['id' => 'field_id']);
    }

    /**
     * @inheritdoc
     */
    public $rules=[
        [['field_id', 'object_id'], 'required'],
        [['field_id', 'object_id'], 'integer'],
        [['value'], 'safe'],
        //[['value'], 'string', 'max'=>1000],
    ];
    public function rules()
    {
        return $this->rules;
    }

    public function setDynamicRules()
    {
        $field = $this->fieldObject;
        foreach ($field->ruleArray as $rule){
            $dynamicRule = [['value'], $rule];
            if(isset($field->ruleValuesOptions[$rule]))
                foreach ($field->ruleValuesOptions[$rule] as $optionKey=>$optionValue)
                    $dynamicRule[$optionKey]=$optionValue;
            $this->rules[]=$dynamicRule;
        }
    }

    /**
     * @inheritdoc
     */
    public $valueLabel;
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'object_id' => Yii::t('common', 'Object ID'),
            'field_id' => Yii::t('common', 'Field ID'),
            'value' => $this->valueLabel ? $this->valueLabel:Yii::t('common', 'Value'),
        ];
    }

    public $_fieldObject;
    public function getFieldObject()
    {
        if($this->_fieldObject)
            return $this->_fieldObject;
        return $this->_fieldObject = $this->field;
    }


    public function fields()
    {
        return [
            'id',
            'object_id',
            'field_id',
            'value',
            'valueText' => function (self $model) {
                return $model->valueText;
            },
        ];
    }

    public function extraFields()
    {
        return [
            'field' => function (self $model) {
                return $model->field;
            },
        ];
    }


}
