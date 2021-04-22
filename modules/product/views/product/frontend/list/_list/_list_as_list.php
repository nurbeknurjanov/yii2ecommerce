<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

/* @var $model Product */
use extended\helpers\Html;
use product\models\Product;
use yii\helpers\Url;
use kartik\rating\StarRating;
use order\models\Basket;

$basketProducts = \order\models\Basket::findAll();
?>
<div class="list-block list-block-list-style" >
    <div>
        <a href="<?=Url::to($model->url)?>"  class="<?=$model->typeClass?>"  data-discount="<?=$model->discount?>" >
            <?=$model->getThumbImg('sm')?>
        </a>
        <div class="block">
            <?=Html::a($model->title, $model->url, ['class'=>'title']);?>
            <div><?=Yii::$app->formatter->asCurrency($model->price);?></div>
            <div class="description">
                <?=$model->valuesText;?>
            </div>
            <div><?php //echo $model->statusText;?></div>
            <?=Html::a(Yii::t('product', 'Buy'), 'javascript:void(0);',
                [
                    'id'=>'showBasket-'.$model->id,
                    'class'=>'btn btn-warning btn-sm showBasket '.(isset($basketProducts[$model->id])?"alreadyInBasket":null),
                    'data'=>[
                        'count'=>isset($basketProducts[$model->id]) ? $basketProducts[$model->id]['count']:1,
                        'product_id'=>$model->id,
                        'price'=>$model->price,
                        'title'=>$model->title,
                        'group_id'=>$model->group_id,
                    ],
                ]);?>
        </div>
        <div class="stars-block">
            <?=StarRating::widget([
                'pjaxContainerId'=>'productsPjax',
                'id' => 'product-rating-'.$model->id,
                'name' => 'product-rating-'.$model->id,
                'value' => $model->rating,
                'options'=>[
                    'class' => 'product-rating-class',
                ]
            ]);?>
        </div>
    </div>
</div>