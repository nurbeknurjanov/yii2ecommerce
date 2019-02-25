<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;
        
/* @var $this yii\web\View */
/* @var $model coupon\models\search\CouponSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coupon-search advancedSearch"  style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>" >

    <?php $form = ActiveForm::begin([
        'action' => '/'.Yii::$app->controller->route,
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'discount') ?>

    <?= $form->field($model, 'interval_from')->widget(DateTimePicker::className(), [
        'model' => $model,
        'attribute' => 'interval_from',
        'options' => ['placeholder' => 'Select time'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
        ]
    ]) ?>

    <?php echo $form->field($model, 'interval_to')->widget(DateTimePicker::className(), [
        'model' => $model,
        'attribute' => 'interval_to',
        'options' => ['placeholder' => 'Select time'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
        ]
    ]) ?>

    <?php echo $form->field($model, 'used')->radioList($model->usedValues, ['prompt'=>Yii::t('common', 'Select'),]) ?>

    <?php echo $form->field($model, 'reusable')->radioList($model->reusableValues, ['prompt'=>Yii::t('common', 'Select'),]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default', 'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>