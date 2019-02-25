<?php

/* @var $this \extended\view\View */
use themes\landing\assets\LandingThemeAsset;

if(isset($this->assetManager->bundles['all']))
    $this->clearAssetBundle(LandingThemeAsset::class);
$themeBundle = LandingThemeAsset::register($this);

$this->title=Yii::$app->name.' - '.Yii::t('common', 'ecommerce platform based on Yii2 PHP Framework');

?>
<!-- About Section Start -->
<section id="main_advantage" class="section">
    <div class="container">
        <div class="section-header">
            <h3 class="section-subtitle wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                <?=Yii::t('landing', 'Why Sakura commerce? What is difference, advantage? Why do you need to know this information?')?>
            </h3>
            <h2 class="section-title wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <?=Yii::t('landing', 'Customizable for you')?>
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="300ms">
                <?=Yii::t('landing', 'Why text?')?>
            </div>
        </div>
    </div>
    <div class="img-about-out">
    </div>
</section>
<!-- About Section End -->

<!-- Services Section Start -->
<section id="other_advantages" class="services section">
    <div class="overlay"></div>
    <div class="container">
        <div class="section-header">
            <h3 class="section-subtitle wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms"><?=Yii::t('landing', 'Other advantages')?></h3>
            <h2 class="section-title wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms"><?=Yii::t('landing', 'What can do Sakura commerce?')?></h2>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="service-box wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <h3><a href="javascript:void(0);"><?=Yii::t('landing', 'Fast')?></a></h3>
                    <p>
                        <?=Yii::t('landing', 'Opportunity of frontend')?>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="service-box wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="450ms">
                    <h3><a href="javascript:void(0);"><?=Yii::t('landing', 'Clear backend')?></a></h3>
                    <p>
                        <?=Yii::t('landing', 'Opportunity of backend')?>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="service-box wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="550ms">
                    <h3><a href="javascript:void(0);">
                            <?=Yii::t('landing', 'Clean code and architecture')?>
                        </a>
                    </h3>
                    <p>
                        <?=Yii::t('landing', 'Opportunity of code')?>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="service-box wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="650ms">
                    <h3><a href="javascript:void(0);"><?=Yii::t('landing', 'Test coverage')?></a></h3>
                    <p>
                        <?=Yii::t('landing', 'Opportunity of tests')?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Portfolio Section -->
<section id="themes" class="section">
    <!-- Container Starts -->
    <div class="container">
        <div class="section-header">
            <h3 class="section-subtitle wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                <?=Yii::t('landing', 'Cover yours any theme')?>
            </h3>
            <h2 class="section-title wow fadeInUp" data-wow-duration="1000ms"
                data-wow-delay="300ms">
                <?=Yii::t('landing', 'Themes')?>
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Portfolio Recent Projects -->
                <div id="portfolio" class="row wow fadeInUp" data-wow-delay="0.8s">
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mix marketing planning">
                        <div class="portfolio-item" target="_blank" href="<?=Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/', 'theme'=>'sakura'])?>">
                            <div class="portfolio-img">
                                <img src="<?=$themeBundle->baseUrl?>/img/portfolio/sakura.png" alt="" />
                            </div>
                            <div class="portfoli-content">
                                <div class="sup-desc-wrap">
                                    <div class="sup-desc-inner">
                                        <div class="sup-meta-wrap">
                                            <a class="sup-title" target="_blank" href="<?=Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/', 'theme'=>'sakura'])?>"><h4>Sakura <?=Yii::t('landing', 'theme')?></h4></a>
                                            <p class="sup-description"><?=Yii::t('landing', 'Based on bootstrap, Responsive')?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mix planning">
                        <div class="portfolio-item" target="_blank" href="<?=Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/', 'theme'=>'sakura_light'])?>">
                            <div class="portfolio-img">
                                <img src="<?=$themeBundle->baseUrl?>/img/portfolio/sakura_light.png" alt="" />
                            </div>
                            <div class="portfoli-content">
                                <div class="sup-desc-wrap">
                                    <div class="sup-desc-inner">
                                        <div class="sup-meta-wrap">
                                            <a class="sup-title" target="_blank" href="<?=Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/', 'theme'=>'sakura_light'])?>"><h4>Sakura <?=Yii::t('landing', 'light')?> <?=Yii::t('landing', 'theme')?></h4></a>
                                            <p class="sup-description"><?=Yii::t('landing', 'Based on bootstrap, Responsive')?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mix research">
                        <div class="portfolio-item" target="_blank" href="<?=Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/', 'theme'=>'bootstrap'])?>">
                            <div class="portfolio-img">
                                <img src="<?=$themeBundle->baseUrl?>/img/portfolio/bootstrap.png" alt="" />
                            </div>
                            <div class="portfoli-content">
                                <div class="sup-desc-wrap">
                                    <div class="sup-desc-inner">
                                        <div class="sup-meta-wrap">
                                            <a class="sup-title" target="_blank"
                                               href="<?=Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/', 'theme'=>'bootstrap'])?>">
                                                <h4>
                                                    <?=Yii::t('landing', 'Mobile theme')?>
                                                </h4>
                                            </a>
                                            <p class="sup-description"><?=Yii::t('landing', 'Responsive mobile template')?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container Ends -->
</section>
<!-- Portfolio Section Ends -->

<!-- Start Pricing Table Section -->
<div id="pricing" class="section pricing-section">
    <div class="container">
        <div class="section-header">
            <h3 class="section-subtitle wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                <?=Yii::t('landing', 'Our best plans')?>
            </h3>
            <h2 class="section-title wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <?=Yii::t('landing', 'Pricing')?>
            </h2>
        </div>

        <div class="row pricing-tables">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="pricing-table wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="plan-name color-1">
                        <h3>Minimum</h3>
                    </div>
                    <div class="plan-price">
                        <div class="price-value"><span>$</span> 100 </div>
                        <div class="interval"><?=Yii::t('landing', 'Minimum ecommerce')?></div>
                    </div>
                    <div class="plan-list">
                        <ul>
                            <li><?=Yii::t('landing', 'No Support')?></li>
                            <li><?=Yii::t('landing', 'Base Functionality')?></li>
                        </ul>
                    </div>
                    <div class="plan-signup">
                        <a href="#contact" class="btn btn-common"><?=Yii::t('landing', 'Buy')?></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="plan-name color-2">
                        <h3>Advanced</h3>
                    </div>
                    <div class="plan-price">
                        <div class="price-value"><span>$</span> 300 </div>
                        <div class="interval">
                            <?=Yii::t('landing', 'Advanced Features')?>
                        </div>
                    </div>
                    <div class="plan-list">
                        <ul>
                            <li><?=Yii::t('landing', '24/7 Support')?></li>
                            <li><?=Yii::t('landing', 'Base Functionality')?></li>
                            <li><?=Yii::t('landing', 'Mailing of Letters')?></li>
                            <li><?=Yii::t('landing', 'RBAC Visual Hierarchical Manage')?></li>
                            <li><?=Yii::t('landing', 'Inheritance Views, Yii2\'s Blocks of View')?></li>
                        </ul>
                    </div>
                    <div class="plan-signup">
                        <a href="#contact" class="btn btn-common"><?=Yii::t('landing', 'Buy')?></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="pricing-table  highlight-plan wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="plan-name color-3">
                        <h3>Individual</h3>
                    </div>
                    <div class="plan-price">
                        <div class="price-value"><span>$</span> 25 <span>/hour</span> </div>
                        <div class="interval"><?=Yii::t('landing', 'Individual Customize for You')?></div>
                    </div>
                    <div class="plan-list">
                        <ul>
                            <li><?=Yii::t('landing', 'According to all of your individual requirements, rebuild, rewrite Sakura commerce for you in short time')?></li>
                        </ul>
                    </div>
                    <div class="plan-signup">
                        <a href="#contact" class="btn btn-border"><?=Yii::t('landing', 'Buy')?></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Pricing Table Section -->

<!-- Contact Section Start -->
<?=$this->render('@landing/views/site/contact',['model'=>new \landing\models\ContactForm()]) ?>
<!-- Contact Section End -->
