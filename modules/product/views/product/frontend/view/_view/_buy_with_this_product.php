<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


/* @var $this yii\web\View */
/* @var $model \product\models\Product */
$models = $model->buyProducts;
if($models){
    ?>
    <br/>
    <br/>
    <br/>
    <h1><?=Yii::t('product', 'Buy with this product');?></h1>
    <div class="buyWithThisProducts">
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