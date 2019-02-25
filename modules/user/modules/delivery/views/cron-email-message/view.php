<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model delivery\models\CronEmailMessage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Report of cron email messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cron-email-message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_date:datetime',
            'recipient_email:email',
            'recipient_name',
            'sender_email:email',
            'sender_name',
            'subject',
            'body',
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value'=>$model->statusText,
            ],
            'sent_date:datetime',
        ],
    ]) ?>

</div>
