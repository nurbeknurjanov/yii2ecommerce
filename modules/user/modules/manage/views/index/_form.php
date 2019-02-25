<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use user\models\User;
use i18n\models\I18nSourceMessage;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap\Tabs;
use file\models\FileImage;
use file\widgets\file_preview\FilePreview;


/* @var $this yii\web\View */
/* @var $model user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?=Html::beginForm('', 'post',['id'=>'anotherForm']).Html::endForm()?>
    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => [ 'enctype' => 'multipart/form-data'],
    ]); ?>

    <?=$form->errorSummary($model);?>





    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php
    $imageAttributeField = $form->field($model, 'imageAttribute');
    if($model->image){
        $imageAttributeField->enableClientValidation=false;
        $imageAttributeField->enableAjaxValidation=false;
        $imageAttributeField->parts['{input}'] =  FilePreview::widget(['image'=>$model->image]);
    }
    else
        $imageAttributeField->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
            ],
        ]);
    echo $imageAttributeField;
    ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'language')->dropDownList((new I18nSourceMessage())->languageValues, ['prompt' => 'Select']) ?>
    <?= $form->field($model, 'time_zone')->dropDownList($model->getTimeZoneValues(), ['prompt' => 'Select']) ?>

    <?php
    $subscribeValues = $model->subscribeValues;
    unset($subscribeValues[$model::SUBSCRIBE_NEUTRAL]);
    ?>
    <?= $form->field($model, 'subscribe')->radioList($model->subscribeValues) ?>


    <?php
    if(Yii::$app->user->can('createUser'))
    {
        ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->dropDownList($model->statusValues,  array('prompt'=>Yii::t('common', 'Select'))); ?>
        <?php
    }
    ?>
    <?php
    if(Yii::$app->user->can('createUser'))
    {
        if(!Yii::$app->request->isPost)
            $model->rolesAttribute = $model->roles;
        $rolesValues = $model->possibleRolesValues;
        echo $form->field($model, 'rolesAttribute')->checkboxList($rolesValues, [
            'item'=>function($index, $label, $name, $checked, $value)  {
                $return = Html::beginTag('label', ['style'=>'display:block;',]);
                $return .= Html::checkbox($name, $checked, ['value' => $value]);
                $return .= ' '.$label;
                $return .= '</label>';
                return $return;
            }
        ]);
    }
    ?>


    <div class="row">
        <div class="form-group">
            <div class="col-lg-4 "><?= Html::submitButton(Yii::t('common', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?></div>
        </div>
    </div>





    <?php ActiveForm::end(); ?>

</div>


















