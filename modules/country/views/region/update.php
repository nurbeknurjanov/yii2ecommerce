<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model country\models\Region */

$this->title = Yii::t('country', 'Update State/Province') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('country', 'States/Provinces'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="region-update card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
