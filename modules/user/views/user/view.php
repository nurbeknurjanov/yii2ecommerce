<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use user\models\User;
use file\widgets\file_preview\FilePreview;

/* @var $this yii\web\View */
/* @var $model \user\models\User */

$this->title = $model->fullName;
if(Yii::$app->user->can('listUser'))
    $this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Users'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
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
            'description:raw',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute'=>'imageAttribute',
                'format'=>'raw',
                'value'=>$model->image ? $model->image->getThumbImg('sm') : null,
            ],
            [
                'attribute'=>'imagesAttribute',
                'format'=>'raw',
                'value'=>$model->images ?  FilePreview::widget(['images'=>$model->images, 'actions'=>false]) : null,
            ],
        ],
    ]) ?>

</div>
