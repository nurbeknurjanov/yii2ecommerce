<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model page\models\Page */

$this->title = Yii::t('page', 'Update Page') . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('page', 'Pages'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="page-update card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
