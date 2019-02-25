<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use file\widgets\file_preview\FilePreview;
use kartik\rating\StarRating;
use extended\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model comment\models\Comment */

$this->title = StringHelper::truncate($model->text, 50);
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Comments'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('page');
?>
<div class="comment-view box">


    <div class="box-header">
        <?php
		if(Yii::$app->user->can('updateComment', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteComment', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        ?>
    </div>

    <?php
    $widget =  Yii::createObject([
        'class'=>DetailView::className(),
        'model' => $model,
        'attributes' => [
            'rating'=>[
                'attribute'=>'ratingOrderAttribute',
                //'attribute'=>'rating',
                'format'=>'raw',
                'value'=>$model->rating ?
                    StarRating::widget([
                        'name' => 'rating-'.$model->id,
                        'value' => $model->rating->mark,
                    ]):null,
            ],
            'id',
            'model_id',
            'model_name',
            'name',
            [
                'attribute'=>'user_id',
                'format'=>'raw',
                'value'=>$model->user ? Html::a($model->user->fullName, ['/user/user/view', 'id'=>$model->user_id]):null,
            ],
            'ip',
            'name',
            'text',
            [
                'attribute'=>'created_at',
                'format'=>'datetime',
            ],
            [
                'attribute'=>'updated_at',
                'format'=>'datetime',
            ],
            [
                'attribute'=>'videosAttrbiute',
                'format'=>'raw',
                'value'=>FilePreview::widget(['video'=>$model->video]),
                'visible'=>(boolean) $model->video,
            ],
            [
                'attribute'=>'imagesAttribute',
                'format'=>'raw',
                'value'=>FilePreview::widget(['images'=>$model->images]),
                'visible'=>(boolean) $model->images,
            ],
            'enabled:boolean',
        ],
    ]) ;
    $this->params['widget'] = $widget;
    $widget->init();
    ?>

    <?php $this->beginBlock('detailView') ?>
        <div class="box-body">
            <?=$widget->run() ?>
        </div>
    <?php $this->endBlock() ?>
    {{detailView}}

</div>
<?php $this->endBlock() ?>
{{page}}