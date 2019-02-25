<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model country\models\City */

$this->title = Yii::t('common', 'Update city: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Cities'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="city-update box">


    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
