<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model i18n\models\I18nMessage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'I18n Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-message-view box">


    <div class="box-header">
        <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id, 'language' => $model->language], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id, 'language' => $model->language], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute'=>'sourceMessage',
                    'format'=>'raw',
                    'value'=>$model->source->message,
                ],
                'language',
                'translation:ntext',
            ],
        ]) ?>
    </div>


</div>
