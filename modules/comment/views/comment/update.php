<?php

use yii\helpers\Html;
use extended\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model comment\models\Comment */

$this->title = Yii::t('common', 'Update {modelClass}: ', [
    'modelClass' => 'Comment',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Comments'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' =>StringHelper::truncate($model->text, 20), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="comment-update box">


    <?php $this->beginBlock('form') ?>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    <?php $this->endBlock() ?>
    {{form}}

</div>
