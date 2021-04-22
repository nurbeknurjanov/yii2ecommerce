<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use extended\helpers\Html;
use product\models\Compare;
use yii\widgets\Pjax;
use kartik\rating\StarRating;
use order\models\Basket;
use product\assets\ProductAsset;
use yii\helpers\Url;

/* @var $this \extended\view\View */
/* @var $model \product\models\Product */


$this->registerLinkTag(['rel' => 'canonical',  'href' => Url::to($model->url)]);

//after bootstrap it needs to update label translations
/*if(isset($this->assetManager->bundles['all']))
    $this->clearAssetBundle(ProductAsset::class);
$productAsset = ProductAsset::register($this);*/

/*$this->registerJsFile($productAsset->baseUrl."/js/product-view.js", ['depends'=>[
    CommonAsset::class
]]);*/

$this->render('_view/_breadcrumbs', ['model' => $model]);
$this->params['description'] = $this->title;
$this->params['menuTitle'] = $this->title;

?>


<h1 class="title"><?= Html::encode($this->title) ?></h1>

<div class="row product-view">
    <div class="col-lg-6 col-xs-6 ">
        <div class="product-image <?=$model->typeClass?>"  data-discount="<?=$model->discount?>" >
            <?php
            //if($mainImage = $model->getImages()->queryMainImage()->one())
            if($mainImage = $model->mainImage)
                echo Html::img($mainImage->getThumbUrl("md"), [
                    'class'=>'zoom-container',
                    'data-large'=>$mainImage->imageUrl
                ]);
            else
                echo Html::noImg(400,400);
            ?>
        </div>

        <div class="product-images-wrap" >
            <div class="scrollLeft scrollHide" ><i class="glyphicon glyphicon-menu-left"></i></div>
            <div class="product-images">
                <div class="table-row">
                    <?php
                    foreach ($model->images as $index=>$image) {
                        ?>
                        <div class="table-cell">
                            <div class="product-thumbnail" >
                                <a href="<?=$image->imageUrl?>" data-lightbox="roadtrip" >
                                    <?=Html::img($image->getThumbUrl("xs"),
                                        [
                                            'class'=>'zoom-image',
                                            'data-medium'=>$image->getThumbUrl("md"),
                                            'data-large'=>$image->imageUrl])?>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="scrollRight"><i class="glyphicon glyphicon-menu-right"></i></div>
        </div>

    </div>
    <div class="col-lg-4 col-xs-4"  >
        <div><?=Html::tag("label", $model->getAttributeLabel('sku').':');?> <?=$model->skuText;?></div>
        <div><span class="price"><?=Yii::$app->formatter->asCurrency($model->price);?></span></div>
        <div><?=Html::tag("label", $model->getAttributeLabel('status').':');?> <?=$model->statusText;?></div>

        <div class="product-view-rating">
            <?php
            Pjax::begin(['id' => 'starPjax']);
                if($model->rating){
                    ?>
                        <?=StarRating::widget([
                            'id' => 'product-rating-'.$model->id,
                            'name' => 'product-rating-'.$model->id,
                            'value' => $model->rating,
                        ])?>
                    <?php
                }
            Pjax::end();
            ?>
        </div>
        <?php
        if($model->discount){
            ?>
            <div><?=Html::tag("label", $model->getAttributeLabel('discount').':');?> <?=$model->discountText;?></div>
            <?php
        }
        ?>

        <?php
        $basketProducts = Basket::findAll();
        ?>
        <?=Html::a(Yii::t('product', 'Buy'), 'javascript:void(0);',
            [
                'id'=>'showBasket-'.$model->id,
                'class'=>'btn btn-default btn-lg btn-warning showBasket '.
                    (Basket::isAlreadyInBasket($model->id)?"alreadyInBasket":null),
                'data'=>[
                    'count'=>Basket::isAlreadyInBasket($model->id) ? Basket::getProduct($model->id)['count']:1,
                    'product_id'=>$model->id,
                    'price'=>$model->price,
                    'title'=>$model->title,
                    'group_id'=>$model->group_id,
                ],
            ]);?>

    </div>
    <div class="col-lg-2 col-xs-2 product-right-block" >
        <?php
        if(Yii::$app->user->can("createFavorite", ['object'=>$model]))
            echo Html::a('', ['/favorite/favorite/create',
                'model_name'=>$model::className(), 'model_id'=>$model->id, ], [
                'class'=>'favorite addToFavorite',
                'title'=>Yii::t('favorite', 'Add to favorites'),
                'data' => [
                    //'confirm' => Yii::t('product', 'Are you sure you want to delete this item?'),
                    /*'method' => 'post',
                    'params' => [
                        'Favorite[model_id]'=>$model->id,
                        'Favorite[model_name]'=>$model::className(),
                    ],*/
                ]
            ]);
        if(Yii::$app->user->can("deleteFavorite", ['object'=>$model]))
            echo Html::a('', ['/favorite/favorite/delete',
                'model_name'=>$model::className(),
                'model_id'=>$model->id,
            ],
                [
                    'class'=>'favorite removeFromFavorite',
                    'title'=>Yii::t('favorite', 'Remove from favorites'),
                    'data' => [
                        //'confirm' => Yii::t('product', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                        'params' => [
                            'Favorite[model_id]'=>$model->id,
                            'Favorite[model_name]'=>$model->className(),
                        ],
                    ]
                ]);
        ?>

        <?php
        if(!in_array($model->id, Compare::findAll()))
            echo Html::a('', ['/product/compare/add', 'id'=>$model->id, ], [
                'class'=>'compare addToCompare',
                'title'=>Yii::t('product', 'Add to compare'),
            ]);
        else
            echo Html::a('', ['/product/compare/remove', 'id'=>$model->id, ], [
                'class'=>'compare removeFromCompare',
                'title'=>Yii::t('product', 'Remove from compare'),
            ]);
        ?>

        <div class="info-block" >
            <h5><?=Yii::t('product', '{title} guarantees', ['title'=>Yii::$app->name]);?>:</h5>
            <ul>
                <li class="delivery"><div><?=Yii::t('product', 'Fast delivery');?></div></li>
                <li class="cash"><div><?=Yii::t('product', 'Payment by cache at the day of delivering or other ways(bank cards, terminals, online payment)');?></div></li>
                <li class="refund"><div><?=Yii::t('product', '7 days to exchange or refund');?></div></li>
            </ul>
        </div>

    </div>
</div>

<br/>


<?=$this->render('_view/_tabs', ['model' => $model]); ?>
<?=$this->render('_view/_buy_with_this_product', ['model' => $model]); ?>
<div class="clear"></div>
<?=$this->render('_view/_similar', ['model' => $model]); ?>