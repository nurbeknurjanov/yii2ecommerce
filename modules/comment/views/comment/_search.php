<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use extended\helpers\Helper;
        
/* @var $this yii\web\View */
/* @var $model comment\models\search\CommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-search advancedSearch"  style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>" >

    <?php $form = ActiveForm::begin([
        'action' => '/'.Yii::$app->controller->route,
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'id') ?>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'model_name')->dropDownList($model->modelNameValues,['prompt'=>'Select']) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'model_id') ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <?=$form->field($model, 'enabled')->radioList(Helper::$booleanValues) ?>
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
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default', 'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>