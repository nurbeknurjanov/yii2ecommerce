<?php
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use category\models\Category;
use extended\helpers\Helper;
?>
<?php $this->beginContent("@themes/{$this->theme->id}/layouts/base.php"); ?>

    <?=$this->render('_top_categories')?>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class='row'>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <?=$this->render('_sidebar_eav', ['model' => $this->params['searchModel']]); ?>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12">
            <?= Alert::widget() ?>
            <?=$content;?>
        </div>
    </div>

<?php $this->endContent(); ?>