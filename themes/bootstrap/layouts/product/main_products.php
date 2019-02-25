<?php
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use category\models\Category;
use extended\helpers\Helper;
?>
<?php $this->beginContent("@themes/{$this->theme->id}/layouts/base.php"); ?>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class='row'>
        <div class="col-lg-3">
            <?=$this->render('_sidebar_eav', ['model' => $this->params['searchModel']]); ?>
        </div>
        <div class="col-lg-9">
            <?= Alert::widget() ?>
            <?=$content;?>
        </div>
    </div>

<?php $this->endContent(); ?>