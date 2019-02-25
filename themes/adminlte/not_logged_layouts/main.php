<?php

use common\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this \yii\web\View */

$this->params['bodyClass']='hold-transition login-page';
?>



<?php $this->beginContent("@themes/adminlte/layouts/base.php"); ?>


<div class="login-box">
    <div class="login-logo">
        <?= Html::a(Yii::$app->name, Yii::$app->homeUrl) ?>
    </div>
    <div class="login-box-body">

        <?=$this->yieldContent($content)?>

    </div>
</div>

<?php $this->endContent(); ?>


