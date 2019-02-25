<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


use yii\bootstrap\Tabs;
use yii\widgets\Pjax;
use yii\base\Widget;

/* @var $this yii\web\View */
/* @var $model \product\models\Product */

$characteristics = $model->valuesWithFields;
echo Tabs::widget([
    'id'=>'product-tabs',
    'items' => [
        [
            'options' => ['id' => 'fields'],
            'label' => Yii::t('product', 'Characteristics'),
            'content' => '<br>'.$this->render('_view_characteristics',['model'=>$model,
                        'characteristics'=>$characteristics]),
            'visible'=>(boolean) $characteristics,
            //'options' => ['tag' => 'div'],
            //'headerOptions' => ['class' => 'my-class'],
        ],
        [
            'options' => ['id' => 'comments'],
            'encode'=>false,
            'label' => Yii::t('product', 'Reviews')."(".
                Pjax::widget([
                    'id'=>'commentCountPjax',
                    'on '.Widget::EVENT_BEFORE_RUN=>function() use ($model){
                        echo $model->getComments()->count();
                    },
                    'options'=>[
                        'tag'=>'span',
                    ]])
                .")",
            'content' => $this->render('_view_comments', ['model'=>$model]),
            'active'=>Yii::$app->request->get('tab')=='comments' || (!$characteristics && !$model->description),
        ],
        [
            'options' => ['id' => 'description'],
            'label' => $model->getAttributeLabel('description'),
            'content' => '<br>'.$model->description,
            'visible'=> (boolean) $model->description,
        ],

    ],
    'options' => ['tag' => 'div'],
    'itemOptions' => ['tag' => 'div'],
    //'headerOptions' => ['class' => 'my-class'],
    'clientOptions' => ['collapsible' => false],
]);