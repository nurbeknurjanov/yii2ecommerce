<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use shop\models\Shop;
use file\widgets\file_preview\FilePreview;
use yii\helpers\Url;
use product\models\Product;

/* @var $this yii\web\View */
/* @var $model \shop\models\Shop */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shops'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <?php
		if(Yii::$app->user->can('updateShop', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteShop', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        ?>
    </div>

    <div style="display: flex">
        <div>
            <?=$model->getThumbImg('md')?>
        </div>
        <div style="margin-left: 20px; flex-grow: 1">
            <div style="display: flex; justify-content: space-between;  ">
                <h1>
                    <?=$model->title?>
                </h1>
                <?php
                if($model->owner){
                    ?>
                    <span>
                        <?=$model->getAttributeLabel('ownerAttribute')?>:
                        <a href="<?=Url::to(['/user/user/view', 'id'=>$model->owner->id])?>"><?=$model->owner->fullName?></a>
                    </span>
                    <?php
                }
                ?>

            </div>


            <div>
                <?=$model->description?>
            </div>
            <br/>
            <div>
                <?=$model->getAttributeLabel('address')?>: <?=$model->address?>
            </div>
        </div>



    </div>
</div>

<br/>
<br/>


<?php
if($models = $model->getProducts()->defaultFrom()->enabled()->with('mainImage')->all()){
    ?>
    <h1> Products of <?=$model->title?></h1>
    <div class="populars">
        <?php
        foreach ($models as $model) {
            ?>
            <?=$this->render("@product/views/product/frontend/list/_list/_list", ['model'=>$model]);?>
            <?php
        }
        ?>
    </div>
    <div class="clear"></div>
    <br/>
    <?php
}
?>
