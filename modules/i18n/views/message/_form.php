<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use \i18n\models\I18nSourceMessage;

/* @var $this yii\web\View */
/* @var $model i18n\models\I18nMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="i18n-message-form">

    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        //'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div><div class=\"col-lg-4\">{hint}</div>\n",
            //'labelOptions' => ['class' => 'col-lg-4 control-label'],
        ],
    ]);
    ?>

    <?= $form->field($model, 'id')->dropDownList(ArrayHelper::map(I18nSourceMessage::find()->all(), 'id', 'message')) ?>

    <?= $form->field($model, 'language')->dropDownList((new I18nSourceMessage)->languageValues) ?>

    <?= $form->field($model, 'translation')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
