<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridViewAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model user\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */

GridViewAsset::register($this);
?>

<div class="advancedSearch" style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'username') ?>
            <?=$form->field($model, 'status')->dropDownList($model->statusValues, ['prompt'=>'Select',]) ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($model, 'subscribe')->radioList($model->subscribeValues) ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($model, 'created_at',['parts'=>[
                '{input}'=> $model->getBehavior('dateSearchCreatedAt')->getWidgetFilter(true)
            ]])?>
            <?=$form->field($model, 'updated_at',['parts'=>[
                '{input}'=> $model->getBehavior('dateSearchUpdatedAt')->getWidgetFilter(true)
            ]])?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default',
            'onclick'=>"javascript:window.location.href='".Url::to(['/user/manage'])."'",]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>


