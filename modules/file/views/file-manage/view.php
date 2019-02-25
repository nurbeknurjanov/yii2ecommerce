<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use file\models\File;
use file\models\FileImage;

/* @var $this yii\web\View */
/* @var $model \file\models\File */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Files'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-view box">

    <div class="box-header">
        <?php
        if(Yii::$app->user->can('update'.$model->shortModelName, ['model' => $model->model])){
            ?>
            <?=Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary',
            ]);?>
            <?=Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);?>
            <?php
        }

        ?>
    </div>

    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute'=>'type',
                    'value'=>$model->typeText,
                ],
                [
                    'attribute'=>'file_name',
                    'label'=>'File',
                    'format'=>'raw',
                    'value'=>$model->icon,
                ],
                'model_id',
                'model_name',
                [
                    'attribute'=>'model_id',
                    'label'=>'Model',
                    'format'=>'raw',
                    'value'=>Html::a($model->modelTitle, $model->modelUrl),
                ],
                'title',
                'created_at:datetime',
            ],
        ]) ?>

    </div>

</div>
