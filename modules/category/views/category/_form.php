<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use category\models\Category;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use file\widgets\file_preview\FilePreview;
use yii\widgets\Block;
use extended\helpers\Helper;

/* @var $this yii\web\View */
/* @var $model \category\models\Category */
/* @var $form yii\widgets\ActiveForm */





?>

<div class="category-form">
    <?=Html::beginForm('', 'post',['id'=>'anotherForm']).Html::endForm()?>
    <?php
    $form = ActiveForm::begin([
        'id'=>'categoryForm',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>false,
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\" >{input}</div>\n<div class=\"col-lg-9 col-lg-offset-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
        ]);
    $this->params['form'] = $form;
    ?>



    <?=$form->errorSummary($model);?>

    <?php $this->beginBlock('fields'); ?>

        <?= $form->field($model, 'parent_id')->dropDownList(
                ArrayHelper::map(Category::find()
                    ->defaultFrom()->defaultOrder()
                    ->selectTitle()->all(), 'id', 'title'),
            ['prompt'=>'Select', 'encode'=>false]); ?>

        <?= $form->field($model, 'position') ?>

        <?= $form->field($model, 'title') ?>

        <?php //echo $form->field($model, 'title_ru') ?>

        <?php
        $imageAttributeField = $form->field($model, 'imageAttribute');
        if($model->image){
            $imageAttributeField->enableClientValidation=false;
            $imageAttributeField->enableAjaxValidation=false;
            $imageAttributeField->parts['{input}'] = FilePreview::widget(['image'=>$model->image]);
        }
        else
            $imageAttributeField->widget(\kartik\file\FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                ],
            ]);
        echo $imageAttributeField;
        ?>

        <?= $form->field($model, 'text')->widget(CKEditor::className(),[
            'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                'preset' => 'full',
                'inline' => false,
                'resize_enabled'=>true,
                'height'=>400,
                'toolbarGroups'=>[
                    ['name' => 'clipboard', 'groups' => [
                        'mode',
                        'doctools'
                    ]],
                    ['name' => 'editing', 'groups' => [ 'tools']],]
            ]),
        ]); ?>

    <?= $form->field($model, 'enabled')->checkbox([],false); ?>


    <?php $this->endBlock(); ?>
        {{fields}}

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-12">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
