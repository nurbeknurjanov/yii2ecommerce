<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \page\models\HelpForm */

?>




<div class="row">
    <div class="col-lg-6">
        <h3><?=$model->subject?></h3>
        <?= DetailView::widget([
            'model' => $model,
            'options'=>['style'=>'border:1px solid #ddd;'],
            'attributes' => [
                [
                    'attribute'=>'name',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'email',
                    'format'=>'raw',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'phone',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'body',
                    'format'=>'raw',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'IP',
                    'format'=>'raw',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'user_id',
                    'format'=>'raw',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                    'value'=>$user,
                ],
                [
                    'attribute'=>'date',
                    'format'=>'datetime',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'page_url',
                    'format'=>'raw',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                    'value'=>$page_url,
                ],
            ],
        ]);
        ?>
    </div>
</div>

