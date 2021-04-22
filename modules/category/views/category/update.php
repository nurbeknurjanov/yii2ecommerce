<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model category\models\Category */

$this->title = Yii::t('common', 'Update {modelClass}: ', [
    'modelClass' => 'Category',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Categories'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="category-update card">


    <?php $this->beginBlock('form') ?>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    <?php $this->endBlock() ?>
    {{form}}

</div>
