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
use extended\helpers\ArrayHelper;
use shop\models\Shop;
use country\models\Country;
use country\models\Region;
use country\models\City;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \user\models\User */
/* @var $profile \user\models\UserProfile */
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

    <?php
    $subscribeValues = $model->subscribeValues;
    unset($subscribeValues[$model::SUBSCRIBE_NEUTRAL]);
    ?>
    <?= $form->field($model, 'subscribe')->radioList($model->subscribeValues,[ 'separator'=>'<br>',]) ?>


    <div class="row">
        <div class="col-lg-4">
            <?=$form->field($profile, 'country_id',['parts'=>['{input}'=>
                (new Country)->getWidgetSelectPicker($profile, 'country_id', null, ['class'=>'selectpicker country_id',])]]) ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($profile, 'region_id',['parts'=>['{input}'=>
                (new Region)->getWidgetSelectPicker($profile, 'region_id', Region::find()->countryQuery($profile->country_id),
                    ['class'=>'selectpicker region_id',
                        'data-url'=>Url::to(['/country/region/select-picker', 'country_id'=>$profile->country_id])
                    ])]]) ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($profile, 'city_id',['parts'=>['{input}'=>
                (new City)->getWidgetSelectPicker($profile, 'city_id', City::find()->regionQuery($profile->region_id),
                    ['class'=>'selectpicker city_id',
                        'data-url'=>Url::to(['/country/region/select-picker', 'region_id'=>$profile->region_id])
                    ])]]) ?>
        </div>
        <div class="col-lg-8">
            <?=$form->field($profile, 'address') ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($profile, 'zip_code') ?>
        </div>
    </div>


    <?php
    if(Yii::$app->user->can('createUser'))
    {
        ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->dropDownList($model->statusOptions,  array('prompt'=>Yii::t('common', 'Select'))); ?>

        <?=$form->field($model, 'shopsAttribute')->dropDownList(
                ArrayHelper::map(Shop::find()->mineOrDefault()->all(), 'id', 'title'),
        [
            //'prompt'=>'Select',
            'multiple'=>true,
            'class'=>'selectpicker',
            //'prompt'=>'',
            'data-live-search'=>'true',
            'data-width' => '100%',
            'data-title' => 'Select',
            'data-header' => 'Select',
            //'data-style' => 'btn-danger',
        ])?>

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
            },
        ]);
        ?>


        <?php
    }
    ?>


    <div class="row">
        <div class="form-group">
            <div class="col-lg-4 "><?= Html::submitButton(Yii::t('common', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?></div>
        </div>
    </div>





    <?php ActiveForm::end(); ?>

</div>


















