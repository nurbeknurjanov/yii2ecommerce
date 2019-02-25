<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;
use file\models\FileImage;
use file\widgets\file_preview\FilePreview;
use tag\models\Tag;
use extended\vendor\BootstrapSelectAsset;

BootstrapSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model article\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?=Html::beginForm('', 'post',['id'=>'anotherForm']).Html::endForm()?>
    <?php
    $this->params['form'] = $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\" >{input}</div>\n<div class=\"col-lg-9 col-lg-offset-3\">{hint}{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
        ]);
    ?>

    <?=$form->errorSummary($model);?>

    <?php $this->beginBlock('fields') ?>

        <?= $form->field($model, 'type')->dropDownList($model->typeValues, ['prompt'=>Yii::t('common', 'Select'),]) ?>

        <?= $form->field($model, 'title')->textInput() ?>

        <?php echo $form->field($model, 'text')->widget(CKEditor::class,[
            'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                /*'preset' => 'full',
                'inline' => false,
                'resize_enabled'=>true,
                'height'=>400,
                'toolbarGroups'=>[
                    ['name' => 'clipboard',
                        'groups' => [
                            'mode',
                            'doctools'
                        ]],
                    ['name' => 'editing', 'groups' => [ 'tools']]
                ]*/
            ]),
        ]); ?>

        <?= $form->field($model, 'created_at')->widget(DateTimePicker::class) ?>

        <?php /* echo  $form->field($model, 'tags')->widget(
            \nex\chosen\Chosen::className(), [
            'multiple'=>true,
            'items' => $model->tagsValues,
            'clientOptions' => [
                'search_contains' => true,
                'single_backstroke_delete' => true,
            ]
        ]) */?>
        <?=$form->field($model, 'tagsAttribute')->dropDownList(ArrayHelper::map(Tag::find()->all(), 'id', 'title'),
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
        $videoAttributeField = $form->field($model, 'videoAttribute');
        $videoAttributeField->parts['{input}'] = FilePreview::widget(['video'=>$model->video]);
        if(!$model->video)
            $videoAttributeField->parts['{input}'].=Html::activeTextInput($model, "videoAttribute", ['class'=>'form-control videoAttribute']);
        $videoAttributeField->hint(Yii::t('file', "Paste a link to your video(youtube, vk.com). Example:{link}", ['link'=>'https://www.youtube.com/watch?v=9SGIDn52MaA',]));
        echo $videoAttributeField;
        ?>



        <?php $this->beginBlock('imagesFields') ?>
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
        <?php $this->endBlock() ?>
        {{imagesFields}}


    <?php $this->endBlock() ?>
    {{fields}}

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-1">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
