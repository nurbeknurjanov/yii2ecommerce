<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

/* @var \eav\models\DynamicField[] $fieldModels */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;


foreach ($fieldModels as $fieldModel){
    $valueModel = $fieldModel->getValueObject($object_id);
    echo $form->field($valueModel, "[$fieldModel->id]value",
        ['parts'=>['{input}'=>$fieldModel->getField($valueModel, "[$fieldModel->id]value") ]]);
}
foreach ($form->attributes as $attribute){
    $this->registerJs( "jQuery('#$form->id').yiiActiveForm('add', ".Json::encode($attribute)." );\n ",
        View::POS_READY, $attribute['id'] );
    echo Html::tag('script', $this->js[View::POS_READY][$attribute['id']]);
}