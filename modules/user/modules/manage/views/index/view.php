<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use user\models\User;

/* @var $this yii\web\View */
/* @var $model \user\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view box">
    <div class="box-header">
        <?php
        if(Yii::$app->user->can('updateUser', ['model'=>$model,]))
            echo Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteUser', ['model'=>$model,]))
            echo Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'All history will be deleted, you can also disable user, then user cannot login, but all history remains. Are you sure you want to delete this item?'),
                    'method' => 'post',
                    'params'=>[
                        'returnUrl'=>\yii\helpers\Url::to(['index']),
                    ],
                ],
            ]);
        ?>
        <?php
        if($model->status==User::STATUS_ACTIVE)
            echo Html::a(Yii::t('common', 'Disable'), ['disable', 'id' => $model->id], [  'class' => 'btn btn-warning' ]);
        else
            echo Html::a(Yii::t('common', 'Enable'), ['enable', 'id' => $model->id], [  'class' => 'btn btn-success' ]);
        ?>
        <?=Html::a(Yii::t('common', 'Reset password'), ['reset-password', 'id' => $model->id], [  'class' => 'btn btn-default' ]);?>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            [
                'attribute'=>'imageAttribute',
                'format'=>'raw',
                'value'=>$model->image ? $model->image->getImg('sm') : null,
            ],
            'name',
            'email:email',
            [
                'attribute'=>'rolesAttribute',
                'value'=>$model->rolesText,
            ],
            [
                'attribute'=>'status',
                'value'=>$model->statusText,
            ],
            [
                'attribute'=>'language',
                'format'=>'raw',
                'value'=>$model->languageText,
            ],
            [
                'attribute'=>'time_zone',
                'format'=>'raw',
                'value'=>$model->timeZoneText,
            ],
            [
                'attribute'=>'subscribe',
                'format'=>'raw',
                'value'=>$model->subscribeText,
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute'=>'referrer_id',
                'format'=>'raw',
                'value'=>$model->referrer ? $model->referrer->name:null,
            ],
            'from',
        ],
    ]) ?>
    </div>

</div>
