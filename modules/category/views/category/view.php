<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model category\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Categories'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('page');
?>
<div class="category-view box">


    <div class="box-header">
        <?php
		if(Yii::$app->user->can('updateCategory', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteCategory', ['model' => $model]))
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
    $model->trigger($model::EVENT_INIT_DATA);
    $widget =  Yii::createObject([
        'class'=>DetailView::class,
        'model' => $model,
        'attributes' => [
            'id',
            'depth',
            'title',
            //'title_ru',
            'title_url',
            [
                'attribute'=>'imageAttribute',
                'format'=>'raw',
                'value'=>$model->image ? $model->image->img:null,
            ],
            'text:raw',
            'product_count',
            'enabled:boolean',
        ],
    ]) ;
    $this->params['widget'] = $widget;
    $widget->init();
    ?>

    <?php $this->beginBlock('detailView') ?>
        <div class="box-body">
            <?=$widget->run(); ?>
        </div>
    <?php $this->endBlock() ?>
    {{detailView}}

</div>
<?php $this->endBlock() ?>
{{page}}
