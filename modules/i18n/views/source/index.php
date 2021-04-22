<?php

use yii\helpers\Html;
use yii\grid\GridView;
use extended\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel i18n\models\search\I18nSourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'I18n Source Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-source-message-index card">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card-header">
        <?= Html::a(Yii::t('common', 'Create I18n Source Message'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card-body">
        To translate messages, use in code this format
        <code>
            Yii::t('db_frontend', 'Some message');
        </code>
        <br/>
        Example:
        <code>
            Yii::t('db_category', 'All categories');
        </code>
        <br/>
        After app is run, app tries to translate it. If translation is missing, it creates new record here. <br/>
        Just update the record fulfilling the translation <?=Html::a('here', ['/i18n/message/index'])?>, selecting the language.
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute'=>'category',
                'filter'=>$searchModel->categoryValues,
            ],
            [
                'attribute'=>'message',
                'value'=>function($data){
                    return StringHelper::truncate($data->message, 50) ;
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
