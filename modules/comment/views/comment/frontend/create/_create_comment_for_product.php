<?php

use yii\helpers\Html;
use comment\models\Comment;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \comment\models\Comment */
/* @var $object product\models\Product */

$model = new Comment;
$model->model_id = $object->id;
$model->model_name = $object::className();

Pjax::begin(['id' => 'newCommentPjax', 'enablePushState'=>false]);

?>
    <br/>
<div class="comment-create">

    <h1><?= Html::encode(Yii::t('comment', 'Leave a comment')) ?></h1>

    <?php $this->beginBlock('form') ?>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    <?php $this->endBlock() ?>
    {{form}}

</div>

<?php
Pjax::end();


