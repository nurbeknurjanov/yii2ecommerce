<?php
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

/* @var \yii\web\View $this */
?>
<?php $this->beginContent("@themes/{$this->theme->id}/layouts/base.php"); ?>
    <?php
    if (isset($this->blocks['sidebar']))
    {
        ?>
        <div class='row'>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <?=$this->blocks['sidebar'];?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?=$content;?>
            </div>
        </div>
        <?php
    }else {
        ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?=$content;?>
        <?php
    }
    ?>



<?php $this->endContent(); ?>