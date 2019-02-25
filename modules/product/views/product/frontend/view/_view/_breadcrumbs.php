<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */



/* @var $this yii\web\View */
/* @var $model \product\models\Product */


if($model->category_id && $model->category) {
    $this->params['category'] = $category = $model->category;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'Products'), 'url' => ['/product/product/list']];
    foreach ($model->category->parents()->all() as $parent)
        $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/product/product/list', 'category_id'=>$parent->id, 'title_url'=>$parent->title_url]];
    $this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['/product/product/list', 'category_id'=>$category->id, 'title_url'=>$category->title_url]];
}else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'Products'), 'url' => [$this->context->defaultAction]];
}

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;