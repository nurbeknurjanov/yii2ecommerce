<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use user\models\User;
use yii\widgets\Pjax;
use order\models\Order;


/*(new \kartik\base\Widget(['pjaxContainerId'=>'ordersPjax']))->registerWidgetJs("
alert('Hey');
");*/

/* @var $this yii\web\View */
/* @var $searchModel \order\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Orders');
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('page');
?>
    <div class="order-index box">





        <div class="box-header">
            <?= Alert::widget() ?>
            <?php $this->beginBlock('form') ?>
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php $this->endBlock() ?>
            {{form}}
        </div>

        <?php
        $columns = [
            'id',
            [
                'attribute'=>'created_at',
                'format'=>'datetime',
                'filter'=>$searchModel->getBehavior('dateSearchCreatedAt')->widgetFilter,
            ],
            [
                'attribute'=>'nameAttribute',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->user ? Html::a($data->user->fullName, ['/user/user/view', 'id'=>$data->user_id]):$data->name;
                },
            ],
            /*[
                'attribute'=>'city_id',
                'format'=>'raw',
                'value'=>function(Order $data){
                    return $data->city->name;
                },
            ],*/
            //'phone',
            //'address',
            //'description:ntext',
            //'delivery_id',
            'amount',
            [
                'attribute'=>'payment_type',
                'value'=>function($data){
                    return $data->paymentTypeText;
                },
                'filter'=>$searchModel->paymentTypeValues,
            ],
            [
                'attribute'=>'status',
                'value'=>function($data){
                    return $data->statusText;
                },
                'filter'=>$searchModel->statusValues,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'visibleButtons' => [
                    //'view' => true,
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('viewOrder', ['model' => $model]);
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('updateOrder', ['model' => $model]);
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('deleteOrder', ['model' => $model]);
                    },
                ],
            ],
        ];

        $this->params['columns'] = $columns;

        $widget = Yii::createObject([
        'class'=>GridView::className(),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
        ]);
        $widget->columns=$columns;
        $widget->init();

        $this->params['widget'] = $widget;
        ?>

        <?php
        /*Pjax::begin([
            'id'=>'ordersPjax',
            'enablePushState'=>true,
        ])*/
        ?>
        <?=$widget->run();?>
        <?php //Pjax::end() ?>

    </div>
<?php $this->endBlock() ?>
{{page}}
