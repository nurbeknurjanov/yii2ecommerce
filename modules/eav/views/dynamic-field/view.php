<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model eav\models\DynamicField */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Dynamic fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dynamic-field-view card">


    <div class="card-header">
        <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="card-body">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                [
                    'attribute'=>'category_id',
                    'format'=>'raw',
                    'value'=>$model->category_id ? $model->category->title:null,
                ],
                'label',
                [
                    'attribute'=>'type',
                    'value'=>$model->typeText,
                ],
                [
                    'attribute'=>'section',
                    'value'=>$model->sectionText,
                ],
                'json_values:ntext',
                [
                    'attribute'=>'rule',
                    'value'=>$model->ruleText,
                ],
                'key',
                'default_value',
                'with_label:boolean',
                'enabled:boolean',
                'position',
                [
                    'attribute'=>'result',
                    'format'=>'raw',
                    'value'=>$model->resultText,
                ],
            ],
        ]);

        ?>
    </div>


</div>
