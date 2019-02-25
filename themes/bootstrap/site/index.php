<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


use product\models\Product;
use extended\helpers\Html;
use article\models\Article;
use yii\helpers\Url;
use extended\vendor\Carousel;

$this->title=Yii::$app->name.' - '.Yii::t('common', 'ecommerce platform based on Yii2 PHP Framework');
/* @var Product[] $models */
?>

<?php
if($models = Product::find()->defaultFrom()->enabled()->promote()->with('mainImage')->limit(8)->all()){
    foreach ($models as $model) {
        $caption = Html::tag('h1', $model->title);
        if($model->discount)
            $caption.=Html::tag('p',Yii::t('product', '{percent}% discount for {title}',  [
                'percent'=>$model->discount,
                'title'=>Html::a($model->title, $model->url)
            ]));
        $items[] = [
            'caption'=>$caption,
            'content'=>Html::a(Html::img($model->mainImage ? $model->mainImage->getThumbUrl("md"):Html::noImgUrl(400, 400)), $model->url,
                ['class'=>'product-image '.$model->typeClass, 'data-discount'=>$model->discount]),
            'indicatorContent'=>Html::img($model->mainImage ? $model->mainImage->getThumbUrl("sm"):Html::noImgUrl()).Html::tag("span", $model->title),
        ];
    }
    ?>
    <!--<h1>Акции</h1>-->
    <?php echo Carousel::widget([
        'id'=>'carousel-index',
        'controls'=>false,
        'showIndicators'=>true,
        'items' => $items,
        'options' => [
            'data-$indicators' => "$('.carousel-indicators div')",
            'class' => 'carousel slide',
            'data-interval' => '3000'],
    ])?>
    <div class="clear"></div>
    <br/>
    <?php
}
?>

<?php
if($models = Product::find()->defaultFrom()->enabled()->popular()->with('mainImage')->limit(12)->all()){
    ?>
    <h1><?=Yii::t('product', 'Popular');?></h1>
    <div class="index-product-list">
        <?php
        foreach ($models as $model) {
            ?>
            <?=$this->render("@product/views/product/frontend/list/_list/_list_index", ['model'=>$model]);?>
            <?php
        }
        ?>
    </div>
    <div class="clear"></div>
    <br/>
    <?php
}
?>

<?php
if($models = Product::find()->defaultFrom()->enabled()->novelty()->with('mainImage')->limit(12)->all()){
    ?>
    <h1><?=Yii::t('product', 'Novelties');?></h1>
    <div class="index-product-list">
        <?php
        foreach ($models as $model) {
            ?>
            <?=$this->render("@product/views/product/frontend/list/_list/_list_index", ['model'=>$model]);?>
            <?php
        }
        ?>
    </div>
    <div class="clear"></div>
    <br/>
    <?php
}
?>

<?php
$models = Article::find()->with('mainImage')->limit(3)->all();
if($models){
    ?>
    <h1><?=Yii::t('article', 'News');?></h1>
    <div class="row news-list">
        <?php
        foreach ($models as $model) {
            ?>
            <?=$this->render("@article/views/article/frontend/_list/_list_index", ['model'=>$model]);?>
            <?php
        }
        ?>
        <div class="col-lg-12" style="text-align: right">
            <a href="<?=Url::to(['/article/article/list', 'ArticleSearch[type]'=>Article::TYPE_NEWS]);?>"><?=Yii::t('article', 'All news');?></a>
        </div>
    </div>
    <?php
}
?>