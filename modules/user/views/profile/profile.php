<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use file\models\FileImage;
use yii\bootstrap\Tabs;
use file\widgets\file_preview\FilePreview;


/* @var $this yii\web\View */
/* @var $model user\models\User */

$this->title = Yii::t('user', 'My profile');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">


    <?php $detailView =  DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'name',
            [
                'attribute'=>'email',
                'format'=>'raw',
                'value'=>$model->email.' '.Html::a(Yii::t('common', 'Change'), ['/user/profile/change-email'], ['class'=>'btn btn-success btn-xs',]),
            ],
            [
                'attribute'=>'rolesAttribute',
                'value'=>$model->rolesText,
            ],
            [
                'attribute'=>'status',
                'value'=>$model->statusText,
            ],
            'description:raw',
            [
                'attribute'=>'subscribe',
                'format'=>'raw',
                'value'=>$model->subscribeText,
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute'=>'imageAttribute',
                'format'=>'raw',
                'value'=>$model->image ? $model->image->getThumbImg('sm') : null,
            ],
        ],
    ]);


    echo Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('user', 'Personal details'),
                'content' => $detailView,
                'options' => ['tag' => 'div'],
                'headerOptions' => ['class' => 'my-class'],
            ],
            [
                'label' => Yii::t('common', 'Description'),
                'content' => '<br>'.$model->description,
                'options' => ['id' => 'my-tab'],
            ],
            [
                'label' => Yii::t('common', 'Photos'),
                'content' => '<br>'. FilePreview::widget(['images'=>$model->images, 'actions'=>false]),
                'options' => ['id' => 'my-tab3'],
            ],
            /*[
                'label' => 'Ajax tab',
                'url' => ['ajax/content'],
            ],*/
        ],
        'options' => ['tag' => 'div'],
        'itemOptions' => ['tag' => 'div'],
        'headerOptions' => ['class' => 'my-class'],
        'clientOptions' => ['collapsible' => false],
    ]);
    ?>

</div>
