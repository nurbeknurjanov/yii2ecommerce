<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model country\models\City */

$this->title = Yii::t('country', 'Update City') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('country', 'Cities'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="city-update card">


    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
