<?php
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

/* @var \yii\web\View $this */
?>
<?php $this->beginContent("@themes/landing/layouts/base.php"); ?>


<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<?= Alert::widget() ?>
<?=$content?>



<?php $this->endContent(); ?>