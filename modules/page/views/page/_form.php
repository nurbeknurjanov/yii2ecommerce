<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use file\models\FileImage;
use kartik\file\FileInput;
use file\widgets\file_preview\FilePreview;

/* @var $this yii\web\View */
/* @var $model page\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?=Html::beginForm('', 'post',['id'=>'anotherForm']).Html::endForm()?>
    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => [/*'class' => 'form-horizontal',*/ 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-4 control-label'],
            ],
        ]);
    ?>

    <?=$form->errorSummary($model);?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
            'preset' => 'full',
            'allowedContent'=>true,
        ]),
    ]); ?>

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

    <div class="form-group">
        <div class="col-lg-offset-0 col-lg-0">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
