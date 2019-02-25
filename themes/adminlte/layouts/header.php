<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

?>

<header class="main-header">


    <?= Html::a('<span class="logo-mini">S</span>
        <span class="logo-lg">'.Yii::$app->name.'</span>',
        Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">


                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?=Yii::$app->user->identity->getImg(['class'=>'user-image'], 160)?>
                        <span class="hidden-xs"><?=Yii::$app->user->identity->fullName?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">

                            <?=Yii::$app->user->identity->img?>
                            <p>
                                <?=Yii::$app->user->identity->fullName?>
                                -
                                <?=Yii::$app->user->identity->rolesText?>
                                <small>Member since <?=date("M Y", Yii::$app->user->identity->created_at)?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!--<li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                        </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?=Url::to(['/user/profile/profile'])?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/user/profile/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                <li>
                    <?php
                    if(Yii::$app->language==Yii::$app->sourceLanguage){
                        ?>
                        <a href="<?=Url::to(["/".Yii::$app->controller->route]+$_GET+['language'=>'ru'])?>" >RU</a>
                        <?php
                    }else{
                        ?>
                        <a href="<?=Url::to(["/".Yii::$app->controller->route]+$_GET+['language'=>'en-US'])?>" >EN</a>
                        <?php
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
