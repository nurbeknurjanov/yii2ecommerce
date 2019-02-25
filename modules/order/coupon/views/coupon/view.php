<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model coupon\models\Coupon */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Coupons'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
		if(Yii::$app->user->can('updateCoupon', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteCoupon', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'code',
            'discount',
            [
                'attribute'=>'interval_from',
                'format'=>'date',
            ],
            [
                'attribute'=>'interval_to',
                'format'=>'date',
            ],
            [
                'attribute'=>'used',
                //'format'=>'boolean',
                'value'=>$model->usedText,
            ],
            [
                'attribute'=>'reusable',
                //'format'=>'boolean',
                'value'=>$model->reusableText,
            ],
        ],
    ]) ?>

</div>
