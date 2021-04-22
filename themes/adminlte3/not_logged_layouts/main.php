<?php

use common\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this \yii\web\View */

$this->params['bodyClass']='login-page';
?>



<?php $this->beginContent("@themes/adminlte3/layouts/base.php"); ?>


<div class="login-box">
    <div class="login-logo">
        <?= Html::a(Yii::$app->name, Yii::$app->homeUrl) ?>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
          <?=$this->yieldContent($content)?>
      </div>
    </div>
</div>

<?php $this->endContent(); ?>


