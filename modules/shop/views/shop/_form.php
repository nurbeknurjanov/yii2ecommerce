<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use file\widgets\file_preview\FilePreview;
use shop\models\Shop;
use user\models\User;

/* @var $this yii\web\View */
/* @var $model \shop\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form">

    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => [ 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-8\">{input}{hint}</div>\n<div class=\"col-lg-8 col-lg-offset-4\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-4 control-label'],
            ],
        ]);
    ?>

    <?=$form->errorSummary($model);?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
    $imagesAttributeField = $form->field($model, 'imagesAttribute[]');
    $imagesAttributeField->parts['{input}'] = FilePreview::widget(['images'=>$model->images]);
    $imagesAttributeField->parts['{input}'].=FileInput::widget([
        'model' => $model,
        'attribute' => 'imagesAttribute[]',
        'options' => ['multiple' => true],
    ]);
    echo $imagesAttributeField;
    ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model, 'usersAttribute')->dropDownList(
        ArrayHelper::map(User::find()->mineOrDefault()->all(), 'id', 'fullName'),
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

    <div class="form-group">
        <div class="col-lg-offset-0 col-lg-0">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
