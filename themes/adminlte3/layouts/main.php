<?php
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

$this->params['bodyClass']='hold-transition  sidebar-mini';
?>
<?php $this->beginContent("@themes/adminlte3/layouts/base.php"); ?>

<div class="wrapper">
    <?= $this->render('navbar')?>
    <?= $this->render('sidebar')?>

    <?= $this->render(
        'content.php',
        ['content' => $this->yieldContent($content) ]
    ) ?>
</div>

<?php $this->endContent(); ?>
