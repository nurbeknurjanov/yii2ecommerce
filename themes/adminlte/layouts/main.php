<?php
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

$this->params['bodyClass']='hold-transition  sidebar-mini';
?>
<?php $this->beginContent("@themes/adminlte/layouts/base.php"); ?>

<div class="wrapper">
    <?= $this->render('header')?>
    <?= $this->render('left')?>

    <?= $this->render(
        'content.php',
        ['content' => $this->yieldContent($content) ]
    ) ?>
</div>

<?php $this->endContent(); ?>
