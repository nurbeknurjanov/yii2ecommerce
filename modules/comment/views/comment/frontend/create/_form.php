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
use himiklab\yii2\recaptcha\ReCaptcha;

/* @var $this yii\web\View */
/* @var $model comment\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-6">
        <?php
        $this->params['form'] = $form = ActiveForm::begin([
            'action'=>['/comment/comment/create-frontend', 'model_id'=>$model->model_id, 'model_name'=>$model->model_name],
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


        <?php $this->beginBlock('fields') ?>

        <?php
        if(Yii::$app->user->isGuest)
            echo $form->field($model, 'name');
        ?>

        <?php $this->beginBlock('mark') ?>
        <?= $form->field($model->ratingObject, 'mark')->widget(StarRating::className(), [
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



        <?= $form->field($model, 'text')->textarea(['rows'=>3]); ?>


        <?php
        $imagesAttributeField = $form->field($model, 'imagesAttribute[]')->fileInput();
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
        $videoAttributeField->hint(Yii::t('file', "Paste a link of video(youtube, vk.com). Example: {link}", ['link'=>'https://www.youtube.com/watch?v=9SGIDn52MaA',]));
        echo $videoAttributeField;
        ?>

        <?php
        if(YII_ENV_PROD)
            echo $form->field($model, 'reCaptcha', ['enableAjaxValidation' => false, 'enableClientValidation' => false])->widget(ReCaptcha::class)
        ?>

        <?php $this->endBlock() ?>
        {{fields}}

        <div class="form-group">
            <div class="col-lg-offset-0 col-lg-0">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('comment', 'Submit a comment') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>


    </div>
</div>

<?php
\richardfan\widget\JSRegister::begin();
?>
    <script>
        resizeReCaptcha();
    </script>
<?php
\richardfan\widget\JSRegister::end();