<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;


$form = new ActiveForm([
    'id'=>'productForm',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    //'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        //'template' => "{label}\n<div class=\"col-lg-9\" >{input}</div>\n<div class=\"col-lg-9 col-lg-offset-3\">{error}</div>",
        //'labelOptions' => ['class' => 'col-lg-3 control-label'],
    ],
]);

if(Yii::$app->controller->action->id=='select'){
    $form->options = ['class' => 'form-horizontal'];
    $form->fieldConfig = [
        'template' => "{label}\n<div class=\"col-lg-9\" >{input}</div>\n<div class=\"col-lg-9 col-lg-offset-3\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-3 control-label'],
    ];
}

foreach ($fieldModels as $fieldModel){
    $valueModel = $fieldModel->getValueObject($id);

    if(Yii::$app->controller->action->id=='select')
        foreach ($fieldModel->validationArray as $rule){
            if($rule=='date')
                $valueModel->rules[]=[['value'], 'date', 'format'=>'yyyy-MM-dd'];
            elseif($rule=='datetime')
                $valueModel->rules[]=[['value'], 'date', 'format'=>'yyyy-MM-dd'];
            else
                $valueModel->rules[]=[['value'], $rule,];
        }


    $formField = $form->field($valueModel, "[$fieldModel->id]value");
    $formField->parts['{input}'] = $fieldModel->getField($valueModel, "[$fieldModel->id]value");
    if($fieldModel->unit)
        $formField->parts['{input}'] = Html::tag("div",
            Html::activeTextInput($valueModel, "[$fieldModel->id]value", ['class'=>'form-control']).
            Html::tag("span", Html::tag("button", $fieldModel->unit, ['class'=>'btn btn-default',])
                ,['class'=>'input-group-btn']),
            ['class'=>'input-group', 'style'=>'width:200px;']);
    echo $formField->__toString();
}
if(Yii::$app->controller->action->id=='select')
    foreach ($form->attributes as $attribute){
        $this->registerJs( "jQuery('#productForm').yiiActiveForm('add', ".Json::encode($attribute)." );\n ", View::POS_READY, $attribute['id'] );
        echo Html::tag('script', $this->js[View::POS_READY][$attribute['id']]);
    }