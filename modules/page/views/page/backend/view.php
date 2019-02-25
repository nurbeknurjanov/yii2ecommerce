<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use file\widgets\file_preview\FilePreview;


/* @var $this yii\web\View */
/* @var $model page\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Pages'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view box">

    <div class="box-header">
        <?php
		if(Yii::$app->user->can('updatePage', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deletePage', ['model' => $model]))
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
                'url:url',
                'title',
                'text:raw',
                [
                    'attribute'=>'imagesAttribute',
                    'format'=>'raw',
                    'value'=>FilePreview::widget(['images'=>$model->images, 'actions'=>false]),
                    'visible'=>(boolean) $model->images,
                ],
            ],
        ]) ?>
    </div>


</div>
