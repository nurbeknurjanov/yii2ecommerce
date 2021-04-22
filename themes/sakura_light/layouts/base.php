<?php
use themes\sakura\assets\SakuraThemeAsset;
use themes\sakura_light\assets\SakuraLightThemeAsset;


if(isset($this->assetManager->bundles['all']))
    $this->clearAssetBundle(SakuraLightThemeAsset::class);
$themeBundle = SakuraLightThemeAsset::register($this);

echo $this->render("@themes/sakura/layouts/base", ['content'=>$content]);