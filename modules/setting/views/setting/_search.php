<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model setting\models\search\SettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-search advancedSearch"  style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>" >

    <?php $form = ActiveForm::begin([
        'action' => '/'.Yii::$app->controller->route,
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'value') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default', 'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>