<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use category\models\Category;
use yii\helpers\ArrayHelper;
use eav\models\DynamicField;

/* @var $this yii\web\View */
/* @var $searchModel eav\models\search\DynamicFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('eav', 'Dynamic fields');
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="dynamic-field-index card">


    <div class="card-header">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= Html::a(Yii::t('eav', 'Create dynamic field'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //'key',
            [
                'attribute'=>'category_id',
                'value'=>function($model) { return $model->category ? $model->category->title:null; },
                'filter'=>Html::activeDropDownList($searchModel, 'category_id', ArrayHelper::map(
                        Category::find()
                            ->defaultFrom()->defaultOrder()
                            ->selectTitle()->enabled()->all(), 'id', 'title'), ['prompt'=>'', 'encode'=>false, 'class'=>'form-control',]),
            ],
            'label',
            [
                'attribute'=>'type',
                'value'=>function($model) { return $model->typeText; },
                'filter'=>$searchModel->typeValues,
            ],
            [
                'attribute'=>'section',
                'value'=>function($model) { return $model->sectionText; },
                'filter'=>$searchModel->sectionValues,
            ],
            'json_values:ntext',
            [
                'attribute'=>'rule',
                'value'=>function($model) { return $model->ruleText; },
                'filter'=>$searchModel->ruleValues,
            ],
            'position',
            //'key',
            //'default_value',
            /*[
               'attribute'=>'enabled',
               'format'=>'boolean',
               'filter'=>$searchModel->booleanValues,
           ],*/
            [
                'attribute'=>'result',
                'format'=>'raw',
                'value'=>function(DynamicField $model) { return $model->getResultText(['labelOptions'=>['style'=>'display:block;'],]); },
                //'value'=>function($model) { return $model->resultText; },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
