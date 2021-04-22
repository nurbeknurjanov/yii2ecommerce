<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model delivery\models\CronEmailMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cron-email-message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'created_date')->textInput(['readonly'=>true]) ?>


    <?= $form->field($model, 'recipient_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sender_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sender_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea() ?>

    <?= $form->field($model, 'status')->radioList($model->statusOptions, [
        'itemOptions'=>[
            'disabled'=>'disabled',
        ],
    ]) ?>

    <?= $form->field($model, 'sent_date')->textInput(['readonly'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
