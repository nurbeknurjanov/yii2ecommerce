<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \i18n\models\I18nSourceMessage;
use \i18n\models\I18nMessage;
use extended\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel i18n\models\search\I18nMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'I18n Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-message-index card">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card-header">
        <?= Html::a(Yii::t('common', 'Create I18n Message'), ['create'], ['class' => 'btn btn-success']) ?>
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
        Just update the record fulfilling the translation here, selecting the language.
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute'=>'sourceMessage',
                'format'=>'raw',
                'value'=>function(I18nMessage $data){
                    return $data->source->message;
                },
            ],
            [
                'attribute'=>'language',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->languageText;
                },
                'filter'=>(new I18nSourceMessage())->languageValues,
            ],
            [
                'attribute'=>'translation',
                'format'=>'raw',
                'value'=>function($data){
                    return StringHelper::truncate($data->translation);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
