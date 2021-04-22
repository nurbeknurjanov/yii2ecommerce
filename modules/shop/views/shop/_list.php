<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="col-lg-3 col-sm-3 col-xs-4 list-block list-block-shop" style="text-align: left; ">
    <div style="height: 140px;">
        <div style="display: flex">
            <div style="">
                <a href="<?=Url::to($model->url)?>">
                    <?=$model->getThumbImg('sm')?>
                </a>
            </div>
            <div style="padding: 0 10px; display: flex;
            align-items: flex-start;
         flex-grow: 1;
            flex-wrap: wrap;
">
                <div style=" flex-basis: 100%">
                    <b><?=Html::a($model->title, $model->url);?></b>
                    <br/>
                    <?=$model->description?>
                </div>
                <div style=" align-self: flex-end;  flex-basis: 100% ">
                    <?=$model->getAttributeLabel('address')?>: <?=$model->address?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>