<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model country\models\Region */

$this->title = Yii::t('common', 'Update region: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Regions'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="region-update box">

    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
