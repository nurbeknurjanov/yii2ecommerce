<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use file\models\FileImage;
use file\models\File;
use extended\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel \file\models\search\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index box">


    <div class="box-header">
        <?= Alert::widget() ?>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //'id',
            [
                'attribute'=>'type',
                'value'=>function($data){
                        return $data->typeText;
                    },
                'filter'=>$searchModel->allTypeValues,
            ],
            [
                'attribute'=>'file_name',
                'label'=>'File',
                'format'=>'raw',
                'value'=>function($data){
                        return $data->icon;
                    },
                'filter'=>false
            ],
            [
                'attribute'=>'model_id',
                'label'=>'Model',
                'format'=>'raw',
                'value'=>function(File $data){
                    return Html::a(StringHelper::truncate($data->modelTitle,20), $data->modelUrl);
                },
            ],
            [
                'attribute'=>'model_name',
                'value'=>function($data){
                        return $data->shortModelName;
                    },
                'filter'=>$searchModel->modelNameValues,
            ],

            'title',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'visibleButtons' => [
                    //'view' => true,
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('update'.$model->shortModelName, ['model' => $model->model]);
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('update'.$model->shortModelName, ['model' => $model->model]);
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('update'.$model->shortModelName, ['model' => $model->model]);
                    },
                ],

            ],

        ],
    ]); ?>

</div>
