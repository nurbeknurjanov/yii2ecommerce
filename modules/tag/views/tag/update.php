<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model tag\models\Tag */

$this->title = Yii::t('common', 'Update {modelClass}: ', [
    'modelClass' => 'Tag',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Tags'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="tag-update card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
