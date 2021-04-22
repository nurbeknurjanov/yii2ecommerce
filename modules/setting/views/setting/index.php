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

if(Yii::$app->user->can('createSetting'))
    $this->params['buttons'][] = Html::a(Yii::t('common', 'Create Setting'), ['create'], ['class' => 'btn btn-primary']);
?>


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
        ],

    ],
]); ?>
