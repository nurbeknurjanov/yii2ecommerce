<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

/* @var $this \extended\view\View */

use \product\assets\ProductAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;
if(isset($this->assetManager->bundles['all']))
    $this->clearAssetBundle(ProductAsset::class);
$productAsset = ProductAsset::register($this);
?>

<img src="<?=$productAsset->baseUrl;?>/img/loading.gif" id="pjaxLoading" style="display: none;" />

<div class="list-view-top">
    <div class="sort-block sort-ordinal">
        <?=Yii::t('product', 'Sort by');?>:
        <?=$dataProvider->sort->link('price');?>,
        <?=$dataProvider->sort->link('noveltyAttribute');?>,
        <?=$dataProvider->sort->link('popularAttribute');?>,
        <?=$dataProvider->sort->link('rating');?>
    </div>
    <div class="list-style-block">

        <?php
        $params = ['/product/product/list'] + Yii::$app->request->queryParams;
        if(!$viewStyle || $viewStyle->value=='asTab')
            echo Html::a('<i class="glyphicon glyphicon-th-list"></i> ',
                $params, [
                    'data' => [
                        'method' => 'post',
                        'pjax' => true,
                        'params'=>[
                            'viewStyle'=>'asList',
                        ],
                    ]]);
        if($viewStyle && $viewStyle->value=='asList')
            echo Html::a('<i class="glyphicon glyphicon-th"></i>',
                $params,
                ['data' => [
                    'method' => 'post',
                    'pjax' => true,
                    'params'=>[
                        'viewStyle'=>'asTab',
                    ],
                ],]);
        ?>



        <div class="per-page">
            <?php
            $params = ['/product/product/list'] + Yii::$app->request->queryParams;
            $items = [
                10=>10,
                20=>20,
                50=>50,
                100=>100,
            ];
            foreach ($items as $key=>&$item) {
                $params['per-page'] = $key;
                $item = [
                    'label'=>$key, 'url'=> Url::to($params),
                    //'options'=>['style'=>'padding:0',],
                    //'linkOptions'=>['style'=>'padding:0',],
                ];
            }
            ?>
            <i class="glyphicon glyphicon-option-vertical"></i>
            <?= ButtonDropdown::widget([
                'encodeLabel'=>false,
                'label' => $dataProvider->pagination->pageSize,
                'dropdown' => [
                    'items' => $items,
                    'options' => [
                        'style' => 'min-width:auto'
                    ],
                ],
                'containerOptions'=>[
                    'class'=>'per-page-container',
                ],
                'options' => [
                    'class' => 'btn'
                ],
            ])?>
            <?php
            $items = [
                10=>10,
                20=>20,
                50=>50,
                100=>100,
            ];
            //echo Html::dropDownList("per-page", $dataProvider->pagination->pageSize, $items, ['class'=>'selectpicker', 'data-width'=>'fit',]);?>
        </div>
    </div>
</div>
<div class="clear"></div>
