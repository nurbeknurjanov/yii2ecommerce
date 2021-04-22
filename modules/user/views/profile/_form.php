<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use i18n\models\I18nSourceMessage;
use user\models\User;
use \yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use file\models\FileImage;
use yii\bootstrap\Tabs;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use file\widgets\file_preview\FilePreview;
use country\models\Country;
use country\models\Region;
use country\models\City;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?=Html::beginForm('', 'post',['id'=>'anotherForm']).Html::endForm()?>
    <?php $form = ActiveForm::begin([
        //'action'=>['/user/profile/edit-profile'],
        'id'=>'formProfile',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'data' => ['pjax' => true]],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\">{input}{hint}</div>\n<div class=\"col-lg-8 col-lg-offset-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?=$form->errorSummary($model);?>



    <?php
    ob_start();
    ?>

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
    unset($subscribeValues[User::SUBSCRIBE_NEUTRAL]);
    ?>
    <?= $form->field($model, 'subscribe')->radioList($subscribeValues) ?>

    <?php
    if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
    {
        ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?php
    }
    ?>

    <div class="form-group">
        <div class="col-lg-4 col-lg-offset-2"><?= Html::submitButton(Yii::t('common', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?></div>
    </div>


    <?php
    $content = ob_get_contents();
    ob_end_clean();

    ob_start();
    ?>
    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
            'preset' => 'basic',
            'inline' => false,
            'resize_enabled'=>true,
            'height'=>400,
            'toolbarGroups'=>[['name' => 'editing', 'groups' => [ 'tools']],]
        ]),
    ]); ?>

    <div class="form-group">
        <div class="col-lg-4 col-lg-offset-2"><?= Html::submitButton(Yii::t('common', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?></div>
    </div>
    <?php
    $content2 = ob_get_contents();
    ob_end_clean();



    ob_start();
    ?>

    <div class="row">
        <div class="col-lg-4">
            <?=$form->field($profile, 'country_id',[
                    'template'=>'{label}{input}{error}',
                    'options'=>['style'=>'margin:0',],
                    'labelOptions'=>['class'=>'control-label'],
                    'parts'=>['{input}'=>
                (new Country)->getWidgetSelectPicker($profile, 'country_id', null, ['class'=>'selectpicker country_id',])]]) ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($profile, 'region_id',[
                    'template'=>'{label}{input}{error}',
                    'options'=>['style'=>'margin:0',],
                    'labelOptions'=>['class'=>'control-label'],
                    'parts'=>[
                    '{input}'=>
                (new Region)->getWidgetSelectPicker($profile, 'region_id', Region::find()->countryQuery($profile->country_id),
                    ['class'=>'selectpicker region_id',
                        'data-url'=>Url::to(['/country/region/select-picker', 'country_id'=>$profile->country_id])
                    ])]]) ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($profile, 'city_id',[
                    'template'=>'{label}{input}{error}',
                    'options'=>['style'=>'margin:0',],
                    'labelOptions'=>['class'=>'control-label'],
                    'parts'=>[
                    '{input}'=>
                (new City)->getWidgetSelectPicker($profile, 'city_id', City::find()->regionQuery($profile->region_id),
                    ['class'=>'selectpicker city_id',
                        'data-url'=>Url::to(['/country/region/select-picker', 'region_id'=>$profile->region_id])
                    ])]]) ?>
        </div>
        <div class="col-lg-8">
            <?=$form->field($profile, 'address', [
                'template'=>'{label}{input}{error}',
                'options'=>['style'=>'margin:0',],
                'labelOptions'=>['class'=>'control-label'],
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($profile, 'zip_code', [
                'template'=>'{label}{input}{error}',
                'options'=>['style'=>'margin:0',],
                'labelOptions'=>['class'=>'control-label'],
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-12" style="text-align: right"><?= Html::submitButton(Yii::t('common', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?></div>
    </div>
    <?php
    $content1 = ob_get_contents();
    ob_end_clean();



    ob_start();
    ?>
    <?php
    $imagesAttributeField = $form->field($model, 'imagesAttribute[]');
    $imagesAttributeField->parts['{input}'] =  FilePreview::widget(['images'=>$model->images]);
    $imagesAttributeField->parts['{input}'].=FileInput::widget([
        'model' => $model,
        'attribute' => 'imagesAttribute[]',
        'options' => ['multiple' => true],
    ]);
    echo $imagesAttributeField;
    ?>
    <div class="form-group">
        <div class="col-lg-4 col-lg-offset-2"><?= Html::submitButton(Yii::t('common', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?></div>
    </div>
    <?php
    $content3 = ob_get_contents();
    ob_end_clean();



    echo Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('user', 'Personal details'),
                'content' => '<br><br>'.$content,
                'options' => ['tag' => 'div'],
                'headerOptions' => ['class' => 'my-class'],
            ],
            [
                'label' => $model->getAttributeLabel('Profile'),
                'content' => '<br>'.$content1,
                'options' => ['id' => 'my-tab1'],
            ],
            [
                'label' => $model->getAttributeLabel('description'),
                'content' => '<br><br>'.$content2,
                'options' => ['id' => 'my-tab2'],
                'active'=>$model->getErrors('description') ? true:false,
            ],
            [
                'label' => $model->getAttributeLabel('imagesAttribute'),
                'content' => '<br><br>'.$content3,
                'options' => ['id' => 'my-tab3'],
                'active'=>$model->getErrors('imagesAttribute') ? true:false,
            ],
            /*[
                'label' => 'Ajax tab',
                'url' => ['ajax/content'],
            ],*/
        ],
        'options' => ['tag' => 'div'],
        'itemOptions' => ['tag' => 'div'],
        'headerOptions' => ['class' => 'my-class'],
        'clientOptions' => ['collapsible' => false],
    ]);
    ?>










    <?php ActiveForm::end(); ?>

</div>
