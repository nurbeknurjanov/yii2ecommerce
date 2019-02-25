<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $characteristics \eav\models\DynamicValue[] */

$fields=[];
foreach ($characteristics as $valueModel)
    $fields[]=[
        'attribute'=>'id',
        'label'=>$valueModel->field->label,
        //'label'=>$valueModel->getAttributeLabel('value'),
        'format'=>'raw',
        'value'=>$valueModel->valueLinkText.' '.$valueModel->field->unit,
    ];
$widget =  Yii::createObject([
    'class'=>DetailView::class,
    'options'=>['class'=>'table detail-view product-detail-view'],
    'model' => $model,
    'attributes' => $fields
]) ;
$this->params['widget'] = $widget;
$widget->init();

echo $widget->run();
