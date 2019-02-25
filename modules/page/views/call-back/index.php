<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \page\models\CallBackForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Alert;


$this->title = Yii::t('page', 'Call back');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin([
            'id' => 'call-back-form',
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            //'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                //'template' => "{label}\n<div class=\"col-lg-8\">{input}{hint}</div>\n<div class=\"col-lg-8 col-lg-offset-4\">{error}</div>",
                //'labelOptions' => ['class' => 'col-lg-2 control-label'],
            ],
        ]); ?>



        <?=$form->errorSummary($model);?>

        <?php
        $model->subject = Yii::t('page', 'You have requested to call back.');
        ?>
        <?=Html::activeHiddenInput($model, 'subject')?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'phone') ?>


        <div class="form-group">
            <?= Html::submitButton(Yii::t('common', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>