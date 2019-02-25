<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use file\widgets\file_preview\FilePreview;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model article\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Articles'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('view',true);
?>

<div class="article-view box">


    <div class="box-header">
        <?php
		if(Yii::$app->user->can('updateArticle', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteArticle', ['model' => $model]))
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
    $attributes = [
        'id',
        [
            'attribute'=>'type',
            'value'=>$model->typeText,
        ],
        'title',
        'text:raw',
        'created_at',
        'updated_at',
        [
            'attribute'=>'tagsAttribute',
            'format'=>'raw',
            'value'=>call_user_func(function() use($model) {
                return implode(', ', ArrayHelper::map($model->tags, 'id', 'title'));
            }),
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
    ];
    ?>
    <?php $this->beginBlock('detailView',true) ?>

        <?php $widget =  Yii::createObject([
            'class'=>DetailView::className(),
            'model' => $model,
            'attributes' => $attributes,
        ]) ;
        $this->params['widget'] = $widget;
        $widget->init();
        ?>

        <div class="box-body">
            <?=$widget->run()?>
        </div>

    <?php $this->endBlock() ?>


</div>
<?php $this->endBlock() ?>

