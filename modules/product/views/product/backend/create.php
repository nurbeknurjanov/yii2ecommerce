<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model product\models\Product */

$this->title = Yii::t('product', 'Create Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'Products'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create box">

    <?php $this->beginBlock('form') ?>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    <?php $this->endBlock() ?>
    {{form}}

</div>
