<?php
use yii\helpers\Html;
use extended\helpers\StringHelper;
?>
<div class="col-lg-4">
    <?php // echo $model->mainImage ? $model->mainImage->img:\extended\helpers\Html::noImg()?>
    <div>
        <?=Html::a(StringHelper::truncate($model->title, 40), ['/article/article/view', 'id'=>$model->id,]);?>
        <div class="date"><?=Yii::$app->formatter->asDatetime($model->created_at, 'short');?></div>
        <p>
            <?=StringHelper::truncate($model->text, 100);?>
        </p>
    </div>
</div>