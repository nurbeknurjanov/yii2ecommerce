<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use user\models\User;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel \user\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index box">

    <div class="box-header">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= Html::a(Yii::t('common', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'id',
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
                'filter'=>$searchModel->statusValues,
            ],
            [
                'attribute'=>'rolesAttribute',
                'value'=>function($data){
                        return $data->rolesText;
                    },
                'filter'=>$searchModel->possibleRolesValues,
            ],
            /*[
                'attribute'=>'referrer_id',
                'format'=>'raw',
                'value'=>function($data){
                        return $data->referrer ? Html::a($data->referrer->name, ['/user/manage/index/view', 'id'=>$data->referrer_id], ['target'=>'_blank',]):null ;
                    },
            ],*/
            //'attribute'=>'from',
            [
                'attribute'=>'subscribe',
                'format'=>'raw',
                'value'=>function(User $data){
                    return $data->subscribeText;
                },
                'filter'=>$searchModel->subscribeValues,
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
                            return Html::a('<span class="fa fa-pencil"></span>', $url, $options);
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
                            return Html::a('<span class="fa fa-times"></span>', $url, $options);
                        },
                    'disable'=>function ($url, $model, $key){
                            if($model->status==User::STATUS_ACTIVE){
                                $options = [
                                    'title' => Yii::t('yii', 'Disable'),
                                    'aria-label' => Yii::t('yii', 'Disable'),
                                    'data-pjax' => '0',
                                    'class'=>'btn btn-xs btn-warning',
                                ];
                                return Html::a(Yii::t('common', 'Disable'), $url, $options);
                            }else{
                                $options = [
                                    'title' => Yii::t('yii', 'Enable'),
                                    'aria-label' => Yii::t('yii', 'Enable'),
                                    'data-pjax' => '0',
                                    'class'=>'btn btn-xs btn-success',
                                ];
                                return Html::a(Yii::t('common', 'Enable'), ['/user/manage/index/enable', 'id'=>$model->id], $options);
                            }
                        },
                    'reset'=>function ($url, $model, $key){
                            $options = [
                                'title' => Yii::t('yii', 'Reset password'),
                                'aria-label' => Yii::t('yii', 'Reset password'),
                                'data-pjax' => '0',
                                'class'=>'btn btn-xs btn-default',
                            ];
                            return Html::a('Reset password', ['/user/manage/index/reset-password', 'id'=>$model->id,], $options);
                        },
                ],
            ],
        ],
    ]); ?>

    <?php //Pjax::end(); ?>

</div>
