<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $model comment\models\Comment */

?>


<?php
Modal::begin([
    'id'=>'commentModal',
    'header' => '<h4 style="display:inline;">'.Yii::t('comment', 'Leave a comment').'</h4>',
    'clientOptions' => ['show' => false]
]);
?>


<?php $this->beginBlock('form') ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
<?php $this->endBlock() ?>
{{form}}

<?php
Modal::end();
?>
