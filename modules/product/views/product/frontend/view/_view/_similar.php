<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


use product\models\Product;

/* @var $this yii\web\View */
/* @var $model \product\models\Product */
$models = Product::find()
    ->defaultFrom()
    ->similar($model)->limit(8)->all();
if($models){
    ?>
    <br/>
    <br/>
    <br/>
    <h1><?=Yii::t('product', 'Similar products');?></h1>
    <div class="similars">
        <?php
        foreach ($models as $data) {
            ?>
            <?=$this->render("@product/views/product/frontend/list/_list/_list_index", ['model'=>$data]);?>
            <?php
        }
        ?>
    </div>
    <?php
}