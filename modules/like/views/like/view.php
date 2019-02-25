<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model like\models\Like */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Likes'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="like-view box">


    <div class="box-header">
        <?php
		if(Yii::$app->user->can('updateLike', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteLike', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        ?>
    </div>

    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'model_id',
                'model_name',
                'user_id',
                'ip',
                [
                    'attribute'=>'mark',
                    'value'=>$model->markText,
                ],
            ],
        ]) ?>

    </div>


</div>
