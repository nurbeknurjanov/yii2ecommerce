<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use user\models\User;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel \user\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index card">

    <div class="card-header">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= Html::a(Yii::t('user', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php //Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function (User $data, $index, $widget, $grid){
                if($data->status==User::STATUS_DELETED)
                    return ['class' => 'danger'];
            },
        'columns' => [
            [
                'attribute'=>'id',
                'contentOptions'=>[
                    'style'=>'width:10px;',
                ],
            ],
            'email:email',
            //'username',
            [
                'attribute'=>'name',
                'value'=>function($data){
                        return $data->fullName;
                    },
            ],
            /*[
                'attribute'=>'created_at',
                'format'=>'datetime',
            ],*/
            [
                'attribute'=>'status',
                'value'=>function($data){
                        return $data->statusText;
                    },
                'filter'=>$searchModel->statusOptions,
            ],
            [
                'attribute'=>'rolesAttribute',
                'value'=>function($data){
                        return $data->rolesText;
                    },
                'filter'=>$searchModel->possibleRolesValues,
            ],
            /*[
                'attribute'=>'subscribe',
                'format'=>'raw',
                'value'=>function(User $data){
                    return $data->subscribeText;
                },
                'filter'=>$searchModel->subscribeValues,
            ],*/
            [
                'attribute'=>'shopsAttribute',
                'format'=>'raw',
                'value'=>function(User $data){
                    return implode(', ', ArrayHelper::map($data->shops,'id', 'link'));
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {disable} {reset}',
                'buttons'=>[
                    'view'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class'=>'btn btn-xs btn-default',
                        ];
                        if(Yii::$app->user->can('viewUser', ['model' => $model]))
                            return Html::a('<span class="fa fa-eye"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class'=>'btn btn-xs btn-primary',
                        ];
                        if(Yii::$app->user->can('updateUser', ['model' => $model]))
                            return Html::a('<span class="fa fa-pencil-alt"></span>', $url, $options);
                    },
                    'delete'=>function ($url, $model, $key){
                            $options = [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'All history will be deleted, you can also disable user, then user cannot login, but all history remains. Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class'=>'btn btn-xs btn-danger',
                            ];
                            if(Yii::$app->user->can('deleteUser', ['model' => $model]))
                                return Html::a('<span class="fa fa-times"></span>', $url, $options);
                        },
                    'disable'=>function ($url, User $model, $key){
                            if(Yii::$app->user->can(User::ROLE_MANAGER))
                                if($model->isActive){
                                    $options = [
                                        'title' => Yii::t('user', 'Disable'),
                                        'aria-label' => Yii::t('user', 'Disable'),
                                        'data-pjax' => '0',
                                        'class'=>'btn btn-xs btn-warning',
                                    ];
                                    return Html::a(Yii::t('user', 'Disable'), $url, $options);
                                }else{
                                    $options = [
                                        'title' => Yii::t('user', 'Enable'),
                                        'aria-label' => Yii::t('user', 'Enable'),
                                        'data-pjax' => '0',
                                        'class'=>'btn btn-xs btn-success',
                                    ];
                                    return Html::a(Yii::t('user', 'Enable'), ['/user/manage/user/enable', 'id'=>$model->id], $options);
                                }
                        },
                    'reset'=>function ($url, $model, $key){
                            $options = [
                                'title' => Yii::t('user', 'Reset password'),
                                'aria-label' => Yii::t('user', 'Reset password'),
                                'data-pjax' => '0',
                                'class'=>'btn btn-xs btn-default',
                            ];
                            if(Yii::$app->user->can(User::ROLE_MANAGER))
                                return Html::a(Yii::t('user', 'Reset password'), ['/user/manage/user/reset-password', 'id'=>$model->id,], $options);
                        },
                ],
            ],
        ],
    ]); ?>

    <?php //Pjax::end(); ?>

</div>
