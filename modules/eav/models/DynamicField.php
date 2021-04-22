<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace eav\models;

use extended\helpers\Helper;
use Yii;
use yii\base\Event;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use extended\helpers\Html;
use eav\models\query\DynamicFieldQuery;
use category\models\Category;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "dynamic_field".
 *
 * @property integer $id
 * @property string $label
 * @property string $key
 * @property integer $type
 * @property string $typeText
 * @property boolean $enabled
 * @property string $enabledText
 * @property string $json_values
 * @property DynamicValue[] $values
 * @property DynamicValue $value
 * @property string $rule
 * @property string $ruleText
 * @property array $ruleArray
 * @property string $default_value
 * @property integer $category_id
 * @property Category $category
 * @property string $resultText
 * @property string $unit
 * @property DynamicValue $valueObject
 * @property DynamicValue $_valueModel
 * @property float $position
 * @property integer $section
 * @property boolean $with_label
 * @property boolean $clickable
 * @property string $data
 * @property boolean $input_fields
 * @property boolean $slider
 * @property float $min
 * @property float $max
 * @property bool $isMultiple
 */
class DynamicField extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dynamic_field';
    }

    /**
     * @inheritdoc
     * @return \eav\models\query\DynamicFieldQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \eav\models\query\DynamicFieldQuery(get_called_class());
    }

    public function getIsMultiple()
    {
        return $this->json_values;
    }
    const TYPE_INPUT = 1;
    const TYPE_AREA = 2;
    const TYPE_DROP_DOWN_LIST = 3;
    const TYPE_DROP_DOWN_LIST_MULTIPLE = 4;
    const TYPE_RADIO_LIST = 5;
    const TYPE_CHECKBOX_LIST = 6;
    public $typeValues = [
        self::TYPE_INPUT=>'textInput',
        self::TYPE_AREA=>'textArea',
        self::TYPE_DROP_DOWN_LIST=>'dropDownList',
        self::TYPE_DROP_DOWN_LIST_MULTIPLE=>'dropDownListMultiple',
        self::TYPE_RADIO_LIST=>'radioList',
        self::TYPE_CHECKBOX_LIST=>'checkboxList',
    ];
    public function getTypeText()
    {
        return $this->typeValues[$this->type];
    }

    const SECTION_SEARCH = 1;
    public $sectionValues = [
        self::SECTION_SEARCH=>'In search',
    ];
    public function getSectionText()
    {
        return isset($this->sectionValues[$this->section])? $this->sectionValues[$this->section]:null;
    }



    public $booleanValues=[0=>'No', 1=>'Yes',];
    public function getEnabledText()
    {
        return $this->booleanValues[$this->enabled];
    }

    public function rules()
    {
        return [
            //[['category_id'], 'required', ],
            [['label', 'type', 'key'], 'required'],
            ['key', 'match', 'pattern'=>'/^[a-zA-Z0-9._]+$/', 'message'=>Yii::t('yii', '{attribute} must be alphanumeric characters only.'),],
            [['key'], 'string', 'max' => 100],
            [['label','unit'], 'string', 'max' => 255],
            [['type', 'category_id'], 'integer'],
            ['json_values', 'required', 'when'=>function($model){
                                                                return in_array($model->type, [self::TYPE_DROP_DOWN_LIST,self::TYPE_DROP_DOWN_LIST_MULTIPLE,   self::TYPE_RADIO_LIST,self::TYPE_CHECKBOX_LIST]);
                                                            },
                'whenClient' => "function (attribute, value) {
                        return in_array ( $('#dynamicfield-type').val(),  [".implode(',', [self::TYPE_DROP_DOWN_LIST,self::TYPE_DROP_DOWN_LIST_MULTIPLE,   self::TYPE_RADIO_LIST,self::TYPE_CHECKBOX_LIST])."] );
                    }"
                                    ],
            ['json_values', 'jsonValidation'],
            [['enabled', 'clickable','with_label'], 'boolean'],
            ['default_value', 'string'],
            ['default_value', 'default', 'value'=>'',],
            ['rule', 'safe'],

            ['position', 'number'],
            ['position', 'default', 'value'=>0,],
            ['section', 'in', 'range' => array_keys($this->sectionValues)],
            ['with_label', 'default', 'value'=>1],
            [['clickable','enabled'], 'default', 'value'=>0],
            [['slider', 'input_fields'], 'boolean'],
            [['min', 'max'], 'number'],
            ['data', 'safe'],
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function jsonValidation()
    {
        if($this->json_values){
            $json_values = Helper::jsonToArray($this->json_values, null, false);
            if(!is_array($json_values))
                $this->addError('json_values', 'Wrong json format');
            if($json_values)
                foreach ($json_values as $key=>$val){
                    if(strpos($key,',')!==false)
                        $this->addError('json_values', "Don't use comma in key of json values.");
                    if(strpos($key,'-')!==false)
                        $this->addError('json_values', "Don't use \"-\" in key of json values.");
                }
        }
    }

    public $slider;
    public $input_fields;
    public $min;
    public $max;

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['rule'],
                    self::EVENT_BEFORE_UPDATE => ['rule'],
                ],
                'value' => function (Event $event) {
                    /* @var $model self */
                    $model = $event->sender;
                    if($model->rule &&  is_array($model->rule))
                        return implode(',',$model->rule);
                    return $model->rule;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT => 'with_label',
                ],
                'value' => 1,
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'json_values',
                    self::EVENT_BEFORE_UPDATE => 'json_values',
                ],
                'value' => function ($event) {
                    /*  @var $model self */
                    $model = $event->sender;
                    $model->json_values = Helper::jsonToArray($model->json_values);
                    return Helper::arrayToJson($model->json_values);
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'data',
                    self::EVENT_BEFORE_UPDATE => 'data',
                ],
                'value' => function ( $event) {
                    /* @var $model self */
                    $model = $event->sender;
                    $data = $model->data;
                    //string to array
                    $data = json_decode($data, true);
                    $data['slider'] = $model->slider;
                    $data['input_fields'] = $model->input_fields;
                    $data['min'] = $model->min;
                    $data['max'] = $model->max;
                    //array to string
                    $data = json_encode((object)$data, JSON_UNESCAPED_UNICODE);
                    return $data;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_DATA => 'data',
                ],
                'value' => function ( $event) {
                    /* @var $model self */
                    $model = $event->sender;
                    //string to array
                    $data = Helper::jsonToArray($model->data);
                    foreach ($data as $attr=>$value)
                        $model->$attr = $value;
                    return $model->data;
                },
            ],
        ];
    }
    const EVENT_INIT_DATA='EVENT_INIT_DATA';




    public $result;
    public function getResultText($options = ['class'=>'form-control'])
    {
        return $this->getField($this, 'result', $options);
    }

    public function getField($model, $attribute, $options=['class'=>'form-control'])
    {
        if(!isset($options['class']))
            $options['class'] = 'form-control';
        $labelOptions = [];
        if(isset($options['labelOptions'])){
            $labelOptions = $options['labelOptions'];
            unset($options['labelOptions']);
        }

        // нужно обращаться к аттрибуту, а у модели не может быть свойство $model->title[] или наоборот $model->[]->title
        // у модели должно быть только $model->title
        // а $attribute это уже вскармливается для ActiveField, там он быть хоть []title, хоть title[]
        $attributeName=preg_replace("/[0-9]/", "", $attribute);
        $attributeName=preg_replace("/\[\]/", "", $attributeName);

        if(!Yii::$app->request->isPost && $model->isNewRecord && !$model->$attributeName && $this->default_value)
            $model->$attributeName = $this->default_value;


        switch($this->type)
        {
            case self::TYPE_INPUT: {
                if($this->unit)
                    return Html::inputWithSymbol($model, $attribute, [], $this->unit );
                return Html::activeTextInput($model, $attribute, $options);
                break;
            }
            case self::TYPE_AREA: {
                return Html::activeTextArea($model, $attribute, $options);
                break;
            }
            case self::TYPE_DROP_DOWN_LIST: {
                return Html::activeDropDownList($model, $attribute, Helper::jsonToArray($this->json_values) ,
                    array_merge($options, ['prompt'=>Yii::t('common', 'Select')]));
                break;
            }
            case self::TYPE_DROP_DOWN_LIST_MULTIPLE: {
                if(!Yii::$app->request->isPost){// для того чтобы выбранные значения были отмеченными в поле
                    if($model->$attributeName &&  !is_array($model->$attributeName))
                        $model->$attributeName=explode(',',$model->$attributeName);
                }
                return Html::activeDropDownList($model, $attribute, Helper::jsonToArray($this->json_values) ,
                    array_merge($options, ['multiple'=>'multiple']));
                break;
            }
            case self::TYPE_RADIO_LIST: {
                if(isset($options['class']))
                    $options['class'] = str_replace('form-control', '', $options['class']);
                return Html::activeRadioList($model, $attribute, Helper::jsonToArray($this->json_values) ,array_merge($options, [
                    'class' => 'form-control',
                    'separator'=>'<br>',
                    //'class' => 'form-control btn-group',
                    //'data-toggle' => 'buttons',
                    //'unselect' => null, // remove hidden field
                    'style'=>'padding:0; border:none; box-shadow:none; background:inherit;',
                    //'itemOptions'=>['class'=>'btn btn-default',],
                    'item'=>function($index, $label, $name, $checked, $value) use ($options, $labelOptions)  {
                        //$labelOptions['class'] = 'btn btn-default';
                        if($checked)
                            Html::addCssClass($labelOptions, 'active');
                        $return = Html::beginTag('label', $labelOptions);
                        $return .= Html::radio($name, $checked, array_merge($options, ['value' => $value]));
                        $return .= ' '.$label;
                        $return .= '</label>';
                        return $return;
                    },
                ]));
                break;
            }
            case self::TYPE_CHECKBOX_LIST: {
                if(isset($options['class']))
                    $options['class'] = str_replace('form-control', '', $options['class']);
                if(!Yii::$app->request->isPost){// для того чтобы выбранные значения были отмеченными в поле
                    if($model->$attributeName &&  !is_array($model->$attributeName))
                        $model->$attributeName=explode(',',$model->$attributeName);
                }
                return Html::activeCheckboxList($model, $attribute, Helper::jsonToArray($this->json_values) ,  array_merge($options, [
                    'class' => 'form-control',
                    //'class' => 'form-control btn-group',
                    //'data-toggle' => 'buttons',
                    //'unselect' => null, // remove hidden field
                    'style'=>'padding:0; padding-top:5px; border:none; box-shadow:none; background:inherit;',
                    //'itemOptions'=>['class'=>'btn btn-default',],
                    'item'=>function($index, $label, $name, $checked, $value) use ($options, $labelOptions) {
                        //$labelOptions['class'] = 'btn btn-default';
                        if($checked)
                            Html::addCssClass($labelOptions, 'active');
                        $return = Html::beginTag('label', $labelOptions);
                        $return .= Html::checkbox($name, $checked, array_merge($options, ['value' => $value]));
                        $return .= ' '.$label;
                        $return .= '</label>';
                        return $return;
                    },
                ]));
                break;
            }
            default: {
            return Html::activeTextInput($model, $attribute, $options);
            break;
            }
        }

    }

    public function addValue($key, $value)
    {
        $array=Helper::jsonToArray($this->json_values);
        $array[$key]=$value;
        $this->json_values = $array;
        $this->json_values = Helper::arrayToJson($this->json_values);
    }
    public function removeValue($key=false, $value=false)
    {
        $array=Helper::jsonToArray($this->json_values);
        if($key && isset($array[$key]))
            unset($array[$key]);
        if($value && ($key = array_search($value, $array)) !== false)
            unset($array[$key]);
        $this->json_values=$array;
        $this->json_values = Helper::arrayToJson($this->json_values);
    }
    public function existValue($value)
    {
        if(($key = array_search($value, Helper::jsonToArray($this->json_values) )) !== false)
            return true;
    }

    public $ruleValuesOptions=[
        'date'=>['format'=>'yyyy-MM-dd'],
        'datetime'=>['format'=>'yyyy-MM-dd'],
    ];
    public $ruleValues=[
        'required'=>'required',
        'number'=>'integer',
        'boolean'=>'boolean',
        'date'=>'date',
        'datetime'=>'datetime',
    ];
    public function getRuleText()
    {
        $rules=[];
        foreach ($this->ruleArray as $value)
            $rules[]=$this->ruleValues[$value];
        return implode(', ', $rules);
    }
    public function getRuleArray()
    {
        if($this->rule && !is_array($this->rule))
            return explode(',', $this->rule);
        return [];
    }




    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'label' => Yii::t('eav', 'Label'),
            'key' => Yii::t('eav', 'Field name'),
            'default_value' => Yii::t('eav', 'Default value'),
            'type' => Yii::t('common', 'Type'),
            'enabled' => Yii::t('common', 'Enabled'),
            'json_values' => Yii::t('eav', 'Values'),

            'category_id' => Yii::t('category', 'Category'),
            'rule' => Yii::t('eav', 'Rule'),
            'result' => Yii::t('eav', 'Result'),
            'position' => Yii::t('eav', 'Position'),
            'unit' => Yii::t('eav', 'Unit'),
            'section' => Yii::t('eav', 'Section'),
            'with_label' => Yii::t('eav', 'With label'),
        ];
    }

    /**
     * @return DynamicValue
     * */

    public $_valueModel;

    /**
     * @return DynamicValue
     * */
    public function getValueObject($object_id=null)
    {
        if($this->_valueModel)
            return $this->_valueModel;

        if($object_id){
            $this->_valueModel = $this->getValue($object_id)->one();
            if(!$this->_valueModel)
                $this->_valueModel = new DynamicValue(['object_id'=>$object_id]);
        }
        else
            $this->_valueModel = new DynamicValue;

        $this->_valueModel->field_id=$this->id;
        $this->_valueModel->_fieldObject=$this;
        $this->_valueModel->valueLabel=$this->label;
        return $this->_valueModel;
    }

    public function getValues()
    {
        return $this->hasMany(DynamicValue::class, ['field_id'=>'id'])->inverseOf('field');
    }
    public function getValue($object_id)
    {
        return $this->hasOne(DynamicValue::class, ['field_id'=>'id'])
            ->andOnCondition(['object_id'=>$object_id])
            ->inverseOf('field');
    }


    public function fields()
    {
        return [
            'id',
            'label',
            'clickable',
            'category_id',
            'key',
            'options'=>function(self $model){
                return Helper::jsonToArray($model->json_values, [], false);
            },
        ];
    }
}
