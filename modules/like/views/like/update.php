<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model like\models\Like */

$this->title = Yii::t('common', 'Update like: ') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Likes'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="like-update card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
