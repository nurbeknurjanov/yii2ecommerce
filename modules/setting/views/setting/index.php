<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use extended\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel setting\models\search\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index box">


    <div class="box-header">
        <?= Alert::widget() ?>
        <?php
		if(Yii::$app->user->can('createSetting'))
            echo Html::a(Yii::t('common', 'Create Setting') . ' <i class="fas fa-chevron-right"></i>', ['create'], ['class' => 'btn btn-primary pull-right']);
        ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'key',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->keyText;
                },
                'filter'=>$searchModel->keyValues,
            ],
            [
                'attribute'=>'value',
                'format'=>'raw',
                'value'=>function($data){
                    return StringHelper::truncate($data->value);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'buttons'=>[
                    'view'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-xs btn-default',
                        ];
                        if(Yii::$app->user->can('viewSetting', ['model' => $model]))
                            return Html::a('<i class="fas fa-eye"></i>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-xs btn-success'
                        ];
                        if(Yii::$app->user->can('updateSetting', ['model' => $model]))
                            return Html::a('<i class="fas fa-pencil-alt"></i>', $url, $options);
                    },
                    'delete'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'class' => 'btn btn-xs btn-danger'
                        ];
                        if(Yii::$app->user->can('deleteSetting', ['model' => $model]))
                            return Html::a('<i class="fas fa-times"></i>', $url, $options);
                    },
                ],
            ],

        ],
    ]); ?>

</div>
