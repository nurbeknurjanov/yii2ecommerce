<?php

namespace setting\models;

use extended\helpers\Helper;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use Yii;
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
class Setting extends \yii\db\ActiveRecord
{
    const EVENT_FIND_JSON_ROWS='EVENT_FIND_JSON_ROWS';
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['value'],
                    self::EVENT_BEFORE_UPDATE => ['value'],
                ],
                'skipUpdateOnClean'=>false,
                'value' => function ( $event) {
                    /* @var $model self */
                    $model = $event->sender;
                    if($model->key==$model::VISUAL_JSON_DATA)
                    {
                        foreach ($model->jsonRows as $jsonRow)
                            $value[$jsonRow->json_key] = $jsonRow->json_value;
                        return Helper::arrayToJson($value);
                    }
                    return $model->value;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_FIND_JSON_ROWS => ['jsonRows'],
                ],
                'value' => function ( $event) {
                    /* @var $model self */
                    $model = $event->sender;

                    $rowsOld = Helper::jsonToArray( $model->value, [], false);
                    array_walk($rowsOld, function (&$value, $key){
                        $value =  new JsonRow([
                            'json_key'=>$key,
                            'json_value'=>$value,
                        ]);
                    });
                    $rows = $rowsOld = array_values($rowsOld);//reset keys

                    if(isset($_POST[(new JsonRow)->formName()])){
                        $rows=[];
                        foreach ($_POST[(new JsonRow)->formName()] as $index=>$postData)
                            $rows[$index] = new JsonRow($postData);
                    }
                    return $rows;
                },
            ],
        ];
    }

    public $jsonRows;

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
            [['key'], 'required'],
            [['value'], 'string'],
            [['key', 'value'], 'default', 'value'=>''],
            [['key'], 'string', 'max' => 255],
            ['value', 'valueValidation'],
            ['jsonRows', 'rowValidation', 'skipOnEmpty' => false],
        ];
    }
    public function rowValidation()
    {
        if($this->key==self::VISUAL_JSON_DATA){
            if(!$this->jsonRows)
                $this->addError('jsonRows', 'List of value can not be empty.');
        }
    }
    public function valueValidation()
    {
        if($this->key==self::CLEAN_JSON_DATA)
        {
            $json_values = Helper::jsonToArray($this->value, null, false);
            if(!is_array($json_values))
                $this->addError('value', 'Wrong json format');
            if($json_values)
                foreach ($json_values as $key=>$val){
                    if(strpos($key,',')!==false)
                        $this->addError('value', "Don't use comma in key of json values.");
                    if(strpos($key,'-')!==false)
                        $this->addError('value', "Don't use \"-\" in key of json values.");
                }
        }
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


    const HTML_DATA='HTML_CONTENT';
    const CLEAN_DATA='CLEAN_CONTENT';
    const BOOLEAN_DATA='BOOLEAN_DATA';
    const CLEAN_JSON_DATA='JSON_DATA';
    const VISUAL_JSON_DATA='VISUAL_DATA';
    public function getKeyValues()
    {
        return [
            self::HTML_DATA=>'Html Data',
            self::CLEAN_DATA=>'Clean Data',
            self::BOOLEAN_DATA=>'Boolean Data',
            self::CLEAN_JSON_DATA=>'Clean JSON Data',
            self::VISUAL_JSON_DATA=>'Visual JSON Data',
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
            case self::BOOLEAN_DATA: return 1; break;
        }
    }

    public $fieldTypeValues=[
        'textarea'=>[self::CLEAN_DATA, self::CLEAN_JSON_DATA],
        'ckeditor'=>[self::HTML_DATA],
        'checkbox'=>[self::BOOLEAN_DATA],
        'visual'=>[self::VISUAL_JSON_DATA],
    ];
    public function getFieldType()
    {
        foreach ($this->fieldTypeValues as $fieldType=>$keys)
            if(in_array($this->key, $keys))
                return $fieldType;
        return 'textinput';
    }

    public function getField($form)
    {
        $valueField = $form->field($this, 'value');

        $valueField->label($this->keyText);

        if(!Yii::$app->request->isPost && !$this->value)
            $this->value = $this::getValue($this->key);

        switch ($this->fieldType){
            case 'textarea':$field = Html::activeTextarea($this, 'value', ['class'=>'form-control','rows'=>6]); break;
            case 'ckeditor':
                $field = CKEditor::widget([
                    'model'=>$this,
                    'attribute'=>'value',
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                        'preset' => 'basic',
                        'allowedContent'=>true,
                        'height'=>300,
                    ])
                ]);
                break;
            case 'checkbox':$field = Html::activeCheckbox($this, 'value',
                ['label'=>false, 'style'=>'display:block',]); break;
            case 'textinput':$field = Html::activeTextInput($this, 'value',['class'=>'form-control']); break;
            case 'visual':
                $field = Yii::$app->view->render('@setting/views/setting/_row_form',['form'=>$form, 'model'=>$this]);
                break;
            default:$field = Html::activeTextInput($this, 'value',['class'=>'form-control']); break;

        }
        $valueField->parts['{input}'] = $field;

        return $valueField;
    }

    public function loadRows($data, $formName)
    {
        if(isset($data[$formName]))
            foreach ($data[$formName] as $index=>$postData) {
                $row = $this->jsonRows[$index];
                $row->attributes = $postData;
                $this->jsonRows[$index] = $row;
            }
        return true;
    }






    public static function convert($quantity, $currency, $new_currency)
    {
        //if($currency==$new_currency)
            return $quantity;

        /*if($setting = Setting::findOne(['key'=>Setting::KEY_CURRENCY_RATE]))
        {
            $value = json_decode($setting->value, JSON_FORCE_OBJECT);

            if(isset($value['1'.$currency.'_TO_'.$new_currency]['value'])){
                return $quantity * $value['1'.$currency.'_TO_'.$new_currency]['value'];
            }elseif(isset($value['1'.$new_currency.'_TO_'.$currency]['value']) && $value['1'.$new_currency.'_TO_'.$currency]['value']){
                return $quantity / $value['1'.$new_currency.'_TO_'.$currency]['value'];
            }else{

                try {
                    if($new_currency=='USD')
                        throw new Exception("Not possible to convert ".$currency." to ".$new_currency);
                    $usdQuantity = self::convert($quantity, $currency, 'USD');

                    if($currency=='USD')
                        throw new Exception("Not possible to convert ".$currency." to ".$new_currency);
                    $newQuantity = self::convert($usdQuantity, 'USD', $new_currency);

                    return $newQuantity;
                } catch (Exception $e) {
                    //throw new Exception($e->getMessage());
                }


                throw new Exception("Not possible to convert ".$currency." to ".$new_currency);
            }
        }else{
            throw new Exception("There is no converter");
        }*/
    }

}