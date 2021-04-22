<?php
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use category\models\Category;
use extended\helpers\Helper;

/* @var Category $category */
/* @var \yii\web\View $this */
?>
<?php $this->beginContent("@themes/{$this->theme->id}/layouts/base.php"); ?>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <h1 class="fullPageSearchTitle">
        <?php
        if(isset($this->params['fullPageSearchTitle']))
            echo $this->params['fullPageSearchTitle'];
        ?>
    </h1>
    <h1 class="fullPageCategoryTitle">
        <?php
        if(isset($this->params['fullPageCategoryTitle']))
            echo $this->params['fullPageCategoryTitle'];
        ?>
    </h1>

    <?=$this->render('_top_categories')?>

    <div class='row'>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <?=$this->render('_sidebar_eav', ['searchModel' => $this->params['searchModel']]); ?>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12">
            <?= Alert::widget() ?>
            <?=$content;?>
        </div>
    </div>

<?php $this->endContent(); ?>