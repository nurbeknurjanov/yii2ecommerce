<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use country\models\Region;
use country\models\Country;

/* @var $this yii\web\View */
/* @var $model \country\models\City */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="city-form">

    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        //'options' => ['class' => 'form-horizontal', /*'enctype' => 'multipart/form-data'*/],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-4 control-label'],
            ],
        ]);
    ?>

    <?=$form->errorSummary($model);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model, 'region_id',['parts'=>['{input}'=>
        (new Region)->getWidgetSelectPicker($model, 'region_id')]]) ?>

    <div class="form-group">
        <div class="col-lg-offset-0 col-lg-0">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
