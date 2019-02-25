<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;

/* @var $dataProvider \yii\data\ActiveDataProvider  */
/* @var $searchModel \product\models\search\ProductSearchFrontend  */

if(isset($title))
    $this->title = $title;//favorite, viewed, types
elseif($searchModel->category_id && $searchModel->category) {
    $this->params['category'] = $category = $searchModel->category;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'All products'), 'url' => ['/product/product/list']];
    foreach ($searchModel->category->parents()->all() as $parent)
        $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => $parent->url];
    $this->title = $category->title;
}
elseif($searchModel->q){
    $sub_text = Yii::t('product', '{n, plural, =0{no products} =1{# product} other{# products}} found.',
        ['n'=>$dataProvider->totalCount]);
    $this->title = Yii::t('common', 'Search results');
    $this->params['titleH1'] = Yii::t('product',
        'For query "{q}" - {sub_text}',
        ['sub_text'=>$sub_text, 'q'=>Html::encode($searchModel->q)]);
}
else
    $this->title = Yii::t('product', 'All products');


foreach ($searchModel->valueModels as &$valueModel)
    if($valueModel->isNotEmpty)
        $this->title.=' - '.$valueModel->getValueText(',');

if(!$searchModel->q)
    $this->params['breadcrumbs'][] = $this->title;

$this->params['searchModel'] = $searchModel;