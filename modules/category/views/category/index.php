<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use category\models\Category;
use \yii\grid\GridViewAsset;
use extended\helpers\StringHelper;
use extended\helpers\Helper;

/* @var $this yii\web\View */
/* @var $searchModel \category\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

GridViewAsset::register($this);

$this->title = Yii::t('common', 'Categories');
$this->params['breadcrumbs'][] = $this->title;


$this->beginBlock('page');
?>

<div class="category-index box">


    <div class="box-header">
        <?= Alert::widget() ?>
        <?php $this->beginBlock('search_form'); ?>
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php $this->endBlock(); ?>
        {{search_form}}
        <?php
		if(Yii::$app->user->can('createCategory'))
            echo Html::a(Yii::t('common', 'Create Category'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </div>

    <?php
    $dataProvider->pagination = false;
    $this->params['columns'] = [
        'id',
        [
            'attribute'=>'imageAttribute',
            'format'=>'raw',
            'value'=>function($data){
                return $data->image ? $data->image->img:null;
            },
            'filter'=>Helper::$booleanValues,
        ],
        [
            'attribute'=>'title',
            'format'=>'raw',
            'value'=>function(Category $data){
                return $data->title;
            },
        ],
        //'title_ru',
        [
            'attribute'=>'title_url',
            'format'=>'raw',
            'value'=>function($data){
                return StringHelper::truncate($data->title_url, 10) ;
            },
        ],
        [
            'attribute'=>'text',
            'format'=>'raw',
            'value'=>function($data){
                return StringHelper::truncate($data->text, 10) ;
            },
        ],
        'enabled:boolean',
        'buttons'=>[
            'class' => 'yii\grid\ActionColumn',
            'visibleButtons' => [
                //'view' => true,
                'view' => function ($model, $key, $index) {
                    return Yii::$app->user->can('viewCategory', ['model' => $model]);
                },
                'update' => function ($model, $key, $index) {
                    return Yii::$app->user->can('updateCategory', ['model' => $model]);
                },
                'delete' => function ($model, $key, $index) {
                    return Yii::$app->user->can('deleteCategory', ['model' => $model]);
                },
            ],  
        ],
    ];

    $widget = Yii::createObject([
        'class'=>GridView::class,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $this->params['columns'],
    ]);
    $widget->columns=$this->params['columns'];
    $widget->init();

    $this->params['widget'] = $widget;
    ?>
    <?php $this->beginBlock('grid'); ?>
        <?=$widget->run();?>
    <?php $this->endBlock(); ?>
    {{grid}}

</div>
<?php $this->endBlock(); ?>
{{page}}
