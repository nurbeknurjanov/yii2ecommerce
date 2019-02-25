<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\rating\StarRating;
use kartik\file\FileInput;
use file\models\FileImage;
use file\widgets\file_preview\FilePreview;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use product\models\Product;
use extended\vendor\BootstrapSelectAsset;

/* @var $this yii\web\View */
/* @var $model comment\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$this->params['form'] = $form = ActiveForm::begin([
    'action'=>$model->isNewRecord ? ['/comment/comment/create', 'model_id'=>$model->model_id, 'model_name'=>$model->model_name]:null,
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'options' => [
        'data-pjax' => true,
        'enctype' => 'multipart/form-data'
    ],
    'fieldConfig' => [
        //'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
        //'labelOptions' => ['class' => 'col-lg-4 control-label'],
    ],
]);
?>

<?=$form->errorSummary($model);?>

<div class="row">
    <div class="col-lg-6">

        <?php $this->beginBlock('fields') ?>

            <?=$form->field($model, 'name') ?>

            <?=$form->field($model, 'model_name')->dropDownList($model->modelNameValues,['prompt'=>'Select']) ?>

            <?=$form->field($model, 'model_id',['parts'=>['{input}'=>
                (new Product)->getWidgetSelectPicker($model, 'model_id')]]) ?>

            <?php $this->beginBlock('mark') ?>
                <?= $form->field($model->ratingObject, 'mark')->widget(StarRating::class, [
                    'pluginOptions' => [
                        //'showClear'=>(boolean) $rating,
                        'showClear'=>true,
                        'size'=>'xs',
                        'step' => 1,
                        'showCaption' => false,
                        //'rtl' => true,
                    ],
                    'options'=>['data-user_id'=>Yii::$app->user->id],
                ]); ?>
            <?php $this->endBlock() ?>
            {{mark}}


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

            <?php
            $videoAttributeField = $form->field($model, 'videoAttribute');
            $videoAttributeField->parts['{input}'] = FilePreview::widget(['video'=>$model->video]);
            if(!$model->video)
                $videoAttributeField->parts['{input}'].=Html::activeTextInput($model, "videoAttribute", ['class'=>'form-control videoAttribute']);
            $videoAttributeField->hint(Yii::t('file', "Paste a link to your video(youtube, vk.com). Example:{link}", ['link'=>'https://www.youtube.com/watch?v=9SGIDn52MaA',]));
            echo $videoAttributeField;
            ?>

            <?=$form->field($model, 'enabled')->checkbox()?>


        <?php $this->endBlock() ?>
        {{fields}}





    </div>
    <div class="col-lg-6">
        <?= $form->field($model, 'text')->widget(CKEditor::class,[
            'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                'preset' => 'full',
                'inline' => false,
                'resize_enabled'=>true,
                'height'=>250,
                'toolbarGroups'=>[
                    ['name' => 'clipboard', 'groups' => [
                        'mode',
                        'doctools'
                    ]],
                    ['name' => 'editing', 'groups' => [ 'tools']],]
            ]),
        ]) ?>

    </div>
</div>
<br>
<div class="form-group">
    <div class="col-lg-offset-0 col-lg-0" style="text-align: right">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
