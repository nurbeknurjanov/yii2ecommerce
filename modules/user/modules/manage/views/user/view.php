<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use user\models\User;
use extended\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model \user\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view card">
    <div class="card-header">
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
        if(Yii::$app->user->can(User::ROLE_MANAGER)){
            if($model->isActive)
                echo Html::a(Yii::t('user', 'Disable'), ['disable', 'id' => $model->id], [  'class' => 'btn btn-warning' ]);
            else
                echo Html::a(Yii::t('user', 'Enable'), ['enable', 'id' => $model->id], [  'class' => 'btn btn-success' ]);
        }
        ?>
        <?php
        if(Yii::$app->user->can(User::ROLE_MANAGER))
            echo Html::a(Yii::t('user', 'Reset password'), ['reset-password', 'id' => $model->id], [  'class' => 'btn btn-default' ]);?>
    </div>
    <div class="card-body">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            [
                'attribute'=>'imageAttribute',
                'format'=>'raw',
                'value'=>$model->image ? $model->image->getThumbImg('sm') : null,
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
                'attribute'=>'subscribe',
                'format'=>'raw',
                'value'=>$model->subscribeText,
            ],
            [
                'attribute'=>'shopsAttribute',
                'format'=>'raw',
                'value'=>implode(', ', ArrayHelper::map($model->shops,'id','link')),
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    </div>

</div>
